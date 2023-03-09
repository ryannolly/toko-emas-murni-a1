<?php

class Model_admin extends CI_Model {
    public function cek_ada_tidak_sama($where, $table){
        $this->db->where($where);
        $query = $this->db->get($table);
        
        if($query->num_rows() > 0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    public function tambah_data($table, $data){
        $this->db->insert($table, $data);
    }

    public function tampil_data($table, $id, $urutan){
        return $this->db->order_by($id, $urutan)->get($table);
    }

    public function hapus_data($where, $table){
        $this->db->where($where);
        $this->db->delete($table);
    }

    public function get_data_from_uuid($where, $table){
        return $this->db->where($where)->get($table);
    }

    public function ubah_data($where, $data, $table){
        $this->db->where($where);
        $this->db->update($table, $data);
    }

    public function tampil_data_barang(){
        $sql = "SELECT bar.*, rak.nama_rak, kadar.nama_kadar
        FROM ms_barang bar
        LEFT JOIN ms_rak rak ON rak.id = bar.id_rak
        LEFT JOIN ms_kadar kadar ON kadar.id = bar.id_kadar";

        return $this->db->query($sql)->result();
    }

    public function get_detail_barang($where){
        $sql = "SELECT bar.*, rak.nama_rak, kadar.nama_kadar
        FROM ms_barang bar
        LEFT JOIN ms_rak rak ON rak.id = bar.id_rak
        LEFT JOIN ms_kadar kadar ON kadar.id = bar.id_kadar WHERE bar.uuid = ?";

        return $this->db->query($sql, array($where['uuid']))->row();
    }

    public function kurang_stok($uuid){
        $sql = "UPDATE ms_barang SET stok = stok - 1 WHERE uuid = ?";

        $this->db->query($sql, array($uuid));
    }

    public function get_barang_pada_rak($Id){
        $this->db->select("barang.*, kadar.nama_kadar");
        $this->db->from("ms_barang barang");
        $this->db->join("ms_kadar kadar", "kadar.id = barang.id_kadar", "left");
        $this->db->where("barang.id_rak", $Id);
        $this->db->where("barang.stok != 0");

        $query = $this->db->get();
        return $query->result();
    }

    public function get_barang_pada_kadar($Id){
        $this->db->select("barang.*, rak.nama_rak");
        $this->db->from("ms_barang barang");
        $this->db->join('ms_rak rak', "rak.id = barang.id_rak", "left");
        $this->db->where("barang.id_kadar", $Id);
        $this->db->where("barang.stok != 0");

        $query = $this->db->get();
        return $query->result();
    }
}

?>