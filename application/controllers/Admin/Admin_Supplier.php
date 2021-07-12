<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Supplier extends CI_Controller
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
        $data['title'] = 'Data Supplier';

        //ambil data session login
        $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        //model get All supplier
        $data['getAllSupplier'] = $this->Toko_Model->getAllSupplier();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_admin_supplier', $data);
        $this->load->view('templates/admin_footer');
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            //title
            $data['title'] = 'Data Supplier';

            //ambil data session login
            $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
            $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_admin_supplier_add', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $input = $this->input->post(null, true);
            $save = $this->Toko_Model->addSupplier($input);

            if ($save) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Supplier berhasil ditambahkan.</div>');
                redirect('Admin/Admin_Supplier');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Supplier gagal ditambahkan!</div>');
                redirect('Admin/Admin_Supplier/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Supplier";

            //ambil data session login
            $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
            $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

            //model get supplier
            $data['supplier'] = $this->Toko_Model->getSupplier($id);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_admin_supplier_edit', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $input = $this->input->post(null, true);
            $update = $this->Toko_Model->updateSupplier($id, $input);
            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Supplier berhasil diedit.</div>');
                redirect('Admin/Admin_Supplier/index');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Supplier gagal diedit!</div>');
                redirect('Admin/Admin_Supplier/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteSupplier($id);
        if ($delete) {
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Supplier berhasil dihapus!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Supplier gagal dihapus!</div>');
        }
        redirect('Admin/Admin_Supplier');
    }
}
