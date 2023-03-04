<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Data Admin</h4>
              
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
                            <h5 class="modal-title" id="exampleModalLabel4">Tambah Data Admin</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('adm/data_admin/tambah_data_admin') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Username</label>
                                    <input type="text" id="nameExLarge" name="username" class="form-control" placeholder="Masukkan Username .." required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Password</label>
                                    <input type="password" id="nameExLarge" name="password" class="form-control" placeholder="Masukkan Password" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Nama</label>
                                    <input type="text" id="nameExLarge" name="nama" class="form-control" placeholder="Masukkan Nama" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Group Admin</label>
                                    <select name="GroupAdminID" class="form-control" style="color:#000" id="">
                                        <option value="1">Super Admin</option>
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
              <div class="card">
                <h5 class="card-header">Data Admin</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000" id="table_ryan">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Username</th>
                          <th>Nama</th>
                          <th>GroupAdminID</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                            <?php $no = 1;foreach($data_user as $bp) :  ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $bp->username ?></td>
                                    <td><?php echo $bp->nama ?></td>
                                    <td><?php echo $bp->GroupAdminID ?></td>
                                    <td>
                                        <a href="<?php echo base_url("adm/data_admin/ubah_data_admin/".$bp->id) ?>">
                                            <button type="button" class="btn btn-icon btn-info">
                                                <span class="tf-icons bx bx-edit"></span>
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