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
        //load model
        $this->load->model('Toko_Model');
        //form validation
        $this->load->library('form_validation');
    }

    public function index()
    {
        //title
        $data['title'] = 'Data Barang';

        //ambil data session login
        $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
        $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

        //model get Barang
        $data['barang'] = $this->Toko_Model->getBarang();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_data_barang', $data);
        $this->load->view('templates/admin_footer', $data);
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_barang', 'Nama Barang', 'required|trim');
        $this->form_validation->set_rules('jenis_id', 'Jenis Barang', 'required');
        $this->form_validation->set_rules('satuan_id', 'Satuan Barang', 'required');
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            //title
            $data['title'] = 'Data Barang';

            //ambil data session login
            $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
            $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

            //model
            $data['jenis'] = $this->Toko_Model->getAllJenis();
            $data['satuan'] = $this->Toko_Model->getAllSatuan();

            //mengenerate ID Barang
            $kode_terakhir = $this->Toko_Model->getMax('tb_barang', 'id_barang');
            $kode_tambah = substr($kode_terakhir, -6, 6);
            $kode_tambah++;
            $number = str_pad($kode_tambah, 6, '0', STR_PAD_LEFT);
            $data['id_barang'] = 'B' . $number;

            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_barang_add', $data);
            $this->load->view('templates/admin_footer', $data);
        } else {
            $input = $this->input->post(null, true);
            $insert = $this->Toko_Model->addBarang($input);

            if ($insert) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang berhasil ditambahkan.</div>');
                redirect('Admin/Data_Barang');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang berhasil ditambahkan.</div>');
                redirect('Admin/Data_Barang/add');
            }
        }
    }

    public function edit($getId)
    {
        $id = encode_php_tags($getId);
        $this->_validasi();

        if ($this->form_validation->run() == false) {
            $data['title'] = "Data Barang";

            //ambil data session login
            $data['akses'] = $this->db->get_where('tb_akses', ['id_akses' => $this->session->userdata('id_akses')])->row_array();
            $data['user'] = $this->db->get_where('tb_user', ['username' => $this->session->userdata('username')])->row_array();

            //model
            $data['jenis'] = $this->Toko_Model->getAllJenis();
            $data['satuan'] = $this->Toko_Model->getAllSatuan();
            $data['barang'] = $this->Toko_Model->getBarangId($id);

            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_barang_edit', $data);
            $this->load->view('templates/admin_footer', $data);
        } else {
            $input = $this->input->post(null, true);
            $update = $this->Toko_Model->updateBarang($id, $input);
            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Barang berhasil diedit.</div>');
                redirect('Admin/Data_Barang');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Barang gagal diedit!</div>');
                redirect('Admin/Data_Barang/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteBarang($id);
        if ($delete) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Barang telah dihapus!</div>');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Barang gagal dihapus!</div>');
        }
        redirect('Admin/Data_Barang');
    }

    public function getstok($getId)
    {
        $id = encode_php_tags($getId);
        $query = $this->Toko_Model->cekStok($id);
        output_json($query);
    }
}
