<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Data Barang</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Ubah Data Barang</h5>
                <div class="card-body">
                  <div class="form-group mb-3">
                    <form action="<?php echo base_url('adm/data_barang/ubah_data_barang_aksi') ?>" method="POST" enctype="multipart/form-data">
                    <input type="hidden" class="form-control" value="<?php echo $detail_data->Id ?>" name="id_real">
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameExLarge" class="form-label">Nama Barang</label>
                                <input type="text" id="nameExLarge" name="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" value="<?php echo $detail_data->nama_barang ?>" required />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameExLarge" class="form-label">Kadar</label>
                                <select name="id_kadar" class="form-control" style="color:#000" id="" required>
                                    <?php foreach($data_kadar as $kadar) :  ?>
                                        <option value="<?php echo $kadar->id ?>" <?php echo ($detail_data->id_kadar == $kadar->id) ? "selected" : "" ?>><?php echo $kadar->nama_kadar ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="nameExLarge" class="form-label">Rak</label>
                                <select name="id_rak" class="form-control" style="color:#000" id="" required>
                                    <?php foreach($data_rak as $rak) :  ?>
                                        <option value="<?php echo $rak->id ?>" <?php echo ($detail_data->id_rak == $rak->id) ? "selected" : "" ?>><?php echo $rak->nama_rak ?></option>
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
                        <div class="row">
                            <div class="col mb-3">
                                <label for="">Stok</label>
                                <input type="number" class="form-control" name="stok" value="<?php echo $detail_data->stok ?>" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="">Berat Jual (gram) <span style="color:#F00">(Gunakan tanda titik "." untuk decimal)</span></label>
                                <input type="text" class="form-control" name="berat_jual" value="<?php echo $detail_data->berat_jual ?>" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="">Tanggal Masuk Barang</span></label>
                                <input type="text" class="form-control" name="tgl_input_real" value="<?php echo $detail_data->tgl_input_real ?>" required> 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="">Foto <span style="color:#F00">(Kosongkan jika tidak ingin diganti)</span></label>
                                <input type="hidden" name="fail_foto_lama" value="<?php echo $detail_data->foto ?>">
                                <input type="file" class="form-control mb-2" name="foto" > 
                                <img width="200px" src="<?php echo base_url('uploads/foto_emas/').$detail_data->foto ?>" alt="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="">Password Transaksi</label>
                                <input type="password" class="form-control" name="PasswordTransaksi" required>
                            </div>
                        </div>
                  </div>
                </div>
                <div class="card-footer">
                    <a href="<?php echo base_url("adm/data_barang") ?>"><button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button></a>
                    <input type="submit" class="btn btn-primary" value="Simpan">
                    </form>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->