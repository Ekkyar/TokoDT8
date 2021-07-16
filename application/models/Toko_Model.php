<?php

class Toko_Model extends CI_Model
{

    public function get($table, $data = null, $where = null)
    {
        if ($data != null) {
            return $this->db->get_where($table, $data)->row_array();
        } else {
            return $this->db->get_where($table, $where)->result_array();
        }
    }

    //------------------------------ USER ------------------------------
    //get All 
    public function getAllUser()
    {
        return $this->db->get('tb_user')->result_array();
    }
    //get by id
    public function getUser($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->get('tb_user')->result_array();
    }
    //add
    public function addUser($input_data)
    {
        return $this->db->insert('tb_user', $input_data);
    }
    //edit
    public function editUser($id, $input_data)
    {
        $this->db->where('id_user', $id);
        return $this->db->update('tb_user', $input_data);
    }
    //delete
    public function deleteUser($id)
    {
        $this->db->where('id_user', $id);
        return $this->db->delete('tb_user');
    }


    //------------------------------ AKSES ------------------------------
    public function getAllAkses()
    {
        return $this->db->get('tb_akses')->result_array();
    }

    //------------------------------ Supplier ------------------------------
    //get all
    public function getAllSupplier()
    {
        return $this->db->get('tb_supplier')->result_array();
    }
    //get by id
    public function getSupplier($id)
    {
        $this->db->where('id_supplier', $id);
        return $this->db->get('tb_supplier')->result_array();
    }
    //add
    public function addSupplier($input)
    {
        return $this->db->insert('tb_supplier', $input);
    }
    //edit
    public function updateSupplier($id, $input)
    {
        $this->db->where('id_supplier', $id);
        return $this->db->update('tb_supplier', $input);
    }
    //delete
    public function deleteSupplier($id)
    {
        $this->db->where('id_supplier', $id);
        return $this->db->delete('tb_supplier');
    }

    //------------------------------ Data Jenis ------------------------------
    //get all
    public function getAllJenis()
    {
        return $this->db->get('tb_jenis')->result_array();
    }
    //get by id
    public function getJenis($id)
    {
        $this->db->where('id_jenis', $id);
        return $this->db->get('tb_jenis')->result_array();
    }
    //add
    public function addJenis($input)
    {
        return $this->db->insert('tb_jenis', $input);
    }
    //edit
    public function updateJenis($id, $input)
    {
        $this->db->where('id_jenis', $id);
        return $this->db->update('tb_jenis', $input);
    }
    //delete
    public function deleteJenis($id)
    {
        $this->db->where('id_jenis', $id);
        return $this->db->delete('tb_jenis');
    }

    //------------------------------ Data Satuan ------------------------------
    //get all
    public function getAllSatuan()
    {
        return $this->db->get('tb_satuan')->result_array();
    }
    //get by id
    public function getSatuan($id)
    {
        $this->db->where('id_satuan', $id);
        return $this->db->get('tb_satuan')->result_array();
    }
    //add
    public function addSatuan($input)
    {
        return $this->db->insert('tb_satuan', $input);
    }
    //edit
    public function updateSatuan($id, $input)
    {
        $this->db->where('id_satuan', $id);
        return $this->db->update('tb_satuan', $input);
    }
    //delete
    public function deleteSatuan($id)
    {
        $this->db->where('id_satuan', $id);
        return $this->db->delete('tb_satuan');
    }

    //------------------------------ Data Barang ------------------------------
    // get
    public function getBarang()
    {
        $this->db->join('tb_jenis j', 'b.jenis_id = j.id_jenis');
        $this->db->join('tb_satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_barang');
        return $this->db->get('tb_barang b')->result_array();
    }
    //get by id
    public function getBarangId($id)
    {
        $this->db->where('id_barang', $id);
        return $this->db->get('tb_barang')->result_array();
    }
    //get all
    public function getAllBarang()
    {
        return $this->db->get('tb_barang')->result_array();
    }
    //add
    public function addBarang($input)
    {
        return $this->db->insert('tb_barang', $input);
    }
    //edit
    public function updateBarang($id, $input)
    {
        $this->db->where('id_barang', $id);
        return $this->db->update('tb_barang', $input);
    }
    //delete
    public function deleteBarang($id)
    {
        $this->db->where('id_barang', $id);
        return $this->db->delete('tb_barang');
    }

    //------------------------------ Barang Masuk ------------------------------
    // get
    public function getBarangMasuk($limit = null, $id_barang = null, $range = null)
    {
        $this->db->select('*');
        $this->db->join('tb_user u', 'bm.user_id = u.id_user');
        $this->db->join('tb_supplier sp', 'bm.supplier_id = sp.id_supplier');
        $this->db->join('tb_barang b', 'bm.barang_id = b.id_barang');
        $this->db->join('tb_satuan s', 'b.satuan_id = s.id_satuan');
        if ($limit != null) {
            $this->db->limit($limit);
        }

        if ($id_barang != null) {
            $this->db->where('id_barang', $id_barang);
        }

        if ($range != null) {
            $this->db->where('tanggal_masuk' . ' >=', $range['mulai']);
            $this->db->where('tanggal_masuk' . ' <=', $range['akhir']);
        }

        $this->db->order_by('id_barang_masuk', 'DESC');
        return $this->db->get('tb_barang_masuk bm')->result_array();
    }
    //add
    public function addBarangMasuk($input)
    {
        return $this->db->insert('tb_barang_masuk', $input);
    }
    //delete
    public function deleteBarangMasuk($id)
    {
        $this->db->where('id_barang_masuk', $id);
        return $this->db->delete('tb_barang_masuk');
    }

    //------------------------------ Barang Keluar ------------------------------
    //get
    public function getBarangKeluar($limit = null, $id_barang = null, $range = null)
    {
        $this->db->select('*');
        $this->db->join('tb_user u', 'bk.user_id = u.id_user');
        $this->db->join('tb_barang b', 'bk.barang_id = b.id_barang');
        $this->db->join('tb_satuan s', 'b.satuan_id = s.id_satuan');
        if ($limit != null) {
            $this->db->limit($limit);
        }
        if ($id_barang != null) {
            $this->db->where('id_barang', $id_barang);
        }
        if ($range != null) {
            $this->db->where('tanggal_keluar' . ' >=', $range['mulai']);
            $this->db->where('tanggal_keluar' . ' <=', $range['akhir']);
        }
        $this->db->order_by('id_barang_keluar', 'DESC');
        return $this->db->get('tb_barang_keluar bk')->result_array();
    }
    //add
    public function addBarangKeluar($input)
    {
        return $this->db->insert('tb_barang_keluar', $input);
    }
    //delete
    public function deleteBarangKeluar($id)
    {
        $this->db->where('id_barang_keluar', $id);
        return $this->db->delete('tb_barang_keluar');
    }

    //------------------------------ DB Set ------------------------------
    // get Max
    public function getMax($table, $field, $kode = null)
    {
        $this->db->select_max($field);
        if ($kode != null) {
            $this->db->like($field, $kode, 'after');
        }
        return $this->db->get($table)->row_array()[$field];
    }

    // count
    public function count($table)
    {
        return $this->db->count_all($table);
    }

    //sum
    public function sum($table, $field)
    {
        $this->db->select_sum($field);
        return $this->db->get($table)->row_array()[$field];
    }

    // min
    public function min($table, $field, $min)
    {
        $field = $field . ' <=';
        $this->db->where($field, $min);
        return $this->db->get($table)->result_array();
    }
    //chart barang masuk 
    public function chartBarangMasuk($bulan)
    {
        $like = 'T-BM-' . date('y') . $bulan;
        $this->db->like('id_barang_masuk', $like, 'after');
        return count($this->db->get('tb_barang_masuk')->result_array());
    }
    //chart barang keluar
    public function chartBarangKeluar($bulan)
    {
        $like = 'T-BK-' . date('y') . $bulan;
        $this->db->like('id_barang_keluar', $like, 'after');
        return count($this->db->get('tb_barang_keluar')->result_array());
    }
    //laporan
    public function laporan($table, $mulai, $akhir)
    {
        $tgl = $table == 'tb_barang_masuk' ? 'tanggal_masuk' : 'tanggal_keluar';
        $this->db->where($tgl . ' >=', $mulai);
        $this->db->where($tgl . ' <=', $akhir);
        return $this->db->get($table)->result_array();
    }
    //cek stok
    public function cekStok($id)
    {
        $this->db->join('tb_satuan s', 'b.satuan_id=s.id_satuan');
        return $this->db->get_where('tb_barang b', ['id_barang' => $id])->row_array();
    }
    //------------------------------  ------------------------------
}
