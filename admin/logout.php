<?php
session_start();
session_unset();
session_destroy();
$id = $_GET['id'];
$url = "index.php?id='$id'";
header("location: $url");