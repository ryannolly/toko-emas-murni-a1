<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Data Barang</h4>
              
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
                            <h5 class="modal-title" id="exampleModalLabel4">Tambah Data Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('adm/data_barang/tambah_data_barang') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Nama Barang</label>
                                    <input type="text" id="nameExLarge" name="nama_barang" class="form-control" placeholder="Masukkan Nama Barang" required />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Kadar</label>
                                    <select name="id_kadar" class="form-control" style="color:#000" id="" required>
                                        <?php foreach($data_kadar as $kadar) :  ?>
                                            <option value="<?php echo $kadar->id ?>"><?php echo $kadar->nama_kadar ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Rak</label>
                                    <select name="id_rak" class="form-control" style="color:#000" id="" required>
                                        <?php foreach($data_rak as $rak) :  ?>
                                            <option value="<?php echo $rak->id ?>"><?php echo $rak->nama_rak ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Keterangan</label>
                                    <textarea name="keterangan" id="" cols="30" rows="3" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="">Stok</label>
                                    <input type="number" class="form-control" name="stok" value="1" required> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="">Berat Jual (gram) <span style="color:#F00">(Gunakan tanda titik "." untuk decimal)</span></label>
                                    <input type="text" class="form-control" name="berat_jual" required> 
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
                <h5 class="card-header">Data Barang</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000" id="table_ryan">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Nama Barang</th>
                          <th>Rak</th>
                          <th>Kadar</th>
                          <th>Stok</th>
                          <th>Last Changed</th>
                          <th>Aksi</th>
                        </tr>
                      </thead>
                      <tbody>
                            <?php $no = 1;foreach($data_barang as $bp) :  ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $bp->nama_barang ?></td>
                                    <td><?php echo $bp->nama_rak ?></td>
                                    <td><?php echo $bp->nama_kadar ?></td>
                                    <td><?php echo $bp->stok ?></td>
                                    <td><?php echo $bp->usrid ?></td>
                                    <td>
                                        <a href="<?php echo base_url("adm/data_barang/ubah_data_barang/".$bp->Id) ?>">
                                            <button type="button" class="btn btn-icon btn-info">
                                                <span class="tf-icons bx bx-edit"></span>
                                            </button>
                                        </a>
                                        <a onclick="return confirm('Apakash anda yakin ingin menghapus data ini?')" href="<?php echo base_url("adm/data_barang/hapus_data_barang/".$bp->Id) ?>">
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