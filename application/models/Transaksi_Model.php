<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_Model extends CI_Model
{

    public function getKeranjang($where)
    {
        $this->db->select('k.id_item, b.id_barang, b.nama_barang, b.harga, k.qty');
        $this->db->join('tb_barang b', 'k.barang_id=b.id_barang');
        return $this->db->get_where('tb_keranjang k', $where)->result();
    }
    public function getBarang()
    {
        $this->db->join('tb_jenis j', 'b.jenis_id = j.id_jenis');
        $this->db->join('tb_satuan s', 'b.satuan_id = s.id_satuan');
        $this->db->order_by('id_barang');
        return $this->db->get('tb_barang b')->result_array();
    }

    public function cekItem($where)
    {
        return $this->db->get_where('tb_keranjang', $where)->num_rows();
    }

    public function updateQtyKeranjang($qty = 0, $where)
    {
        $getQty = $this->db->get_where('tb_keranjang', $where)->row()->qty;
        $result = (int) $getQty + (int) $qty;

        return $this->db->update('tb_keranjang', ['qty' => $result], $where);
    }

    public function getTotalKeranjang($where)
    {
        $this->db->join('tb_barang b', 'b.id_barang=k.barang_id');
        $keranjang = $this->db->get_where('tb_keranjang k', $where)->result();

        $subtotal = [];
        foreach ($keranjang as $k) {
            $subtotal[] = $k->qty * $k->harga;
        }

        return array_sum($subtotal);
    }

    public function getTransaksi($id = null)
    {
        if ($id == null) {
            return $this->db->get('tb_transaksi')->result();
        } else {
            $this->db->join('tb_user u', 'u.id_user=t.user_id');
            return $this->db->get_where('tb_transaksi t', ['id_transaksi' => $id])->row();
        }
    }

    public function getDetailTransaksi($id)
    {
        // $this->db->select("namaBarang, harga, qty, (harga*qty) as subtotal");
        // $this->db->join('barang b', 'b.kdBarang=td.kdBarang');
        // $this->db->where('idTransaksi', $id);
        // return $this->db->get('transaksi_detail td')->result();

        $this->db->select("b.nama_barang, td.qty, td.subtotal, (td.subtotal/td.qty) as harga");
        $this->db->join('tb_barang b', 'b.id_barang=td.barang_id');
        $this->db->where('transaksi_id', $id);
        return $this->db->get('tb_transaksi_detail td')->result();
    }
    // public function getTotalHarga($id)
    // {
    //     $this->db->select("sum(harga*qty) as total");
    //     $this->db->join('barang b', 'b.kdBarang=td.kdBarang');
    //     $this->db->where('idTransaksi', $id);
    //     return $this->db->get('transaksi_detail td')->row()->total;
    // }



    public function getLaporanTransaksi($tgl1, $tgl2)
    {
        $this->db->join('tb_user u', 'u.id_user=t.user_id');
        if ($tgl1 != null && $tgl2 != null) {
            $this->db->where('tanggal' . ' >=', $tgl1);
            $this->db->where('tanggal' . ' <=', $tgl2);
        }
        return $this->db->get('tb_transaksi t')->result();
    }

    public function getTotalTransaksi($bln = null, $custom = [])
    {
        if ($bln != null) {
            $this->db->like('tanggal', $bln, 'after');
        }
        if ($custom != null) {
            $this->db->where('tanggal' . ' >=', $custom[0]);
            $this->db->where('tanggal' . ' <=', $custom[1]);
        }
        $this->db->select_sum('total', 'totalTransaksi');
        return $this->db->get('tb_transaksi')->row()->totalTransaksi;
    }

    public function chartTransaksi($date = null)
    {
        if ($date != null) {
            $this->db->like('tanggal', $date, 'after');
        }
        $this->db->select_sum('total', 'totalTransaksi');
        return $this->db->get('tb_transaksi')->row()->totalTransaksi;
    }
}
