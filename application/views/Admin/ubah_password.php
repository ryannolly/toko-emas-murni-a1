<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Riwayat Big Book</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

              <!-- Filter Data -->
              <div class="card mb-3">
                <h5 class="card-header">Silahkan pilih tanggal yang ingin dicetak</h5>
                <div class="card-body">
                  <div class="form-group">
                    <form action="<?php echo base_url("adm/ubah_password/proses") ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Masukkan Password Baru</label>
                            <input type="text" class="form-control" style="color:#000" name="password">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-info" value="Ubah">
                    </form>
                </div>
              </div>
              <!--/ Bordered Table -->

              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->
<script src="<?php echo base_url('assets') ?>/assets/vendor/libs/jquery/jquery.js"></script>