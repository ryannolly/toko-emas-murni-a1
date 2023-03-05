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
        $data['data'] = $this->model_admin->get_detail_barang($where);

        //Update the data in session
        if(@$data['data']){
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