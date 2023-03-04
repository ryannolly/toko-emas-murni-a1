<?php

class Data_group_admin extends CI_Controller {
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
        redirect("adm/dashboard/under_development");
        // $data['data_user']         = $this->model_admin->tampil_data("ms_user", "username", "ASC")->result();
        
        // $this->load->view('Admin/Template_admin/header');
        // $this->load->view('Admin/Template_admin/sidebar');
        // $this->load->view('Admin/data_admin', $data);
        // $this->load->view('Admin/Template_admin/footer');
    }
}

?>