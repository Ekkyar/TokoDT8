<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Transaksi_Model extends CI_Model
{
    //-------------------------------------- Penjualan------------------------------------
    // ambil data transaksi/penjualan 
    public function getTransaksi($id = null)
    {
        if ($id == null) {
            $this->db->join('tb_user u', 'u.id_user=t.user_id');
            return $this->db->get('tb_transaksi t')->result();
        } else {
            $this->db->join('tb_user u', 'u.id_user=t.user_id');
            return $this->db->get_where('tb_transaksi t', ['id_transaksi' => $id])->row();
        }
    }

    // ambil data keranjang join tb_barang
    public function getKeranjang($where)
    {
        $this->db->select('k.id_item, b.id_barang, b.nama_barang, b.harga, k.qty');
        $this->db->join('tb_barang b', 'k.barang_id=b.id_barang');
        return $this->db->get_where('tb_keranjang k', $where)->result();
    }

    // ambil data keranjang join tb_barang (Total Keranjang (Jumlah Barang + Harga Barang))
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

    // cek item keranjang
    public function cekItem($where)
    {
        return $this->db->get_where('tb_keranjang', $where)->num_rows();
    }

    // update stok setelah stok di ambil ke keranjang
    public function updateQtyKeranjang($qty = 0, $where)
    {
        $getQty = $this->db->get_where('tb_keranjang', $where)->row()->qty;
        $result = (int) $getQty + (int) $qty;

        return $this->db->update('tb_keranjang', ['qty' => $result], $where);
    }

    // ambil data tb_detail_transaksi join tb_barang(id)
    public function getDetailTransaksi($id)
    {
        $this->db->select("b.nama_barang, td.qty, td.subtotal, (td.subtotal/td.qty) as harga");
        $this->db->join('tb_barang b', 'b.id_barang=td.barang_id');
        $this->db->where('transaksi_id', $id);
        return $this->db->get('tb_transaksi_detail td')->result();
    }

    //-------------------------------------- Barang Masuk------------------------------------
    // ambil data transaksi/penjualan 
    public function getBarangMasuk($id = null)
    {
        if ($id == null) {
            $this->db->join('tb_user u', 'u.id_user=bm.user_id');
            $this->db->join('tb_supplier s', 's.id_supplier=bm.supplier_id');
            return $this->db->get('tb_barang_masuk bm')->result();
        } else {
            $this->db->join('tb_user u', 'u.id_user=bm.user_id');
            $this->db->join('tb_supplier s', 's.id_supplier=bm.supplier_id');
            return $this->db->get_where('tb_barang_masuk bm', ['id_barang_masuk' => $id])->row();
        }
    }

    // ambil data keranjang join tb_barang
    public function getKeranjangMasuk($where)
    {
        $this->db->select('km.id_item, b.id_barang, b.nama_barang, km.qty, km.harga_masuk');
        $this->db->join('tb_barang b', 'km.barang_id=b.id_barang');
        return $this->db->get_where('tb_keranjang_masuk km', $where)->result();
    }

    // ambil data keranjang join tb_barang (Total Keranjang (Jumlah Barang + Harga Barang))
    public function getTotalKeranjangMasuk($where)
    {
        $keranjang = $this->db->get_where('tb_keranjang_masuk km', $where)->result();

        $subtotal = [];
        foreach ($keranjang as $km) {
            $subtotal[] = $km->qty * $km->harga_masuk;
        }

        return array_sum($subtotal);
    }

    // cek item keranjang
    public function cekItemMasuk($where)
    {
        return $this->db->get_where('tb_keranjang_masuk', $where)->num_rows();
    }

    // update stok setelah stok di ambil ke keranjang
    public function updateQtyKeranjangMasuk($qty = 0, $where)
    {
        $getQty = $this->db->get_where('tb_keranjang_masuk', $where)->row()->qty;
        $result = (int) $getQty + (int) $qty;

        return $this->db->update('tb_keranjang_masuk', ['qty' => $result], $where);
    }

    // ambil data tb_detail_transaksi join tb_barang(id)
    public function getDetailBarangMasuk($id)
    {
        $this->db->select("b.nama_barang, bd.harga_masuk, bd.qty, bd.subtotal, (bd.subtotal/bd.qty) as harga");
        $this->db->join('tb_barang b', 'b.id_barang=bd.barang_id');
        $this->db->where('barang_masuk_id', $id);
        return $this->db->get('tb_barang_masuk_detail bd')->result();
    }

    // public function getTotalBarangMasuk($bln = null, $custom = [])
    // {
    //     if ($bln != null) {
    //         $this->db->like('tanggal', $bln, 'after');
    //     }
    //     if ($custom != null) {
    //         $this->db->where('tanggal' . ' >=', $custom[0]);
    //         $this->db->where('tanggal' . ' <=', $custom[1]);
    //     }
    //     $this->db->select_sum('total', 'totalTransaksi');
    //     return $this->db->get('tb_transaksi')->row()->totalTransaksi;
    // }


    //-------------------------------------- Chart ------------------------------------
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

    public function getPengeluaran($bln = null, $custom = [])
    {
        if ($bln != null) {
            $this->db->like('tanggal', $bln, 'after');
        }
        if ($custom != null) {
            $this->db->where('tanggal' . ' >=', $custom[0]);
            $this->db->where('tanggal' . ' <=', $custom[1]);
        }
        $this->db->select_sum('total', 'totalPengeluaran');
        return $this->db->get('tb_barang_masuk')->row()->totalPengeluaran;
    }

    public function chartPengeluaran($date = null)
    {
        if ($date != null) {
            $this->db->like('tanggal', $date, 'after');
        }
        $this->db->select_sum('total', 'totalPengeluaran');
        return $this->db->get('tb_barang_masuk')->row()->totalPengeluaran;
    }
}
