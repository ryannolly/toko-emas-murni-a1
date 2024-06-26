<?php 

class Data_barang extends CI_Controller {
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
        if(@$_POST['id_rak'] || @$_POST['id_kadar']){
            $where = array(
                'id_rak'    => $_POST['id_rak'],
                'id_kadar'  => $_POST['id_kadar'] 
            );
        }else{
            $where = array(
                'id_rak'    => "",
                'id_kadar'  => ""
            );
        }
        

        //Mulai
        $list = $this->model_admin->get_datatables_data_barang("ms_barang", $where);
        $data = array();
        $no = @$_POST['start'];
        foreach ($list as $item){
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $item->Id. " / " .$item->urutan_rak;
            $row[] = $item->nama_barang;
            $row[] = $item->nama_rak;
            $row[] = $item->nama_kadar;
            $row[] = $item->stok;
            $row[] = $item->usrid;
            $row[] = '<a href="'.base_url("adm/data_barang/ubah_data_barang/".$item->Id).'">
                            <button type="button" class="btn btn-icon btn-info" title="Edit Barang">
                                <span class="tf-icons bx bx-edit"></span>
                            </button>
                        </a>
                        <a href="'.base_url("adm/data_barang/cetak_qr/".$item->Id).'">
                            <button type="button" class="btn btn-icon btn-primary" title="Print QR">
                                <span class="tf-icons bx bx-printer"></span>
                            </button>
                        </a>
                        <a class="hapus_data" href="'.base_url("adm/data_barang/hapus_data_barang/".$item->Id).'">
                            <button type="button" class="btn btn-icon btn-danger" title="Hapus Barang">
                                <span class="tf-icons bx bx-trash"></span>
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
        $this->load->view('Admin/data_barang', $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function tambah_data_barang(){
        $data = array(
            'nama_barang'       => $this->input->post("nama_barang"),
            'id_kadar'          => $this->input->post("id_kadar"),
            'id_rak'            => $this->input->post("id_rak"),
            'keterangan'        => $this->input->post("keterangan"),
            'stok'              => (int) $this->input->post("stok"),
            'usrid'             => $this->session->userdata("username") . " - " . date("Y-m-d H:i:s", time()),
            'tgl_input_real'    => $this->input->post("tgl_input_real"),
            'tgl_input_real_jam'    => date("Y-m-d H:i:s", time()),
            'berat_jual'        => (float) $this->input->post("berat_jual")
        );

        $this->db->set('uuid', 'REPLACE(UUID(), "-", "")', FALSE);

        //Ngatur Fail
        $fileName = $_FILES['foto']['name'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        if($fileName != ""){
            $config['upload_path']          = "./uploads/foto_emas/";
            $config['allowed_types']        = 'jpg|jpeg|png';
            $newFileName                    = "EMAS-".uniqid('', true).".".$fileActualExt;
            $config["file_name"]            = $newFileName;
            $config['max_size']             = 10000;

            //Upload
            $this->load->library('upload', $config);
            if(!$this->upload->do_upload('foto')){
                $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                            '.$this->upload->display_errors('<p>', '</p>').'
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>');
                redirect('adm/data_barang');
            }else{
                $fileName = $this->upload->data('file_name');
            }
        }

        //Get Terakhir
        $nomor_terakhir         = $this->model_admin->get_nomor_terakhir($this->input->post("id_rak"));
        $nomor_terakhir_hapus   = $this->model_admin->get_nomor_terakhir_hapus($this->input->post("id_rak"));
        $nomor_terakhir_gunakan = max($nomor_terakhir, $nomor_terakhir_hapus);

        $data['urutan_rak'] = ++$nomor_terakhir_gunakan;
        $data['foto']       = $fileName;

        $this->model_admin->tambah_data("ms_barang", $data);

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Barang Telah Berhasil Ditambahkan!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_barang');        
    }

    public function ubah_data_barang($Id = 0){
        if($Id === 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Harap Memilih terlebih dahulu data yang ingin diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_barang');
        }

        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'id'       => $Id
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_barang')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_barang');
        }

        //Get Detail Data
        $data['detail_data']        = $this->model_admin->get_data_from_uuid($where, "ms_barang")->row();
        $data['data_kadar']         = $this->model_admin->tampil_data("ms_kadar", "nama_kadar", "ASC")->result();
        $data['data_rak']           = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();

        $this->load->view("Admin/Template_admin/header");
        $this->load->view("Admin/Template_admin/sidebar");
        $this->load->view("Admin/ubah/data_barang", $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function ubah_data_barang_aksi(){
        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'id'       => $this->input->post("id_real")
        );

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_barang')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda ubah tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_barang');
        }

        //Cek Dulu Password Transaksinya benar gak?
        $data_bos = $this->model_admin->get_data_boss();
        $check = hash('sha512', $this->input->post("PasswordTransaksi").$data_bos->salt);
        if($check != $data_bos->password){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Maaf, Password Transaksi Salah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_barang/ubah_data_barang/'.$this->input->post('id_real'));
        }

        $data = array(
            'nama_barang'       => $this->input->post("nama_barang"),
            'id_kadar'          => $this->input->post("id_kadar"),
            'id_rak'            => $this->input->post("id_rak"),
            'keterangan'        => $this->input->post("keterangan"),
            'stok'              => $this->input->post("stok"),
            'berat_jual'        => (float) $this->input->post("berat_jual"),
            'tgl_input_real'    => $this->input->post("tgl_input_real"),
            'usrid'             => $this->session->userdata("username") . " - " . date("Y-m-d H:i:s", time())
        );

        //Ngatur Fail
        $fileName = $_FILES['foto']['name'];

        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));

        if($fileName != ""){
            $config['upload_path']          = "./uploads/foto_emas/";
            $config['allowed_types']        = 'jpg|jpeg|png';
            $newFileName                    = "EMAS-".uniqid('', true).".".$fileActualExt;
            $config["file_name"]            = $newFileName;
            $config['max_size']             = 10000;

            //Upload
            $this->load->library('upload', $config);
            if(!$this->upload->do_upload('foto')){
                $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                            '.$this->upload->display_errors('<p>', '</p>').'
                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                        </div>');
                redirect('adm/data_barang');
            }else{
                unlink("./uploads/foto_emas/".$this->input->post('fail_foto_lama'));
                $fileName = $this->upload->data('file_name');
            }
        }

        $data['foto']   = $fileName;

        $this->model_admin->ubah_data($where, $data, "ms_barang");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Barang Telah Berhasil Diubah!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_barang');
    }

    public function hapus_data_barang($id = 0){
        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'Id'       => $id
        );

        //Get Dulu Data nya baru letak di ms_barang_hapus
        $datanya  = $this->model_admin->get_data_from_uuid($where, "ms_barang")->row();
        $data = array(
            'Id'                    => $datanya->Id,
            'uuid'                  => $datanya->uuid,
            'nama_barang'           => $datanya->nama_barang,
            'id_kadar'              => $datanya->id_kadar,
            'id_rak'                => $datanya->id_rak,
            'urutan_rak'            => $datanya->urutan_rak,
            'keterangan'            => $datanya->keterangan,
            'usrid'                 => $datanya->usrid,
            'tgl_input_real'        => $datanya->tgl_input_real,
            'tgl_input_real_jam'    => $datanya->tgl_input_real_jam,
            'stok'                  => $datanya->stok,
            'berat_jual'            => $datanya->berat_jual,
            'foto'                  => $datanya->foto,
            'tanggal_hapus'         => time(),
            'alasan'                => "HAPUS DARI DATA BARANG"
        );

        $this->model_admin->tambah_data("ms_barang_hapus", $data);

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_barang')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda hapus tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_barang');
        }

        $this->model_admin->hapus_data($where, "ms_barang");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Barang Telah Berhasil Dihapus!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_barang');
    }

    public function hapus_data_barang_dari_cek_rak($KdBarang, $KdRak){
        //Cek Dulu Ada Gak Datanya!
        $where = array(
            'Id'       => $KdBarang
        );

        //Get Dulu Data nya baru letak di ms_barang_hapus
        $datanya  = $this->model_admin->get_data_from_uuid($where, "ms_barang")->row();
        $data = array(
            'Id'                    => $datanya->Id,
            'uuid'                  => $datanya->uuid,
            'nama_barang'           => $datanya->nama_barang,
            'id_kadar'              => $datanya->id_kadar,
            'id_rak'                => $datanya->id_rak,
            'keterangan'            => $datanya->keterangan,
            'usrid'                 => $datanya->usrid,
            'tgl_input_real'        => $datanya->tgl_input_real,
            'tgl_input_real_jam'    => $datanya->tgl_input_real_jam,
            'stok'                  => $datanya->stok,
            'berat_jual'            => $datanya->berat_jual,
            'foto'                  => $datanya->foto,
            'tanggal_hapus'         => time(),
        );

        $this->model_admin->tambah_data("ms_barang_hapus", $data);

        //Cek udah ada belum datanya
        if(!$this->model_admin->cek_ada_tidak_sama($where, 'ms_barang')){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Data yang ingin anda hapus tidak tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_barang');
        }

        $this->model_admin->hapus_data($where, "ms_barang");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Data Barang Telah Berhasil Dihapus!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_rak/cek_barang_pada_rak/'.$KdRak);
    }

    public function print_qr($id = 0){
        $where = array(
            'id'    => $id
        );

        $data['detail_data']        = $this->model_admin->get_data_from_uuid($where, "ms_barang")->row();

        $this->load->view("Admin/cetak_qr/qr_barang", $data);
    }

    public function cetak_qr($id = 0){
        $where = array(
            'id'        => $id
        );

        $data['data_barang']        = $this->model_admin->get_data_barang_for_qr_single($where);

        if(count($data['data_barang']) <= 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Tidak ada data pada rak dan tanggal tersebut!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_barang');
        }

        $this->load->view("Admin/print/print_qr", $data);
    }

    public function cetak_qr_banyak(){
        $where = array(
            'id_rak'            => $this->input->post("id_rak"),
            'tgl_input_real'    => $this->input->post("tgl_input_real"),
            'sampai_jam'        => $this->input->post('sampai_jam'),
        );

        $data['data_barang']    = $this->model_admin->get_data_barang_for_qr($where);

        if(count($data['data_barang']) <= 0){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Tidak ada data pada rak dan tanggal tersebut!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/data_barang');
        }

        $this->load->view("Admin/print/print_qr", $data);
    }

    public function ajax_post_and_get(){
        $where = array(
            'uuid'      => $this->input->post("uuid")
        );

        //Get Data
        $data['data'] = $this->model_admin->get_detail_barang($where);

        //Update the data in session
        if(@$data['data']){
            //Update last id barang kasir
            $data['data']->foto_url          = base_url('uploads/foto_emas/').$data['data']->foto;
            $data['is_data_ada'] = 1;
        }else{
            $data['is_data_ada'] = 0;
        }

        //Send
        echo json_encode($data);
    }

    public function get_kadar_for_rak(){
        $where = array(
            'id_kadar'    => $this->input->post("id")
        );

        $data = $this->model_admin->get_ajax_kadar_by_rak($this->input->post("id"));

        echo json_encode($data);
    }

    public function cetak_riwayat_barang_masuk(){
        if(!@$this->input->post("id_rak")){
            redirect("adm/data_barang");
        }

        $where = array(
            'id'    => $this->input->post("id_rak")
        );
        
        $sampai_jam = $this->input->post("tgl_input_real"). " " . $this->input->post("sampai_jam");

        $data['barang']     = $this->model_admin->get_barang_pada_rak_with_condition($this->input->post("id_rak"), $this->input->post("tgl_input_real"), $sampai_jam);
        $data['detail_rak'] = $this->model_admin->get_data_from_uuid($where, "ms_rak")->row();
        $data['tanggal']    = $this->input->post("tgl_input_real");
        $data['sampai_jam'] = $this->input->post("sampai_jam");

        $this->load->view("Admin/print/cetak_riwayat_barang_masuk", $data);
    }

    public function update_data_barang(){
        //get semua data rak
        $data_rak = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        
        foreach($data_rak as $d){
            $data_barang = $this->model_admin->get_barang_pada_rak_berurut($d->id);
            $no = 1;
            foreach($data_barang as $b){
                $where = array(
                    'Id'        => $b->Id
                );

                $data = array(
                    'urutan_rak'    => $no++
                );

                $this->model_admin->ubah_data($where, $data, "ms_barang");
            }
        }

        echo "Udah bang!";
    }

    public function tambah_berat_barang_nol_persen(){
        $id_rak         = intval($this->input->post("id_rak"));
        $id_barang      = intval($this->input->post("id_barang"));
        $berat_keluar   = floatval($this->input->post("berat_keluar"));

        $this->model_admin->tambah_berat_pada_barang($id_barang, $berat_keluar);

        //Get Current KdBukuBesar
        $kyou   = date("Y-m-d", time());
        $big_book       = $this->model_admin->get_big_book_dashboard($kyou);

        //Find big book real
        $big_book_real = array();
        foreach($big_book as $b){
            if($b->id_rak == $id_rak){
                $big_book_real = $b;
            }
        }

        $data = array(
            'id_rak'            => $id_rak,
            'id_barang'         => $id_barang,
            'penambahan_berat'  => $berat_keluar,
            'tgl_penambahan'    => $kyou,
            'user'              => $this->session->userdata("username") . " - " . date("Y-m-d H:i:s", time())
        );

        //Masukkan ke hs penambahan berat paikia
        $this->model_admin->tambah_data("hs_penambahan_berat_paikia", $data);

        // $this->model_admin->ubah_data($where, $data, "tr_detail_dashboard_big_book");

        // echo "<pre>";
        // print_r($data);
        // exit(1);

        //Redirect
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                                Berat Barang Telah Berhasil Ditambahkan! Silahkan cek pada big book
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
        ');
        redirect('adm/data_barang');        
    }
}

?>