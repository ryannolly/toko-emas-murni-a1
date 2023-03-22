<?php

function hari_ini(){
	$hari = date ("D");
 
	switch($hari){
		case 'Sun':
			$hari_ini = "Minggu";
		break;
 
		case 'Mon':			
			$hari_ini = "Senin";
		break;
 
		case 'Tue':
			$hari_ini = "Selasa";
		break;
 
		case 'Wed':
			$hari_ini = "Rabu";
		break;
 
		case 'Thu':
			$hari_ini = "Kamis";
		break;
 
		case 'Fri':
			$hari_ini = "Jumat";
		break;
 
		case 'Sat':
			$hari_ini = "Sabtu";
		break;
		
		default:
			$hari_ini = "Tidak di ketahui";		
		break;
	}
 
	return $hari_ini;
 
}

function tgl_indo_hari_ini(){
  $tanggal = date("Y-m-d", time());
  $bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}

?>

<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl mt-4">
              <div class="row">
                <div class="col-lg-12">
                  <h3 style="text-align:right"><?php echo hari_ini() ?>, <?php echo tgl_indo_hari_ini() ?></h3>
                </div>
              </div>
            </div>

            <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row">
                <div class="col-lg-12">
                  <div class="row">
                    <div class="col-lg-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="<?php echo base_url('assets') ?>/assets/img/icons/unicons/chart-success.png"
                                alt="chart success"
                                class="rounded"
                              />
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">Penjualan</span>
                          <table class="table">
                            <tr>
                              <th>Nominal</th>
                              <th>Berat</th>
                              <th>Banyak</th>
                            </tr>
                            <tr>
                              <td>Rp<?php echo $data_penjualan->Harga ?></td>
                              <td><?php echo $data_penjualan->Berat ?>gr</td>
                              <td><?php echo $data_penjualan->Banyak ?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 mb-4">
                      <div class="card">
                        <div class="card-body">
                          <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                              <img
                                src="<?php echo base_url('assets') ?>/assets/img/icons/unicons/wallet-info.png"
                                alt="Credit Card"
                                class="rounded"
                              />                            
                            </div>
                          </div>
                          <span class="fw-semibold d-block mb-1">Pengembalian</span>
                          <table class="table">
                            <tr>
                              <th>Nominal</th>
                              <th>Berat</th>
                              <th>Banyak</th>
                            </tr>
                            <tr>
                              <td>Rp<?php echo $data_pengembalian->Harga ?></td>
                              <td><?php echo $data_pengembalian->Berat ?>gr</td>
                              <td><?php echo $data_pengembalian->Banyak ?></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-lg-12">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-title d-flex align-items-start justify-content-between">
                        <div class="avatar flex-shrink-0">
                          <img
                            src="<?php echo base_url('assets') ?>/assets/img/icons/unicons/cc-primary.png"
                            alt="chart success"
                            class="rounded"
                          />
                        </div>
                      </div>
                      <span class="fw-semibold d-block mb-1">Big Book</span>
                      <?php if(@$big_book) :  ?>
                        <table class="table">
                          <tr>
                            <th>Kode</th>
                            <th>Open</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Jual</th>
                            <th>Tutup</th>
                            <th>Timbang</th>
                          </tr>
                          <?php foreach($big_book as $p) :  ?>
                            <tr>
                              <td><?php echo $p->nama_rak ?></td>
                              <td><?php echo $p->open ?></td>
                              <td><?php echo $p->masuk ?></td>
                              <td><?php echo $p->keluar ?></td>
                              <td><?php echo $p->jual ?></td>
                              <td><?php echo $p->tutup ?></td>
                              <td><?php echo $p->timbang ?></td>
                            </tr>
                            <tr>
                              <td>Quantity</td>
                              <td><?php echo $p->open_qt ?></td>
                              <td><?php echo $p->masuk_qt ?></td>
                              <td><?php echo $p->keluar_qt ?></td>
                              <td><?php echo $p->jual_qt ?></td>
                              <td><?php echo $p->tutup_qt ?></td>
                              <td><?php echo $p->timbang_qt ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </table>
                      <?php else: ?>
                        <h3 class="text-danger" style="text-align:center">Silahkan buka toko terlebih dahulu</h3>
                      <?php endif; ?>
                    </div>
                    <div class="card-footer">
                      <a onclick="return confirm('Apakah anda yakin ingin membuka toko?')" href="<?php echo base_url("adm/dashboard/buka_toko") ?>"><button type="button" class="btn btn-success" data-bs-dismiss="modal">Buka Toko</button></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
