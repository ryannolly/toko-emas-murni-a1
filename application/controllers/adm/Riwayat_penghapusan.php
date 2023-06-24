<?php

class Riwayat_penghapusan extends CI_Controller {
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

    public function get_ajax(){
        //Set Dulu Variabel Yang Dipakek Buat Get_DataTables
        $this->model_admin->column_order = array(null, 'bar.nama_barang', 'rak.nama_rak', 'kadar.nama_kadar');
        $this->model_admin->column_search = array('bar.nama_barang', 'rak.nama_rak', 'kadar.nama_kadar', 'bar.id');
        $this->model_admin->order = array('bar.id' => 'desc');

        //Cek Dulu Ada Gak Filternya
        if(@$_POST['id_rak'] || @$_POST['id_kadar'] || @$_POST['tanggal_awal'] || @$_POST['tanggal_akhir']){
            $where = array(
                'id_rak'        => $_POST['id_rak'],
                'id_kadar'      => $_POST['id_kadar'],
                'tanggal_awal'  => $_POST['tanggal_awal'],
                'tanggal_akhir' => $_POST['tanggal_akhir']
            );
        }else{
            $where = array(
                'id_rak'        => "",
                'id_kadar'      => "",
                'tanggal_awal'  => "",
                'tanggal_akhir' => ""
            );
        }
        

        //Mulai
        $list = $this->model_admin->get_datatables_data_barang_penghapusan("ms_barang_hapus", $where);
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->Id;
            $row[] = $item->nama_barang;
            $row[] = $item->nama_rak;
            $row[] = $item->nama_kadar;
            $row[] = $item->stok;
            $row[] = $item->berat_jual . " gr";
            $row[] = date("Y-m-d H:i:s", $item->tanggal_hapus);
            $row[] = $item->alasan;
            $row[] = '<a class="hapus_data" href="'.base_url("adm/riwayat_penghapusan/undo_barang/".$item->Id).'">
                        <button type="button" class="btn btn-icon btn-primary" title="Batal Penghapusan">
                            <span class="tf-icons bx bx-undo"></span>
                        </button>
                    </a>';

            


            $data[] = $row;
        }

        $output = array(
            "draw"  => @$_POST['draw'],
            "recordsTotal"  => $this->model_admin->count_all_data_barang($where),
            "recordsFiltered"   => $this->model_admin->count_filtered_data_barang($where),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function index(){
        $data['data_barang']        = $this->model_admin->tampil_data_barang();
        $data['data_kadar']         = $this->model_admin->tampil_data("ms_kadar", "nama_kadar", "ASC")->result();
        $data['data_rak']           = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/riwayat_data_barang', $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function undo_barang($id = 0){
        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'Id'       => $id
        );

        //Get Dulu Data nya baru letak di ms_barang_hapus
        $datanya  = $this->model_admin->get_data_from_uuid($where, "ms_barang_hapus")->row();
        $data = array(
            'Id'                    => $datanya->Id,
            'uuid'                  => $datanya->uuid,
            'nama_barang'           => $datanya->nama_barang,
            'id_kadar'              => $datanya->id_kadar,
            'id_rak'                => $datanya->id_rak,
            'keterangan'            => $datanya->keterangan,
            'usrid'                 => $datanya->usrid ." - Pengembalian barang hapus/terjual" ,
            'tgl_input_real'        => $datanya->tgl_input_real,
            'tgl_input_real_jam'    => $datanya->tgl_input_real_jam,
            'stok'                  => $datanya->stok,
            'berat_jual'            => $datanya->berat_jual,
            'foto'                  => $datanya->foto,
        );

        $this->model_admin->tambah_data("ms_barang", $data);

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_barang_hapus')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda hapus tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/riwayat_penghapusan');
        }

        $this->model_admin->hapus_data($where, "ms_barang_hapus");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Pembatalan penghapusan berhasil! Barang kembali aktif
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/riwayat_penghapusan');
    }
}

?>