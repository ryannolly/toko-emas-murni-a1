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
}

?>