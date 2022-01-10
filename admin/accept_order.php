<?php
session_start();
include "../config.php";
$property_id = $_REQUEST['property_id'];
$order_id = $_REQUEST['order_id'];
$sales = $_REQUEST['sales'];
$sales = stripslashes($sales);
$sales_array = array();
$sales_array = json_decode($sales);
$status = "accepted";
for ($i = 0; $i < count($sales_array); $i++) {
    $status = $sales_array[$i]->status;
    $itmsrl = $sales_array[$i]->itmsrl;
    if($status == "accepted"){
        $sql = "update poskot set status='$status' where order_id=$order_id and id = $itmsrl";
    }else{
        $sql = "delete from poskot where order_id = $order_id and id = $itmsrl";
    }
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
}
