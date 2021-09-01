<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Supplier extends CI_Controller
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

        //model get All supplier
        $data['getAllSupplier'] = $this->Toko_Model->getAllSupplier();

        $data['title'] = 'Data Supplier';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_supplier', $data);
        $this->load->view('templates/footer');
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_supplier', 'Nama Supplier', 'required|trim');
        $this->form_validation->set_rules('no_telp', 'Nomor Telepon', 'required|trim|numeric|is_unique[tb_supplier.no_telp]', [
            'is_unique' => 'Nomor Telepon telah digunakan!'
        ]);
        $this->form_validation->set_rules('alamat', 'Alamat', 'required|trim');
    }

    public function add()
    {
        $this->_validasi();

        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        $data['title'] = 'Data Supplier';
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_supplier_add', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $save = $this->Toko_Model->addSupplier($input);
            if ($save) {
                set_pesan('Supplier berhasil ditambahkan.');
                redirect('Admin/Supplier');
            } else {
                set_pesan('Supplier gagal ditambahkan!', false);
                redirect('Admin/Supplier/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        //model get supplier
        $data['supplier'] = $this->Toko_Model->getSupplier($id);

        $data['title'] = "Data Supplier";
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_supplier_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $update = $this->Toko_Model->updateSupplier($id, $input);
            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Supplier berhasil diedit.</div>');
                set_pesan('Supplier berhasil di-update.');
                redirect('Admin/Supplier');
            } else {
                set_pesan('Supplier gagal di-update!', false);
                redirect('Admin/Supplier/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteSupplier($id);
        if ($delete) {
            set_pesan('Supplier berhasil dihapus!', false);
            redirect('Admin/Supplier');
        } else {
            set_pesan('Supplier gagal dihapus!', false);
            redirect('Admin/Supplier');
        }
    }
}
