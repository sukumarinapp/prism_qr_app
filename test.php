<?php
include "phpqrcode/qrlib.php";
$qr_code_url = "http://prismblr.com";
QRcode::png($qr_code_url, "qr/prismblr.png", QR_ECLEVEL_H, 3, 10);
