<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Akun extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Session Login
        if (!$this->session->userdata('username')) {
            redirect('Auth/access_blocked');
        } else {
            $akses = $this->session->userdata('id_akses');
            if ($akses != '1') {
                redirect('Auth/access_blocked');
            }
        }
        //load model
        $this->load->model('Toko_Model');
        //form validation
        $this->load->library('form_validation');
    }

    public function index()
    {
        //title
        $data['title'] = 'Akun';

        //ambil data session login
        $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        //model get user
        $data['getAllUser'] = $this->Toko_Model->getAllUser();
        $data['getAllAkses'] = $this->Toko_Model->getAllAkses();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_admin_akun', $data);
        $this->load->view('templates/admin_footer');
    }

    public function registration()
    {
        //Rule Validasi
        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('kontak', 'Kontak', 'trim|required|min_length[10]|max_length[13]', [
            'min_length' => 'Nomor tidak valid',
            'max_length' => 'Nomor tidak valid'
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
        $this->form_validation->set_rules('id_akses', 'id_akses', 'required', ['required' => 'The User Akses is required.']);

        if ($this->form_validation->run() == false) {
            //isi form gagal
            $data['title'] = 'Administator | Registration';

            //ambil data session login
            $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
            $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

            //ambil data akses
            $data['getAkses'] = $this->Toko_Model->getAllAkses();

            $this->load->view('templates/auth_header', $data);
            $this->load->view('admin/v_admin_registration', $data);
            $this->load->view('templates/auth_footer');
        } else {
            //isi form berhasil

            //ambil data pada form
            $data = [
                'nama' => htmlspecialchars($this->input->post('nama', true)),
                'alamat' => htmlspecialchars($this->input->post('alamat', true)),
                'kontak' => htmlspecialchars($this->input->post('kontak', true)),
                'email' => htmlspecialchars($this->input->post('email', true)),
                'username' => htmlspecialchars($this->input->post('username', true)),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'foto' => 'default.png',
                'date_created' => time(),
                'id_akses' => $this->input->post('id_akses')
            ];

            //insert ke db
            $this->db->insert('tb_user', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Daftar Akun Berhasil!</div>');
            redirect('Admin/Admin_Akun');
        }
    }

    public function detail_user($id_user)
    { //rules form edit !!!
        $this->form_validation->set_rules('nama', 'Nama', 'required|trim');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
        $this->form_validation->set_rules('kontak', 'Kontak', 'trim|required|min_length[10]|max_length[13]', [
            'min_length' => 'Nomor tidak valid',
            'max_length' => 'Nomor tidak valid'
        ]);
        $this->form_validation->set_rules('id_akses', 'ID Akses', 'required');

        if ($this->form_validation->run() == FALSE) {
            //form validasi gagal
            //title
            $data['title'] = 'Detail Akun';

            //ambil data session login
            $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
            $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

            //model
            $data['getuser'] = $this->Toko_Model->getUser($id_user);
            $data['getakses'] = $this->Toko_Model->getAllAkses();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_admin_detail_user', $data);
            $this->load->view('templates/admin_footer');
        } else {
            //form validasi sukses
            //model edit user
            $this->Toko_Model->editUser($id_user);
            //notif edit data sukses
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center" role="alert">Data User telah diupdate</div>');
            redirect('Admin/Admin_Akun/');
        }
    }

    public function delete_user($id_user)
    {
        //model delete
        $this->Toko_Model->deleteUser($id_user);

        //notif delete sukses
        $this->session->set_flashdata('message', '<div class="alert alert-danger text-center" role="alert">User berhasil dihapus</div>');
        redirect('Admin/Admin_Akun');
    }
}
