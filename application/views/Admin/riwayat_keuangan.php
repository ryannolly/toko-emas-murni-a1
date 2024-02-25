<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Riwayat Keuangan</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

              <!-- Filter Data -->
              <div class="card mb-3">
                <h5 class="card-header">Silahkan pilih tanggal yang ingin dilihat</h5>
                <div class="card-body">
                  <div class="form-group">
                    <form action="<?php echo base_url("adm/riwayat_keuangan/ganti_tanggal") ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-12">
                            <label for="">Tanggal Riwayat Keuangan</label>
                            <input type="date" class="form-control" style="color:#000" name="tgl_big_book" value="<?php echo $tanggal ?>">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-info" value="Ganti Tanggal">
                    </form>
                </div>
              </div>
              <!--/ Bordered Table -->

              <!-- Filter Data -->
              <div class="card mb-3">
                <h5 class="card-header">Opening & Closing Stock</h5>
                <div class="card-body">
                  <div class="form-group">
                    <form action="<?php echo base_url("adm/riwayat_keuangan/opening_closing_proses/" . $tanggal) ?>" method="POST">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Uang Stock/Opening <span class="text-danger">(Defaultnya adalah sisa uang hari sebelumnya)</span></label>
                            <input type="number" class="form-control" style="color:#000" name="uang_stock" value="<?php echo $detail_opening->uang_stok ?>">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Closing Stock</label>
                            <input type="number" class="form-control" style="color:#000" name="closing_stock" value="<?php echo $detail_opening->closing_stok ?>">
                        </div>
                    </div>
                  </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-info" value="Simpan">
                    <a href="<?php echo base_url("adm/riwayat_keuangan/cetak_riwayat_keuangan/" . $tanggal) ?>" class="btn btn-primary">Cetak</a>
                    </form>
                </div>
              </div>

              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->
<script src="<?php echo base_url('assets') ?>/assets/vendor/libs/jquery/jquery.js"></script>

<script>
    $(document).on("click", ".hapus_data", function(){
        return confirm("Apakah anda yakin ingin membatalkan penghapusan barang ini? Barang akan kembali ke data barang aktif");
    })
</script>

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
              "targets" : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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
              "targets" : [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
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