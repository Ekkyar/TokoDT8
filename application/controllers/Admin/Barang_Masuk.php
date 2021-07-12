<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_Masuk extends CI_Controller
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
        $data['title'] = 'Barang Masuk';

        //ambil data session login
        $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        //model
        $data['barangmasuk'] = $this->Toko_Model->getBarangMasuk();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_barang_masuk', $data);
        $this->load->view('templates/admin_footer');
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_masuk', 'Tanggal Masuk', 'required|trim');
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');
        $this->form_validation->set_rules('jumlah_masuk', 'Jumlah Masuk', 'required|trim|numeric|greater_than[0]');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            $data['title'] = "Barang Masuk";

            //ambil data session login
            $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
            $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

            //model
            $data['supplier'] = $this->Toko_Model->getAllSupplier();
            $data['barang'] = $this->Toko_Model->getAllBarang();
            $data['barangdetail'] = $this->Toko_Model->getBarang();

            // Mendapatkan dan men-generate kode transaksi barang masuk
            $kode = 'T-BM-' . date('ymd');
            $kode_terakhir = $this->Toko_Model->getMax('tb_barang_masuk', 'id_barang_masuk', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_masuk'] = $kode . $number;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_barang_masuk_add', $data);
            $this->load->view('templates/admin_footer', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->Toko_Model->addBarangMasuk($input);

            if ($insert) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang masuk berhasil disimpan.</div>');
                redirect('Admin/Barang_Masuk');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Barang masuk gagal disimpan!</div>');
                redirect('Admin/Barang_Masuk/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteBarangMasuk($id);
        if ($delete) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Barang Masuk telah dihapus!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Data Barang Masuk gagal dihapus!</div>');
        }
        redirect('Admin/Barang_Masuk');
    }
}
