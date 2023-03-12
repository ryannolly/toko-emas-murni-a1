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
        $this->model_admin->column_search = array('bar.nama_barang', 'rak.nama_rak', 'kadar.nama_kadar');
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
            'tgl_input_real'    => date("Y-m-d", time()),
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
        }else{
            //Kalau Gak dimasukkan ya nendang beb
            $this->session->set_flashdata('pesan', '<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Harap Memasukkan foto anda terlebih dahulu!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>');
            redirect('adm/data_barang');
        }

        $data['foto']   = $fileName;

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

        $data = array(
            'nama_barang'       => $this->input->post("nama_barang"),
            'id_kadar'          => $this->input->post("id_kadar"),
            'id_rak'            => $this->input->post("id_rak"),
            'keterangan'        => $this->input->post("keterangan"),
            'stok'              => $this->input->post("stok"),
            'berat_jual'        => (float) $this->input->post("berat_jual"),
            'tgl_input_real'    => date("Y-m-d", time()),
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

    public function print_qr($id = 0){
        $where = array(
            'id'    => $id
        );

        $data['detail_data']        = $this->model_admin->get_data_from_uuid($where, "ms_barang")->row();

        $this->load->view("Admin/cetak_qr/qr_barang", $data);
    }

    public function cetak_qr_banyak(){
        $where = array(
            'id_rak'            => $this->input->post("id_rak"),
            'tgl_input_real'    => $this->input->post("tgl_input_real")
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
}

?>