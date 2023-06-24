<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Riwayat Penghapusan Barang</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

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
                    <div class="row mt-2">
                        <div class="col-lg-6">
                            <label for="">Rentang Tanggal Awal</label>
                            <input type="date" id="filter_tanggal_awal" class="form-control filter" style="color:#000">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Rentang Tanggal Akhir</label>
                            <input type="date" id="filter_tanggal_akhir" class="form-control filter" style="color:#000">
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
                          <th>Kode Barang</th>
                          <th>Nama Barang</th>
                          <th>Rak</th>
                          <th>Kadar</th>
                          <th>Stok</th>
                          <th>Berat Jual (gr)</th>
                          <th>Tanggal Hapus</th>
                          <th>Alasan</th>
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
$(document).ready(function() {
    $('#table_ryan_2').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url" : "<?=site_url('adm/riwayat_penghapusan/get_ajax') ?>",
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
        var Rak             = $('#filter_rak').val();
        var Kadar           = $("#filter_kadar").val();
        var tanggal_awal    = $('#filter_tanggal_awal').val();
        var tanggal_akhir   = $('#filter_tanggal_akhir').val();

    
        $('#table_ryan_2').DataTable().clear().destroy();

        $('#table_ryan_2').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url"   : "<?=site_url('adm/riwayat_penghapusan/get_ajax') ?>",
            "type"  : "POST",
            "data"  : {
                'id_rak'        : Rak,
                'id_kadar'      : Kadar,
                'tanggal_awal'  : tanggal_awal,
                'tanggal_akhir' : tanggal_akhir
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