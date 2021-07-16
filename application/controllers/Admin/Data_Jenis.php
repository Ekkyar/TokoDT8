<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Jenis extends CI_Controller
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

        //model get All Jenis
        $data['jenis'] = $this->Toko_Model->getAllJenis();

        $data['title'] = 'Data Jenis';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_data_jenis', $data);
        $this->load->view('templates/footer');
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_jenis', 'Nama Jenis', 'required|trim|is_unique[tb_jenis.nama_jenis]', [
            'is_unique' => 'Jenis barang telah tersedia'
        ]);
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            $data['title'] = 'Data Jenis';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_jenis_add', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $save = $this->Toko_Model->addJenis($input);

            if ($save) {
                set_pesan('Jenis barang berhasil ditambahkan.');
                redirect('Admin/Data_Jenis');
            } else {
                set_pesan('Jenis barang gagal ditambahkan!', false);
                redirect('Admin/Data_Jenis/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            //model get jenis
            $data['jenis'] = $this->Toko_Model->getJenis($id);

            $data['title'] = "Data jenis";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_jenis_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $update = $this->Toko_Model->updateJenis($id, $input);
            if ($update) {
                set_pesan('Jenis barang berhasil di-update.');
                redirect('Admin/Data_Jenis');
            } else {
                set_pesan('Jenis barang gagal di-update.', false);
                redirect('Admin/Data_Jenis/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteJenis($id);
        if ($delete) {
            set_pesan('Jenis barang telah dihapus!', false);
            redirect('Admin/Data_Jenis');
        } else {
            set_pesan('Jenis gagal dihapus!', false);
            redirect('Admin/Data_Jenis');
        }
    }
}
