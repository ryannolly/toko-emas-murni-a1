<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Penjualan</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

              <div class="modal fade" id="penjualanKasir" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Proses Penjualan Barang</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <h5 class="text-danger">Harap masukkan angka saja pada kolom harga!</h5>
                        <form action="<?php echo base_url('adm/penjualan/penjualan_proses') ?>" method="post">
                            <div class="table-responsive">
                                <table class="table table-bordered" style="border:3px" id="tempat_jual">
                                    <tr>
                                        <th>Nama Barang</th>
                                        <th>Rak/Kadar/Berat</th>
                                        <th>Harga</th>
                                        <th>Berat Jual</th>
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

              <div class="row mb-3">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cetakQR">Penjualan Tanpa Barcode</button>
                </div>
              </div>

              <!-- Extra Large Modal -->
              <div class="modal fade" id="cetakQR" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Proses Penjualan Tanpa Barcode</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('adm/penjualan/penjualan_tanpa_barang_proses') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Keterangan (Isi dengan Keterangan Penjualan)</label>
                                    <input type="text" class="form-control" name="keterangan" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="">Nilai Jual (Harap diisi dengan angka)</label>
                                    <input type="number" class="form-control" name="nilai_jual" required>
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
                <h5 class="card-header">Barang yang ingin dijual</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000">
                      <thead>
                        <tr>
                          <th class="text-wrap">Kode Barang</th>
                          <th class="text-wrap">Nama Barang</th>
                          <th class="text-wrap">Rak/Kadar</th>
                          <th class="text-wrap">Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="body_tabel">
                            <?php $no = 1;foreach($this->session->userdata("barang_kasir") as $bp) :  ?>
                                <tr id="tr_<?php echo $bp->id_session_barang ?>">
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
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->

<script src="<?php echo base_url('assets') ?>/assets/vendor/libs/jquery/jquery.js"></script>

<script>
    $(document).ready(function(){
        $("#QR_UUID").focus();
    })
</script>

<script>
    $('#QR_UUID').on("keypress", function(e) {
            if (e.keyCode == 13) {
                var uuid = $("#QR_UUID").val();
                $("#QR_UUID").val("");
                
                
                $.ajax({
                    type : "POST",
                    url : "<?= site_url('adm/penjualan/ajax_post_and_get') ?>",
                    data : {
                        "uuid" : uuid
                    },
                    success : function(response){
                        var jawaban = JSON.parse(response);

                        if(jawaban.is_data_ada){
                            console.log(jawaban.data);
                            var html = "";
                            html += "<tr id='tr_" + jawaban.data.id_session_barang +"'>";
                            html += "<td>" + jawaban.data.Id + "</td>";
                            html += "<td class='text-wrap'>" + jawaban.data.nama_barang + "</td>";
                            html += "<td class='text-wrap'>" + jawaban.data.nama_rak + " / " + jawaban.data.nama_kadar +  "</td>";
                            html += '<td><button type="button" id="' + jawaban.data.id_session_barang + '" class="btn btn-icon btn-danger hapus_barang_session"><span class="tf-icons bx bx-trash"></span></button></td></tr>';

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
            url : "<?= site_url('adm/penjualan/ajax_post_and_get') ?>",
            data : {
                "uuid" : uuid
            },
            success : function(response){
                var jawaban = JSON.parse(response);

                if(jawaban.is_data_ada){
                    console.log(jawaban.data);
                    var html = "";
                    html += "<tr id='tr_" + jawaban.data.id_session_barang +"'>";
                    html += "<td>" + jawaban.data.Id + "</td>";
                    html += "<td class='text-wrap'>" + jawaban.data.nama_barang + "</td>";
                    html += "<td class='text-wrap'>" + jawaban.data.nama_rak + " / " + jawaban.data.nama_kadar +  "</td>";
                    html += '<td><button type="button" id="' + jawaban.data.id_session_barang + '" class="btn btn-icon btn-danger hapus_barang_session"><span class="tf-icons bx bx-trash"></span></button></td></tr>';

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
    $(document).on('click', '.hapus_barang_session', function(){
        var id = $(this).attr("id");

        $.ajax({
            type    : "POST",
            url     : "<?= site_url("adm/penjualan/ajax_delete_barang_from_session") ?>",
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
    $("#tombol_jual_barang").click(function(){
        $.ajax({
            type    : "POST",
            url     : "<?= site_url("adm/penjualan/get_ajax_session_barang") ?>",
            success : function(response){
                data = JSON.parse(response);
                var html = "";

                var i;
                for(i = 0; i<data.length; i++){
                    html += "<tr>";
                    html += "<td>" + data[i].nama_barang + "</td>";
                    html += "<td>" + data[i].nama_rak + " / " + data[i].nama_kadar + "/" + data[i].berat_jual + "gr</td>";
                    html += "<input type='hidden' name='id_barang_session[]' value='" + data[i].id_session_barang +  "'>";
                    html += "<td><input name='harga_barang[]' type='number' class='form-control hitung_harga' value='' required placeholder='Masukkan harga ..'></td>";
                    html += "<td><input name='berat_jual[]' type='text' class='form-control' value='' required placeholder='Masukkan Berat dalam gram ..'></td>";
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