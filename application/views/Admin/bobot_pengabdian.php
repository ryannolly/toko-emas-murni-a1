<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Bobot Pengabdian</h4>
              
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
                            <h5 class="modal-title" id="exampleModalLabel4">Tambah Data Bobot Pengabdian</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('admin/bobot_pengabdian_tambah') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Kode Jenis Bobot</label>
                                    <input type="text" id="nameExLarge" name="KdJenis" class="form-control" placeholder="Masukkan Kode ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Nama Jenis</label>
                                    <input type="text" id="nameExLarge" name="NmJenis" class="form-control" placeholder="Masukkan Nama ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Nilai Bobot</label>
                                    <input type="number" id="nameExLarge" name="Bobot" class="form-control" placeholder="Masukkan Nilai Bobot ..." />
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
                <h5 class="card-header">Data Bobot</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Jenis</th>
                          <th>Nama Jenis</th>
                          <th>Nilai Bobot</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($bobot_pengabdian) > 0) :  ?>
                            <?php $no = 1;foreach($bobot_pengabdian as $bp) :  ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $bp->KdJenis ?></td>
                                    <td><?php echo $bp->NmJenis ?></td>
                                    <td><?php echo $bp->Bobot ?></td>
                                    <td>
                                        <a href="<?php echo base_url("admin/bobot_pengabdian_ubah/".$bp->KdJenis) ?>">
                                            <button type="button" class="btn btn-icon btn-info">
                                                <span class="tf-icons bx bx-edit"></span>
                                            </button>
                                        </a>
                                        <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" href="<?php echo base_url("admin/bobot_pengabdian_hapus/".$bp->KdJenis) ?>">
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