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
	font-size: 5pt; !important
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
  size: potrait;
}
table td {
 padding : 0 3px;
}
.fontType1 {
	font-weight: bold;
}

.mini_td{
    height:25px;
    width:25px;
	padding-bottom:5px;
}
</style>

</head>
<?php 
	$counter_print = 0; 
	$banyak_data   = count($data_barang);
	// Baru
	$berapa_baris = ceil((float) count($data_barang)/18);
	
	function format_ip($number, $decimals = 0, $decPoint = '.' , $thousandsSep = ','){
		$negation = ($number < 0) ? (-1) : 1;
		$coefficient = 10 ** $decimals;
		$number = $negation * floor((string)(abs($number) * $coefficient)) / $coefficient;
		return number_format($number, $decimals, $decPoint, $thousandsSep);
	}
?>
<body>
	<table  cellspacing="0" Border="1" style="width:100%;" style="font-size: 4pt;">
		<thead style="background-color: #c3c3c3;">
			<!-- <tr>
				<th style="width :5%;" >No</th>
				<th>Nama Barang</th>
                <th>Rak</th>
				<th>Berat Jual</th>
                <th>Foto</th>
			</tr> -->
		</thead>
		<tbody  Border="0">
			<?php for($i = 0; $i<$berapa_baris; $i++) :  ?>
				<tr>
                <?php for($j = 0; $j<18; $j++) :  ?>
					<?php if($counter_print < $banyak_data) :  ?>
						<td style="text-align:center;" class="mini_td"><p style="text-align:center"><?php echo $data_barang[$counter_print]->urutan_rak ?></p><img width="30px" src="<?php echo site_url("adm/data_barang/print_qr/".$data_barang[$counter_print]->Id) ?>" alt=""><p style="text-align:center; overflow-wrap: anywhere;"><?php echo $data_barang[$counter_print]->nama_rak ?>/<?php echo $data_barang[$counter_print]->nama_kadar ?>/<?php echo format_ip($data_barang[$counter_print++]->berat_jual, 2, ".", "") ?></p></td>
					<?php else : ?>
						<td style="text-align:center" class="mini_td">&nbsp;</td>
					<?php endif; ?>
                <?php endfor; ?>
				</tr>
            <?php endfor; ?>   
        </tbody>
	</table>
</body>
</html>