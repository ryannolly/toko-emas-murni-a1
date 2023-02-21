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
}

?>