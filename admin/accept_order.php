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
$kotid = "";
for ($i = 0; $i < count($sales_array); $i++) {
    $status = $sales_array[$i]->status;
    $itmsrl = $sales_array[$i]->itmsrl;
    $kotid = $kotid . $itmsrl;
    if($i != count($sales_array) - 1) $kotid = $kotid . ",";
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
   $order_id = $row['order_id'];
   $response['ORDER_ID'] = "ORDPRISMAPP-".$row['order_id'];
   $response['PaxPer'] = 1;
   $response['BILNUB'] = "BILLPRISMAPP-".$row['order_id'];
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
   $i = 0;
   $sql2 = "select * from poskot where order_id = $order_id and id in (".$kotid.") order by id";
   $result2 = mysqli_query($conn, $sql2);
   while ($row2 = mysqli_fetch_assoc($result2)) {
      $itmcod = $row2['itmcod']; 
      $response['kot'][$i]['itmcod'] = $itmcod; 
      $response['kot'][$i]['ITMSRL'] = $row2['kotsrl']; 
      $response['kot'][$i]['ITMVAL'] = $row2['itmval']; 
      $response['kot'][$i]['itmnam'] = $row2['itmnam']; 
      $response['kot'][$i]['Modifier'] = array();
      $response['kot'][$i]['QUANTY'] = $row2['itmqty']; 
      $response['kot'][$i]['RATAMT'] = $row2['itmrat']; 
      $sql3 = "select * from posrat where property_id = $property_id and itmcod = $itmcod and rescod='$rescod'";
      $result3 = mysqli_query($conn, $sql3);
      while ($row3 = mysqli_fetch_assoc($result3)) {
         $response['kot'][$i]['TAXSTR'] = $row3['TAXSTR']; 
      } 
      $response['kot'][$i]['TAXAMT'] = $row2['taxamt']; 
      $response['kot'][$i]['MODAMT'] = 0; 
      $sql3 = "select * from posmas where property_id = $property_id and itmcod = $itmcod";
      $result3 = mysqli_query($conn, $sql3);
      while ($row3 = mysqli_fetch_assoc($result3)) {
         $response['kot'][$i]['MENGRP'] = $row3['MENGRP']; 
         $response['kot'][$i]['MENCOD'] = $row3['MENTYP'];
      } 
      $i++;
   }
}
echo json_encode($response);

