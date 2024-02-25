<?php

class Penjualan extends CI_Controller {
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
        // $data['data_barang']        = $this->model_admin->tampil_data_barang();
        $data['data_kadar']         = $this->model_admin->tampil_data("ms_kadar", "nama_kadar", "ASC")->result();
        // $data['data_rak']           = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/penjualan', $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function penjualan_tanpa_barang_proses(){
        if(@$this->input->post("keterangan") && @$this->input->post("nilai_jual")){
            //Masukkan terlebih dahulu ke ms penjualan
            $KdPenjualan    = $this->model_admin->create_kode_penjualan();

            $berat = 0;
            if(!empty($this->input->post("berat"))){
                $berat = $this->input->post("berat");
            }

            $data_per_biji = array(
                'id_barang'   => $this->input->post("keterangan"),
                'KdPenjualan' => $KdPenjualan,
                'berat_jual'  => $berat,
                'berat_asli'  => $berat,
                'nilai_barang'=> $this->input->post("nilai_jual"),
                'DP_Pelunasan'=> $this->input->post("nilai_jual"),
                'JnPembayaran'=> "Bank",
                'id_rak'      => "",
                'id_kadar'    => $this->input->post("id_kadar"),
                'usrid'       => $this->session->userdata("username"). " - " .date("Y-m-d H:i:s", time()),
                'tgl_penjualan' => date("Y-m-d H:i:s", time()),
                'tgl_real_penjualan'    => time()
            );

            $this->model_admin->tambah_data("tr_penjualan", $data_per_biji);

            $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                    Penjualan Tanpa Barang Berhasil Dilakukan!
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>
            ');
            redirect('adm/penjualan');
        }else{
            redirect('adm/penjualan');
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
        $data = $this->session->userdata("barang_kasir");
        foreach($data as $d){
            $where = array(
                'id_rak'        => $d->id_rak,
                'id_kadar'      => "1"
            );
    
            $barang     = $this->model_admin->get_data_from_uuid($where, "ms_barang")->result();
            $d->barang_paikia      = $barang;
        }

        echo json_encode($data);
    }

    public function penjualan_proses(){
        if(count($this->session->userdata('barang_kasir')) <= 0){
            $this->session->set_flashdata('pesan',
                '<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                    Silahkan scan barang terlebih dahulu!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>'
            );  
            redirect('adm/penjualan');
        }

        // echo "<pre>";
        // print_r($this->input->post());
        // exit(1);

        $POST_id_barang     = $this->input->post("id_barang_session[]");
        $POST_harga_barang  = $this->input->post("harga_barang[]");
        $POST_berat_barang  = $this->input->post("berat_jual[]");
        $POST_paikia        = $this->input->post("paikia[]");
        $POST_berat_paikia  = $this->input->post("berat_paikia[]");

        $data = array();

        $NoInvoice = $this->input->post("NoInvoice");

        //Post and get kdPenjualan
        $KdPenjualan    = $this->model_admin->create_kode_penjualan($NoInvoice);

        //{Proses Dulu Penjualannya di tabel Penjualan}
        for($i = 0; $i<sizeof($POST_id_barang); $i++){
            foreach($this->session->userdata("barang_kasir") as $p){
                if($p->id_session_barang == $POST_id_barang[$i]){
                    $data_per_biji = array(
                        'id_kadar'    => $p->id_kadar,
                        'KdPenjualan' => $KdPenjualan,
                        'berat_jual'  => $p->berat_jual,
                        'berat_asli'  => (floatval($POST_berat_barang[$i]) == 0) ? $p->berat_jual : $POST_berat_barang[$i],
                        'nilai_barang'=> $POST_harga_barang[$i],
                        'DP_Pelunasan'=> $POST_harga_barang[$i],
                        'JnPembayaran'=> "TUNAI",
                        'id_rak'      => $p->id_rak,
                        'id_barang'   => $p->Id,
                        'usrid'       => $this->session->userdata("username"). " - " .date("Y-m-d H:i:s", time()),
                        'tgl_penjualan' => date("Y-m-d H:i:s", time()),
                        'tgl_real_penjualan'    => time()
                    );

                    $data[] = $data_per_biji;
                }
            }
        }

        //Masukkan ke tabel penjualan
        foreach($data as $p){
            $this->model_admin->tambah_data("tr_penjualan", $p);
        }

        foreach($this->session->userdata("barang_kasir") as $b){
            //Kurangin dulu stok yang ada pada barang tersebut
            $this->model_admin->kurang_stok($b->uuid);
            //Langsung Letak di ms_barang_hapus
            //Cek Dulu Ada Gak Datanya!
            $where_hapus = array(
                'uuid'       => $b->uuid
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
                'alasan'                => "PENJUALAN"
            );

            $this->model_admin->tambah_data("ms_barang_hapus", $data_hapus);

            $this->model_admin->hapus_data($where_hapus, "ms_barang");
        }

        //Kurangin dulu pada paikia dan tambah pada data pengeluaran
        //Masukkan dulu ke tabel pengeluaran
        $KdPengembalian = $this->model_admin->create_kode_pengeluaran();

        for($i = 0; $i<sizeof($POST_paikia); $i++){
            $data = array(
                'KdPengeluaran'     => $KdPengembalian,
                'id_barang'         => $POST_paikia[$i],
                'id_kadar'          => "1",
                'berat_terima'      => floatval($POST_berat_paikia[$i]),
                'uang'              => 0,
                'berat_asli'        => floatval($POST_berat_paikia[$i]),
                'Kategori'          => "lebur",
                'selisih_berat'     => 0,
                'usrid'             => $this->session->userdata("username") . " - " . date("Y-m-d H:i:s", time()),
                'tgl_penjualan'     => date("Y-m-d", time()),
                'tgl_real_penjualan'=> time()
            );
    
            $this->model_admin->tambah_data("tr_pengeluaran", $data);
    
            $this->model_admin->kurang_dari_stok($POST_paikia[$i], $POST_berat_paikia[$i]);
        }

        //-- End of Kurangin dulu paikia nya

        $this->session->set_userdata("barang_kasir", array());
        
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Penjualan Berhasil Dilakukan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/penjualan');
    }
}

?>