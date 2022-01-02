<?php
session_start();
$page = "link steward";
include "../config.php";
$id = $_GET['id'];
$sql = "delete from posout where id=$id";
$result = mysqli_query($conn, $sql);
header("location: link_steward.php");