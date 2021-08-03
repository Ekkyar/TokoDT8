<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Barang extends CI_Controller
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
        //libraries
        $this->load->library('Ciqrcode');
        $this->load->library('form_validation');
    }

    public function index()
    {
        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        //model get Barang
        $data['barang'] = $this->Toko_Model->getBarang();
        $data['title'] = 'Data Barang';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_data_barang', $data);
        $this->load->view('templates/footer');
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim|is_unique[tb_barang.nama_barang]', [
            'is_unique' => 'Barang telah tersedia!'
        ]);
        $this->form_validation->set_rules('jenis_id', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('satuan_id', 'Satuan Barang', 'required');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            //model
            $data['jenis'] = $this->Toko_Model->getAllJenis();
            $data['satuan'] = $this->Toko_Model->getAllSatuan();

            //mengenerate ID Barang
            $kode_terakhir = $this->Toko_Model->getMax('tb_barang', 'id_barang');
            $kode_tambah = substr($kode_terakhir, -6, 6);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
            $data['id_barang'] = 'B' . $number;

            $data['title'] = 'Data Barang';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_barang_add', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->Toko_Model->addBarang($input);

            if ($insert) {
                set_pesan('Barang berhasil ditambahkan.');
                redirect('Admin/Data_Barang');
            } else {
                set_pesan('Barang gagal ditambahkan!', false);
                redirect('Admin/Data_Barang/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            //model
            $data['jenis'] = $this->Toko_Model->getAllJenis();
            $data['satuan'] = $this->Toko_Model->getAllSatuan();
            $data['barang'] = $this->Toko_Model->getBarangId($id);

            $data['title'] = "Data Barang";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_barang_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $update = $this->Toko_Model->updateBarang($id, $input);
            if ($update) {
                set_pesan('Barang berhasil di-update.');
                redirect('Admin/Data_Barang');
            } else {
                set_pesan('Barang gagal di-update.', false);
                redirect('Admin/Data_Barang/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteBarang($id);
        if ($delete) {
            set_pesan('Barang telah dihapus!', false);
        } else {
            set_pesan('Barang gagal dihapus!', false);
        }
        redirect('Admin/Data_Barang');
    }

    public function getstok($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->Toko_Model->cekStok($id);
        output_json($query);
    }

    public function harga()
    {
        //ambil data session login
        $data['akses'] = $this->akses;
        $data['user'] = $this->user;

        //model get Barang
        $data['barang'] = $this->Toko_Model->getBarang();

        $data['title'] = 'Data Harga';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_data_harga', $data);
        $this->load->view('templates/footer');
    }

    public function edit_harga($getId)
    {
        $id = encode_php_tags($getId);

        $this->form_validation->set_rules('harga', 'Harga Barang', 'required|numeric', [
            'numeric' => 'Harga yang anda masukkan tidak valid!'
        ]);
        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            //model
            $data['barang'] = $this->Toko_Model->getBarangId($id);

            $data['title'] = "Data Harga";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_harga_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            if ($input['harga'] >= $input['harga_masuk']) {
                $this->Toko_Model->updateBarang($id, $input);
                set_pesan('Harga berhasil di-update.');
                redirect('Admin/Data_Barang/harga');
            } else {
                set_pesan('Harga yang anda masukkan kurang dari harga masuk!', false);
                redirect('Admin/Data_Barang/edit_harga/' . $id);
            }
        }
    }

    public function QRcode($kode)
    {
        QRcode::png(
            $kode,
            $outfile = false,
            $level = QR_ECLEVEL_H,
            $size = 5,
            $margin = 2
        );
    }
}
