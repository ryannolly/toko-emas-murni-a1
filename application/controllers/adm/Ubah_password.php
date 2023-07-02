<?php

class Ubah_password extends CI_Controller {
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
        $this->load->view('Admin/ubah_password');
        $this->load->view('Admin/Template_admin/footer');
    }

    public function proses(){
        $where = array(
            'username'      => $this->session->userdata("username")
        );

        $salt       = random_string("alnum", 16);
        $password   = hash("sha512", $this->input->post("password").$salt);

        $data = array(
            'password'      => $password,
            'salt'          => $salt
        );

        $this->model_admin->ubah_data($where, $data, "ms_user");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                Password telah berhasil diubah!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
        redirect('adm/ubah_password/');
    }
}

?>