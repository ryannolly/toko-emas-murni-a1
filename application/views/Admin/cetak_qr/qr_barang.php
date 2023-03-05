<?php
//Untuk QR CODE
include APPPATH."../assets/assets/vendor/phpqrcode/qrlib.php";

QRcode::png($detail_data->uuid);

?>