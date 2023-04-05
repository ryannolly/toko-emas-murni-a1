<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Cetak Daftar Barang Pada Rak</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta name="robots" content="noindex,nofollow" />
    <link href="css/print.css" rel="stylesheet" media="print" type="text/css" />
	<link href="css/screen.css" rel="stylesheet" media="screen" type="text/css" />

<!-- this section is the stylesheet for both print and display version --> 
<style type="text/css">
* {
	margin: 0;
	padding: 0;
}

p {
	text-align: justify;
}

body {
	font-family: Arial, Tahoma, Verdana, sans-serif;
	font-size: 11pt;
}

h1 {
	font-size: 20pt;
	text-transform: uppercase;
	text-align: center;
	margin: 0;
	padding: 0;
}

.outerwrapper {
	padding: 0.3cm;
}

.lower-header {
	font-size: 15pt;
	font-weight: bold;
	padding: 0.2cm;
	text-align: center;
}

.body {
	clear: both;
	line-height: 1.5em;
	font-size: 11pt;
	margin: 0.2in 0 0 0;
}

ul.student-info {
	list-style: none;
	margin-left: 1cm;
}

ul.student-info li {
	margin: 0.2cm 0;
}

.label {
	float:left;
	width: 4cm;
	padding-right: 0.1cm;
}

.doublecol {
	float:left;
	margin-right: 0.2cm;
}

.val {
	display: block;
	margin-left: 4.4cm;
}

.lower-body {
	text-align: left;
}

.photobox {
	border: 1px solid #000;
	float: left;
	height: 3cm;
	margin: 1.5cm 0 0 0.3cm;
	padding-top: 1cm;
	text-align: center;
	width: 3cm;
}


.right {
	float: right;
}

.date {
	margin-top: 1.5cm;
	text-align: right;
}

.foot {
	font-size: 9pt;
	width: 8.5cm;
}

.contact-info {
	margin-left: 1cm;
}

.signature-right {
	border-top: 1px dotted #000;
}

.pos {
	margin-top: 0.8cm;
	text-align: left;
}

.signature-name {
	margin-top: 2cm;
}

h2 {
	font-size: 15pt;
	margin: 0;
	padding: 0;

}

.lower-body {
	margin: 1cm 0 0 0;
}

.lower-left-body {
	clear: both;
}

.lower-left-body ul {
	list-style: none;
}

.lower-left-body li {
	margin: 0.2cm 0;
}
.center {text-align:center}
.bold{font-weight: bold;}
.txt-left{text-align:left}
@Page {
  size: landscape;
}
table td {
 padding : 0 3px;
}
.fontType1 {
	font-weight: bold;
}

.button {
  display: inline-block;
  padding: 12px 24px;
  background-color: #4CAF50;
  color: white;
  text-align: center;
  text-decoration: none;
  font-size: 16px;
  border-radius: 8px;
  margin:2px;
}

.button.danger{
	background-color:#ff4136;
}
</style>

</head>
<body>
	<h3 class="letter-info center" style="text-transform: uppercase;">DAFTAR BARANG PADA RAK</h3>
	<h3 class="letter-info center" style="text-transform: uppercase;">NAMA RAK : <?php echo $detail_rak->nama_rak; ?></h3>
	<table  cellspacing="0" Border="1" style="width:100%;" style="font-size: 8pt;">
		<thead style="background-color: #c3c3c3;">
			<tr>
				<th style="width :5%" >No</th>
				<th style="width: 5%">Kode Barang</th>
				<th>Nama Barang</th>
                <th>Kadar</th>
				<th>Berat Jual</th>
                <th width="10%">Foto</th>
				<th width="5%">Aksi</th>
			</tr>
		</thead>
		<tbody  Border="0">
			<?php if(sizeof($barang) <= 0) : ?>
				<tr>
					<td colspan="5" style="text-align:center;">Tidak Ada Data</td>
				</tr>
			<?php else : ?>
				<?php $jumlah_berat = 0; $jumlah_berat_wadah = 0; $no = 0; foreach($barang as $p) :  ?>
					<?php if($p->nama_kadar == "0%") :  ?>
						<tr>
							<td></td>
							<td></td>
							<td><?php echo $p->nama_barang ?></td>
							<td><?php echo $p->nama_kadar ?></td>
							<td style="text-align:center"><?php echo $p->berat_jual ?> gr</td>
							<td><img width="200px" src="<?php echo base_url("uploads/foto_emas/").$p->foto ?>" alt=""></td>
							<td></td>
						</tr>
						<?php $jumlah_berat_wadah += $p->berat_jual ?>
					<?php else: ?>
						<tr>
							<td style="text-align:center"><?php echo ++$no ?></td>
							<td style="text-align:center"><?php echo $p->Id ?></td>
							<td><?php echo $p->nama_barang ?></td>
							<td><?php echo $p->nama_kadar ?></td>
							<td style="text-align:center;"><?php echo $p->berat_jual ?> gr</td>
							<td><img width="200px" src="<?php echo base_url("uploads/foto_emas/").$p->foto ?>" alt=""></td>
							<td>
								<a target="_blank" class="button" href="<?php echo base_url("adm/data_barang/ubah_data_barang/").$p->Id ?>">Ubah</a>
								<a onclick="return confirm('Apakah anda yakin ingin menghapus data berikut?')" class="button danger" href="<?php echo base_url("adm/data_barang/hapus_data_barang_dari_cek_rak/".$p->Id."/".$detail_rak->id) ?>">Hapus</a>
							</td>
						</tr>
                    	<?php $jumlah_berat += $p->berat_jual ?>
					<?php endif; ?>
				<?php endforeach; ?>
                <tr>
                    <td colspan="3" rowspan="2" style="text-align:right; background-color: #c3c3c3">TOTAL</td>
					<td style="text-align:right">Emas Bersih : </td>
					<td colspan="3" style="text-align:left"><?php echo $no ?> (<?php echo $jumlah_berat ?> gr)</td>
                </tr>
				<tr>
					<td style="text-align:right">Berat Rak+Barcode : </td>
					<td colspan="3" style="text-align:left"><?php echo $no ?> (<?php echo $jumlah_berat_wadah ?> gr)</td>
				</tr>
			<?php endif; ?>
        </tbody>
	</table>
</body>
</html>