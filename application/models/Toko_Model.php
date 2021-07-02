<?php

class Toko_Model extends CI_Model
{
    //------------------------------ USER ------------------------------
    public function getAllUser()
    {
        return $this->db->get('tb_user')->result_array();
    }

    public function getUser($id_user)
    {
        $this->db->where('id_user', $id_user);
        return $this->db->get('tb_user')->result_array();
    }

    public function deleteUser($id_user)
    {
        $this->db->where('id_user', $id_user);
        $this->db->delete('tb_user');
    }

    public function editUser($id_user)
    {
        $data = [
            "nama" => htmlspecialchars($this->input->post('nama', true)),
            "alamat" => htmlspecialchars($this->input->post('alamat', true)),
            "kontak" => htmlspecialchars($this->input->post('kontak', true)),
            "id_akses" => htmlspecialchars($this->input->post('id_akses', true))
        ];
        $this->db->where('id_user', $id_user);
        $this->db->update('tb_user', $data);
    }

    //------------------------------ AKSES ------------------------------
    public function getAllAkses()
    {
        return $this->db->get('tb_akses')->result_array();
    }
}
