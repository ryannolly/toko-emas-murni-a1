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
        echo "iso";
    }

    public function under_development(){
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/under_development');
        $this->load->view('Admin/Template_admin/footer');
    }
}

?>