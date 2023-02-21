<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Konfigurasi Umum</h4>
              
              <div class="row mb-3">
                <div class="col-lg-3">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exLargeModal">➕ Tambah Data</button>
                </div>
              </div>

              <?php echo $this->session->flashdata("pesan"); ?>

              <!-- Extra Large Modal -->
              <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Tambah Data Konfigurasi</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('admin/konfigurasi_umum_tambah') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Kode Konfigurasi</label>
                                    <input type="text" id="nameExLarge" name="KdKonfigurasi" class="form-control" placeholder="Masukkan Kode ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Nama Konfigurasi</label>
                                    <input type="text" id="nameExLarge" name="NmKonfigurasi" class="form-control" placeholder="Masukkan Nama ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Isi Konfigurasis</label>
                                    <input type="text" id="nameExLarge" name="IsiKonfigurasi" class="form-control" placeholder="Masukkan Isi ..." />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                            </button>
                            <input type="submit" class="btn btn-primary" value="Simpan">
                        </div>
                        </form>
                    </div>
                </div>
              </div>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Data Konfigurasi</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Konfigurasi</th>
                          <th>Nama Konfigurasi</th>
                          <th>Isi Konfigurasi</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($ms_konfigurasi) > 0) :  ?>
                            <?php $no = 1;foreach($ms_konfigurasi as $bp) :  ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $bp->KdKonfigurasi ?></td>
                                    <td><?php echo $bp->NmKonfigurasi ?></td>
                                    <td><?php echo $bp->IsiKonfigurasi ?></td>
                                    <td>
                                        <a href="<?php echo base_url("admin/bobot_penelitian_ubah/".$bp->Id) ?>">
                                            <button type="button" class="btn btn-icon btn-info">
                                                <span class="tf-icons bx bx-edit"></span>
                                            </button>
                                        </a>
                                        <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" href="<?php echo base_url("admin/bobot_penelitian_hapus/".$bp->Id) ?>">
                                            <button type="button" class="btn btn-icon btn-danger">
                                                <span class="tf-icons bx bx-trash"></span>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="5">Tidak Ada Data</td>
                            </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->