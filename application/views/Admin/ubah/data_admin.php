<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Data Admin</h4>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Ubah Data Admin</h5>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <form action="<?php echo base_url('adm/data_admin/ubah_data_admin_aksi') ?>" method="POST">
                    <input type="hidden" class="form-control" value="<?php echo $detail_data->id ?>" name="id_real">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameExLarge" class="form-label">Username</label>
                                <input type="text" id="nameExLarge" name="username" class="form-control" placeholder="Masukkan Username .." value="<?php echo $detail_data->username ?>" readonly/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameExLarge" class="form-label">Password <span class="text-danger">(Kosongkan Jika Tidak Ingin Mengganti Password)</span></label>
                                <input type="password" id="nameExLarge" name="password" class="form-control" placeholder="Masukkan Password" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameExLarge" class="form-label">Nama</label>
                                <input type="text" id="nameExLarge" name="nama" class="form-control" placeholder="Masukkan Nama" value="<?php echo $detail_data->nama ?>" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameExLarge" class="form-label">Group Admin</label>
                                <select name="GroupAdminID" class="form-control" style="color:#000" id="">
                                    <option value="1" <?php echo ($detail_data->GroupAdminID == "1") ? "selected" : "" ?>>Super Admin</option>
                                </select>
                            </div>
                        </div>
                  </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url("adm/data_admin") ?>"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button></a>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                    </form>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->