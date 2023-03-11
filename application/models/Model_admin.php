<?php

class Model_admin extends CI_Model {
    //Untuk Datatables
    public $column_order;
    public $column_search;
    public $order;

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

    //Datatables Data Barang
    function _get_datatables_data_barang_query($where){
        $this->db->select('bar.*, rak.nama_rak, kadar.nama_kadar');
        $this->db->from('ms_barang bar');
        if(!empty($where['id_rak'])){
            $this->db->where('bar.id_rak', $where['id_rak']);
        }
        if(!empty($where['id_kadar'])){
            $this->db->where('bar.id_kadar', $where['id_kadar']);
        }
        $this->db->join('ms_rak rak', 'rak.id = bar.id_rak', 'left');
        $this->db->join('ms_kadar kadar', 'kadar.id = bar.id_kadar', 'left');
        $this->db->order_by('bar.nama_barang ASC, bar.stok DESC');

        $i = 0;
        foreach($this->column_search as $item){
            if(@$_POST['search']['value']){
                if($i === 0){
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                }else{
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if(count($this->column_search) - 1 == $i) //Last Loop
                    $this->db->group_end();
            }
            $i++;
        }

        if(isset($_POST['order'])) { // here order processing
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        }else if(isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_data_barang($table, $where) {
        $this->_get_datatables_data_barang_query($where);
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_data_barang($where) {
        $this->_get_datatables_data_barang_query($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_data_barang($where) {
        $this->db->from('ms_barang');
        // if(!empty($where['KdProdi'])){
        //     $this->db->where('ms_data_dosen.KdProdi', $where['KdProdi']);
        // }
        return $this->db->count_all_results();
    }
    //-- Datatables Data Barang
}

?>