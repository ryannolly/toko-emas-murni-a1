<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Detail Riwayat Penjualan</h4>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Riwayat</h5>
                <div class="card-body">
                  <div class="form-group mb-3">
                        <table class="table">
                            <tr>
                                <th class="text-wrap">Kode Penjualan</th>
                                <td class="text-wrap"><?php echo $penjualan->KdPenjualan ?></td>
                            </tr>
                            <tr>
                                <th class="text-wrap">Tanggal Penjualan</th>
                                <td class="text-wrap"><?php echo date("D, Y-m-d H:i:s", $penjualan->TglProses) ?></td>
                            </tr>
                        </table>
                  </div>
                  <div class="form-group mb-3">
                        <table class="table">
                            <tr>
                                <th>Nama Barang/Nama Kadar/Nama Rak</th>
                                <th>Berat Jual/Berat Asli</th>
                                <th>Harga</th>
                            </tr>
                            <?php foreach($detail_penjualan as $p) :  ?>
                                <tr>
                                    <td class="text-wrap"><?php echo $p->nama_barang."/".$p->nama_kadar."/".$p->nama_rak ?></td>
                                    <td class="text-wrap"><?php echo $p->berat_jual ?>gr/<?php echo $p->berat_asli ?>gr</td>
                                    <td class="text-wrap"><?php echo "Rp".$p->nilai_barang ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                  </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url("adm/riwayat_penjualan") ?>"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kembali</button></a>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->