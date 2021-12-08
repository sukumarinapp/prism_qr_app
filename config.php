<?php
date_default_timezone_set("Asia/Kolkata");
$base_url = "https://prismblr.com/kot";
$mysql_hostname = "localhost";
$mysql_user = "prism";
$mysql_password = "1bit_mysql";
$mysql_user = "root";
$mysql_password = "";
$mysql_database = "prismdev";
$conn = new mysqli($mysql_hostname, $mysql_user, $mysql_password, $mysql_database);
$displayCurrency = 'INR';
?>
