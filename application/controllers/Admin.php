<?php

class Admin extends CI_Controller {
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

        if($this->session->userdata("role_user") != "0"){
            $this->keluar();
        }
    }

    public function index(){
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/dashboard');
        $this->load->view('Admin/Template_admin/footer');
    }

    public function data_dosen(){
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/data_dosen');
        $this->load->view('Admin/Template_admin/footer');
    }

    public function nilai_dosen(){
        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/nilai_dosen");
        $this->load->view("Admin/Template_admin/footer");
    }

    public function hasil_perhitungan(){
        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/hasil_perhitungan");
        $this->load->view('Admin/Template_admin/footer');
    }

    public function bobot_pendidikan(){
        $data['bobot_pendidikan']       = $this->model_admin->tampil_data("tbl_jenis_pendidikan", "Id", "DESC")->result();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/bobot_pendidikan", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function bobot_pendidikan_tambah(){
        $where = array(
            'KdJenis'       => $this->input->post("KdJenis")
        );

        //Cek udah ada belum datanya
        if($this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_pendidikan')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Bobot Pendidikan dengan Kode Tersebut Telah Tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pendidikan');
        }

        if(!ctype_alnum($this->input->post("KdJenis"))){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Kode Bobot Hanya Boleh Alphanumeric dan Tanpa Spasi!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pendidikan');
        }

        //Kalau Gak ada yang sama ya masukkan aja
        $data = array(
            'KdJenis'       => $this->input->post("KdJenis"),
            'NmJenis'       => $this->input->post("NmJenis"),
            'Bobot'         => $this->input->post("Bobot")
        );

        $this->model_admin->tambah_data("tbl_jenis_pendidikan", $data);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Ditambahkan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/bobot_pendidikan');
    }

    public function bobot_pendidikan_hapus($KdJenis = 0){
        if($KdJenis === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Harap Memilih terlebih dahulu data yang ingin dihapus!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pendidikan');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'KdJenis'       => $KdJenis
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_pendidikan')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Data yang ingin anda hapus tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pendidikan');
        }

        //Langsung hapus
        $this->model_admin->hapus_data($where, "tbl_jenis_pendidikan");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Dihapus!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/bobot_pendidikan');
    }

    public function bobot_pendidikan_ubah($KdJenis = 0){
        if($KdJenis === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Harap Memilih terlebih dahulu data yang ingin diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pendidikan');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'KdJenis'       => $KdJenis
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_pendidikan')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pendidikan');
        }

        //Get Detail Data
        $data['detail_data']        = $this->model_admin->get_data_from_uuid($where, "tbl_jenis_pendidikan")->row();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/ubah/bobot_pendidikan", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function bobot_pendidikan_ubah_aksi(){
        $where = array(
            'KdJenis'       => $this->input->post("KdJenisReal")
        );

        //Cek Dulu Ada Gak Datanya!
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_pendidikan')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pendidikan');
        }

        $data = array(
            'NmJenis'       => $this->input->post("NmJenis"),
            "Bobot"         => $this->input->post("Bobot")
        );

        $this->model_admin->ubah_data($where, $data, "tbl_jenis_pendidikan");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/bobot_pendidikan');
    }

    public function bobot_penelitian(){
        $data['bobot_penelitian']       = $this->model_admin->tampil_data("tbl_jenis_penelitian", "Id", "DESC")->result();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/bobot_penelitian", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function bobot_penelitian_tambah(){
        $where = array(
            'KdJenis'       => $this->input->post("KdJenis")
        );

        //Cek udah ada belum datanya
        if($this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_penelitian')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Bobot Penelitian dengan Kode Tersebut Telah Tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_penelitian');
        }

        if(!ctype_alnum($this->input->post("KdJenis"))){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Kode Bobot Hanya Boleh Alphanumeric dan Tanpa Spasi!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_penelitian');
        }

        //Kalau Gak ada yang sama ya masukkan aja
        $data = array(
            'KdJenis'       => $this->input->post("KdJenis"),
            'NmJenis'       => $this->input->post("NmJenis"),
            'Bobot'         => $this->input->post("Bobot")
        );

        $this->model_admin->tambah_data("tbl_jenis_penelitian", $data);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Ditambahkan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/bobot_penelitian');
    }

    public function bobot_penelitian_hapus($KdJenis = 0){
        if($KdJenis === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Harap Memilih terlebih dahulu data yang ingin dihapus!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_penelitian');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'KdJenis'       => $KdJenis
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_penelitian')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Data yang ingin anda hapus tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_penelitian');
        }

        //Langsung hapus
        $this->model_admin->hapus_data($where, "tbl_jenis_penelitian");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Dihapus!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/bobot_penelitian');
    }

    public function bobot_penelitian_ubah($KdJenis = 0){
        if($KdJenis === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Harap Memilih terlebih dahulu data yang ingin diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_penelitian');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'KdJenis'       => $KdJenis
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_penelitian')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_penelitian');
        }

        //Get Detail Data
        $data['detail_data']        = $this->model_admin->get_data_from_uuid($where, "tbl_jenis_penelitian")->row();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/ubah/bobot_penelitian", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function bobot_penelitian_ubah_aksi(){
        $where = array(
            'KdJenis'       => $this->input->post("KdJenisReal")
        );

        //Cek Dulu Ada Gak Datanya!
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_penelitian')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_penelitian');
        }

        $data = array(
            'NmJenis'       => $this->input->post("NmJenis"),
            "Bobot"         => $this->input->post("Bobot")
        );

        $this->model_admin->ubah_data($where, $data, "tbl_jenis_penelitian");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/bobot_penelitian');
    }

    public function bobot_pengabdian(){
        $data['bobot_pengabdian']       = $this->model_admin->tampil_data("tbl_jenis_pengabdian", "Id", "DESC")->result();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/bobot_pengabdian", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function bobot_pengabdian_tambah(){
        $where = array(
            'KdJenis'       => $this->input->post("KdJenis")
        );

        //Cek udah ada belum datanya
        if($this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_pengabdian')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Bobot Penelitian dengan Kode Tersebut Telah Tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pengabdian');
        }

        if(!ctype_alnum($this->input->post("KdJenis"))){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Kode Bobot Hanya Boleh Alphanumeric dan Tanpa Spasi!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pengabdian');
        }

        //Kalau Gak ada yang sama ya masukkan aja
        $data = array(
            'KdJenis'       => $this->input->post("KdJenis"),
            'NmJenis'       => $this->input->post("NmJenis"),
            'Bobot'         => $this->input->post("Bobot")
        );

        $this->model_admin->tambah_data("tbl_jenis_pengabdian", $data);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Ditambahkan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/bobot_pengabdian');
    }

    public function bobot_pengabdian_hapus($KdJenis = 0){
        if($KdJenis === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Harap Memilih terlebih dahulu data yang ingin dihapus!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pengabdian');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'KdJenis'       => $KdJenis
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_pengabdian')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Data yang ingin anda hapus tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pengabdian');
        }

        //Langsung hapus
        $this->model_admin->hapus_data($where, "tbl_jenis_pengabdian");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Dihapus!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/bobot_pengabdian');
    }

    public function bobot_pengabdian_ubah($KdJenis = 0){
        if($KdJenis === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Harap Memilih terlebih dahulu data yang ingin diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pengabdian');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'KdJenis'       => $KdJenis
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_pengabdian')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pengabdian');
        }

        //Get Detail Data
        $data['detail_data']        = $this->model_admin->get_data_from_uuid($where, "tbl_jenis_pengabdian")->row();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/ubah/bobot_pengabdian", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function bobot_pengabdian_ubah_aksi(){
        $where = array(
            'KdJenis'       => $this->input->post("KdJenisReal")
        );

        //Cek Dulu Ada Gak Datanya!
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'tbl_jenis_pengabdian')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/bobot_pengabdian');
        }

        $data = array(
            'NmJenis'       => $this->input->post("NmJenis"),
            "Bobot"         => $this->input->post("Bobot")
        );

        $this->model_admin->ubah_data($where, $data, "tbl_jenis_pengabdian");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/bobot_pengabdian');
    }

    public function data_validator_reviewer(){
        $data['ms_validator']       = $this->model_admin->tampil_data("ms_validator", "id", "DESC")->result();
        $data['ms_reviewer']        = $this->model_admin->tampil_data("ms_reviewer", "id", "DESC")->result();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/data_validator_reviewer", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function data_validator_reviewer_tambah(){
        //Cek Dulu Dia Mau Kemana ya kan
        $Table = ($this->input->post("SaveTo") == "Reviewer") ? "ms_reviewer" : "ms_validator";

        $where = array(
            'email'       => $this->input->post("email")
        );

        //Cek udah ada belum datanya
        if($this->model_admin->cek_ada_tidak_sama($where, $Table)){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Akun dengan Email Tersebut Telah Tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/data_validator_reviewer');
        }

        if(!ctype_alnum($this->input->post("email"))){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Email Hanya Boleh Alphanumeric dan Tanpa Spasi!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/data_validator_reviewer');
        }

        //Kalau Gak ada yang sama ya masukkan aja
        $data = array(
            'email'         => $this->input->post("email"),
            'password'      => $this->input->post("password"),
            'nama_admin'    => $this->input->post("nama_admin")
        );

        $this->model_admin->tambah_data($Table, $data);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Telah Berhasil Ditambahkan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/data_validator_reviewer');
    }

    public function konfigurasi_umum(){
        $data['ms_konfigurasi']        = $this->model_admin->tampil_data("ms_konfigurasi", "id", "DESC")->result();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/konfigurasi_umum", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function konfigurasi_umum_tambah(){
        $where = array(
            'KdKonfigurasi'       => $this->input->post("KdKonfigurasi")
        );

        //Cek udah ada belum datanya
        if($this->model_admin->cek_ada_tidak_sama($where, 'ms_konfigurasi')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Konfigurasi dengan Kode Tersebut Telah Tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/konfigurasi_umum');
        }

        if(!ctype_alnum($this->input->post("KdKonfigurasi"))){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert">
                                                Kode Konfigurasi Hanya Boleh Alphanumeric dan Tanpa Spasi!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('admin/konfigurasi_umum');
        }

        //Kalau Gak ada yang sama ya masukkan aja
        $data = array(
            'KdKonfigurasi'     => $this->input->post("KdKonfigurasi"),
            'NmKonfigurasi'     => $this->input->post("NmKonfigurasi"),
            'IsiKonfigurasi'    => $this->input->post("IsiKonfigurasi")
        );

        $this->model_admin->tambah_data("ms_konfigurasi", $data);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Konfigurasi Telah Berhasil Ditambahkan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('admin/konfigurasi_umum');
    }
}

?>