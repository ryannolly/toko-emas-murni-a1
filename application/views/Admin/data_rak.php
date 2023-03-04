<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Data Rak</h4>
              
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
                            <h5 class="modal-title" id="exampleModalLabel4">Tambah Data Rak</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('adm/data_rak/tambah_data_rak') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Nama Rak</label>
                                    <input type="text" id="nameExLarge" name="nama_rak" class="form-control" placeholder="Masukkan Nama Rak" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" id="" cols="30" rows="3" class="form-control"></textarea>
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
                <h5 class="card-header">Data Rak</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000" id="table_ryan">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Rak</th>
                          <th>Keterangan</th>
                          <th>Last Input</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                            <?php $no = 1;foreach($data_rak as $bp) :  ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td class="text-wrap"><?php echo $bp->nama_rak ?></td>
                                    <td class="text-wrap"><?php echo $bp->keterangan ?></td>
                                    <td class="text-wrap"><?php echo $bp->usrid ?></td>
                                    <td>
                                        <a href="<?php echo base_url("adm/data_rak/ubah_data_rak/".$bp->id) ?>">
                                            <button type="button" class="btn btn-icon btn-info">
                                                <span class="tf-icons bx bx-edit"></span>
                                            </button>
                                        </a>
                                        <a onclick="return confirm('Apakash anda yakin ingin menghapus data ini?')" href="<?php echo base_url("adm/data_rak/hapus_data_rak/".$bp->id) ?>">
                                            <button type="button" class="btn btn-icon btn-danger">
                                                <span class="tf-icons bx bx-trash"></span>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->