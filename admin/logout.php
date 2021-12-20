<?php
session_start();
$property_id = $_SESSION['property_id'];
$url = "index.php?id=$property_id";
session_destroy();
header("location: $url");
?>