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

    public function get_detail_barang_penjualan($where){
        $sql = "SELECT bar.*, rak.nama_rak, kadar.nama_kadar 
        FROM ms_barang bar
        LEFT JOIN ms_rak rak ON rak.id = bar.id_rak
        LEFT JOIN ms_kadar kadar ON kadar.id = bar.id_kadar WHERE bar.uuid = ? AND bar.stok > 0";

        return $this->db->query($sql, array($where['uuid']))->row();
    }

    public function get_detail_barang_penjualan_checklist($where){
        $sql = "SELECT bar.*, rak.nama_rak, kadar.nama_kadar 
        FROM ms_barang bar
        LEFT JOIN ms_rak rak ON rak.id = bar.id_rak
        LEFT JOIN ms_kadar kadar ON kadar.id = bar.id_kadar WHERE bar.uuid = ? AND bar.id_rak = ?";

        return $this->db->query($sql, array($where['uuid'], $where['id_rak']))->row();
    }


    public function kurang_stok($uuid){
        $sql = "UPDATE ms_barang SET stok = stok - 1 WHERE uuid = ?";

        $this->db->query($sql, array($uuid));
    }

    public function get_barang_pada_rak($Id){
        $this->db->select("barang.*, kadar.nama_kadar, rak.nama_rak");
        $this->db->from("ms_barang barang");
        $this->db->join("ms_kadar kadar", "kadar.id = barang.id_kadar", "left");
        $this->db->join("ms_rak rak", "rak.Id = barang.id_rak", "left");
        $this->db->where("barang.id_rak", $Id);
        $this->db->order_by("kadar.id DESC");
        //$this->db->where("barang.stok != 0");

        $query = $this->db->get();
        return $query->result();
    }

    public function get_barang_pada_rak_berurut($Id){
        $this->db->select("barang.*, kadar.nama_kadar, rak.nama_rak");
        $this->db->from("ms_barang barang");
        $this->db->join("ms_kadar kadar", "kadar.id = barang.id_kadar", "left");
        $this->db->join("ms_rak rak", "rak.Id = barang.id_rak", "left");
        $this->db->where("barang.id_rak", $Id);
        $this->db->order_by("barang.id ASC");
        //$this->db->where("barang.stok != 0");

        $query = $this->db->get();
        return $query->result();
    }

    public function get_barang_pada_rak_with_condition($Id, $tgl_input_real, $sampai_jam){
        $this->db->select("barang.*, kadar.nama_kadar");
        $this->db->from("ms_barang barang");
        $this->db->join("ms_kadar kadar", "kadar.id = barang.id_kadar", "left");
        $this->db->where("barang.id_rak", $Id);
        $this->db->where("barang.tgl_input_real", $tgl_input_real);
        $this->db->where("barang.tgl_input_real_jam >=", $sampai_jam);
        //$this->db->where("barang.stok != 0");

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

    function create_kode_penjualan(){
        $data = array(
            'TglProses' => time(),
            'usrid'     => $this->session->userdata("username")
        );

        $this->tambah_data("ms_penjualan", $data);

        $sql = "SELECT KdPenjualan FROM ms_penjualan ORDER BY KdPenjualan DESC LIMIT 1";
        $KdPenjualan = $this->db->query($sql)->row()->KdPenjualan;

        return $KdPenjualan;
    }

    function create_kode_pengembalian(){
        $data = array(
            'TglProses' => time(),
            'usrid'     => $this->session->userdata("username")
        );

        $this->tambah_data("ms_pengembalian", $data);

        $sql = "SELECT KdPengembalian FROM ms_pengembalian ORDER BY KdPengembalian DESC LIMIT 1";
        $KdPenjualan = $this->db->query($sql)->row()->KdPengembalian;

        return $KdPenjualan;
    }

    function create_kode_pengeluaran(){
        $data = array(
            'TglProses' => time(),
            'usrid'     => $this->session->userdata("username")
        );

        $this->tambah_data("ms_pengeluaran", $data);

        $sql = "SELECT KdPengeluaran FROM ms_pengeluaran ORDER BY KdPengeluaran DESC LIMIT 1";
        $KdPenjualan = $this->db->query($sql)->row()->KdPengeluaran;

        return $KdPenjualan;
    }

    function create_kd_buku_besar(){
        $data = array(
            'TglBukuBesar'        => date("Y-m-d", time()),
            'JamBukaToko'         => time(),
            'JamTutupToko'        => 0,
            'UserBukaToko'        => $this->session->userdata("username"),
            'UserTutupToko'       => ""
        );

        $this->tambah_data("ms_dashboard_big_book", $data);

        $sql = "SELECT KdBukuBesar FROM ms_dashboard_big_book ORDER BY KdBukuBesar DESC LIMIT 1";
        $KdPenjualan = $this->db->query($sql)->row()->KdBukuBesar;

        return $KdPenjualan;
    }

    function get_data_barang_for_qr($where){
        $this->db->select('bar.*, rak.nama_rak, kadar.nama_kadar');
        $this->db->from('ms_barang bar');
        // if(!empty($where['id_rak'])){
        //     $this->db->where('bar.id_rak', $where['id_rak']);
        // }
        // if(!empty($where['id_kadar'])){
        //     $this->db->where('bar.id_kadar', $where['id_kadar']);
        // }
        $this->db->join('ms_rak rak', 'rak.id = bar.id_rak', 'left');
        $this->db->join('ms_kadar kadar', 'kadar.id = bar.id_kadar', 'left');
        $this->db->where("id_rak", $where['id_rak']);
        if(!empty($where['tgl_input_real'])){
            $this->db->where("tgl_input_real", $where['tgl_input_real']);
        }
        if(!empty($where['sampai_jam'])){
            $sampai_jam = $where['tgl_input_real'] . " " . $where['sampai_jam'];
            $this->db->where("tgl_input_real_jam >=", $sampai_jam);
        }   
        $this->db->order_by('bar.Id DESC');

        $query = $this->db->get();
        return $query->result();
    }

    function get_data_barang_for_qr_single($where){
        $this->db->select('bar.*, rak.nama_rak, kadar.nama_kadar');
        $this->db->from('ms_barang bar');
        // if(!empty($where['id_rak'])){
        //     $this->db->where('bar.id_rak', $where['id_rak']);
        // }
        // if(!empty($where['id_kadar'])){
        //     $this->db->where('bar.id_kadar', $where['id_kadar']);
        // }
        $this->db->join('ms_rak rak', 'rak.id = bar.id_rak', 'left');
        $this->db->join('ms_kadar kadar', 'kadar.id = bar.id_kadar', 'left');
        $this->db->where("bar.id", $where['id']);
        $this->db->order_by('bar.Id DESC');

        $query = $this->db->get();
        return $query->result();
    }

    //Untuk Data Riwayat Penjualan

    //Datatables Data Barang
    function _get_datatables_data_riwayat_penjualan_query($where){
        $this->db->select('penjualan.*');
        $this->db->from('ms_penjualan penjualan');
        if(!empty($where['tanggal_mulai'])){
            $this->db->where('penjualan.TglProses >=', $where['tanggal_mulai']);
        }
        if(!empty($where['tanggal_berakhir'])){
            $this->db->where('penjualan.TglProses <=', $where['tanggal_berakhir']);
        }
        $this->db->order_by('penjualan.TglProses', "DESC");

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

    function get_datatables_data_riwayat_penjualan($table, $where) {
        $this->_get_datatables_data_riwayat_penjualan_query($where);
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_data_riwayat_penjualan($where) {
        $this->_get_datatables_data_riwayat_penjualan_query($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_data_riwayat_penjualan($where) {
        $this->db->from('ms_penjualan');
        // if(!empty($where['KdProdi'])){
        //     $this->db->where('ms_data_dosen.KdProdi', $where['KdProdi']);
        // }
        return $this->db->count_all_results();
    }

    function get_data_penjualan_by_kd_penjualan($KdPenjualan){
        $this->db->select("penjualan.*, rak.nama_rak, IF(barang.nama_barang IS NULL, barpus.nama_barang, barang.nama_barang) AS nama_barang, kadar.nama_kadar, IF(barang.foto IS NULL, barpus.foto, barang.foto) AS foto");
        $this->db->from("tr_penjualan penjualan");
        $this->db->join("ms_barang barang", "penjualan.id_barang = barang.id", 'left');
        $this->db->join("ms_barang_hapus barpus", "barpus.id = penjualan.id_barang", "left");
        $this->db->join("ms_rak rak", "penjualan.id_rak = rak.id", 'left');
        $this->db->join("ms_kadar kadar", "barang.id_kadar = kadar.id OR barpus.id_kadar = kadar.id", 'left');
        $this->db->where("penjualan.KdPenjualan", $KdPenjualan);

        $query = $this->db->get();
        return $query->result();
    }

    //End of Data Riwayat Penjualan

    //Data Riwayat Pengembalian
    function _get_datatables_data_riwayat_pengembalian_query($where){
        $this->db->select('pengembalian.*');
        $this->db->from('ms_pengembalian pengembalian');
        if(!empty($where['tanggal_mulai'])){
            $this->db->where('pengembalian.TglProses >=', $where['tanggal_mulai']);
        }
        if(!empty($where['tanggal_berakhir'])){
            $this->db->where('pengembalian.TglProses <=', $where['tanggal_berakhir']);
        }
        $this->db->order_by('pengembalian.TglProses', "DESC");

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

    function get_datatables_data_riwayat_pengembalian($table, $where) {
        $this->_get_datatables_data_riwayat_pengembalian_query($where);
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_data_riwayat_pengembalian($where) {
        $this->_get_datatables_data_riwayat_pengembalian_query($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_data_riwayat_pengembalian($where) {
        $this->db->from('ms_pengembalian');
        // if(!empty($where['KdProdi'])){
        //     $this->db->where('ms_data_dosen.KdProdi', $where['KdProdi']);
        // }
        return $this->db->count_all_results();
    }

    function get_data_pengembalian_by_kd_pengembalian($KdPenjualan){
        $this->db->select("pengembalian.*, rak.nama_rak, barang.nama_barang, kadar.nama_kadar, barang.foto");
        $this->db->from("tr_pengembalian pengembalian");
        $this->db->join("ms_barang barang", "pengembalian.id_barang = barang.id", 'left');
        $this->db->join("ms_rak rak", "barang.id_rak = rak.id", 'left');
        $this->db->join("ms_kadar kadar", "pengembalian.id_kadar = kadar.id", 'left');
        $this->db->where("pengembalian.KdPengembalian", $KdPenjualan);

        $query = $this->db->get();
        return $query->result();
    }

    //End Of Data Riwayat Pengembalian

    //Menghitung jumlah pengeluaran
    function get_dashboard_penjualan($hari, $ashita){
        $sql = "SELECT COALESCE(SUM(penjualan.nilai_barang), 0) AS Harga, COUNT(penjualan.nilai_barang) AS Banyak, COALESCE(SUM(penjualan.berat_asli), 0) AS Berat FROM ms_penjualan ms
                LEFT JOIN tr_penjualan penjualan ON penjualan.KdPenjualan = ms.KdPenjualan
                WHERE ms.TglProses >= ? AND ms.TglProses <= ?";

        $query = $this->db->query($sql, array($hari, $ashita));
        return $query->row();
    }

    function get_dashboard_penjualan_group_by($hari, $ashita, $group_by){
        $sql = "SELECT ? AS Nama,  COALESCE(SUM(penjualan.nilai_barang), 0) AS Harga, COUNT(penjualan.nilai_barang) AS Banyak, COALESCE(SUM(penjualan.berat_asli), 0) AS Berat FROM ms_penjualan ms
                LEFT JOIN tr_penjualan penjualan ON penjualan.KdPenjualan = ms.KdPenjualan
                LEFT JOIN ms_rak rak ON rak.id = penjualan.id_rak
                LEFT JOIN ms_kadar kadar on kadar.id = penjualan.id_kadar
                WHERE ms.TglProses >= ? AND ms.TglProses <= ? GROUP BY ?";

        $query = $this->db->query($sql, array($group_by, $hari, $ashita, $group_by));
        return $query->result();
    }

    function get_dashboard_pengembalian($hari, $ashita){
        $sql = "SELECT COALESCE(SUM(penjualan.uang), 0) AS Harga, COUNT(penjualan.uang) AS Banyak, COALESCE(SUM(penjualan.berat_asli), 0) AS Berat FROM ms_pengembalian ms
                LEFT JOIN tr_pengembalian penjualan ON penjualan.KdPengembalian = ms.KdPengembalian
                WHERE ms.TglProses >= ? AND ms.TglProses <= ?";

        $query = $this->db->query($sql, array($hari, $ashita));
        return $query->row();
    }

    function get_dashboard_pengembalian_group_by($hari, $ashita, $group_by){
        $sql = "SELECT ? AS Nama, COALESCE(SUM(penjualan.uang), 0) AS Harga, COUNT(penjualan.uang) AS Banyak, COALESCE(SUM(penjualan.berat_asli), 0) AS Berat FROM ms_pengembalian ms
                LEFT JOIN tr_pengembalian penjualan ON penjualan.KdPengembalian = ms.KdPengembalian
                LEFT JOIN ms_kadar kadar on kadar.id = penjualan.id_kadar
                WHERE ms.TglProses >= ? AND ms.TglProses <= ? GROUP BY ?";

        $query = $this->db->query($sql, array($group_by, $hari, $ashita, $group_by));
        return $query->result();
    }

    function get_big_book_dashboard($kyou){
        $this->db->select("detail.*, big_book.JamBukaToko, big_book.JamTutupToko, big_book.UserBukaToko, big_book.UserTutupToko, rak.nama_rak");
        $this->db->from("ms_dashboard_big_book big_book");
        $this->db->join("tr_detail_dashboard_big_book detail", "detail.KdBukuBesar = big_book.KdBukuBesar", "left");
        $this->db->join('ms_rak rak', "rak.id = detail.id_rak", "left");
        $this->db->where("big_book.TglBukuBesar", $kyou);

        $query = $this->db->get();
        return $query->result();
    }

    function get_tgl_big_book_dashboard_terakhir(){
        $this->db->select("big_book.TglBukuBesar");
        $this->db->from("ms_dashboard_big_book big_book");
        $this->db->order_by("big_book.TglBukuBesar", "DESC");
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row();
    }

    function get_big_book_dashboard_terakhir($kyou){
        $this->db->select("detail.*, big_book.JamBukaToko, big_book.JamTutupToko, big_book.UserBukaToko, big_book.UserTutupToko, rak.nama_rak");
        $this->db->from('ms_rak rak');
        $this->db->join("tr_detail_dashboard_big_book detail", "detail.id_rak = rak.id", "left");
        $this->db->join("ms_dashboard_big_book big_book", "big_book.KdBukuBesar = detail.KdBukuBesar", "left");
        $this->db->where("big_book.TglBukuBesar", $kyou);

        $query = $this->db->get();
        return $query->result();
    }

    //Start of Riwayat Pengeluaran Barang
   
    function _get_datatables_data_riwayat_pengeluaran_query($where){
        $this->db->select('pengeluaran.*');
        $this->db->from('ms_pengeluaran pengeluaran');
        if(!empty($where['tanggal_mulai'])){
            $this->db->where('pengeluaran.TglProses >=', $where['tanggal_mulai']);
        }
        if(!empty($where['tanggal_berakhir'])){
            $this->db->where('pengeluaran.TglProses <=', $where['tanggal_berakhir']);
        }
        $this->db->order_by('pengeluaran.TglProses', "DESC");

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

    function get_datatables_data_riwayat_pengeluaran($table, $where) {
        $this->_get_datatables_data_riwayat_pengeluaran_query($where);
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_data_riwayat_pengeluaran($where) {
        $this->_get_datatables_data_riwayat_pengeluaran_query($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_data_riwayat_pengeluaran($where) {
        $this->db->from('ms_pengeluaran');
        // if(!empty($where['KdProdi'])){
        //     $this->db->where('ms_data_dosen.KdProdi', $where['KdProdi']);
        // }
        return $this->db->count_all_results();
    }

    function get_data_pengeluaran_by_kd_pengeluaran($KdPenjualan){
        $this->db->select("pengeluaran.*, rak.nama_rak, IF(barang.nama_barang IS NULL, barpus.nama_barang, barang.nama_barang) AS nama_barang, kadar.nama_kadar, IF(barang.foto IS NULL, barpus.foto, barang.foto) AS barang");
        $this->db->from("tr_pengeluaran pengeluaran");
        $this->db->join("ms_barang barang", "pengeluaran.id_barang = barang.id", 'left');
        $this->db->join("ms_barang_hapus barpus", "barpus.id = pengeluaran.id_barang", "left");
        $this->db->join("ms_rak rak", "barang.id_rak = rak.id OR barpus.id_rak = rak.id", 'left');
        $this->db->join("ms_kadar kadar", "pengeluaran.id_kadar = kadar.id", 'left');
        $this->db->where("pengeluaran.KdPengeluaran", $KdPenjualan);

        $query = $this->db->get();
        return $query->result();
    }

    function get_berat_total_per_rak($id_rak, $tanggal){
        $sql = "SELECT SUM(berat_jual) AS Berat, COUNT(berat_jual) AS Qty FROM ms_barang WHERE id_rak = ? AND tgl_input_real = ?";

        $query = $this->db->query($sql, array($id_rak, $tanggal));
        return $query->row();
    }

    function get_pengeluaran_per_rak($id_rak, $tanggal, $ashita){
        $sql = "SELECT SUM(pengeluaran.berat_terima) AS Berat, COUNT(IF(barang.berat_jual IS NULL, barpus.berat_jual, barang.berat_jual)) AS Qty
                FROM tr_pengeluaran pengeluaran
                LEFT JOIN ms_pengeluaran ms ON ms.KdPengeluaran = pengeluaran.KdPengeluaran
                LEFT JOIN ms_barang barang ON barang.Id = pengeluaran.id_barang
                LEFT JOIN ms_barang_hapus barpus ON barpus.Id = pengeluaran.id_barang
                WHERE ms.TglProses >= ? AND ms.TglProses <= ? AND (barang.id_rak = ? OR barpus.id_rak = ?)";

        $query = $this->db->query($sql, array($tanggal, $ashita, $id_rak, $id_rak));
        return $query->row();
    }

    function get_penjualan_per_rak($id_rak, $tanggal, $ashita){
        $sql = "SELECT SUM(penjualan.berat_asli) AS Berat, COUNT(penjualan.berat_jual) AS Qty
                FROM tr_penjualan penjualan
                LEFT JOIN ms_penjualan ms ON ms.KdPenjualan = penjualan.KdPenjualan                
                LEFT JOIN ms_barang barang ON barang.Id = penjualan.id_barang
                LEFT JOIN ms_barang_hapus barpus ON barpus.Id = penjualan.id_barang
                WHERE ms.TglProses >= ? AND ms.TglProses <= ? AND (barang.id_rak = ? OR barpus.id_rak = ?)";

        $query = $this->db->query($sql, array($tanggal, $ashita, $id_rak, $id_rak));
        return $query->row();
    }

    function get_ajax_kadar_by_rak($Id_Rak){
        $sql = "SELECT kadar.id, kadar.nama_kadar, IF(rak.Id IS NOT NULL, 'selected', '') AS Status
                FROM ms_kadar kadar
                LEFT JOIN ms_rak rak ON rak.id_kadar = kadar.id AND rak.id = ?";
        
        $query = $this->db->query($sql, array($Id_Rak));
        return $query->result();
    }

    //End Of Riwayat Pengeluaran Barang

    function get_barang_pada_rak_checklist($Id){
        $this->db->select("check.id_barang, rak.nama_rak, barang.nama_barang, kadar.nama_kadar");
        $this->db->from("tr_checklist_barang check");
        $this->db->join("ms_barang barang", "barang.Id = check.id_barang", "left");
        $this->db->join("ms_rak rak", "rak.Id = check.id_rak", "left");
        $this->db->join("ms_kadar kadar", "kadar.Id = barang.id_kadar", "left");
        $this->db->where("check.id_rak", $Id);

        $query = $this->db->get();
        return $query->result();
    }

    function generate_checklist_barang($Id){
        $sql = "INSERT INTO tr_checklist_barang (id_rak, id_barang)
                SELECT barang.id_rak, barang.id FROM ms_barang barang WHERE barang.id_rak = ?";

        $this->db->query($sql, array($Id));
    }

    //Start of Riwayat Penghapusan Barang
    function _get_datatables_data_barang_penghapusan_query($where){
        $this->db->select('bar.*, rak.nama_rak, kadar.nama_kadar');
        $this->db->from('ms_barang_hapus bar');
        if(!empty($where['id_rak'])){
            $this->db->where('bar.id_rak', $where['id_rak']);
        }
        if(!empty($where['id_kadar'])){
            $this->db->where('bar.id_kadar', $where['id_kadar']);
        }
        if(!empty($where['tanggal_awal'])){
            $this->db->where("bar.tanggal_hapus >= ", strtotime($where['tanggal_awal']));
        }
        if(!empty($where['tanggal_akhir'])){
            $this->db->where("bar.tanggal_hapus <= ", strtotime($where['tanggal_akhir']));
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

    function get_datatables_data_barang_penghapusan($table, $where) {
        $this->_get_datatables_data_barang_penghapusan_query($where);
        if(@$_POST['length'] != -1)
        $this->db->limit(@$_POST['length'], @$_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_data_barang_penghapusan($where) {
        $this->_get_datatables_data_barang_penghapusan_query($where);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function get_data_berat_pada_bigbook($id_rak, $kyou){
        $this->db->select("detail.*");
        $this->db->from("tr_detail_dashboard_big_book detail");
        $this->db->join("ms_dashboard_big_book big", "big.KdBukuBesar = detail.KdBukuBesar", "left");
        $this->db->where("detail.id_rak", $id_rak);
        $this->db->where("big.TglBukuBesar", $kyou);
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row();
    }

    function get_nomor_terakhir($id_rak){
        $this->db->select("MAX(urutan_rak) AS maks");
        $this->db->from("ms_barang");
        $this->db->where("id_rak", $id_rak);
        
        $query = $this->db->get();
        $res = $query->row();
        return $res->maks;
    }

    function get_nomor_terakhir_hapus($id_rak){
        $this->db->select("MAX(urutan_rak) AS maks");
        $this->db->from("ms_barang_hapus");
        $this->db->where("id_rak", $id_rak);
        
        $query = $this->db->get();
        $res = $query->row();
        return $res->maks;
    }
    //End of Riwayat Penghapusan Barang

    function get_rekap_penjualan($tanggal_awal, $tanggal_akhir){
        $sql = "SELECT jual.KdPenjualan, jual.TglProses, barang.nama_barang, kadar.nama_kadar, rak.nama_rak, detail.berat_asli, detail.berat_jual, detail.nilai_barang, detail.JnPembayaran, detail.id_kadar FROM
                ms_penjualan jual
                LEFT JOIN tr_penjualan detail ON detail.KdPenjualan = jual.KdPenjualan
                LEFT JOIN ms_barang_hapus barang ON barang.id = detail.id_barang
                LEFT JOIN ms_rak rak ON rak.id = barang.id_rak
                LEFT JOIN ms_kadar kadar ON kadar.id = barang.id_kadar
                WHERE jual.TglProses >= ? AND jual.TglProses <= ?";

        $query = $this->db->query($sql, array($tanggal_awal, $tanggal_akhir));
        return $query->result();
    }

    function get_rekap_penjualan_per_kadar($tanggal_awal, $tanggal_akhir){
        $sql = "SELECT kadar.nama_kadar, SUM(detail.berat_asli) AS BeratAsli, SUM(detail.berat_jual) AS BeratJual, SUM(detail.nilai_barang) AS NilaiBarang FROM
                ms_penjualan jual
                LEFT JOIN tr_penjualan detail ON detail.KdPenjualan = jual.KdPenjualan
                LEFT JOIN ms_barang_hapus barang ON barang.id = detail.id_barang
                LEFT JOIN ms_rak rak ON rak.id = barang.id_rak
                LEFT JOIN ms_kadar kadar ON kadar.id = barang.id_kadar
                WHERE jual.TglProses >= ? AND jual.TglProses <= ? AND detail.JnPembayaran != 'Bank'
                GROUP BY kadar.nama_kadar";

        $query = $this->db->query($sql, array($tanggal_awal, $tanggal_akhir));
        return $query->result();
    }
    
    //Get Rekap Pengembalian
    function get_rekap_pengembalian($tanggal_awal, $tanggal_akhir){
        $sql = "SELECT jual.KdPengembalian, jual.TglProses, IF(barang.nama_barang IS NULL, barpus.nama_barang, barang.nama_barang) AS nama_barang, kadar.nama_kadar, rak.nama_rak, detail.berat_asli, detail.uang FROM
                ms_pengembalian jual
                LEFT JOIN tr_pengembalian detail ON detail.KdPengembalian = jual.KdPengembalian
                LEFT JOIN ms_barang barang ON barang.id = detail.id_barang
                LEFT JOIN ms_barang_hapus barpus ON barpus.id = detail.id_barang
                LEFT JOIN ms_rak rak ON rak.id = barang.id_rak OR rak.id = barpus.id_rak
                LEFT JOIN ms_kadar kadar ON kadar.id = barang.id_kadar OR kadar.id = barpus.id_kadar
                WHERE jual.TglProses >= ? AND jual.TglProses <= ?";

        $query = $this->db->query($sql, array($tanggal_awal, $tanggal_akhir));
        return $query->result();
    }

    function get_rekap_pengembalian_per_kadar($tanggal_awal, $tanggal_akhir){
        $sql = "SELECT kadar.nama_kadar, SUM(detail.berat_asli) AS BeratAsli, SUM(detail.uang) AS uang FROM
                ms_pengembalian jual
                LEFT JOIN tr_pengembalian detail ON detail.KdPengembalian = jual.KdPengembalian
                LEFT JOIN ms_barang barang ON barang.id = detail.id_barang
                LEFT JOIN ms_rak rak ON rak.id = barang.id_rak
                LEFT JOIN ms_kadar kadar ON kadar.id = barang.id_kadar
                WHERE jual.TglProses >= ? AND jual.TglProses <= ?
                GROUP BY kadar.nama_kadar";

        $query = $this->db->query($sql, array($tanggal_awal, $tanggal_akhir));
        return $query->result();
    }

    //Get Rekap Pengembalian
    function get_rekap_pengeluaran($tanggal_awal, $tanggal_akhir){
        $sql = "SELECT jual.KdPengeluaran, jual.TglProses, barang.nama_barang, kadar.nama_kadar, rak.nama_rak, detail.berat_asli FROM
                ms_pengeluaran jual
                LEFT JOIN tr_pengeluaran detail ON detail.KdPengeluaran = jual.KdPengeluaran
                LEFT JOIN ms_barang_hapus barang ON barang.id = detail.id_barang
                LEFT JOIN ms_rak rak ON rak.id = barang.id_rak
                LEFT JOIN ms_kadar kadar ON kadar.id = barang.id_kadar
                WHERE jual.TglProses >= ? AND jual.TglProses <= ?";

        $query = $this->db->query($sql, array($tanggal_awal, $tanggal_akhir));
        return $query->result();
    }

    function get_rekap_pengeluaran_per_kadar($tanggal_awal, $tanggal_akhir){
        $sql = "SELECT kadar.nama_kadar, SUM(detail.berat_asli) AS BeratAsli FROM
                ms_pengeluaran jual
                LEFT JOIN tr_pengeluaran detail ON detail.KdPengeluaran = jual.KdPengeluaran
                LEFT JOIN ms_barang_hapus barang ON barang.id = detail.id_barang
                LEFT JOIN ms_rak rak ON rak.id = barang.id_rak
                LEFT JOIN ms_kadar kadar ON kadar.id = barang.id_kadar
                WHERE jual.TglProses >= ? AND jual.TglProses <= ?
                GROUP BY kadar.nama_kadar";

        $query = $this->db->query($sql, array($tanggal_awal, $tanggal_akhir));
        return $query->result();
    }

    function get_data_boss(){
        $this->db->select("*");
        $this->db->from("ms_user");
        $this->db->where("GroupAdminID", 2);

        $query = $this->db->get();
        return $query->row();
    }

    function kurang_dari_stok($id, $berat){
        $sql = "UPDATE ms_barang SET berat_jual = berat_jual - ? WHERE Id = ?";

        $this->db->query($sql, array($berat, $id));
    }
}

?>