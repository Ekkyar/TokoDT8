<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');
        if ($this->form_validation->run() == false) {
            //validasi gagal
            $data['title'] = 'Toko DT8 | Login';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //validasi berhasil
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('username');
        $password = $this->input->post('password');

        $user = $this->db->get_where('tb_user', ['username' => $username])->row_array();

        //cek user
        if ($user) {
            //user terdaftar

            //cek password
            if (password_verify($password, $user['password'])) {
                //password benar

                //membuat session akses
                $data = [
                    'username' => $user['username'],
                    'id_akses' => $user['id_akses']
                ];
                //buat session
                $this->session->set_userdata($data);

                //cek akses
                if ($data['id_akses'] == '1') {
                    redirect('Admin/Admin_Dashboard');
                } else if ($data['id_akses'] == '2') {
                    redirect('Kasir/Kasir_Dashboard');
                }
            } else {
                //password salah
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Password yang anda masukkan salah!</div>');
                redirect('Auth');
            }
        } else {
            //user tidak terdaftar
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">User tidak terdaftar!</div>');
            redirect('Auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('username');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Anda telah logout!</div>');
        redirect('Auth');
    }

    public function access_blocked()
    {
        $this->load->view('access_blocked');
    }
}
