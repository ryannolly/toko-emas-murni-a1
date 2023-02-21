<?php 

class Dosen extends CI_Controller {
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


        if($this->session->userdata('id_user') == null){
            $this->keluar();
        }

        if($this->session->userdata("role_user") != "1"){
            $this->keluar();
        }
    }

    public function index(){
        $this->load->view('Dosen/Template_dosen/header');
        $this->load->view('Dosen/Template_dosen/sidebar');
        $this->load->view('Dosen/dashboard');
        $this->load->view('Dosen/Template_dosen/footer');
    }

    public function bidang_pendidikan_dan_pembelajaran(){
        $this->load->view('Dosen/Template_dosen/header');
        $this->load->view('Dosen/Template_dosen/sidebar');
        $this->load->view('Dosen/bidang_pendidikan_dan_pembelajaran');
        $this->load->view('Dosen/Template_dosen/footer');
    }
}

?>