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
              <div class="row">
                <div class="card">
                    <h5 class="card-header">Barang yang belum discan</h5>
                    <div class="card-body">
                    <div class="table-responsive text-nowrap">
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
                                    <tr id="tr_<?php echo $p->Id ?>">
                                        <td><?php echo $p->Id; ?></td>
                                        <td class="text-wrap"><?php echo $p->nama_barang ?></td>
                                        <td class="text-wrap"><?php echo $p->nama_rak . " / " . $p->nama_kadar ?></td>
                                        <td class="text-wrap">
                                            <a target="_blank" href="<?php echo base_url("adm/data_barang/ubah_data_barang/".$p->Id) ?>">
                                                <button type="button" class="btn btn-icon btn-info" title="Edit Barang">
                                                    <span class="tf-icons bx bx-edit"></span>
                                                </button>
                                            </a>
                                            <a tagert="_blank" class="hapus_data" href="<?php echo base_url("adm/data_barang/hapus_data_barang/".$p->Id) ?>">
                                                <button type="button" class="btn btn-icon btn-danger" title="Hapus Barang">
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
                        console.log(jawaban.data.Id);
                        $("#tr_" + jawaban.data.Id).remove();

                        if(jawaban.is_data_ada){
                            
                            var html = "";
                            html += "<tr id='tr_" + jawaban.data.id_session_barang +"'>";
                            html += "<td>" + jawaban.data.Id + "</td>";
                            html += "<td class='text-wrap'>" + jawaban.data.nama_barang + "</td>";
                            html += "<td class='text-wrap'>" + jawaban.data.nama_rak + " / " + jawaban.data.nama_kadar +  "</td>";

                            $('#body_tabel').append(html);
                        }else{
                            alert("Data tersebut tidak ada pada rak tersebut!");
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
            url : "<?= site_url('adm/data_rak/check_barang_di_sebuah_rak') ?>",
            data : {
                "uuid" : uuid,
                'id_rak' : "<?php echo $detail_rak->id ?>"
            },
            success : function(response){
                var jawaban = JSON.parse(response);
                console.log(jawaban.data.Id);
                $("#tr_" + jawaban.data.Id).remove();

                if(jawaban.is_data_ada){
                    
                    var html = "";
                    html += "<tr id='tr_" + jawaban.data.id_session_barang +"'>";
                    html += "<td>" + jawaban.data.Id + "</td>";
                    html += "<td class='text-wrap'>" + jawaban.data.nama_barang + "</td>";
                    html += "<td class='text-wrap'>" + jawaban.data.nama_rak + " / " + jawaban.data.nama_kadar +  "</td>";

                    $('#body_tabel').append(html);
                }else{
                    alert("Data tersebut tidak ada pada rak tersebut!");
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