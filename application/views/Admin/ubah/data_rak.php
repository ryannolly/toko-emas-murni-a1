<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Data Rak</h4>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Ubah Data Rak</h5>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <form action="<?php echo base_url('adm/data_rak/ubah_data_rak_aksi') ?>" method="POST">
                    <input type="hidden" class="form-control" value="<?php echo $detail_data->id ?>" name="id_real">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Nama Rak</label>
                            <input type="text" id="nameExLarge" name="nama_rak" class="form-control" value="<?php echo $detail_data->nama_rak ?>" placeholder="Masukkan Nama Rak" />
                        </div>
                    </div>
                    <div class="row">
                                <div class="col mb-3">
                                    <label for="">Default Kadar</label>
                                    <select name="default_kadar" id="" class="form-control">
                                        <?php foreach($data_kadar as $d) :  ?>
                                            <option value="<?php echo $d->id ?>" <?php echo ($d->id == $detail_data->id_kadar) ? "selected" : "" ?>><?php echo $d->nama_kadar ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                    <div class="row">
                        <div class="col mb-3">
                            <label for="nameExLarge" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="" cols="30" rows="3" class="form-control"><?php echo $detail_data->keterangan ?></textarea>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url("adm/data_rak") ?>"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button></a>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                    </form>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->