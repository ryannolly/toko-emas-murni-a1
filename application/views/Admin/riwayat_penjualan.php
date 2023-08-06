<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Riwayat Penjualan</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

              <?php if($this->session->userdata("GroupAdminID") == "2") :  ?>
              <div class="row mb-3">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cetakQR">Cetak Penjualan</button>
                </div>
              </div>
              <?php endif;  ?>

              <!-- Extra Large Modal -->
              <div class="modal fade" id="cetakQR" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Cetak Penjualan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('adm/riwayat_penjualan/cetak_penjualan') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Tanggal</label>
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

              <!-- Filter Data -->
              <div class="card mb-3">
                <h5 class="card-header">Filter Data</h5>
                <div class="card-body">
                  <div class="form-group">
                    <div class="row">
                        <div class="col-lg-6">
                            <label for="">Tanggal Mulai</label>
                            <input type="date" class="form-control filter" id="filter_tanggal_mulai">
                        </div>
                        <div class="col-lg-6">
                            <label for="">Tanggal Berakhir</label>
                            <input type="date" class="form-control filter" id="filter_tanggal_berakhir">
                        </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Bordered Table -->

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Riwayat</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000" id="table_ryan_2">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Kode Penjualan/ Invoice</th>
                          <th>Tanggal Proses</th>
                          <th>User</th>
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
            "url" : "<?=site_url('adm/riwayat_penjualan/get_ajax') ?>",
            "type": "POST"
        },
        "columnDefs" : [{
              "targets" : [0, 1, 2, 3],
              "orderable" : false
          },
          {
              "targets" : [1, 2],
              "className" : "text-wrap"
          },
          {
            "width" : "5%",
            "targets" : 0    
          }
        ]
    } );
} );
</script>

<script>
    $(".filter").change(function(){
        var TanggalMulai     = $('#filter_tanggal_mulai').val();
        var TanggalBerakhir  = $("#filter_tanggal_berakhir").val();

        $('#table_ryan_2').DataTable().clear().destroy();

        $('#table_ryan_2').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url"   : "<?=site_url('adm/riwayat_penjualan/get_ajax') ?>",
            "type"  : "POST",
            "data"  : {
                'tanggal_mulai'    : TanggalMulai,
                'tanggal_berakhir' : TanggalBerakhir
            }
        },
        "columnDefs" : [{
              "targets" : [0, 1, 2, 3],
              "orderable" : false
          },
          {
              "targets" : [1, 2],
              "className" : "text-wrap"
          },
          {
            "width" : "5%",
            "targets" : 0    
          }
        ]
    } );
    })
</script>