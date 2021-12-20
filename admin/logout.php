<?php
session_start();
session_unset();
session_destroy();
$property_id = $_GET['id'];
header("location: index.php?id='$id'");