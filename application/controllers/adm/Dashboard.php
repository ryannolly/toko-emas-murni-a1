<?php 

class Dashboard extends CI_Controller {
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
        $kyou = date("Y-m-d", time());
        $data['data_penjualan']     = $this->model_admin->get_dashboard_penjualan(strtotime($kyou));
        $data['data_pengembalian']  = $this->model_admin->get_dashboard_pengembalian(strtotime($kyou));

        $data['big_book']           = $this->model_admin->get_big_book_dashboard($kyou);

        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/dashboard', $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function buka_toko(){
        //Cek Dulu Apakah big book hari ini udah dibuat?
        $kyou                   = date("Y-m-d", time());
        $apakah_sudah_ada       = $this->model_admin->get_big_book_dashboard($kyou);
        if(@$apakah_sudah_ada){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Gagal! Toko sudah dibuka untuk hari ini!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/dashboard');
        }

        //Get Data Sebelumnya
        $data_sebelumnya        = $this->model_admin->get_big_book_dashboard_terakhir();
        $tutup_per_rak          = array();
        $tutup_per_rak_qt       = array();
        if(@$data_sebelumnya){
            $tutup_per_rak_qt[$data_sebelumnya->id_rak] = $data_sebelumnya->tutup_qt;
            $tutup_per_rak[$data_sebelumnya->id_rak] = $data_sebelumnya->tutup;
        }else{
            $tutup_per_rak_qt[$data_sebelumnya->id_rak] = 0;
            $tutup_per_rak[$data_sebelumnya->id_rak]    = 0;
        }

        //Create master big book for today
        $KdBukuBesar            = $this->model_admin->create_kd_buku_besar();

        //Get All Rak
        $semua_rak              = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        foreach($semua_rak as $n){
            $data = array(
                'KdBukuBesar'       => $KdBukuBesar,
                'id_rak'            => $n->id,
                'open'              => $tutup_per_rak[$n->id_rak],
                'masuk'             => 0,
                'keluar'            => 0,
                'jual'              => 0,
                'tutup'             => 0,
                'timbang'           => 0,
                'open_qt'           => $tutup_per_rak_qt[$n->id_rak],
                'masuk_qt'          => 0,
                'keluar_qt'         => 0,
                'jual_qt'           => 0,
                'tutup_qt'          => 0,
                'timbang_qt'        => 0,
            );

            $this->model_admin->tambah_data("tr_detail_dashboard_big_book", $data);
        }

        //Balik Ke Dashboard
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Toko Telah Berhasil Dibuka! Data Open diambil dari penjualan hari terakhir!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/dashboard');
    }

    public function refresh_big_book($KdBukaBesar = 0){
        echo "<pre>";
        print_r($KdBukuBesar);
        exit(1);
    }

    public function under_development(){
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/under_development');
        $this->load->view('Admin/Template_admin/footer');
    }
}

?>