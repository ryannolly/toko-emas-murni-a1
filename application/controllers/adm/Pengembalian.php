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

    public function index(){
        // $data['data_barang']        = $this->model_admin->tampil_data_barang();
        // $data['data_kadar']         = $this->model_admin->tampil_data("ms_kadar", "nama_kadar", "ASC")->result();
        // $data['data_rak']           = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/pengembalian');
        $this->load->view('Admin/Template_admin/footer');
    }
}

?>