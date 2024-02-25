<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Checklist Barang Pada Rak</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

              <!-- Bordered Table -->
              <div class="card mb-3">
                <h5 class="card-header">Silahkan melakukan scan pada Barcode/QR Code</h5>
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control mb-2" id="QR_UUID" placeholder="Kode Pada Barcode/QR Code akan muncul disini ....">
                        <button type="button" class="btn btn-info" id="tombol_masukkan_keranjang">Masukkan</button>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Detail Barang</label>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Rak/Kadar</th>
                                </tr>
                            </thead>
                            <?php 
                                $ada_terchecked = false;
                                foreach($barang as $p){
                                    if($p->is_checked == 1){
                                        $ada_terchecked = true;
                                        break;
                                    }
                                }
                            ?>
                            <tbody id="tempat_detail_barang_scan">
                                <?php if(!$ada_terchecked) : ?>
                                    <tr>
                                        <td colspan="3" class="text-danger" style="text-align:center">Silahkan untuk scan barang terlebih dahulu!</td>
                                    </tr>
                                <?php else :  ?>
                                    <?php foreach($barang as $p) : ?>
                                        <?php if($p->is_checked) : ?>
                                            <tr>
                                                <td><?php echo $p->id_barang; ?> / <?php echo $p->urutan_rak ?></td>
                                                <td class="text-wrap"><?php echo $p->nama_barang ?> / <?php echo number_format($p->berat_jual, 2, ".", ",") ?> gr</td>
                                                <td class="text-wrap"><?php echo $p->nama_rak . " / " . $p->nama_kadar ?></td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
              </div>

              <!-- Bordered Table -->
              <div class="row">
                <div class="card">
                    <h5 class="card-header">Barang yang belum discan</h5>
                    <div class="card-body">
                    <a class="btn btn-primary mt-3" onclick="return confirm('Apakah anda yakin untuk mengulangi pengecekan?')" href="<?php echo base_url("adm/data_rak/ulangi_pengecekan/".$detail_rak->id) ?>">
                        Ulangi Pengecekan
                    </a>
                    <div class="table-responsive text-nowrap mt-3">
                        <table class="table table-bordered" style="color:#000">
                        <thead>
                            <tr>
                            <th class="text-wrap">Kode Barang</th>
                            <th class="text-wrap">Nama Barang</th>
                            <th class="text-wrap">Rak/Kadar</th>
                            <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="">
                                <?php foreach($barang as $p) :   ?>
                                    <?php if($p->is_checked == 0) :  ?>
                                        <tr id="tr_<?php echo $p->id_barang ?>">
                                            <td><?php echo $p->id_barang; ?> / <?php echo $p->urutan_rak ?></td>
                                            <td class="text-wrap"><?php echo $p->nama_barang ?> / <?php echo number_format($p->berat_jual, 2, ".", ",") ?> gr</td>
                                            <td class="text-wrap"><?php echo $p->nama_rak . " / " . $p->nama_kadar ?></td>
                                            <td class="text-wrap">
                                                <a target="_blank" href="<?php echo base_url("adm/data_barang/ubah_data_barang/".$p->id_barang) ?>">
                                                    <button type="button" class="btn btn-icon btn-info" title="Edit Barang">
                                                        <span class="tf-icons bx bx-edit"></span>
                                                    </button>
                                                </a>
                                                <a tagert="_blank" class="hapus_data" href="<?php echo base_url("adm/data_barang/hapus_data_barang/".$p->id_barang) ?>">
                                                    <button type="button" class="btn btn-icon btn-danger" title="Hapus Barang">
                                                        <span class="tf-icons bx bx-trash"></span>
                                                    </button>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                        </tbody>
                        </table>
                    </div>
                    </div>
                </div>
              </div>
              <!--/ Bordered Table -->
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
                    url : "<?= site_url('adm/data_rak/check_barang_di_sebuah_rak') ?>",
                    data : {
                        "uuid" : uuid,
                        'id_rak' : "<?php echo $detail_rak->id ?>"
                    },
                    success : function(response){
                        var jawaban = JSON.parse(response);

                        if(jawaban.is_udah_dicheck && jawaban.is_data_ada){
                            alert("Data tersebut sudah di scan, Kode Data: " + jawaban.data.Id);
                            console.log(jawaban);
                        }else if(jawaban.is_data_ada){
                            $("#tr_" + jawaban.data.Id).remove();
                            
                            var html = "";
                            html += "<tr>";
                            html += "<td>" + jawaban.data.Id + "/" + jawaban.data.urutan_rak + "</td>";
                            html += "<td class='text-wrap'>" + jawaban.data.nama_barang + "/" + jawaban.data.berat_jual + "</td>";
                            html += "<td class='text-wrap'>" + jawaban.data.nama_rak + " / " + jawaban.data.nama_kadar +  "</td>";
                            html += "</tr>";

                            $('#tempat_detail_barang_scan').append(html);
                        }else{
                            alert("Data tersebut tidak ada pada rak tersebut!");

                            // var html = "";
                            // html += "<tr>";
                            // html += "<td colspan='3' class='text-danger' style='text-align:center'>Data Tidak Ada Pada Rak Berikut!</td>";
                            // html += "</tr>";
                            // $('#tempat_detail_barang_scan').html(html);
                            // alert("Data tersebut tidak ada pada rak tersebut!");
                        }
                        $("#QR_UUID").focus();
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
            url : "<?= site_url('adm/data_rak/check_barang_di_sebuah_rak') ?>",
            data : {
                "uuid" : uuid,
                'id_rak' : "<?php echo $detail_rak->id ?>"
            },
            success : function(response){
                var jawaban = JSON.parse(response);

                if(jawaban.is_udah_dicheck && jawaban.is_data_ada){
                    alert("Data tersebut sudah di scan, Kode Data: " + jawaban.data.Id);
                    console.log(jawaban);
                }else if(jawaban.is_data_ada){        
                    console.log(jawaban.data.Id);
                    $("#tr_" + jawaban.data.Id).remove();
                    var html = "";
                    html += "<tr>";
                    html += "<td>" + jawaban.data.Id + "/" + jawaban.data.urutan_rak + "</td>";
                    html += "<td class='text-wrap'>" + jawaban.data.nama_barang + "/" + jawaban.data.berat_jual + " gr</td>";
                    html += "<td class='text-wrap'>" + jawaban.data.nama_rak + " / " + jawaban.data.nama_kadar +  "</td>";
                    html += "</tr>";

                    $('#tempat_detail_barang_scan').append(html);
                }else{
                    alert("Data tersebut tidak ada pada rak tersebut!");

                    // var html = "";
                    // html += "<tr>";
                    // html += "<td colspan='3' class='text-danger' style='text-align:center'>Data Tidak Ada Pada Rak Berikut!</td>";
                    // html += "</tr>";
                    // $('#tempat_detail_barang_scan').html(html);
                }

                $("#QR_UUID").focus();
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