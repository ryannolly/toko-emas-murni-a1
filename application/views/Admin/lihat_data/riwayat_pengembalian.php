<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Detail Riwayat Pengembalian</h4>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Riwayat</h5>
                <div class="card-body">
                  <div class="form-group mb-3">
                        <table class="table">
                            <tr>
                                <th class="text-wrap">Kode Penjualan</th>
                                <td class="text-wrap"><?php echo $pengembalian->KdPengembalian ?></td>
                            </tr>
                            <tr>
                                <th class="text-wrap">Tanggal Penjualan</th>
                                <td class="text-wrap"><?php echo date("D, Y-m-d H:i:s", $pengembalian->TglProses) ?></td>
                            </tr>
                        </table>
                  </div>
                  <div class="form-group mb-3">
                        <table class="table">
                            <tr>
                                <th>Nama Barang/Kadar/Rak</th>
                                <th>Terima/Lebur</th>
                                <th>Uang</th>
                            </tr>
                            <?php foreach($detail_pengembalian as $p) :  ?>
                                <tr>
                                    <?php if(!empty($p->nama_barang)) : ?>
                                        <td class="text-wrap"><?php echo $p->nama_barang."/".$p->nama_kadar."/".$p->nama_rak ?></td>
                                        <td><?php echo $p->Kategori ?></td>
                                        <td class="text-wrap"><?php echo "Rp".$p->uang ?></td>
                                    <?php else: ?>
                                        <td class="text-wrap"><?php echo $p->id_barang."/".$p->nama_kadar."/".$p->nama_rak ?></td>
                                        <td><?php echo $p->Kategori ?></td>
                                        <td class="text-wrap"><?php echo "Rp".$p->uang ?></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                  </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url("adm/riwayat_pengembalian") ?>"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Kembali</button></a>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->