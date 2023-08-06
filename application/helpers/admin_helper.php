<?php

if(!defined('BASEPATH')) exit('no file allowed');

function generate_big_book_open_with_live_data(){
    $Ci =& get_instance();

    $KdBukuBesar            = $Ci->model_admin->create_kd_buku_besar();

    //Get All Rak
    $semua_rak              = $Ci->model_admin->tampil_data("ms_rak", "nama_rak", "ASC")->result();
    
    foreach($semua_rak as $d){
        $berat_data = $Ci->model_admin->get_berat_dan_qty_per_rak($d->id);

        $data_masuk = array(
            'KdBukuBesar'       => $KdBukuBesar,
            'id_rak'            => $d->id,
            'open'              => $berat_data->BeratKotor,
            'open_bersih'       => $berat_data->BeratBersih,  
            'open_timbang'      => 0,
            'masuk'             => 0,
            'keluar'            => 0,
            'jual'              => 0,
            'tutup'             => 0,
            'timbang'           => 0,
            'open_qt'           => $berat_data->Qty,
            'open_bersih_qt'    => $berat_data->Qty,
            'open_timbang_qt'   => 0,
            'masuk_qt'          => 0,
            'keluar_qt'         => 0,
            'jual_qt'           => 0,
            'tutup_qt'          => 0,
            'timbang_qt'        => 0,
        );

        // echo "<pre>";
        // print_r($data_masuk);
        // exit(1);

        $Ci->model_admin->tambah_data("tr_detail_dashboard_big_book", $data_masuk);
    }
}

?>