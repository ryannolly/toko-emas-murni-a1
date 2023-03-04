<?php

class Data_admin extends CI_Controller {
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
        $data['data_user']         = $this->model_admin->tampil_data("ms_user", "username", "ASC")->result();
        
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/data_admin', $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function tambah_data_admin(){
        $where = array(
            'username'      => $this->input->post('username')
        );

        //Cek udah ada belum datanya
        if($this->model_admin->cek_ada_tidak_sama($where, 'ms_user')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Admin dengan username tersebut sudah ada!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_admin');
        }

        $data = array(
            'username'      => $this->input->post("username"),
            'password'      => $this->input->post("password"),
            'nama'          => $this->input->post('nama'),
            'GroupAdminID'  => $this->input->post("GroupAdminID")
        );

        $this->model_admin->tambah_data("ms_user", $data);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Admin Telah Berhasil Ditambahkan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_admin');        
    }

    public function ubah_data_admin($Id = 0){
        if($Id === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Harap Memilih terlebih dahulu data yang ingin diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_admin');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'id'       => $Id
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_user')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_admin');
        }

        //Get Detail Data
        $data['detail_data']        = $this->model_admin->get_data_from_uuid($where, "ms_user")->row();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/ubah/data_admin", $data);
        $this->load->view('Admin/Template_admin/footer');
    }
    
    public function ubah_data_admin_aksi(){
        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'id'       => $this->input->post("id_real")
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_user')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_admin');
        }

        $data = array(
            'nama'          => $this->input->post("nama"),
            'GroupAdminID'  => $this->input->post('GroupAdminID')
        );

        if(!($this->input->post("password") == "")){
            $data['password']       = $this->input->post("password");
        }

        $this->model_admin->ubah_data($where, $data, "ms_user");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data User Telah Berhasil Diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_admin');
    }
}

?>