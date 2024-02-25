<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Detail Total Keuangan Harian</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
    <meta name="robots" content="noindex,nofollow" />
    <link href="css/print.css" rel="stylesheet" media="print" type="text/css" />
	<link href="css/screen.css" rel="stylesheet" media="screen" type="text/css" />

<?php

function format_ip($number, $decimals = 0, $decPoint = '.' , $thousandsSep = ','){
    $negation = ($number < 0) ? (-1) : 1;
    $coefficient = 10 ** $decimals;
    $number = $negation * floor((string)(abs($number) * $coefficient)) / $coefficient;
    return number_format($number, $decimals, $decPoint, $thousandsSep);
  }

?>

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

<?php

$total_berat = 0;
$total_berat_jual = 0;
$total_harga = 0;

$total_uang_keluar = 0;

?>

</head>
<body>
	<h3 class="letter-info center" style="text-transform: uppercase;">Detail Total Keuangan Harian</h3>
	<h3 class="letter-info center" style="text-transform: uppercase;">Tanggal : <?php echo $detail_opening->tanggal; ?></h3>
    <h3 class="letter-info center" style="text-transform: uppercase;">Waktu Cetak : <?php echo date("Y-m-d H:i:s", time()); ?></h3>
	<h2 style="margin-top:3px">Uang Masuk</h2>
    <h2 style="margin-top:3px">Uang Stock: Rp. <?php echo format_ip($detail_opening->uang_stok, 2, ".", ",") ?></h2>
    <table  cellspacing="0" Border="1" style="width:100%;" style="font-size: 8pt;">
		<thead style="background-color: #c3c3c3;">
			<tr>
				<th style="width :5%" >No</th>
				<th>Nama Barang</th>
                <th>Jumlah Uang</th>
			</tr>
		</thead>
		<tbody  Border="0">
            <?php $no = 1; foreach($pemasukkan_hari_ini as $b) :  ?>
                <tr>
                    <td align="center" width="10%"><?php echo $no++; ?></td>
					<td width="70%"><?php echo ($b->JnPembayaran == "Bank") ? $b->id_barang : ($b->nama_barang."/".$b->nama_rak."/".$b->nama_kadar) ?></td>
                    <td width="20%">Rp. <?php echo format_ip($b->nilai_barang, 2, ".", ","); $total_harga += $b->nilai_barang ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2" align="right"><b>Total Uang Masuk</b></td>
                <td><b>Rp. <?php echo format_ip($total_harga + $detail_opening->uang_stok, 2, ".", ",") ?></b></td>
            </tr>
        </tbody>
	</table>

    <h2 style="margin-top:3px">Uang Keluar</h1>
    <table  cellspacing="0" Border="1" style="width:100%;" style="font-size: 8pt;">
		<thead style="background-color: #c3c3c3;">
			<tr>
				<th style="width :5%" >No</th>
				<th>Nama Barang</th>
                <th>Jumlah Uang</th>
			</tr>
		</thead>
		<tbody  Border="0">
            <?php $no = 1; foreach($pengeluaran_hari_ini as $b) :  ?>
                <tr>
                    <td align="center" width="10%"><?php echo $no++; ?></td>
					<td width="70%"><?php echo ($b->nama_barang == "") ? $b->id_barang : ($b->nama_barang."/".$b->nama_rak."/".$b->nama_kadar) ?></td>
                    <td width="20%">Rp. <?php echo format_ip($b->uang, 2, ".", ","); $total_uang_keluar += $b->uang ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="2" align="right"><b>Total Uang Keluar</b></td>
                <td><b>Rp. <?php echo format_ip($total_uang_keluar, 2, ".", ",") ?></b></td>
            </tr>
        </tbody>
	</table>

    <table  cellspacing="0" Border="1" style="width:100%;margin-top:20px;" style="font-size: 8pt;">
		<tr>
            <th>Total Masuk Uang</th>
            <td><b>Rp. <?php echo format_ip($total_harga + $detail_opening->uang_stok, 2, ".", ",") ?></b></td>
        </tr>
        <tr>
            <th>Total Keluar Uang</th>
            <td><b>Rp. <?php echo format_ip($total_uang_keluar, 2, ".", ",") ?></b></td>
        </tr>
        <tr>
            <th>Sisa Uang</th>
            <td><b>Rp. <?php echo format_ip($total_harga + $detail_opening->uang_stok - $total_uang_keluar, 2, ".", ",") ?></b></td>
        </tr>
	</table>

    <table  cellspacing="0" Border="1" style="width:100%;margin-top:20px;" style="font-size: 8pt;">
		<tr>
            <th>Closing Stock</th>
            <td><b>Rp. <?php echo format_ip($detail_opening->closing_stok, 2, ".", ",") ?></b></td>
        </tr>
        <tr>
            <th>Selisih</th>
            <td><b>Rp. <?php echo format_ip($detail_opening->closing_stok - ($total_harga + $detail_opening->uang_stok - $total_uang_keluar), 2, ".", ",") ?></b></td>
        </tr>
	</table>
</body>
</html>