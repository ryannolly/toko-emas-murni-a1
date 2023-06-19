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

function format_ip($number, $decimals = 0, $decPoint = '.' , $thousandsSep = ','){
  $negation = ($number < 0) ? (-1) : 1;
  $coefficient = 10 ** $decimals;
  $number = $negation * floor((string)(abs($number) * $coefficient)) / $coefficient;
  return number_format($number, $decimals, $decPoint, $thousandsSep);
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

              <!-- Extra Large Modal -->
              <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Detail Penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                          <h3>Per Rak</h3>
                          <table class="table">
                            <tr>
                              <th>Nama Rak</th>
                              <th>Harga</th>
                            </tr>
                            <?php if(count($detail_data_penjualan_rak) > 0) : ?>
                              <?php foreach($detail_data_penjualan_rak as $d) : ?>
                                <tr>
                                  <td><?php $d->Nama ?></td>
                                  <td><?php $d->Harga ?></td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else : ?>
                              <tr>
                                <td colspan = '2' style="text-align:center">Tidak ada data</td>
                              </tr>
                            <?php endif; ?>
                          </table>
                          <br>
                          <h3>Per Kadar</h3>
                          <table class="table">
                            <tr>
                              <th>Nama Kadar</th>
                              <th>Harga</th>
                            </tr>
                            <?php if(count($detail_data_penjualan_kadar) > 0) : ?>
                              <?php foreach($detail_data_penjualan_kadar as $d) : ?>
                                <tr>
                                  <td><?php $d->Nama ?></td>
                                  <td><?php $d->Harga ?></td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else : ?>
                              <tr>
                                <td colspan="2" style="text-align:center">Tidak ada data</td>
                              </tr>
                            <?php endif; ?>
                          </table>
                        </div>
                    </div>
                </div>
              </div>

              <!-- Extra Large Modal -->
              <div class="modal fade" id="exLargeModalPengembalian" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Detail Pengembalian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <h3>Per Kadar</h3>
                          <table class="table">
                            <tr>
                              <th>Nama Kadar</th>
                              <th>Harga</th>
                            </tr>
                            <?php if(count($detail_data_pengembalian_kadar) <= 0) :  ?>
                            <tr>
                              <td colspan="2" style="text-align:center">Tidak ada data</td>
                            </tr>
                            <?php else : ?>
                              <?php foreach($detail_data_pengembalian_kadar as $d) : ?>
                                <tr>
                                  <td><?php $d->Nama ?></td>
                                  <td><?php $d->Harga ?></td>
                                </tr>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          </table>
                        </div>
                    </div>
                </div>
              </div>

            <div class="container-xxl flex-grow-1 container-p-y">

              <?php echo $this->session->flashdata("pesan"); ?>


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
                              <td>Rp<?php echo number_format($data_penjualan->Harga, 2, ".", ",") ?></td>
                              <td><?php echo number_format($data_penjualan->Berat, 2, ".", "") ?>gr</td>
                              <td><?php echo $data_penjualan->Banyak ?></td>
                            </tr>
                          </table>
                          <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#exLargeModal">Lihat Detail</button>
                        </div>
                        <!-- <div class="card-footer">
                          
                        </div> -->
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
                              <td>Rp<?php echo number_format($data_pengembalian->Harga, 2, ".", ",") ?></td>
                              <td><?php echo number_format($data_pengembalian->Berat, 2, ".", ",") ?>gr</td>
                              <td><?php echo $data_pengembalian->Banyak ?></td>
                            </tr>
                          </table>
                          <button type="button" class="btn btn-outline-primary mt-2" data-bs-toggle="modal" data-bs-target="#exLargeModalPengembalian">Lihat Detail</button>
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
                        <table class="table table-striped">
                          <tr>
                            <th style="text-align:center">Kode</th>
                            <th>Open</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Jual</th>
                            <th>Tutup</th>
                            <th width="10%">Timbang</th>
                            <th width="10%">Selisih</th>
                          </tr>
                          <form action="<?php echo base_url('adm/dashboard/refresh_big_book/'.$big_book[0]->KdBukuBesar ) ?>" method="post">
                          <?php foreach($big_book as $p) :  ?>
                            <tr>
                              <td style="text-align:center"><b><?php echo $p->nama_rak ?></b></td>
                              <td><?php echo $p->open ?></td>
                              <td><?php echo $p->masuk ?></td>
                              <td><?php echo $p->keluar ?></td>
                              <td><?php echo $p->jual ?></td>
                              <td><?php echo $p->tutup ?></td>
                              <td><input name="timbang[]" type="text" class="form-control" value="<?php echo $p->timbang ?>"></td>
                              <td><?php echo format_ip($p->tutup - $p->timbang, 2, ".", ""); ?></td>
                            </tr>
                            <tr>
                              <td style="text-align:center">Quantity</td>
                              <td><?php echo $p->open_qt ?></td>
                              <td><?php echo $p->masuk_qt ?></td>
                              <td><?php echo $p->keluar_qt ?></td>
                              <td><?php echo $p->jual_qt ?></td>
                              <td><?php echo $p->tutup_qt ?></td>
                              <td><input name="timbang_qt[]" type="text" class="form-control" value="<?php echo $p->timbang_qt ?>"></td>
                              <td><?php echo $p->tutup_qt - $p->timbang_qt ?></td>
                            </tr>
                          <?php endforeach; ?>
                        </table>
                      <?php else: ?>
                        <h3 class="text-danger" style="text-align:center">Silahkan buka toko terlebih dahulu</h3>
                      <?php endif; ?>
                    </div>
                    <div class="card-footer">
                      <?php if(@!$big_book) :  ?>
                        <a onclick="return confirm('Apakah anda yakin ingin membuka toko?')" href="<?php echo base_url("adm/dashboard/buka_toko") ?>"><button type="button" class="btn btn-success" data-bs-dismiss="modal">Buka Toko</button></a>
                      <?php else :  ?>
                          <a target="_blank" href="<?php echo base_url("adm/dashboard/print_big_book") ?>"><button type="button" class="btn btn-success" data-bs-dismiss="modal">Print</button></a>
                          <input type="submit" class="btn btn-info" data-bs-dismiss="modal" value="Refresh Data">
                        </form>
                      <?php endif; ?>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- / Content -->
