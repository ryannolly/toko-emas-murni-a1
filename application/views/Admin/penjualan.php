<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Penjualan</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

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
                  <a href="<?php echo base_url("adm/penjualan/penjualan_proses/") ?>" ><button type="button" class="btn btn-info">Proses</button></a>
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
                        console.log(jawaban);

                        var html = "";
                        html += "<tr>";
                        html += "<td>" + jawaban.data.Id + "</td>";
                        html += "<td class='text-wrap'>" + jawaban.data.nama_barang + "</td>";
                        html += "<td class='text-wrap'>" + jawaban.data.nama_rak + " / " + jawaban.data.nama_kadar +  "</td>";
                        html += "<td></td></tr>";

                        $('#body_tabel').append(html);
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