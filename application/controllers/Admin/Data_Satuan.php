<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Satuan extends CI_Controller
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
        $data['title'] = 'Data Satuan';

        //ambil data session login
        $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        //model get All Satuan
        $data['satuan'] = $this->Toko_Model->getAllSatuan();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_data_satuan', $data);
        $this->load->view('templates/admin_footer');
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            //title
            $data['title'] = 'Data Satuan';

            //ambil data session login
            $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
            $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_satuan_add', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $input = $this->input->post(null, true);
            $save = $this->Toko_Model->addSatuan($input);

            if ($save) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Satuan barang berhasil ditambahkan.</div>');
                redirect('Admin/Data_Satuan');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Satuan barang gagal ditambahkan!</div>');
                redirect('Admin/Data_Satuan/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Satuan";

            //ambil data session login
            $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
            $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

            //model get satuan
            $data['satuan'] = $this->Toko_Model->getSatuan($id);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_satuan_edit', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $input = $this->input->post(null, true);
            $update = $this->Toko_Model->updateSatuan($id, $input);
            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Satuan barang berhasil diedit.</div>');
                redirect('Admin/Data_Satuan');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Satuan barang gagal diedit!</div>');
                redirect('Admin/Data_Satuan/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteSatuan($id);
        if ($delete) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Satuan barang telah dihapus!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Satuan barang gagal dihapus!</div>');
        }
        redirect('Admin/Data_Satuan');
    }
}
