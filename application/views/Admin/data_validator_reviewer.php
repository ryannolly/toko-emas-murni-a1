<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Data Validator & Reviewer</h4>
              
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
                            <h5 class="modal-title" id="exampleModalLabel4">Tambah Data Validator & Reviewer</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('admin/data_validator_reviewer_tambah') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Email/Username</label>
                                    <input type="text" id="nameExLarge" name="email" class="form-control" placeholder="Masukkan Email/Username ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Password</label>
                                    <input type="password" id="nameExLarge" name="password" class="form-control" placeholder="Masukkan Password ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Nama Validator/Reviewer</label>
                                    <input type="text" id="nameExLarge" name="nama_admin" class="form-control" placeholder="Masukkan Nama ..." />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="">Simpan Sebagai : </label>
                                    <select name="SaveTo" class='form-control' style="color:#000" id="">
                                        <option value="Reviewer">Reviewer</option>
                                        <option value="Validator">Validator</option>
                                    </select>
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
              <div class="card mb-3">
                <h5 class="card-header">Data Validator</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Email/Username</th>
                          <th>Nama Validator</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($ms_validator) > 0) :  ?>
                            <?php $no = 1;foreach($ms_validator as $bp) :  ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $bp->email ?></td>
                                    <td><?php echo $bp->nama_admin ?></td>
                                    <td>
                                        <a href="<?php echo base_url("admin/data_validator_ubah/".$bp->id) ?>">
                                            <button type="button" class="btn btn-icon btn-info">
                                                <span class="tf-icons bx bx-edit"></span>
                                            </button>
                                        </a>
                                        <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" href="<?php echo base_url("admin/data_validator_hapus/".$bp->id) ?>">
                                            <button type="button" class="btn btn-icon btn-danger">
                                                <span class="tf-icons bx bx-trash"></span>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4">Tidak Ada Data</td>
                            </tr>
                        <?php endif; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--/ Bordered Table -->

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Data Reviewer</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Email/Username</th>
                          <th>Nama Reviewer</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(count($ms_reviewer) > 0) :  ?>
                            <?php $no = 1;foreach($ms_reviewer as $bp) :  ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $bp->email ?></td>
                                    <td><?php echo $bp->nama_admin ?></td>
                                    <td>
                                        <a href="<?php echo base_url("admin/data_validator_ubah/".$bp->id) ?>">
                                            <button type="button" class="btn btn-icon btn-info">
                                                <span class="tf-icons bx bx-edit"></span>
                                            </button>
                                        </a>
                                        <a onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')" href="<?php echo base_url("admin/data_validator_hapus/".$bp->id) ?>">
                                            <button type="button" class="btn btn-icon btn-danger">
                                                <span class="tf-icons bx bx-trash"></span>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="4">Tidak Ada Data</td>
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