<?php

class Riwayat_big_book extends CI_Controller {
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
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/riwayat_big_book');
        $this->load->view('Admin/Template_admin/footer');
    }

    public function print(){
        $kyou       = $this->input->post("tgl_big_book");
        $kyou_angka = strtotime($this->input->post("tgl_big_book"));
        $ashita     = date("Y-m-d", $kyou_angka+86400);

        $data['big_book']               = $this->model_admin->get_big_book_dashboard($kyou);
        
        foreach($data['big_book'] as $b){
            $b->jumlah_nol_persen       = $this->model_admin->get_nol_persen_pada_rak($b->id_rak);
        }

        $data['kyou']                   = $kyou;

        $this->load->view("admin/print/print_big_book.php", $data);
    }
}

?>