<?php

class Penjualan extends CI_Controller {
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

    public function index(){
        // $data['data_barang']        = $this->model_admin->tampil_data_barang();
        // $data['data_kadar']         = $this->model_admin->tampil_data("ms_kadar", "nama_kadar", "ASC")->result();
        // $data['data_rak']           = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/penjualan');
        $this->load->view('Admin/Template_admin/footer');
    }

    public function ajax_post_and_get(){
        $where = array(
            'uuid'      => $this->input->post("uuid")
        );

        //Get Data
        $data['data'] = $this->model_admin->get_detail_barang_penjualan($where);

        //Update the data in session
        if(@$data['data']){
            //Update last id barang kasir
            $data['data']->id_session_barang = $this->session->userdata("last_id_barang_kasir");
            $this->session->set_userdata("last_id_barang_kasir", $data['data']->id_session_barang + 1);

            //Masukkan
            $array_data = $this->session->userdata("barang_kasir");
            $array_data[] =  $data['data'];
            $this->session->set_userdata("barang_kasir", $array_data);
            $data['is_data_ada'] = 1;
        }else{
            $data['is_data_ada'] = 0;
        }

        //Send
        echo json_encode($data);
    }

    public function ajax_delete_barang_from_session(){
        $id_barangnya = $_POST['id_session_barang'];
        $indexnya = -1;
        $array_sekarang = $this->session->userdata("barang_kasir");
        for($i = 0; $i<sizeof($array_sekarang); $i++){
            if($id_barangnya == $array_sekarang->id_session_barang){
                $indexnya = $i;
            }
        }

        array_splice($array_sekarang, $indexnya, 1);

        $this->session->set_userdata("barang_kasir", $array_sekarang);
    }

    public function get_ajax_session_barang(){
        echo json_encode($this->session->userdata("barang_kasir"));
    }

    public function penjualan_proses(){
        if(count($this->session->userdata('barang_kasir')) <= 0){
            $this->session->set_flashdata('pesan',
                '<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                    Silahkan scan barang terlebih dahulu!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );  
            redirect('adm/penjualan');
        }

        $POST_id_barang     = $this->input->post("id_barang_session[]");
        $POST_harga_barang  = $this->input->post("harga_barang[]");
        $POST_berat_barang  = $this->input->post("berat_jual[]");

        $data = array();

        //Post and get kdPenjualan
        $KdPenjualan    = $this->model_admin->create_kode_penjualan();

        //{Proses Dulu Penjualannya di tabel Penjualan}
        for($i = 0; $i<sizeof($POST_id_barang); $i++){
            foreach($this->session->userdata("barang_kasir") as $p){
                if($p->id_session_barang == $POST_id_barang[$i]){
                    $data_per_biji = array(
                        'id_kadar'    => $p->id_rak,
                        'KdPenjualan' => $KdPenjualan,
                        'berat_jual'  => $p->berat_jual,
                        'berat_asli'  => $POST_berat_barang[$i],
                        'nilai_barang'=> $POST_harga_barang[$i],
                        'DP_Pelunasan'=> $POST_harga_barang[$i],
                        'JnPembayaran'=> "TUNAI",
                        'id_rak'      => $p->id_rak,
                        'id_barang'   => $p->Id,
                        'usrid'       => $this->session->userdata("username"). " - " .date("Y-m-d H:i:s", time()),
                        'tgl_penjualan' => date("Y-m-d H:i:s", time()),
                        'tgl_real_penjualan'    => time()
                    );

                    $data[] = $data_per_biji;
                }
            }
        }

        //Masukkan ke tabel penjualan
        foreach($data as $p){
            $this->model_admin->tambah_data("tr_penjualan", $p);
        }

        foreach($this->session->userdata("barang_kasir") as $b){
            $this->model_admin->kurang_stok($b->uuid);
        }

        $this->session->set_userdata("barang_kasir", array());
        
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Penjualan Berhasil Dilakukan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/penjualan');
    }
}

?>