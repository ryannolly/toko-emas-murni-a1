<?php

class Pengembalian extends CI_Controller {
    function keluar(){
        $this->session->set_flashdata('pesan',
                '<div class="alert alert-warning alert-dismissible" role="alert">
                    Silahkan untuk login terlebih dahulu!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );  
        $userdata = array('id_user', 'nama_admin');
        $this->session->unset_userdata($userdata);
        redirect('login');
    }

    public function __construct(){
        parent::__construct();

        if($this->session->userdata('id') == null){
            $this->keluar();
        }

        if($this->session->userdata("role_user") != "0"){
            $this->keluar();
        }   
    }

    public function ajax_post_and_get(){
        $data['data']   = (object) array();

        //Update the data in session
        //Update last id barang kasir
        $data['data']->id_session_barang = $this->session->userdata("last_id_barang_pengembalian");
        $data['data']->nama_barang       = $this->input->post("nama_barang");
        $data['data']->id_rak            = $this->input->post("id_rak");
        $data['data']->id_kadar          = $this->input->post("id_kadar");
        $data['data']->berat             = $this->input->post("berat");
        $data['data']->kategori          = $this->input->post("kategori");
        $data['data']->harga             = $this->input->post("harga");

        $where = array(
            'Id'    => $this->input->post("id_rak")
        );

        $data['data']->nama_rak          = $this->model_admin->get_data_from_uuid($where, "ms_rak")->row()->nama_rak;

        $where = array(
            'Id'    => $this->input->post("id_kadar")
        );

        $data['data']->nama_kadar          = $this->model_admin->get_data_from_uuid($where, "ms_kadar")->row()->nama_kadar;

        $this->session->set_userdata("last_id_barang_pengembalian", $data['data']->id_session_barang + 1); 

        //Masukkan
        $array_data = $this->session->userdata("barang_pengembalian");
        $array_data[] =  $data['data'];
        $this->session->set_userdata("barang_pengembalian", $array_data);

        //Send
        echo json_encode($data);
    }

    public function ajax_delete_barang_from_session(){
        $id_barangnya = $_POST['id_session_barang'];
        $indexnya = -1;
        $array_sekarang = $this->session->userdata("barang_pengembalian");
        for($i = 0; $i<sizeof($array_sekarang); $i++){
            if($id_barangnya == $array_sekarang->id_session_barang){
                $indexnya = $i;
            }
        }

        array_splice($array_sekarang, $indexnya, 1);

        $this->session->set_userdata("barang_pengembalian", $array_sekarang);
    }

    public function get_ajax_session_barang(){
        echo json_encode($this->session->userdata("barang_kasir"));
    }

    public function index(){
        // $data['data_barang']        = $this->model_admin->tampil_data_barang();
        $data['data_kadar']         = $this->model_admin->tampil_data("ms_kadar", "nama_kadar", "ASC")->result();
        $data['data_rak']           = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/pengembalian', $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function proses_pengembalian(){
        //Kalau Kosong langsung tembak keluar aja
        if(count($this->session->userdata("barang_pengembalian")) <= 0){
            redirect("adm/pengembalian/");
        }

        //Buat dulu ms_penjualan
        $KdPengembalian = $this->model_admin->create_kode_pengembalian();

        //{Proses Dulu Penjualannya di tabel Penjualan}
        foreach($this->session->userdata("barang_pengembalian") as $p){
            $data = array(
                'nama_barang'       => $p->nama_barang,
                'id_kadar'          => $p->id_kadar,
                'id_rak'            => $p->id_rak,
                'keterangan'        => "BARANG HASIL PENGEMBALIAN",
                'stok'              => 1,
                'usrid'             => $this->session->userdata("username") . " - BARANG PENGEMBALIAN - " . date("Y-m-d H:i:s", time()),
                'tgl_input_real'    => date("Y-m-d", time()),
                'berat_jual'        => $p->berat
            );

            //Letak di tabel ms_barang
            $this->db->set('uuid', 'REPLACE(UUID(), "-", "")', FALSE);

            $this->model_admin->tambah_data("ms_barang", $data);

            //get Id nya
            $barang = $this->model_admin->get_data_from_uuid($data, "ms_barang")->row();

            //Baru letak di tr_pengembalian
            $data = array(
                'KdPengembalian'    => $KdPengembalian,
                'id_barang'         => $barang->Id,
                'id_kadar'          => $p->id_kadar,
                'berat_terima'      => $p->berat,
                'uang'              => $p->harga,
                'berat_asli'        => $p->berat,
                'Kategori'          => $p->Kategori,
                'selisih_berat'     => 0,
                'usrid'             => $this->session->userdata("username") . " - BARANG PENGEMBALIAN - " . date("Y-m-d H:i:s", time()),
                'tgl_penjualan'     => date("Y-m-d", time()),
                'tgl_real_penjualan'=> time()
            );

            $this->model_admin->tambah_data("tr_pengembalian", $data);
        }

        $this->session->set_userdata("barang_pengembalian", array());

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Pengembalian Barang Berhasil Dilakukan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/pengembalian');
    }
}

?>