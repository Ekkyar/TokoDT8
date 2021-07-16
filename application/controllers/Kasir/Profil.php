<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profil extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //Session Login
        if (!$this->session->userdata('username')) {
            redirect('Auth/access_blocked');
        } else {
            $akses = $this->session->userdata('id_akses');
            if ($akses != '2') {
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

        $data['title'] = 'Profil';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/kasir_sidebar', $data);
        $this->load->view('templates/kasir_topbar', $data);
        $this->load->view('kasir/v_profil', $data);
        $this->load->view('templates/footer');
    }

    private function _validasi()
    {
        $db = $this->Toko_Model->get('tb_user', ['id_user' => $this->input->post('id_user', true)]);
        $email = $this->input->post('email', true);
        $no_telp = $this->input->post('no_telp', true);

        $uniq_notelp = $db['no_telp'] == $no_telp ? '' : '|is_unique[tb_user.no_telp]';
        $uniq_email = $db['email'] == $email ? '' : '|is_unique[tb_user.email]';

        $this->form_validation->set_rules('nama', 'Nama', 'trim|required');
        $this->form_validation->set_rules('alamat', 'Alamat', 'trim|required');
        $this->form_validation->set_rules('no_telp', 'No Telepon', 'trim|required|min_length[10]|max_length[13]|numeric' . $uniq_notelp, [
            'min_length' => 'Nomor tidak valid',
            'max_length' => 'Nomor tidak valid',
            'is_unique' => 'Nomor telah digunakan',
        ]);
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email' . $uniq_email);
    }

    private function _config()
    {
        $config['upload_path']      = "./assets/img/profil";
        $config['allowed_types']    = 'gif|jpg|jpeg|png';
        $config['encrypt_name']     = TRUE;
        $config['max_size']         = '2048';

        $this->load->library('upload', $config);
    }

    public function edit()
    {
        $this->_validasi();
        $this->_config();

        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            $data['title'] = 'Profil';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/kasir_sidebar', $data);
            $this->load->view('templates/kasir_topbar', $data);
            $this->load->view('kasir/v_profil_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $input_data = $this->input->post(null, true);
            if (empty($_FILES['foto']['name'])) {
                //update db tanpa foto
                $this->Toko_Model->editUser($input_data['id_user'], $input_data);
                set_pesan('perubahan berhasil disimpan.');
                redirect('Kasir/Profil/edit');
            } else {
                if ($this->upload->do_upload('foto') == false) {
                    echo $this->upload->display_errors();
                    die;
                } else {
                    $userdata = $this->user;
                    if ($userdata['foto'] != 'default.png') {
                        $old_image = FCPATH . 'assets/img/profil/' . $userdata['foto'];
                        if (!unlink($old_image)) {
                            set_pesan('gagal hapus foto lama.');
                            redirect('Kasir/Profil/edit');
                        }
                    }
                    $input_data['foto'] = $this->upload->data('file_name');
                    //update db beserta foto
                    set_pesan('perubahan berhasil disimpan.');
                    $this->Toko_Model->editUser($input_data['id_user'], $input_data);
                    redirect('Kasir/Profil/edit');
                }
            }
        }
    }

    public function ubahpassword()
    {
        $this->form_validation->set_rules('password_lama', 'Password Lama', 'required|trim');
        $this->form_validation->set_rules('password_baru', 'Password Baru', 'required|trim|min_length[6]|differs[password_lama]');
        $this->form_validation->set_rules('konfirmasi_password', 'Konfirmasi Password', 'matches[password_baru]');
        $this->form_validation->set_rules('id_akses', 'id_akses', 'required', ['required' => 'User Akses is required.']);

        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            $data['title'] = 'Profil';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/kasir_sidebar', $data);
            $this->load->view('templates/kasir_topbar', $data);
            $this->load->view('kasir/v_profil_ubahpassword', $data);
            $this->load->view('templates/footer');
        } else {
            $userdata = $this->user;
            $input = $this->input->post(null, true);
            if (password_verify($input['password_lama'], $userdata['password'])) {
                //password lama benar
                $new_pass = ['password' => password_hash($input['password_baru'], PASSWORD_DEFAULT)];
                $this->Toko_Model->editUser($userdata['id_user'], $new_pass);
                set_pesan('password berhasil diubah.');
                redirect('Kasir/Profil');
            } else {
                //pasword lama salah
                set_pesan('password lama salah!', false);
                redirect('Kasir/Profil/ubahpassword');
            }
        }
    }
}
