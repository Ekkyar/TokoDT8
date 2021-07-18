<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Session Login
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
        $data['transaksi'] = $this->transaksi->getTransaksi();

        $data['title'] = 'Penjualan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_penjualan', $data);
        $this->load->view('templates/footer', $data);
    }

    public function add()
    {
        //generate Kode Barang / ID Barang
        $id_transaksi = generate_id("T", "tb_transaksi", "id_transaksi", date('ymd'), 3);

        //ambil data session
        $id_user = $this->user['id_user'];

        //models
        $data['keranjang'] = $this->transaksi->getKeranjang(['user_id' => $id_user]);
        $data['total_harga'] = $this->transaksi->getTotalKeranjang(['user_id' => $id_user]);

        $this->form_validation->set_rules('bayar', 'Bayar', 'required|numeric');

        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            $data['title'] = 'Penjualan';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_penjualan_add', $data);
            $this->load->view('templates/footer', $data);
        } else {
            // Data Tabel Transaksi
            $input = $this->input->post(null, true);
            $input['tanggal'] = date('Y-m-d');
            $input['user_id'] = $id_user;
            $input['id_transaksi'] = $id_transaksi;
            $input['kembalian'] = $input['bayar'] - $data['total_harga'];

            // Data Detail Transaksi
            $data_detail = [];
            $i = 0;
            foreach ($data['keranjang'] as $k) {
                $data_detail[$i]['transaksi_id'] = $id_transaksi;
                $data_detail[$i]['barang_id']    = $k->id_barang;
                $data_detail[$i]['qty']         = $k->qty;
                $data_detail[$i]['subtotal']    = $k->harga * $k->qty;
                $i++;
            }

            if ($input['bayar'] >= $data['total_harga']) {
                // Simpan transaksi
                $this->Toko_Model->insert('tb_transaksi', $input);
                //Simpan detail transaksi
                $this->Toko_Model->insert_batch('tb_transaksi_detail', $data_detail);
                //bersihkan keranjang
                $this->Toko_Model->delete('tb_keranjang', ['user_id' => $id_user]);

                // msgBox('save');
                set_pesan('Penjualan berhasil disimpan.');
                redirect('Admin/Penjualan/detail/' . $id_transaksi);
            } else {
                // setMsg('danger', 'Uang bayar tidak cukup.');
                redirect('Admin/Penjualan/add');
            }
        }
    }

    public function add_item()
    {
        //tittle
        $data['title'] = 'Penjualan';

        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;
        $id_user = $this->user['id_user'];

        //models
        $data['barang'] = $this->transaksi->getBarang();

        $this->form_validation->set_rules('barang_id', 'ID Barang', 'required|trim');
        $this->form_validation->set_rules('qty', 'Jumlah Beli', 'required|numeric');
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_penjualan_addItem', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $input = $this->input->post(null, true);
            $input['id_item'] = time();
            $input['user_id'] = $id_user;

            // Cek stok
            $stok = $this->Toko_Model->get_where('tb_barang', ['id_barang' => $input['barang_id']])->stok;
            if ($stok >= $input['qty']) {
                // $cekItem = $this->transaksi->cekItem(['idUser' => $idUser, 'kdBarang' => $input['kdBarang']]);
                $cekItem = $this->transaksi->cekItem(['id_user', $id_user, 'barang_id' => $input['barang_id']]);
                if ($cekItem > 0) {
                    $this->transaksi->updateQtyKeranjang($input['qty'], ['user_id' => $id_user, 'barang_id' => $input['barang_id']]);
                } else {
                    $this->Toko_Model->insert('tb_keranjang', $input);
                    redirect('Admin/Penjualan/add');
                }
            } else {
                // setMsg('danger', "Maaf stok yang tersedia hanya {$stok}");

                //ambil data session login
                $data['akses'] = $this->akses;
                $data['user'] = $this->user;

                $this->load->view('templates/header', $data);
                $this->load->view('templates/admin_sidebar', $data);
                $this->load->view('templates/admin_topbar', $data);
                $this->load->view('admin/v_penjualan_addItem', $data);
                $this->load->view('templates/footer', $data);
            }
        }
    }

    public function delete_item($id_item)
    {
        $id = encode_php_tags($id_item);
        $this->main->delete('tb_keranjang', ['id_item' => $id]);

        redirect('Admin/Penjualan/add');
    }

    public function detail($id)
    {
        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        $data['id_transaksi'] = $id;
        $data['transaksi'] = $this->transaksi->getTransaksi($id);
        $data['detail'] = $this->transaksi->getDetailTransaksi($id);

        $data['title'] = "Penjualan";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_penjualan_detail', $data);
        $this->load->view('templates/footer', $data);
    }

    public function cetak_detail($getId)
    {
        $this->load->library('Dompdf_gen');

        $id = encode_php_tags($getId);
        $where = ['idKategori' => $id];

        $data['transaksi'] = $this->transaksi->getTransaksi($id);
        $data['detail'] = $this->transaksi->getDetailTransaksi($id);

        $this->load->view('transaksi/cetak_detail', $data);

        $paper_size = 'A4'; // ukuran kertas
        $orientation = 'landscape'; //tipe format kertas potrait atau landscape
        $html = $this->output->get_output();

        $this->dompdf->set_paper($paper_size, $orientation);
        //Convert to PDF
        $this->dompdf->load_html($html);
        $this->dompdf->render();

        ob_end_clean();
        $this->dompdf->stream("detail_transaksi_" . time() . ".pdf", array('Attachment' => 0));
    }

    public function hapus($id)
    {
        $where = ['idTransaksi' => $id];
        $del = $this->main->delete('transaksi', $where);
        if ($del) {
            // msgBox('delete');
        } else {
            // msgBox('delete', false);
        }
        redirect('transaksi');
    }
}
