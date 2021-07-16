<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_Satuan extends CI_Controller
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

        //model get All Satuan
        $data['satuan'] = $this->Toko_Model->getAllSatuan();

        $data['title'] = 'Data Satuan';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/admin_sidebar', $data);
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/v_data_satuan', $data);
        $this->load->view('templates/footer');
    }

    private function _validasi()
    {
        $this->form_validation->set_rules('nama_satuan', 'Nama Satuan', 'required|trim|is_unique[tb_satuan.nama_satuan]', [
            'is_unique' => 'Satuan barang telah tersedia!'
        ]);
    }

    public function add()
    {
        $this->_validasi();
        if ($this->form_validation->run() == false) {
            //ambil data session login
            $data['akses'] = $this->akses;
            $data['user'] = $this->user;

            $data['title'] = 'Data Satuan';
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_satuan_add', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $save = $this->Toko_Model->addSatuan($input);

            if ($save) {
                set_pesan('Satuan barang berhasil ditambahkan.');
                redirect('Admin/Data_Satuan');
            } else {
                set_pesan('Satuan barang gagal ditambahkan!', false);
                redirect('Admin/Data_Satuan/add');
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

            //model get satuan
            $data['satuan'] = $this->Toko_Model->getSatuan($id);

            $data['title'] = "Data Satuan";
            $this->load->view('templates/header', $data);
            $this->load->view('templates/admin_sidebar', $data);
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('admin/v_data_satuan_edit', $data);
            $this->load->view('templates/footer');
        } else {
            $input = $this->input->post(null, true);
            $update = $this->Toko_Model->updateSatuan($id, $input);
            if ($update) {
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Satuan barang berhasil diedit.</div>');
                set_pesan('Satuan barang berhasil di-update.');
                redirect('Admin/Data_Satuan');
            } else {
                set_pesan('Satuan barang gagal di-update.', false);
                redirect('Admin/Data_Satuan/edit/' . $id);
            }
        }
    }

    public function delete($getId)
    {
        $id = encode_php_tags($getId);
        $delete = $this->Toko_Model->deleteSatuan($id);
        if ($delete) {
            set_pesan('Satuan barang telah dihapus!', false);
            redirect('Admin/Data_Satuan');
        } else {
            set_pesan('Satuan barang gagal dihapus!', false);
            redirect('Admin/Data_Satuan');
        }
    }
}
