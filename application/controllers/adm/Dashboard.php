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
        $ashita = date("Y-m-d", time()+86400);
        $data['data_penjualan']         = $this->model_admin->get_dashboard_penjualan(strtotime($kyou), strtotime($ashita));
        $data['data_pengembalian']      = $this->model_admin->get_dashboard_pengembalian(strtotime($kyou), strtotime($ashita));

        $data['detail_data_penjualan_rak']      = $this->model_admin->get_dashboard_penjualan_group_by(strtotime($kyou), strtotime($ashita), "rak.nama_rak");
        $data['detail_data_penjualan_kadar']    = $this->model_admin->get_dashboard_penjualan_group_by(strtotime($kyou), strtotime($ashita), "kadar.nama_kadar");

        //Cek dulu udah buka toko belum?
        $apakah_sudah_ada       = $this->model_admin->get_big_book_dashboard($kyou);
        if(!@$apakah_sudah_ada){
            generate_big_book_open_with_live_data();
        }

        
        // $data['detail_data_pengembalian_rak']   = $this->model_admin->get_dashboard_pengembalian_group_by(strtotime($kyou), strtotime($ashita), "rak.nama_rak");
        $data['detail_data_pengembalian_kadar']   = $this->model_admin->get_dashboard_pengembalian_group_by(strtotime($kyou), strtotime($ashita), "kadar.nama_kadar");
        $data['big_book']               = $this->model_admin->get_big_book_dashboard($kyou);

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

        //Inisialisasi dulu semua rak

        //Get Data Sebelumnya
        $tgl_sebelumnya         = $this->model_admin->get_tgl_big_book_dashboard_terakhir();
        $tutup_per_rak          = array();
        $tutup_per_rak_qt       = array();

        //Inisialisasi dulu semua rak
        $semua_rak = $this->model_admin->tampil_data('ms_rak', "nama_rak", "ASC")->result();
        foreach($semua_rak as $n){
            $tutup_per_rak_qt[$n->id]   = 0;
            $tutup_per_rak[$n->id]      = 0;
        }

        if(@$tgl_sebelumnya){
            $data_sebelumnya    = $this->model_admin->get_big_book_dashboard_terakhir($tgl_sebelumnya->TglBukuBesar);
			
			if(@$data_sebelumnya){
				foreach($data_sebelumnya as $p){
					$tutup_per_rak_qt[$p->id_rak] = $p->tutup_qt;
					$tutup_per_rak[$p->id_rak] = $p->tutup;
				}
			}else{
				$semua_rak = $this->model_admin->tampil_data('ms_rak', "nama_rak", "ASC")->result();
				foreach($semua_rak as $n){
					$tutup_per_rak_qt[$n->id]   = 0;
					$tutup_per_rak[$n->id]      = 0;
				}
            }
        }else{
            $semua_rak = $this->model_admin->tampil_data('ms_rak', "nama_rak", "ASC")->result();
            foreach($semua_rak as $n){
                $tutup_per_rak_qt[$n->id]   = 0;
                $tutup_per_rak[$n->id]      = 0;
            }
        }

        //Create master big book for today
        $KdBukuBesar            = $this->model_admin->create_kd_buku_besar();

        //Get All Rak
        $semua_rak              = $this->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
        foreach($semua_rak as $n){
            $data = array(
                'KdBukuBesar'       => $KdBukuBesar,
                'id_rak'            => $n->id,
                'open'              => $tutup_per_rak[$n->id],
                'masuk'             => 0,
                'keluar'            => 0,
                'jual'              => 0,
                'tutup'             => 0,
                'timbang'           => 0,
                'open_qt'           => $tutup_per_rak_qt[$n->id],
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

    public function refresh_big_book($KdBukuBesar = 0){
        $timbangan          = $this->input->post("timbang[]");
        $timbangan_qt       = $this->input->post("timbang_qt[]");

        $open_timbangan     = $this->input->post("timbang_open[]");
        $open_timbangan_qt  = $this->input->post("timbang_open_qt[]");

        //Get Tanggal
        $kyou   = date("Y-m-d", time());
        $ashita = date("Y-m-d", time()+86400);
        
        //Get All Rak in Buku Besar
        $big_book       = $this->model_admin->get_big_book_dashboard($kyou);
        $counter = 0;
        foreach($big_book as $p){
            $open       = $this->model_admin->get_data_berat_pada_bigbook($p->id_rak, $kyou)->open;
            $open_qt    = $this->model_admin->get_data_berat_pada_bigbook($p->id_rak, $kyou)->open_qt; 


            //Update Masuk
            $where = array(
                'KdBukuBesar'       => $KdBukuBesar,
                'id_rak'            => $p->id_rak
            );

            //Get Data
            $terbaru        = $this->model_admin->get_berat_total_per_rak($p->id_rak, $kyou);
            $terbaru_paikia = $this->model_admin->get_penambahan_paikia_per_rak($p->id_rak, $kyou);

            $data = array(
                'masuk'         => $terbaru->Berat + $terbaru_paikia->Berat,
                'masuk_qt'      => $terbaru->Qty
            );

            $open += ($terbaru->Berat + $terbaru_paikia->Berat);
            $open_qt += $terbaru->Qty;

            $this->model_admin->ubah_data($where, $data, "tr_detail_dashboard_big_book");

            //Get Data
            $terbaru        = $this->model_admin->get_pengeluaran_per_rak($p->id_rak, strtotime($kyou), strtotime($ashita));
            $terbaru_paikia = $this->model_admin->get_pengeluaran_per_rak_paikia($p->id_rak, strtotime($kyou), strtotime($ashita));

            //Update Keluar
            $data = array(
                'keluar'        => $terbaru->Berat + $terbaru_paikia->Berat,
                'keluar_qt'     => $terbaru->Qty
            );

            $open -= ($terbaru->Berat + $terbaru_paikia->Berat);
            $open_qt -= $terbaru->Qty;

            $this->model_admin->ubah_data($where, $data, "tr_detail_dashboard_big_book");

            //Get Data
            $terbaru        = $this->model_admin->get_penjualan_per_rak($p->id_rak, strtotime($kyou), strtotime($ashita));

            //Update Jual
            $data = array(
                'jual'      => $terbaru->Berat,
                'jual_qt'   => $terbaru->Qty
            );

            $open -= $terbaru->Berat;
            $open_qt -= $terbaru->Qty;

            $this->model_admin->ubah_data($where, $data, "tr_detail_dashboard_big_book");

            //Tutup 
            $data = array(
                'tutup'     => $open,
                'tutup_qt'  => $open_qt
            );

            $this->model_admin->ubah_data($where, $data, "tr_detail_dashboard_big_book");

            //Get dulu data paikia atau apalah tuh namanya yang 0%
            $data_nol_persen    = $this->model_admin->get_data_paikia_per_rak($p->id_rak);

            $open -= $data_nol_persen->berat;

            //Tutup_Bersih
            $data = array(
                'tutup_bersih'  => $open,
                'tutup_bersih_qt'  => $open_qt
            );

            $this->model_admin->ubah_data($where, $data, "tr_detail_dashboard_big_book");

            //Update Timbangan
            $data = array(
                'open_timbang'      => $open_timbangan[$counter], 
                'open_timbang_qt'   => $open_timbangan_qt[$counter]
            );

            $this->model_admin->ubah_data($where, $data, "tr_detail_dashboard_big_book");

            //Update Timbangan
            $data = array(
                'timbang'   => $timbangan[$counter], 
                'timbang_qt'=> $timbangan_qt[$counter++]
            );

            $this->model_admin->ubah_data($where, $data, "tr_detail_dashboard_big_book");
        }

        //Balik Ke Dashboard
        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                Data telah berhasil diperbaharui!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        ');
        redirect('adm/dashboard');
    }

    public function print_big_book(){
        $kyou = date("Y-m-d", time());
        $ashita = date("Y-m-d", time()+86400);

        $data['big_book']               = $this->model_admin->get_big_book_dashboard($kyou);
        $data['kyou']                   = $kyou;

        foreach($data['big_book'] as $b){
            $b->jumlah_nol_persen       = $this->model_admin->get_nol_persen_pada_rak($b->id_rak);
        }

        $this->load->view("admin/print/print_big_book.php", $data);
    }

    public function under_development(){
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/under_development');
        $this->load->view('Admin/Template_admin/footer');
    }

    public function backup_database(){
        // Database configuration
        $dbHost = 'localhost';
        $dbUsername = 'root';
        $dbPassword = '';
        $dbName = 'toko-emas-murni-a1';

        // Command to execute mysqldump. Adjust the path according to your server configuration
        $command = "C:\\xampp\\mysql\\bin\\mysqldump -h$dbHost -u$dbUsername $dbName";

        // Execute the command and capture the output
        $output = shell_exec($command);

        if ($output === null) {
            echo "Backup gagal.";
        } else {
            // Set the header to return a SQL file
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . $dbName . '.sql"');
            echo $output;
        }
    }
}

?>