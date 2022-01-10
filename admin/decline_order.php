<?php
session_start();
include "../config.php";
$property_id = $_REQUEST['property_id'];
$order_id = $_REQUEST['order_id'];
$sales = $_REQUEST['sales'];
$sales = stripslashes($sales);
$sales_array = array();
$sales_array = json_decode($sales);
for ($i = 0; $i < count($sales_array); $i++) {
    $itmsrl = $sales_array[$i]->itmsrl;
    $sql = "delete from poskot where order_id = $order_id and id = $itmsrl";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
}
$sql = "select * from poskot where order_id = $order_id"; 
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
}else{
	$sql = "delete from posord where order_id = $order_id";
    mysqli_query($conn, $sql) or die(mysqli_error($conn));
}
