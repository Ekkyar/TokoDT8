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

        //model
        $data['barangmasuk'] = $this->Toko_Model->getBarangMasuk();

        $data['title'] = 'Barang Masuk';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_barang_masuk', $data);
        $this->load->view('templates/footer');
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
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

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

            $data['title'] = "Barang Masuk";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_barang_masuk_add', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->Toko_Model->addBarangMasuk($input);

            if ($insert) {
                set_pesan('Barang masuk berhasil ditambahkan.');
                redirect('Admin/Barang_Masuk');
            } else {
                set_pesan('Barang masuk gagal ditambahkan!', false);
                redirect('Admin/Barang_Masuk/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteBarangMasuk($id);
        if ($delete) {
            set_pesan('Barang masuk telah dihapus!', false);
        } else {
            set_pesan('Barang masuk gagal dihapus!', false);
        }
        redirect('Admin/Barang_Masuk');
    }
}
