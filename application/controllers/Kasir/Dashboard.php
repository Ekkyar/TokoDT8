<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
        $this->load->model('Transaksi_Model', 'transaksi');
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
        $data['barang'] = $this->Toko_Model->count('tb_barang');
        $data['barang_masuk'] = $this->Toko_Model->count('tb_barang_masuk');
        $data['barang_keluar'] = $this->Toko_Model->count('tb_transaksi');
        $data['supplier'] = $this->Toko_Model->count('tb_supplier');
        $data['users'] = $this->Toko_Model->count('tb_user');
        $data['stok'] = $this->Toko_Model->sum('tb_barang', 'stok');
        $data['barang_min'] = $this->Toko_Model->min('tb_barang', 'stok', 10);
        $data['transaksi'] = ['barang_keluar' => $this->Toko_Model->getTransaksi(9)];
        $data['total_transaksi'] = $this->transaksi->getTotalTransaksi(date('Y-m'));
        $data['total_pengeluaran'] = $this->transaksi->getPengeluaran(date('Y-m'));
        $data['laba'] = $data['total_transaksi'] - $data['total_pengeluaran'];


        // Line Chart
        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['cbm'] = [];
        $data['cbk'] = [];

        foreach ($bln as $b) {
            $data['cbk'][] = $this->Toko_Model->chartBarangKeluar($b);
        }

        // Line Chart 
        $bln = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
        $data['pd'] = [];
        foreach ($bln as $b) {
            $date = date('Y-') . $b;
            $total1 = (int) $this->transaksi->chartTransaksi($date);
            $total2 = (int) $this->transaksi->chartPengeluaran($date);
            $laba = $total1 - $total2;
            $data['pd'][] = $total1 == null ? 0 : $total1;
            $data['pg'][] = $total2 == null ? 0 : $total2;
            $data['lb'][] = $laba == null ? 0 : $laba;
        }

        $data['title'] = 'Dashboard';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/kasir_sidebar', $data);
        $this->load->view('templates/kasir_topbar', $data);
        $this->load->view('kasir/v_dashboard', $data);
        $this->load->view('templates/footer', $data);
    }
}
