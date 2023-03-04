<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Dalam Pengembangan</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

              <!-- Bordered Table -->
              <div class="card">
                <!-- <h5 class="card-header">Data Admin</h5> -->
                <div class="card-body">
                  <p>Mohon Maaf, Menu Sedang Dalam Pengembangan! Silahkan kembali lagi nanti! 🙏</p>
                  <a href="<?php echo base_url("adm/dashboard") ?>"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="color:#000">Kembali Ke Menu Utama</button></a>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->