<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Session Login
        if (!$this->session->userdata('username')) {
            redirect('Auth/access_blocked');
        } else {
            $akses = $this->session->userdata('id_akses');
            if ($akses != '1') {
                redirect('Auth/access_blocked');
            }
        }
        //ambil data session login
        $this->akses = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
        $this->user = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();
        //load model
        $this->load->model('Toko_Model');
        //form validation
        $this->load->library('form_validation');
    }

    public function index()
    {
        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        //model get user
        $data['getAllUser'] = $this->Toko_Model->getAllUser();
        $data['getAllAkses'] = $this->Toko_Model->getAllAkses();

        $data['title'] = 'Data User';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_data_user', $data);
        $this->load->view('templates/footer');
    }

    // Rule Validasi add
    private function _validasiAdd()
    {
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_telp', 'no_telp', 'trim|required|is_unique[tb_user.no_telp]|min_length[10]|max_length[13]|numeric', [
            'min_length' => 'Nomor tidak valid',
            'max_length' => 'Nomor tidak valid',
            'is_unique' => 'Nomor Telepon telah digunakan.'
        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[tb_user.email]', [
            'is_unique' => 'Email telah digunakan.'
        ]);
        $this->form_validation->set_rules('username', 'Username', 'trim|required|is_unique[tb_user.username]', [
            'is_unique' => 'username telah digunakan.'
        ]);
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]', [
            'min_length' => 'min 6 karakter.'
        ]);
        $this->form_validation->set_rules('id_akses', 'id_akses', 'required', ['required' => 'User Akses is required.']);
    }

    private function _validasiEdit()
    {
        $db = $this->Toko_Model->get('tb_user', ['id_user' => $this->input->post('id_user', true)]);
        $username = $this->input->post('username', true);
        $no_telp = $this->input->post('no_telp', true);
        $email = $this->input->post('email', true);

        $uniq_username = $db['username'] == $username ? '' : '|is_unique[tb_user.username]';
        $uniq_notelp = $db['no_telp'] == $no_telp ? '' : '|is_unique[tb_user.no_telp]';
        $uniq_email = $db['email'] == $email ? '' : '|is_unique[tb_user.email]';

        $this->form_validation->set_rules('username', 'Username', 'trim|required' . $uniq_username, [
            'is_unique' => 'Username telah digunakan',
        ]);
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'No Telepon', 'trim|required|min_length[10]|max_length[13]|numeric' . $uniq_notelp, [
            'min_length' => 'Nomor tidak valid',
            'max_length' => 'Nomor tidak valid',
            'is_unique' => 'Nomor telah digunakan',
        ]);
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email' . $uniq_email, [
            'is_unique' => 'email telah digunakan'
        ]);
        $this->form_validation->set_rules('id_akses', 'ID Akses', 'required');
    }

    public function add()
    {
        $this->_validasiAdd();
        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            //ambil data akses
            $data['getAkses'] = $this->Toko_Model->getAllAkses();

            $data['title'] = 'Data User';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_user_add', $data);
            $this->load->view('templates/footer');
        } else {
            //ambil data pada form
            $input = $this->input->post(null, true);
            $input_data = [
                'nama'          => $input['nama'],
                'alamat'          => $input['alamat'],
                'no_telp'       => $input['no_telp'],
                'email'         => $input['email'],
                'username'      => $input['username'],
                'password'      => password_hash($input['password'], PASSWORD_DEFAULT),
                'foto'          => 'default.png',
                'date_created'    => time(),
                'id_akses'          => $input['id_akses']
            ];
            $this->Toko_Model->addUser($input_data);
            set_pesan('User berhasil ditambahkan.');
            redirect('Admin/Data_User');
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasiEdit();
        if ($this->form_validation->run() == FALSE) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            //model
            $data['usr'] = $this->Toko_Model->getUser($id);
            $data['aks'] = $this->Toko_Model->getAllAkses();

            $data['title'] = 'Data User';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_user_edit', $data);
            $this->load->view('templates/footer');
        } else {
            //model edit user
            $input = $this->input->post(null, true);
            $input_data = [
                'nama'          => $input['nama'],
                'alamat'          => $input['alamat'],
                'no_telp'       => $input['no_telp'],
                'email'         => $input['email'],
                'username'      => $input['username'],
                'id_akses'          => $input['id_akses']
            ];
            $this->Toko_Model->editUser($id, $input_data);
            set_pesan('Data User telah diupdate.');
            redirect('Admin/Data_User/');
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);

        //model delete
        $this->Toko_Model->deleteUser($id);

        //notif delete sukses
        set_pesan('User telah dihapus!', false);
        redirect('Admin/Data_User');
    }
}
