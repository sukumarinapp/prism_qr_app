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

$today = date("Ymd");
$response =array();
$sql = "select * from  posord where property_id=$property_id and order_id=$order_id";
$result = mysqli_query($conn, $sql);
$i=0;
while ($row = mysqli_fetch_assoc($result)) {
    $tblnub = $row['tblnub'];
    $rescod = $row['rescod'];
    $response['ORDER_ID'] = "ORDPRISMAPP-"+$row['order_id'];
    $response['PaxPer'] = 1;
    $response['BILNUB'] = "BILL"+$row['order_id'];
    $response['Rescod'] = $rescod;
    $response['TblNub'] = $tblnub;

    $sql2 = "select kotdat from poskot where order_id=$order_id linit 1";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
       $response['BilDat'] = $row['kotdat']; 
    }

    $sql2 = "select userid from posout where rescod='$rescod' and tblnub='$tblnub' and property_id=$property_id and appdat = (select max(appdat) from posout d where tblnub='$tblnub'  and appdat <= $today )";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
       $response['STWCOD'] = $row['userid']; 
    }
}
