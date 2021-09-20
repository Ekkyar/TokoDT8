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
        $this->load->model('Transaksi_Model', 'transaksi');
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
        $data['barangmasuk'] = $this->transaksi->getBarangMasuk();

        $data['title'] = 'Barang Masuk';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_barang_masuk', $data);
        $this->load->view('templates/footer');
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);

        //model delete
        $this->Toko_Model->deleteBarangMasuk($id);

        //notif delete sukses
        set_pesan('Data Barang_Masuk telah dihapus!', false);
        redirect('Admin/Barang_Masuk');
    }

    // ------------------------------ Controller Keranjang ---------------------------------
    public function keranjang()
    {
        //generate Kode transaksi / ID transaksi
        $id_barang_masuk = generate_id("B", "tb_barang_masuk", "id_barang_masuk", date('ymd'), 3);

        //ambil id user sesseion
        $id_user = $this->user['id_user'];

        //model
        $data['keranjang'] = $this->transaksi->getKeranjangMasuk(['user_id' => $id_user]);
        $data['supplier'] = $this->Toko_Model->get('tb_supplier');
        $data['total_harga'] = $this->transaksi->getTotalKeranjangMasuk(['user_id' => $id_user]);

        //Validasi
        $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');

        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        $data['title'] = 'Barang Masuk';
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_barang_masuk_keranjang', $data);
            $this->load->view('templates/footer', $data);
        } else {
            // Data Tabel Transaksi
            $input = $this->input->post(null, true);
            $input['tanggal'] = date('Y-m-d');
            $input['user_id'] = $id_user;
            $input['id_barang_masuk'] = $id_barang_masuk;

            // Data Detail Transaksi
            $data_detail = [];
            $i = 0;
            foreach ($data['keranjang'] as $k) {
                $data_detail[$i]['barang_masuk_id'] = $id_barang_masuk;
                $data_detail[$i]['barang_id']    = $k->id_barang;
                $data_detail[$i]['harga_masuk']    = $k->harga_masuk;
                $data_detail[$i]['qty']         = $k->qty;
                $data_detail[$i]['subtotal']    = $k->harga_masuk * $k->qty;
                $i++;
            }

            $pemesanan =  $this->transaksi->getTotalKeranjangMasuk(['user_id' => $id_user]);
            if ($pemesanan != '0') {
                // Simpan transaksi
                $this->Toko_Model->insert('tb_barang_masuk', $input);
                //Simpan detail transaksi
                $this->Toko_Model->insert_batch('tb_barang_masuk_detail', $data_detail);
                //bersihkan keranjang
                $this->db->truncate('tb_keranjang_masuk', ['user_id' => $id_user]);

                set_pesan('Barang masuk berhasil disimpan.');
                redirect('Admin/Barang_Masuk/detail/' . $id_barang_masuk);
            } else {
                set_pesan('Anda belum memasukkan barang yang akan di-checkout!', false);
                redirect('Admin/Barang_Masuk/keranjang');
            }
        }
    }

    // delete item di keranjang
    public function delete_item($id_item)
    {
        $id = encode_php_tags($id_item);
        $this->Toko_Model->delete('tb_keranjang_masuk', ['id_item' => $id]);
        set_pesan('Barang berhasil dihapus', false);
        redirect('Admin/Barang_Masuk/keranjang');
    }

    // hapus isi keranjang
    public function batal()
    {
        //ambil id user sesseion
        $id_user = $this->user['id_user'];

        $this->Toko_Model->delete('tb_keranjang_masuk', ['user_id' => $id_user]);
        set_pesan('Keranjang berhasil di-reset!', false);
        redirect('Admin/Barang_Masuk/keranjang');
    }

    // ------------------------------ Controller Add Items ---------------------------------
    public function add_item()
    {

        //validasi
        $this->form_validation->set_rules('barang_id', 'ID Barang', 'required|trim');
        $this->form_validation->set_rules('qty', 'Jumlah Masuk', 'required|numeric');
        $this->form_validation->set_rules('harga_masuk', 'Harga Masuk', 'required|numeric');

        //models
        $data['supplier'] = $this->Toko_Model->getAllSupplier();
        $data['barang'] = $this->Toko_Model->getAllBarang();
        // $data['getbarang'] = $this->Toko_Model->getBarang();
        $data['barangdetail'] = $this->Toko_Model->getBarang();

        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;
        $id_user = $this->user['id_user']; //get user session id

        $data['title'] = 'Barang Masuk';
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_barang_masuk_addItem', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $input = $this->input->post(null, true);
            $input['id_item'] = time();
            $input['user_id'] = $id_user;

            $cekItem = $this->transaksi->cekItemMasuk(['id_user', $id_user, 'barang_id' => $input['barang_id']]);
            if ($cekItem > 0) {
                $this->transaksi->updateQtyKeranjangMasuk($input['qty'], ['user_id' => $id_user, 'barang_id' => $input['barang_id']]);
            } else {
                $this->Toko_Model->insert('tb_keranjang_masuk', $input);
                set_pesan('Barang berhasil ditambahkan ke keranjang.');
                redirect('Admin/Barang_Masuk/keranjang');
            }
        }
    }

    // ------------------------------ Controller Detail Barang Masuk ---------------------------------
    public function detail($id)
    {
        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        $data['id_barang_masuk'] = $id;
        $data['barangmasuk'] = $this->transaksi->getBarangMasuk($id);
        $data['detail'] = $this->transaksi->getDetailBarangMasuk($id);

        $data['title'] = "Barang Masuk";
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_barang_masuk_detail', $data);
        $this->load->view('templates/footer', $data);
    }

    public function cetak_nota($id)
    {
        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        $data['id_barang_masuk'] = $id;
        $data['barangmasuk'] = $this->transaksi->getBarangMasuk($id);
        $data['detail'] = $this->transaksi->getDetailBarangMasuk($id);

        $data['title'] = "Barang Masuk";
        $this->load->view('admin/v_cetak_nota_kulak', $data);
    }
}
