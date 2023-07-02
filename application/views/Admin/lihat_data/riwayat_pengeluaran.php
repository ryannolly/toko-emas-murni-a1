<?php

function format_ip($number, $decimals = 0, $decPoint = '.' , $thousandsSep = ','){
    $negation = ($number < 0) ? (-1) : 1;
    $coefficient = 10 ** $decimals;
    $number = $negation * floor((string)(abs($number) * $coefficient)) / $coefficient;
    return number_format($number, $decimals, $decPoint, $thousandsSep);
}

?>
<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Detail Riwayat Pengeluaran</h4>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Riwayat</h5>
                <div class="card-body">
                  <div class="form-group mb-3">
                        <table class="table">
                            <tr>
                                <th class="text-wrap">Kode Pengeluaran</th>
                                <td class="text-wrap"><?php echo $pengeluaran->KdPengeluaran ?></td>
                            </tr>
                            <tr>
                                <th class="text-wrap">Tanggal Pengeluaran</th>
                                <td class="text-wrap"><?php echo date("D, Y-m-d H:i:s", $pengeluaran->TglProses) ?></td>
                            </tr>
                        </table>
                  </div>
                  <div class="form-group mb-3">
                        <table class="table">
                            <tr>
                                <th>Nama Barang/Nama Kadar/Nama Rak</th>
                                <th>Kategori</th>
                                <th>Berat Asli</th>
                            </tr>
                            <?php foreach($detail_pengeluaran as $p) :  ?>
                                <tr>
                                    <td class="text-wrap"><?php echo $p->nama_barang."/".$p->nama_kadar."/".$p->nama_rak ?></td>
                                    <td class="text-wrap"><?php echo $p->Kategori ?></td>
                                    <td class="text-wrap"><?php echo format_ip($p->berat_asli, 2, ".", "") ?>gr</td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                  </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url("adm/riwayat_pengeluaran") ?>"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kembali</button></a>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->