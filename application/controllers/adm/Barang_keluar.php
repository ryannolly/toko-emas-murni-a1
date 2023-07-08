<?php

class Barang_keluar extends CI_Controller {
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
            $data['data']->id_session_barang = $this->session->userdata("last_id_barang_pengeluaran");
            $this->session->set_userdata("last_id_barang_pengeluaran", $data['data']->id_session_barang + 1);

            //Masukkan
            $array_data = $this->session->userdata("barang_pengeluaran");
            $array_data[] =  $data['data'];
            $this->session->set_userdata("barang_pengeluaran", $array_data);
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
        $array_sekarang = $this->session->userdata("barang_pengeluaran");
        for($i = 0; $i<sizeof($array_sekarang); $i++){
            if($id_barangnya == $array_sekarang->id_session_barang){
                $indexnya = $i;
            }
        }

        array_splice($array_sekarang, $indexnya, 1);

        $this->session->set_userdata("barang_pengeluaran", $array_sekarang);
    }

    public function index(){
        // $data['data_barang']        = $this->model_admin->tampil_data_barang();
        // $data['data_kadar']         = $this->model_admin->tampil_data("ms_kadar", "nama_kadar", "ASC")->result();
        $data['data_rak']           = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/barang_keluar', $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function get_ajax_session_barang(){
        echo json_encode($this->session->userdata("barang_pengeluaran"));
    }

    public function get_ajax_data_barang_per_rak(){
        $id_rak     = $this->input->post("id_rak");

        $where = array(
            'id_rak'        => $id_rak,
            'id_kadar'      => "1"
        );

        $barang     = $this->model_admin->get_data_from_uuid($where, "ms_barang")->result();

        echo json_encode($barang);
    }

    public function pengeluaran_tanpa_barang_proses(){
        //Masukkan dulu ke tabel pengeluaran
        $KdPengembalian = $this->model_admin->create_kode_pengeluaran();
        $beratnya       = floatval($this->input->post("berat_keluar"));

        // echo "<pre>";
        // print_r($beratnya);
        // exit(1);

        $data = array(
            'KdPengeluaran'     => $KdPengembalian,
            'id_barang'         => $this->input->post("id_barang"),
            'id_kadar'          => "1",
            'berat_terima'      => $beratnya,
            'uang'              => 0,
            'berat_asli'        => $beratnya,
            'Kategori'          => "lebur",
            'selisih_berat'     => 0,
            'usrid'             => $this->session->userdata("username") . " - " . date("Y-m-d H:i:s", time()),
            'tgl_penjualan'     => date("Y-m-d", time()),
            'tgl_real_penjualan'=> time()
        );

        $this->model_admin->tambah_data("tr_pengeluaran", $data);

        $this->model_admin->kurang_dari_stok($this->input->post("id_barang"), $beratnya);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Pengeluaran Barang Berhasil Dilakukan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/barang_keluar');
    }

    public function proses_barang_keluar(){
        //Kalau Kosong langsung tembak keluar aja
        if(count($this->session->userdata("barang_pengeluaran")) <= 0){
            redirect("adm/pengeluaran/");
        }

        $kategori_barang    = $this->input->post("kategori");
        $counter            = 0;

        //Buat dulu ms_penjualan
        $KdPengembalian = $this->model_admin->create_kode_pengeluaran();



        //{Proses Dulu Penjualannya di tabel Penjualan}
        foreach($this->session->userdata("barang_pengeluaran") as $p){
            //get Id nya
            // $barang = $this->model_admin->get_data_from_uuid($where, "ms_barang")->row();

            //Baru letak di tr_pengembalian
            $data = array(
                'KdPengeluaran'     => $KdPengembalian,
                'id_barang'         => $p->Id,
                'id_kadar'          => $p->id_kadar,
                'berat_terima'      => $p->berat_jual,
                'uang'              => 0,
                'berat_asli'        => $p->berat_jual,
                'Kategori'          => $kategori_barang[$counter++],
                'selisih_berat'     => 0,
                'usrid'             => $this->session->userdata("username") . " - " . date("Y-m-d H:i:s", time()),
                'tgl_penjualan'     => date("Y-m-d", time()),
                'tgl_real_penjualan'=> time()
            );

            $this->model_admin->tambah_data("tr_pengeluaran", $data);

            //Habiskan
            $this->model_admin->kurang_stok($p->uuid);
        }

        //Setelah di proses, selanjutnya kita hapus dan letak di barang hapus
        foreach($this->session->userdata("barang_pengeluaran") as $p){
            //Cek Dulu Ada Gak Datanya!
            $where_hapus = array(
                'uuid'       => $p->uuid
            );

            //Get Dulu Data nya baru letak di ms_barang_hapus
            $datanya_hapus  = $this->model_admin->get_data_from_uuid($where_hapus, "ms_barang")->row();
            $data_hapus = array(
                'Id'                    => $datanya_hapus->Id,
                'uuid'                  => $datanya_hapus->uuid,
                'nama_barang'           => $datanya_hapus->nama_barang,
                'id_kadar'              => $datanya_hapus->id_kadar,
                'id_rak'                => $datanya_hapus->id_rak,
                'urutan_rak'            => $datanya_hapus->urutan_rak,
                'keterangan'            => $datanya_hapus->keterangan,
                'usrid'                 => $datanya_hapus->usrid,
                'tgl_input_real'        => $datanya_hapus->tgl_input_real,
                'tgl_input_real_jam'    => $datanya_hapus->tgl_input_real_jam,
                'stok'                  => $datanya_hapus->stok,
                'berat_jual'            => $datanya_hapus->berat_jual,
                'foto'                  => $datanya_hapus->foto,
                'tanggal_hapus'         => time(),
                'alasan'                => "PENGELUARAN"
            );

            $this->model_admin->tambah_data("ms_barang_hapus", $data_hapus);

            $this->model_admin->hapus_data($where_hapus, "ms_barang");
        }


        $this->session->set_userdata("barang_pengeluaran", array());

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Pengeluaran Barang Berhasil Dilakukan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/barang_keluar');
    }
}

?>