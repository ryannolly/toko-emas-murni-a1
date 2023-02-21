<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Bobot Pengabdian</h4>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Ubah Data</h5>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <form action="<?php echo base_url('admin/bobot_pengabdian_ubah_aksi') ?>" method="POST">
                    <label for="">Kode Jenis Bobot</label>
                    <input type="text" class="form-control" value="<?php echo $detail_data->KdJenis ?>" disabled>
                    <input type="hidden" class="form-control" value="<?php echo $detail_data->KdJenis ?>" name="KdJenisReal">
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Nama Jenis</label>
                    <input type="text" class="form-control" value="<?php echo $detail_data->NmJenis ?>" name="NmJenis">
                  </div>
                  <div class="form-group mb-3">
                    <label for="">Bobot</label>
                    <input type="number" class="form-control" value="<?php echo $detail_data->Bobot ?>" name="Bobot">
                  </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url("admin/bobot_pengabdian") ?>"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button></a>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                    </form>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->