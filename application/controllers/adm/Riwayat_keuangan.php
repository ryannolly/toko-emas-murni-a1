<?php

class Riwayat_keuangan extends CI_Controller {
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

    public function lihat_riwayat_keuangan($tanggal = ''){
        $kyou = date("Y-m-d", time());

        if($tanggal == ''){
            $tanggal = date("Y-m-d", time());
        }

        if($tanggal <= "2024-02-24"){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Tanggal Tidak Tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/riwayat_keuangan/lihat_riwayat_keuangan');
        }

        //Ambil dulu opening dan closing
        $where = array(
            'tanggal'       => $tanggal
        );

        $data['detail_opening'] = $this->model_admin->get_data_from_uuid($where, "tr_riwayat_keuangan")->row();

        if(empty($data['detail_opening']) && $tanggal == $kyou){
            //Kalau Kosong, buat dulu baru ambil lagi
            
            //Get Detail opening paling terakhir
            $detail_opening_terakhir    = $this->model_admin->get_detail_opening_terakhir();

            //Hitung Dulu berapa banyak pemasukkan semalam
            $tanggal_awal   = strtotime($detail_opening_terakhir->tanggal. " 00:00:00");
            $tanggal_akhir  = strtotime($detail_opening_terakhir->tanggal. " 23:59:59");

            $pemasukkan_semalam = $this->model_admin->get_rekap_penjualan($tanggal_awal, $tanggal_akhir);

            $pemasukkan_semalam_fix = 0;

            foreach($pemasukkan_semalam as $p){
                $pemasukkan_semalam_fix += $p->nilai_barang;
            }
            
            //Hitung Dulu berapa banyak pengeluaran semalam
            $pengeluaran_semalam = $this->model_admin->get_rekap_pengembalian($tanggal_awal, $tanggal_akhir);

            $pengeluaran_semalam_fix = 0;

            foreach($pengeluaran_semalam as $p){
                $pengeluaran_semalam_fix += $p->uang;
            }

            $final_uang_masuk_stock = $detail_opening_terakhir->uang_stok + $pemasukkan_semalam_fix - $pengeluaran_semalam_fix;

            //Baru sisanya itu lah dia
            
            $data_isi_stock = array(
                'tanggal'   => $tanggal,
                'uang_stok' => $final_uang_masuk_stock,
                'closing_stok'  => 0
            );

            $this->model_admin->tambah_data("tr_riwayat_keuangan", $data_isi_stock);

            $data['detail_opening'] = $this->model_admin->get_data_from_uuid($where, "tr_riwayat_keuangan")->row();
        }else if(empty($data['detail_opening']) && $tanggal != $kyou){
            $this->session->set_flashdata('pesan','<div class="alert alert-warning alert-dismissible" role="alert" style="color:#000">
                                                Tanggal Tidak Tersedia!
                                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                            </div>
            ');
            redirect('adm/riwayat_keuangan/lihat_riwayat_keuangan');
        }

        $data['tanggal'] = $tanggal;
        $this->load->view('Admin/Template_admin/header');
        $this->load->view('Admin/Template_admin/sidebar');
        $this->load->view('Admin/riwayat_keuangan', $data);
        $this->load->view('Admin/Template_admin/footer');
    }

    public function ganti_tanggal(){
        redirect("adm/riwayat_keuangan/lihat_riwayat_keuangan/" . $this->input->post("tgl_big_book"));
    }

    public function opening_closing_proses($tanggal){
        $where = array(
            'tanggal'       => $tanggal
        );

        $data = array(
            'uang_stok'     => $this->input->post("uang_stock"),
            'closing_stok'  => $this->input->post("closing_stock")
        );

        $this->model_admin->ubah_data($where, $data, "tr_riwayat_keuangan");

        $this->session->set_flashdata('pesan','<div class="alert alert-success alert-dismissible" role="alert" style="color:#000">
                                            Uang Stock Open dan Closing telah diperbaharui!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
        ');
        redirect('adm/riwayat_keuangan/lihat_riwayat_keuangan/'. $tanggal);
    }

    public function cetak_riwayat_keuangan($tanggal = ''){
        if($tanggal == ''){
            $tanggal = date("Y-m-d", time());
        }

        $tanggal_awal   = strtotime($tanggal. " 00:00:00");
        $tanggal_akhir  = strtotime($tanggal. " 23:59:59");

        $data['pemasukkan_hari_ini']     = $this->model_admin->get_rekap_penjualan($tanggal_awal, $tanggal_akhir);
        $data['pengeluaran_hari_ini']    = $this->model_admin->get_rekap_pengembalian($tanggal_awal, $tanggal_akhir);

        //Ambil dulu opening dan closing
        $where = array(
            'tanggal'       => $tanggal
        );

        $data['detail_opening'] = $this->model_admin->get_data_from_uuid($where, "tr_riwayat_keuangan")->row();

        $this->load->view("admin/print/cetak_riwayat_keuangan", $data);
    }
}

?>