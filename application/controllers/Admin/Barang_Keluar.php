<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Barang_Keluar extends CI_Controller
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
        $data['barangkeluar'] = $this->Toko_Model->getBarangKeluar();

        $data['title'] = 'Barang Keluar';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_barang_keluar', $data);
        $this->load->view('templates/footer');
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('tanggal_keluar', 'Tanggal Keluar', 'required|trim');
        $this->form_validation->set_rules('barang_id', 'Barang', 'required');

        $input = $this->input->post('barang_id', true);
        $stok = $this->Toko_Model->get('tb_barang', ['id_barang' => $input])['stok'];
        $stok_valid = $stok + 1;

        $this->form_validation->set_rules(
            'jumlah_keluar',
            'Jumlah Keluar',
            "required|trim|numeric|greater_than[0]|less_than[{$stok_valid}]",
            [
                'less_than' => "Jumlah Keluar tidak boleh lebih dari {$stok}"
            ]
        );
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            //model
            $data['barang'] = $this->Toko_Model->get('tb_barang', null, ['stok >' => 0]);
            $data['barangdetail'] = $this->Toko_Model->getBarang();

            // Mendapatkan dan men-generate kode transaksi barang keluar
            $kode = 'T-BK-' . date('ymd');
            $kode_terakhir = $this->Toko_Model->getMax('tb_barang_keluar', 'id_barang_keluar', $kode);
            $kode_tambah = substr($kode_terakhir, -5, 5);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 5, '0', STR_PAD_LEFT);
            $data['id_barang_keluar'] = $kode . $number;

            $data['title'] = "Barang Keluar";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_barang_keluar_add', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->Toko_Model->addBarangKeluar($input);
            if ($insert) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang keluar berhasil disimpan.</div>');
                set_pesan('Barang keluar berhasil disimpan.');
                redirect('Admin/Barang_Keluar');
            } else {
                set_pesan('perubahan gagal disimpan!', false);
                redirect('Admin/Barang_Keluar/add');
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteBarangKeluar($id);
        if ($delete) {
            set_pesan('perubahan telah dihapus!', false);
        } else {
            set_pesan('perubahan gagal dihapus!', false);
        }
        redirect('Admin/Barang_Keluar');
    }
}
