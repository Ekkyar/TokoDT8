<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cetak_Laporan extends CI_Controller
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
        $this->form_validation->set_rules('transaksi', 'Transaksi', 'required|in_list[tb_barang_masuk_detail,tb_transaksi_detail]');
        $this->form_validation->set_rules('tanggal', 'Periode Tanggal', 'required');

        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            $data['title'] = 'Cetak Laporan';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_cetak_laporan', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $input = $this->input->post(null, true);
            $table = $input['transaksi'];
            $tanggal = $input['tanggal'];
            $pecah = explode(' - ', $tanggal);
            $mulai = date('Y-m-d', strtotime($pecah[0]));
            $akhir = date('Y-m-d', strtotime(end($pecah)));

            $query = '';
            if ($table == 'tb_barang_masuk_detail') {
                $query = $this->Toko_Model->getBarangMasuk(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            } else {
                $query = $this->Toko_Model->getTransaksi(null, null, ['mulai' => $mulai, 'akhir' => $akhir]);
            }
            $this->_cetak($query, $table, $tanggal);
        }
    }

    private function _cetak($data, $table_, $tanggal)
    {
        $this->load->library('CustomPDF');
        $table = $table_ == 'tb_barang_masuk_detail' ? 'Barang Masuk' : 'Penjualan';

        $pdf = new FPDF();
        $pdf->AddPage('P', 'Letter');
        $pdf->SetFont('Times', 'B', 16);
        $pdf->Cell(190, 7, 'Laporan ' . $table, 0, 1, 'C');
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(190, 4, 'Tanggal : ' . $tanggal, 0, 1, 'C');
        $pdf->Ln(10);

        $pdf->SetFont('Arial', 'B', 10);

        if ($table_ == 'tb_transaksi_detail') :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(22, 7, 'Tanggal', 1, 0, 'C');
            $pdf->Cell(35, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(15, 7, 'Qty', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Harga', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Total', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(22, 7, $d['tanggal'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['id_transaksi'], 1, 0, 'C');
                $pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'C');
                $pdf->Cell(15, 7, $d['qty'], 1, 0, 'C');
                $pdf->Cell(30, 7, format_uang($d['harga']), 1, 0, 'R');
                $pdf->Cell(30, 7, format_uang($d['subtotal']), 1, 0, 'R');
                $pdf->Ln();
            }
        else :
            $pdf->Cell(10, 7, 'No.', 1, 0, 'C');
            $pdf->Cell(22, 7, 'Tanggal', 1, 0, 'C');
            $pdf->Cell(35, 7, 'ID Transaksi', 1, 0, 'C');
            $pdf->Cell(55, 7, 'Nama Barang', 1, 0, 'C');
            $pdf->Cell(15, 7, 'Qty', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Harga Masuk', 1, 0, 'C');
            $pdf->Cell(30, 7, 'Total', 1, 0, 'C');
            $pdf->Ln();

            $no = 1;
            foreach ($data as $d) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(10, 7, $no++ . '.', 1, 0, 'C');
                $pdf->Cell(22, 7, $d['tanggal'], 1, 0, 'C');
                $pdf->Cell(35, 7, $d['barang_masuk_id'], 1, 0, 'C');
                $pdf->Cell(55, 7, $d['nama_barang'], 1, 0, 'C');
                $pdf->Cell(15, 7, $d['qty'], 1, 0, 'C');
                $pdf->Cell(30, 7, format_uang($d['harga_masuk']), 1, 0, 'R');
                $pdf->Cell(30, 7, format_uang($d['subtotal']), 1, 0, 'R');
                $pdf->Ln();
            }
        endif;

        $file_name = $table . ' ' . $tanggal;
        $pdf->Output('I', $file_name);
    }
}
