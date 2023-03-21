<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Data Barang</h4>
              
              <div class="row mb-3">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#exLargeModal">➕ Tambah Data</button>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cetakQR">Cetak QR</button>
                </div>
                <div class="col-lg-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cekBarang">Cek Barang</button>
                </div>
              </div>

              <?php echo $this->session->flashdata("pesan"); ?>

              <!-- Extra Large Modal -->
              <div class="modal fade" id="cetakQR" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Cetak QR</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('adm/data_barang/cetak_qr_banyak') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Nama Rak</label>
                                    <select name="id_rak" id="" class="form-control" style="color:#000">
                                        <?php foreach($data_rak as $rak) :  ?>
                                            <option value="<?php echo $rak->id ?>"><?php echo $rak->nama_rak ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Tanggal Barang Masuk</label>
                                    <input type="date" class="form-control" name="tgl_input_real">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                            </button>
                            <input type="submit" class="btn btn-primary" value="Cetak">
                        </div>
                        </form>
                    </div>
                </div>
              </div>

              <!-- Extra Large Modal -->
              <div class="modal fade" id="cekBarang" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Cek Barang Dengan QR</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row form-group mb-3">
                                <div class="col mb-3">
                                    <input type="text" id="QR_UUID" class="form-control" placeholder="Tekan textbox ini, kemudian scan dengan scanner">
                                </div>
                            </div>
                            <div class="row form-group mb-3" id="tempat_detail">
                                
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                            </button>
                        </div>
                    </div>
                </div>
              </div>

              <!-- Extra Large Modal -->
              <div class="modal fade" id="exLargeModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Tambah Data Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('adm/data_barang/tambah_data_barang') ?>" method="post" enctype="multipart/form-data">
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
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="">Tanggal Masuk Barang</label>
                                    <input type="date" class="form-control" name="tgl_input_real" required> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="">Foto (Maksimum Fail 10MB)</label>
                                    <input type="file" class="form-control" name="foto" required>
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

              <!-- Filter Data -->
              <div class="card mb-3">
                <h5 class="card-header">Filter Data</h5>
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <select name="" id="filter_kadar" class="form-control filter">
                                <option value="">SEMUA KADAR</option>
                                <?php foreach($data_kadar as $d) :  ?>
                                    <option value="<?php echo $d->id ?>"><?php echo $d->nama_kadar ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <select name="" id="filter_rak" class="form-control filter">
                                <option value="">SEMUA RAK</option>
                                <?php foreach($data_rak as $d) :  ?>
                                    <option value="<?php echo $d->id ?>"><?php echo $d->nama_rak ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Bordered Table -->

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Data Barang</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000" id="table_ryan_2">
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
                            
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->
<script src="<?php echo base_url('assets') ?>/assets/vendor/libs/jquery/jquery.js"></script>

<script>
    $(document).on("click", ".hapus_data", function(){
        return confirm("Apakah anda yakin ingin menghapus barang ini?");
    })
</script>

<script>
$(document).ready(function() {
    $('#table_ryan_2').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url" : "<?=site_url('adm/data_barang/get_ajax') ?>",
            "type": "POST"
        },
        "columnDefs" : [{
              "targets" : [0, 1, 2, 3, 4, 5, 6],
              "orderable" : false
          },
          {
              "targets" : [1, 2, 3],
              "className" : "text-wrap"
          },
          {
            "width" : "5%",
            "targets" : 0    
          },
          {
            "width" : "15%",
            "targets" : [1, 2, 3]
          }
        ]
    } );
} );
</script>

<script>
    $(".filter").change(function(){
        var Rak     = $('#filter_rak').val();
        var Kadar   = $("#filter_kadar").val();

        $('#table_ryan_2').DataTable().clear().destroy();

        $('#table_ryan_2').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url"   : "<?=site_url('adm/data_barang/get_ajax') ?>",
            "type"  : "POST",
            "data"  : {
                'id_rak'    : Rak,
                'id_kadar'  : Kadar
            }
        },
        "columnDefs" : [{
              "targets" : [0, 1, 2, 3, 4, 5, 6],
              "orderable" : false
          },
          {
              "targets" : [1, 2, 3],
              "className" : "text-wrap"
          },
          {
            "width" : "5%",
            "targets" : 0    
          },
          {
            "width" : "15%",
            "targets" : [1, 2, 3]
          }
        ]
    } );
    })
</script>

<script>
    $('#QR_UUID').on("keypress", function(e) {
            if (e.keyCode == 13) {
                var uuid = $("#QR_UUID").val();
                $("#QR_UUID").val("");
                
                
                $.ajax({
                    type : "POST",
                    url : "<?= site_url('adm/data_barang/ajax_post_and_get') ?>",
                    data : {
                        "uuid" : uuid
                    },
                    success : function(response){
                        var jawaban = JSON.parse(response);
                        console.log(jawaban);
                        var html = "";
                        html    += '<table class="table"><tr><th>Nama Barang</th><td>'+ jawaban.data.nama_barang +'</td></tr>';
                        html    += '<tr><th>Rak/Kadar</th><td>' + jawaban.data.nama_rak + '/'+ jawaban.data.nama_kadar +'</td></tr>';
                        html    += '<tr><th>Berat</th><td>'+ jawaban.data.berat_jual +'g</td></tr>';
                        html    += '<tr><th>Foto</th>'
                                        
                        html    +=  '<td><img width="200px" src="' + jawaban.data.foto_url + '" alt=""></td></tr></table>';
                        $('#tempat_detail').html(html);
                    },fail : function(){
                        alert("Koneksi Gagal! Silahkan untuk merefresh halaman berikut");
                    },
                    error : function(statusCode, errorThrown){
                        if(statusCode.status == 0){
                            alert("Koneksi Anda Terputus!");
                        }
                    },
                    complete : function(){
                        // $("#kode-ruang-section").show();
                        // $('#gambar-loading-2').hide();
                    }
                })
            }
    });
</script>