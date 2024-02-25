<!-- Content wrapper -->
<div class="content-wrapper">
            <!-- Content -->

            <div class="container-xxl flex-grow-1 container-p-y">
              <h4 class="fw-bold py-3 mb-3">Pengembalian Barang</h4>

              <?php echo $this->session->flashdata("pesan"); ?>

              <div class="row mb-3">
                <div class="col-lg-2">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#cetakQR">Pengembalian Tanpa Barcode</button>
                </div>
              </div>

              <!-- Extra Large Modal -->
              <div class="modal fade" id="cetakQR" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel4">Proses Pengembalian Tanpa Barcode</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form action="<?php echo base_url('adm/pengembalian/pengembalian_tanpa_barang_proses') ?>" method="post">
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="nameExLarge" class="form-label">Keterangan (Isi dengan Keterangan Pengembalian/Pengeluaran)</label>
                                    <input type="text" class="form-control" name="keterangan" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mb-3">
                                    <label for="">Nilai Pengeluaran (Harap diisi dengan angka)</label>
                                    <input type="number" class="form-control" name="nilai_jual" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            Close
                            </button>
                            <input type="submit" class="btn btn-primary" value="Tambahkan">
                        </div>
                        </form>
                    </div>
                </div>
              </div>

              <!-- Bordered Table -->
              <div class="card mb-3">
                <h5 class="card-header">Silahkan masukkan keterangan barang yang ingin dikembalikan</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="nameExLarge" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="" class="form-label">Rak</label>
                            <select name="id_rak" id="id_rak" class="form-control" style="color:#000">
                                <?php foreach($data_rak as $rak) :  ?>
                                    <option value="<?php echo $rak->id ?>"><?php echo $rak->nama_rak ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="" class="form-label">Kadar</label>
                            <select name="id_kadar" id="id_kadar" class="form-control" style="color:#000">
                                <?php foreach($data_kadar as $rak) :  ?>
                                    <option value="<?php echo $rak->id ?>"><?php echo $rak->nama_kadar ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="" class="form-label">Berat <span class="text-danger">(Gunakan titik "." untuk desimal)</span></label>
                            <input type="text" class="form-control" name="berat" id="berat">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="" class="form-label">Kategori</label>
                            <select name="kategori" id="kategori" class="form-control" style="color:#000">
                                <option value="terima">Terima</option>
                                <option value="lebur">Lebur</option>
                            </select>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label for="" class="form-label">Harga <span class="text-danger">Diisi hanya dengan angka</span></label>
                            <input type="number" class="form-control" id="harga" name="harga">
                        </div>
                    </div>
                    <button type="button" class="btn btn-info" id="tombol_masukkan_keranjang">Masukkan</button>
                </div>
              </div>

              <!-- Bordered Table -->
              <div class="card">
                <h5 class="card-header">Barang yang ingin dikembalikan</h5>
                <div class="card-body">
                  <div class="table-responsive text-nowrap">
                    <table class="table table-bordered" style="color:#000">
                      <thead>
                        <tr>
                          <th class="text-wrap">Nama Barang</th>
                          <th class="text-wrap">Rak/Kadar</th>
                          <th class="text-wrap">Berat</th>
                          <th class="text-wrap">Kategori</th>
                          <th class="text-wrap">Harga</th>
                          <th class="text-wrap">Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="body_tabel">
                            <?php $no = 1;foreach($this->session->userdata("barang_pengembalian") as $bp) :  ?>
                                <tr id="tr_<?php echo $bp->id_session_barang ?>">
                                    <td class="text-wrap"><?php echo $bp->nama_barang ?></td>
                                    <td class="text-wrap"><?php echo $bp->nama_rak . " / " . $bp->nama_kadar ?></td>
                                    <td class="text-wrap"><?php echo $bp->berat ?>gr</td>
                                    <td class="text-wrap"><?php echo $bp->kategori ?></td>
                                    <td class="text-wrap">Rp<?php echo $bp->harga ?></td>
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
                  <a href="<?php echo base_url('adm/pengembalian/proses_pengembalian') ?>"><button type="button" class="btn btn-info" id="tombol_pengembalian_barang">Proses</button></a>
                </div>
              </div>
              <!--/ Bordered Table -->
              <!--/ Bordered Table -->
              <!--/ Responsive Table -->
            </div>
            <!-- / Content -->

<script src="<?php echo base_url('assets') ?>/assets/vendor/libs/jquery/jquery.js"></script>

<script>
    $('#tombol_pengembalian_barang').click(function(){
        return confirm("Apakah anda yakin ingin memproses pengembalian barang ini? Barang yang dikembalikan akan otomatis masuk ke dalam rak");
    })
</script>

<script>
    $("#tombol_masukkan_keranjang").click(function(){
        // console.log($("#QR_UUID").val());
        console.log("masuk");
        var nama_barang = $("#nama_barang").val();
        var id_rak      = $("#id_rak").val();
        var id_kadar    = $("#id_kadar").val();
        var berat       = $("#berat").val();
        var kategori    = $("#kategori").val();
        var harga       = $("#harga").val();
        
        $.ajax({
            type : "POST",
            url : "<?= site_url('adm/pengembalian/ajax_post_and_get') ?>",
            data : {
                "nama_barang"   : nama_barang,
                'id_rak'        : id_rak,
                'id_kadar'      : id_kadar,
                'berat'         : berat,
                'kategori'      : kategori,
                'harga'         : harga
            },
            success : function(response){
                var jawaban = JSON.parse(response);

                var html = "";
                html += "<tr id='tr_" + jawaban.data.id_session_barang +"'>";
                html += "<td>" + jawaban.data.nama_barang + "</td>";
                html += "<td class='text-wrap'>" + jawaban.data.nama_rak + "/" + jawaban.data.nama_kadar + "</td>";
                html += "<td class='text-wrap'>" + jawaban.data.berat + "gr</td>";
                html += "<td class='text-wrap'>" + jawaban.data.kategori + "</td>";
                html += "<td class='text-wrap'>Rp" + jawaban.data.harga + "</td>";
                html += '<td><button type="button" id="' + jawaban.data.id_session_barang + '" class="btn btn-icon btn-danger hapus_barang_session"><span class="tf-icons bx bx-trash"></span></button></td></tr>';

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
        
    })

</script>

<script>
    $(document).on('click', '.hapus_barang_session', function(){
        var id = $(this).attr("id");

        $.ajax({
            type    : "POST",
            url     : "<?= site_url("adm/pengembalian/ajax_delete_barang_from_session") ?>",
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
                    html += "<td>" + data[i].nama_rak + " / " + data[i].nama_kadar + "</td>";
                    html += "<input type='hidden' name='id_barang_session[]' value='" + data[i].id_session_barang +  "'>";
                    html += "<td><input name='harga_barang[]' type='number' class='form-control hitung_harga' value='' required placeholder='Masukkan harga ..'></td>";
                    html += "</tr>";   
                }

                $("#tempat_jual").html(html);
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