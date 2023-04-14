<?php 

class Data_rak extends CI_Controller {
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
        $data['data_rak']       = $this->model_admin->tampil_data("ms_rak", "id", "DESC")->result();
        $data['data_kadar']       = $this->model_admin->tampil_data("ms_kadar", "id", "DESC")->result();
        
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/data_rak', $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function cek_barang_pada_rak($Id = 0){
        if($Id === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Harap Memilih terlebih dahulu data yang ingin dicetak!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_rak');
        }

        $where = array(
            'Id'    => $Id
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_rak')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda cetak tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_rak');
        }


        $data['barang']     = $this->model_admin->get_barang_pada_rak($Id);
        $data['detail_rak'] = $this->model_admin->get_data_from_uuid($where, "ms_rak")->row();

        $this->load->view("Admin/print/cek_barang_pada_rak", $data);
    }

    public function tambah_data_rak(){
        $data = array(
            'nama_rak'      => strip_tags($this->input->post("nama_rak")),
            'keterangan'    => strip_tags($this->input->post("keterangan")),
            'id_kadar'      => $this->input->post("default_kadar"),
            'usrid'         => $this->session->userdata("username") . " - " . date("Y-m-d H:i:s", time())
        );

        $this->model_admin->tambah_data("ms_rak", $data);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Ditambahkan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_rak');
    }

    public function ubah_data_rak($Id = 0){
        if($Id === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Harap Memilih terlebih dahulu data yang ingin diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_rak');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'id'       => $Id
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_rak')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_rak');
        }

        //Get Detail Data
        $data['detail_data']        = $this->model_admin->get_data_from_uuid($where, "ms_rak")->row();
        $data['data_kadar']       = $this->model_admin->tampil_data("ms_kadar", "id", "DESC")->result();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/ubah/data_rak", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function ubah_data_rak_aksi($Id = 0){
        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'id'       => $this->input->post("id_real")
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_rak')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_rak');
        }

        $data = array(
            'nama_rak'       => $this->input->post("nama_rak"),
            'keterangan'     => $this->input->post("keterangan"),
            'id_kadar'       => $this->input->post("default_kadar"),
            'usrid'          => $this->session->userdata("username") . " - " . date("Y-m-d H:i:s", time())
        );

        $this->model_admin->ubah_data($where, $data, "ms_rak");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Bobot Telah Berhasil Diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_rak');
    }

    public function hapus_data_rak($Id = 0){
        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'id'       => $Id
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_rak')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda hapus tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_rak');
        }

        //Cek Dulu Ada barangnya gak di rak tersebut
        $barang = $this->model_admin->get_barang_pada_rak($Id);
        if(count($barang) > 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Tidak dapat menghapus rak yang masih terdapat barang didalamnya!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
            ');

            redirect('adm/data_rak');
        }

    
        $this->model_admin->hapus_data($where, "ms_rak");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Rak Telah Berhasil Dihapus!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_rak');

    }

    public function checklist_barang_pada_rak($Id = 0){
        if($Id === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Harap Memilih terlebih dahulu data yang ingin dicetak!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_rak');
        }

        $where = array(
            'Id'    => $Id
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_rak')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda cetak tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_rak');
        }

        //Get Data Di tr_checklist_barang
        $data['barang']     = $this->model_admin->get_barang_pada_rak_checklist($Id);
        if(count($data['barang']) <= 0){
            //Generate dulu semua letak situ
            $this->model_admin->generate_checklist_barang($Id);
            $data['barang'] = $this->model_admin->get_barang_pada_rak_checklist($Id);
        }

        // $data['barang']     = $this->model_admin->get_barang_pada_rak($Id);
        $data['detail_rak'] = $this->model_admin->get_data_from_uuid($where, "ms_rak")->row();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/lihat_data/checklist_barang_pada_rak", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function ulangi_pengecekan($Id = 0){
        //Cek udah ada belum datanya
        if($Id == 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Silahkan untuk memilih rak yang ingin di refresh!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_rak');
        }

        //Hapus Dulu
        $where = array(
            'id_rak'        => $Id
        );
        $this->model_admin->hapus_data($where, "tr_checklist_barang");

        //Generate Ulang
        $this->model_admin->generate_checklist_barang($Id);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Pengecekan telah direset!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_rak/checklist_barang_pada_rak/'.$Id);
    }

    public function check_barang_di_sebuah_rak(){
        $where = array(
            'uuid'      => $this->input->post("uuid"),
            'id_rak'    => $this->input->post("id_rak")
        );

        //Get Data
        $data['data'] = $this->model_admin->get_detail_barang_penjualan_checklist($where);

        //Update the data in session
        if(@$data['data']){
            //Hapus di database
            $where_baru = array(
                'id_barang'     => $data['data']->Id,
                'id_rak'        => $this->input->post("id_rak")
            );

            $this->model_admin->hapus_data($where_baru, "tr_checklist_barang");
            
            $data['is_data_ada'] = 1;
        }else{
            $data['is_data_ada'] = 0;
        }

        //Send
        echo json_encode($data);
    }
}

?>