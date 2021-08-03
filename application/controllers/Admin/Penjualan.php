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
    // ------------------------------ Controller Index ---------------------------------

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

    public function delete($getId)
    {
        $id = encode_php_tags($getId);

        //model delete
        $this->Toko_Model->deleteUser($id);

        //notif delete sukses
        set_pesan('Data Penjualan telah dihapus!', false);
        redirect('Admin/Penjualan');
    }

    // ------------------------------ Controller Keranjang ---------------------------------

    public function keranjang()
    {
        //generate Kode transaksi / ID transaksi
        $id_transaksi = generate_id("T", "tb_transaksi", "id_transaksi", date('ymd'), 3);

        //ambil id user sesseion
        $id_user = $this->user['id_user'];

        //model
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
            $this->load->view('admin/v_penjualan_keranjang', $data);
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

            // Cek Bayar
            if ($input['bayar'] >= $data['total_harga']) {
                $pemesanan =  $this->transaksi->getTotalKeranjang(['user_id' => $id_user]);
                if ($pemesanan != '0') {
                    // Simpan transaksi
                    $this->Toko_Model->insert('tb_transaksi', $input);
                    //Simpan detail transaksi
                    $this->Toko_Model->insert_batch('tb_transaksi_detail', $data_detail);
                    //bersihkan keranjang
                    $this->db->truncate('tb_keranjang', ['user_id' => $id_user]);

                    set_pesan('Penjualan berhasil disimpan.');
                    redirect('Admin/Penjualan/detail/' . $id_transaksi);
                } else {
                    set_pesan('Anda belum memasukkan barang yang akan di-checkout!', false);
                    redirect('Admin/Penjualan/keranjang');
                }
            } else {
                set_pesan('Maaf. Uang bayar tidak cukup!', false);
                redirect('Admin/Penjualan/keranjang');
            }
        }
    }

    // delete item di keranjang
    public function delete_item($id_item)
    {
        $id = encode_php_tags($id_item);
        $this->Toko_Model->delete('tb_keranjang', ['id_item' => $id]);
        set_pesan('Barang berhasil dihapus', false);
        redirect('Admin/Penjualan/keranjang');
    }

    // hapus isi keranjang
    public function batal()
    {
        //ambil id user sesseion
        $id_user = $this->user['id_user'];

        $this->Toko_Model->delete('tb_keranjang', ['user_id' => $id_user]);
        set_pesan('Keranjang berhasil di-reset!', false);
        redirect('Admin/Penjualan/keranjang');
    }

    // ------------------------------ Controller Add Items ---------------------------------

    public function add_item()
    {
        //tittle
        $data['title'] = 'Penjualan';

        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;
        $id_user = $this->user['id_user']; //get user session id

        //models
        $data['barang'] = $this->Toko_Model->getBarang();

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
                $cekItem = $this->transaksi->cekItem(['id_user', $id_user, 'barang_id' => $input['barang_id']]);
                if ($cekItem > 0) {
                    $this->transaksi->updateQtyKeranjang($input['qty'], ['user_id' => $id_user, 'barang_id' => $input['barang_id']]);
                } else {
                    $this->Toko_Model->insert('tb_keranjang', $input);
                    set_pesan('Barang berhasil ditambahkan ke keranjang.');
                    redirect('Admin/Penjualan/keranjang');
                }
            } else {
                set_pesan('Pembelian barang melenihi stok yang tersedia!', false);
                redirect('Admin/Penjualan/add_item');
            }
        }
    }


    // ------------------------------ Controller Detail Penjualan ---------------------------------
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

    public function cetak_nota($id)
    {
        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        $data['id_transaksi'] = $id;
        $data['transaksi'] = $this->transaksi->getTransaksi($id);
        $data['detail'] = $this->transaksi->getDetailTransaksi($id);

        $data['title'] = "Penjualan";
        $this->load->view('admin/v_cetak_nota', $data);
    }
}
