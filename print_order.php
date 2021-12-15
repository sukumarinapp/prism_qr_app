<?php
session_start();
include "config.php";
include_once("functions.php");
$sales = $_REQUEST['sales'];
$id = 0;
$order_id = 0;
foreach($sales as $sale){
    $id = $sale['printitemid'];
    $sql="select * from poskot where id = $id";
    $result = mysqli_query($conn, $sql);
    while($row = mysqli_fetch_array($result)){
        $order_id = $row['order_id'];
        $sql2 = "update poskot set status='ordered' where id = $id";
        mysqli_query($conn, $sql2) or die(mysqli_error($conn));
        $sql3 = "update posord set status='ordered' where order_id = $order_id";
        mysqli_query($conn, $sql3) or die(mysqli_error($conn));
    }
}