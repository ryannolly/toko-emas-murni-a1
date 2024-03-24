<?php 

class Riwayat_penjualan extends CI_Controller {
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
        $this->model_admin->column_search = array('penjualan.KdPenjualan', 'penjualan.NoInvoice', 'penjualan.TglProses', 'penjualan.usrid');
        $this->model_admin->order = array('bar.id' => 'desc');

        //Cek Dulu Ada Gak Filternya
        if(@$_POST['tanggal_mulai'] || @$_POST['tanggal_berakhir']){
            $where = array(
                'tanggal_mulai'    => strtotime($_POST['tanggal_mulai']),
                'tanggal_berakhir' => strtotime($_POST['tanggal_berakhir']) 
            );
        }else{
            $where = array(
                'tanggal_mulai'    => "",
                'tanggal_berakhir' => ""
            );
        }
        

        //Mulai
        $list = $this->model_admin->get_datatables_data_riwayat_penjualan("ms_penjualan", $where);
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->KdPenjualan . " / " . $item->NoInvoice;
            $row[] = date("D, Y-m-d H:i:s", $item->TglProses);
            $row[] = $item->usrid;
            $row[] = '<a href="'.base_url("adm/riwayat_penjualan/detail_penjualan/".$item->KdPenjualan).'">
                            <button type="button" class="btn btn-icon btn-info" title="Lihat Detail Penjualan">
                                <span class="tf-icons bx bx-edit"></span>
                            </button>
                        </a>';

            


            $data[] = $row;
        }

        $output = array(
            "draw"  => @$_POST['draw'],
            "recordsTotal"  => $this->model_admin->count_all_data_riwayat_penjualan($where),
            "recordsFiltered"   => $this->model_admin->count_filtered_data_riwayat_penjualan($where),
            "data" => $data
        );

        echo json_encode($output);
    }

    public function cetak_penjualan(){
        //Proses Tanggal Proses
        $tanggal        = $this->input->post("tgl_input_real");
        $tanggal_awal   = strtotime($tanggal. " 00:00:00");
        $tanggal_akhir  = strtotime($tanggal. " 23:59:59");

        $data['rekap'] = $this->model_admin->get_rekap_penjualan($tanggal_awal, $tanggal_akhir);
        $data['rekap_per_kadar'] = $this->model_admin->get_rekap_penjualan_per_kadar($tanggal_awal, $tanggal_akhir); 
        $data['kyou']  = $this->input->post("tgl_input_real");

        $this->load->view("Admin/print/cetak_penjualan_per_hari", $data);
    }

    public function cetak_penjualan_range(){
        $tanggal_awal   = strtotime($this->input->post("tgl_input_real") . " 00:00:00");
        $tanggal_akhir  = strtotime($this->input->post("tgl_input_real_akhir") . " 23:59:59");

        $data['rekap'] = $this->model_admin->get_rekap_penjualan($tanggal_awal, $tanggal_akhir);
        $data['rekap_per_kadar'] = $this->model_admin->get_rekap_penjualan_per_kadar($tanggal_awal, $tanggal_akhir); 
        $data['tanggal_awal']  = $this->input->post("tgl_input_real");
        $data['tanggal_akhir'] = $this->input->post("tgl_input_real_akhir");

        $this->load->view("Admin/print/cetak_penjualan_per_hari_range", $data);
    }

    public function index(){
        // $data['data_barang']        = $this->model_admin->tampil_data_barang();
        // $data['data_kadar']         = $this->model_admin->tampil_data("ms_kadar", "nama_kadar", "ASC")->result();
        // $data['data_rak']           = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/riwayat_penjualan');
        $this->load->view('Admin/Template_admin/footer');
    }

    public function detail_penjualan($Id = 0){
        if($Id === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Harap Memilih terlebih dahulu data yang ingin diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/riwayat_penjualan');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'KdPenjualan'       => $Id
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_penjualan')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/riwayat_penjualan');
        }

        //Get Detail Data
        $data['detail_penjualan']       = $this->model_admin->get_data_penjualan_by_kd_penjualan($Id);
        $data['penjualan']              = $this->model_admin->get_data_from_uuid($where, "ms_penjualan")->row();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/lihat_data/riwayat_penjualan", $data);
        $this->load->view('Admin/Template_admin/footer');
    }
}

?>