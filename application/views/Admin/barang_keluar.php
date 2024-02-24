<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Barang Keluar</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

              <!-- Extra Large Modal -->
              <div class="modal fade" id="cetakQR" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Proses Pengeluaran Tanpa Barcode</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('adm/barang_keluar/pengeluaran_tanpa_barang_proses') ?>" method="post">
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="">Nama Rak</label>
                                    <select name="id_rak" class="form-control" id="pilihan_rak">
                                        <?php foreach($data_rak as $d) :  ?>
                                            <option value="<?php echo $d->id ?>"><?php echo $d->nama_rak ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="">Nama Barang (Pilihan mengikuti rak)</label>
                                    <select name="id_barang" class="form-control" id="pilihan_barang">
                                        <option value="">-- Silahkan Pilih Barang Terlebih Dahulu! --</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="form-group col-lg-12">
                                    <label for="">Berat yang ingin dikeluarkan (Gram)</label>
                                    <input type="text" class="form-control" name="berat_keluar">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                            </button>
                            <input type="submit" class="btn btn-primary" value="Proses">
                        </div>
                        </form>
                    </div>
                </div>
              </div>

              <div class="row mb-3">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cetakQR">Pengeluaran Tanpa Barcode</button>
                </div>
              </div>

              <div class="modal fade" id="penjualanKasir" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Proses Pengeluaran Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <h5 class="text-danger">Harap masukkan angka saja pada kolom harga!</h5>
                        <form action="<?php echo base_url('adm/barang_keluar/proses_barang_keluar') ?>" method="post">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="border:3px" id="tempat_jual">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Rak/Kadar/Berat</th>
                                        <th>Kategori</th>
                                    </tr>
                                    
                                </table>
                            </div>

                            <h3 style="text-align:right" id="Label_Harga">Total Belanja: Rp0</h3>
                        </div>
                        <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                Close
                                </button>
                                <input type="submit" class="btn btn-success" value="Proses">
                            </form>
                        </div>
                    </div>
                </div>
              </div>

              <!-- Bordered Table -->
              <div class="card mb-3">
                <h5 class="card-header">Silahkan melakukan scan pada Barcode/QR Code</h5>
                <div class="card-body">
                    <input type="text" class="form-control mb-2" id="QR_UUID" placeholder="Kode Pada Barcode/QR Code akan muncul disini ....">
                    <button type="button" class="btn btn-info" id="tombol_masukkan_keranjang">Masukkan</button>
                </div>
              </div>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Barang yang ingin dikeluarkan</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000">
                      <thead>
                        <tr>
                          <th class="text-wrap">No</th>
                          <th class="text-wrap">Kode Barang</th>
                          <th class="text-wrap">Nama Barang</th>
                          <th class="text-wrap">Rak/Kadar</th>
                          <th class="text-wrap">Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="body_tabel">
                            <?php $no = 1;foreach($this->session->userdata("barang_pengeluaran") as $bp) :  ?>
                                <tr id="tr_<?php echo $bp->id_session_barang ?>">
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $bp->Id; ?></td>
                                    <td class="text-wrap"><?php echo $bp->nama_barang ?></td>
                                    <td class="text-wrap"><?php echo $bp->nama_rak . " / " . $bp->nama_kadar ?></td>
                                    <td>
                                        <button type="button" id="<?php echo $bp->id_session_barang ?>" class="btn btn-icon btn-danger hapus_barang_session"><span class="tf-icons bx bx-trash"></span></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="card-footer">
                    <button type="button" class="btn btn-info" id="tombol_jual_barang" data-bs-toggle="modal" data-bs-target="#penjualanKasir">Proses</button>
                    <!-- <a href="<?php echo base_url('adm/barang_keluar/proses_barang_keluar') ?>"><button type="button" class="btn btn-info" id="tombol_pengembalian_barang">Proses</button></a> -->
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->

<script src="<?php echo base_url('assets') ?>/assets/vendor/libs/jquery/jquery.js"></script>

<script>
    $("#pilihan_rak").change(function(){
        var id_rak = $("#pilihan_rak").val();

        $.ajax({
            type : "POST",
            url : "<?= site_url('adm/barang_keluar/get_ajax_data_barang_per_rak') ?>",
            data : {
                "id_rak" : id_rak
            },
            success : function(response){
                var jawaban = JSON.parse(response);
                var html = "";

                for(i = 0; i<jawaban.length; i++){
                    html += '<option value="' + jawaban[i].Id + '">' + jawaban[i].nama_barang + ' (' + jawaban[i].berat_jual + ' Gr)</option>';
                }

                $("#pilihan_barang").html(html);
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
    })
</script>

<script>
    $(document).ready(function(){
        $("#QR_UUID").focus();

        var id_rak = $("#pilihan_rak").val();

        $.ajax({
            type : "POST",
            url : "<?= site_url('adm/barang_keluar/get_ajax_data_barang_per_rak') ?>",
            data : {
                "id_rak" : id_rak
            },
            success : function(response){
                var jawaban = JSON.parse(response);
                var html = "";

                for(i = 0; i<jawaban.length; i++){
                    html += '<option value="' + jawaban[i].Id + '">' + jawaban[i].nama_barang + ' (' + jawaban[i].berat_jual + ' Gr)</option>';
                }

                $("#pilihan_barang").html(html);
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
    })
</script>

<script>
    var urutan = <?php echo $no; ?>;
    $('#QR_UUID').on("keypress", function(e) {
            if (e.keyCode == 13) {
                var uuid = $("#QR_UUID").val();
                $("#QR_UUID").val("");
                
                
                $.ajax({
                    type : "POST",
                    url : "<?= site_url('adm/barang_keluar/ajax_post_and_get') ?>",
                    data : {
                        "uuid" : uuid
                    },
                    success : function(response){
                        var jawaban = JSON.parse(response);

                        if(jawaban.is_data_ada){
                            console.log(jawaban.data);
                            var html = "";
                            html += "<tr id='tr_" + jawaban.data.id_session_barang +"'>";
                            html += "<td>" + urutan + "</td>";
                            html += "<td>" + jawaban.data.Id + "</td>";
                            html += "<td class='text-wrap'>" + jawaban.data.nama_barang + "</td>";
                            html += "<td class='text-wrap'>" + jawaban.data.nama_rak + " / " + jawaban.data.nama_kadar +  "</td>";
                            html += '<td><button type="button" id="' + jawaban.data.id_session_barang + '" class="btn btn-icon btn-danger hapus_barang_session"><span class="tf-icons bx bx-trash"></span></button></td></tr>';

                            urutan = urutan + 1;
                            $('#body_tabel').append(html);
                        }else{
                            alert("Data tidak tersedia atau stok telah habis!");
                        }
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

    $("#tombol_masukkan_keranjang").click(function(){
        // console.log($("#QR_UUID").val());
        var uuid = $("#QR_UUID").val();
        $("#QR_UUID").val("");
        
        
        $.ajax({
            type : "POST",
            url : "<?= site_url('adm/barang_keluar/ajax_post_and_get') ?>",
            data : {
                "uuid" : uuid
            },
            success : function(response){
                var jawaban = JSON.parse(response);

                if(jawaban.is_data_ada){
                    console.log(jawaban.data);
                    var html = "";
                    html += "<tr id='tr_" + jawaban.data.id_session_barang +"'>";
                    html += "<td>" + urutan + "</td>";
                    html += "<td>" + jawaban.data.Id + "</td>";
                    html += "<td class='text-wrap'>" + jawaban.data.nama_barang + "</td>";
                    html += "<td class='text-wrap'>" + jawaban.data.nama_rak + " / " + jawaban.data.nama_kadar +  "</td>";
                    html += '<td><button type="button" id="' + jawaban.data.id_session_barang + '" class="btn btn-icon btn-danger hapus_barang_session"><span class="tf-icons bx bx-trash"></span></button></td></tr>';

                    urutan = urutan + 1;
                    $('#body_tabel').append(html);
                }else{
                    alert("Data tidak tersedia atau stok telah habis!");
                }
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
        
    })



</script>

<script>
    $("#tombol_jual_barang").click(function(){
        $.ajax({
            type    : "POST",
            url     : "<?= site_url("adm/barang_keluar/get_ajax_session_barang") ?>",
            success : function(response){
                data = JSON.parse(response);
                var html = "";

                var i;
                for(i = 0; i<data.length; i++){
                    html += "<tr>";
                    html += "<td>" + data[i].nama_barang + "</td>";
                    html += "<td>" + data[i].nama_rak + " / " + data[i].nama_kadar + "/" + data[i].berat_jual + "gr</td>";
                    html += "<input type='hidden' name='id_barang_session[]' value='" + data[i].id_session_barang +  "'>";
                    html += '<td><select name="kategori[]" id="" class="form-control"><option value="lebur">Lebur</option><option value="AD">AD</option></select></td>';
                    html += "</tr>";   
                }

                $("#tempat_jual").append(html);
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
    })
</script>

<script>
    $(document).on('click', '.hapus_barang_session', function(){
        var id = $(this).attr("id");

        $.ajax({
            type    : "POST",
            url     : "<?= site_url("adm/barang_keluar/ajax_delete_barang_from_session") ?>",
            data    : {
                'id_session_barang' : id
            },
            success : function(response){
                $("#tr_" + id).remove();
                alert("Pembatalan barang berhasil!");
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

        
    })
</script>

<script>
    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>

<script>
    $(document).on('keyup', '.hitung_harga', function(){
        var harga_total = 0;
        $('.hitung_harga').each(function(){
            harga_total += +$(this).val();
        })

        $("#Label_Harga").html("Total Belanja: Rp" +  addCommas(harga_total));
    })
</script>