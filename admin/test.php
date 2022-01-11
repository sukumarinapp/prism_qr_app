<?php
include "../config.php";
$property_id = 1;
$order_id = 7;
$today = date("Ymd");
$response =array();
$sql = "select * from  posord where property_id=$property_id and order_id=$order_id";
$result = mysqli_query($conn, $sql);
$i=0;
while ($row = mysqli_fetch_assoc($result)) {
    $tblnub = $row['tblnub'];
    $rescod = $row['rescod'];
    $response['ORDER_ID'] = "ORDPRISMAPP-".$row['order_id'];
    $response['PaxPer'] = 1;
    $response['BILNUB'] = "BILL".$row['order_id'];
    $response['Rescod'] = $rescod;
    $response['TblNub'] = $tblnub;

    $sql2 = "select kotdat from poskot where order_id=$order_id limit 1";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
       $response['BilDat'] = $row2['kotdat']; 
    }

    $sql2 = "select userid from posout where rescod='$rescod' and tblnub='$tblnub' and property_id=$property_id and appdat = (select max(appdat) from posout d where tblnub='$tblnub'  and appdat <= $today )";
    $result2 = mysqli_query($conn, $sql2);
    while ($row2 = mysqli_fetch_assoc($result2)) {
       $response['STWCOD'] = $row2['userid']; 
    }
}
echo json_encode($response);