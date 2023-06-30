<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Cetak Pengembalian Per Hari</title>
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

?>

</head>
<body>
	<h3 class="letter-info center" style="text-transform: uppercase;">CETAK PENGEMBALIAN</h3>
	<h3 class="letter-info center" style="text-transform: uppercase;">Tanggal : <?php echo $kyou; ?></h3>
    <h3 class="letter-info center" style="text-transform: uppercase;">Waktu Cetak : <?php echo date("Y-m-d H:i:s", time()); ?></h3>
	<table  cellspacing="0" Border="1" style="width:100%;" style="font-size: 8pt;">
		<thead style="background-color: #c3c3c3;">
			<tr>
				<th style="width :5%" >No</th>
				<th>Kode Pengembalian</th>
                <th>Tgl Proses</th>
				<th>Nama Barang</th>
                <th>Nama Kadar</th>
                <th>Nama Rak</th>
                <th>Berat Asli (Gram)</th>
			</tr>
		</thead>
		<tbody  Border="0">
            <?php $no = 1; foreach($rekap as $b) :  ?>
                <tr>
                    <td align="center"><?php echo $no++; ?></td>
                    <td><?php echo $b->KdPengembalian ?></td>
                    <td><?php echo date("Y-m-d H:i:s", $b->TglProses) ?></td>
                    <td><?php echo $b->nama_barang ?></td>
                    <td><?php echo $b->nama_kadar ?></td>
                    <td><?php echo $b->nama_rak ?></td>
                    <td><?php echo $b->berat_asli; $total_berat += $b->berat_asli ?></td>
                </tr>
            <?php endforeach; ?>
            <tr>
                <td colspan="6" align="right">Jumlah</td>
                <td><?php echo $total_berat; ?></td>
            </tr>
        </tbody>
	</table>
</body>
</html>