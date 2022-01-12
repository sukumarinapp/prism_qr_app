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
    //mysqli_query($conn, $sql) or die(mysqli_error($conn));
}
$today = date("Ymd");
$payload =array();
$sql = "select * from  posord where property_id=$property_id and order_id=$order_id";
$result = mysqli_query($conn, $sql);
$i=0;
while ($row = mysqli_fetch_assoc($result)) {
   $tblnub = $row['tblnub'];
   $rescod = $row['rescod'];
   $order_id = $row['order_id'];
   $payload['ORDER_ID'] = "ORDPRISMAPP-".$row['order_id'];
   $payload['PaxPer'] = 1;
   $payload['BILNUB'] = "BILLPRISMAPP-".$row['order_id'];
   $payload['Rescod'] = $rescod;
   $payload['TblNub'] = $tblnub;

   $sql2 = "select kotdat from poskot where order_id=$order_id limit 1";
   $result2 = mysqli_query($conn, $sql2);
   while ($row2 = mysqli_fetch_assoc($result2)) {
      $payload['BilDat'] = $row2['kotdat']; 
   }

   $sql2 = "select userid from posout where rescod='$rescod' and tblnub='$tblnub' and property_id=$property_id and appdat = (select max(appdat) from posout d where tblnub='$tblnub'  and appdat <= $today )";
   $result2 = mysqli_query($conn, $sql2);
   while ($row2 = mysqli_fetch_assoc($result2)) {
      $payload['STWCOD'] = $row2['userid']; 
   }
   $i = 0;
   $sql2 = "select * from poskot where order_id = $order_id and id in (".$kotid.") order by id";
   $result2 = mysqli_query($conn, $sql2);
   while ($row2 = mysqli_fetch_assoc($result2)) {
      $itmcod = $row2['itmcod']; 
      $payload['kot'][$i]['itmcod'] = $itmcod; 
      $payload['kot'][$i]['ITMSRL'] = $row2['kotsrl']; 
      $payload['kot'][$i]['ITMVAL'] = $row2['itmval']; 
      $payload['kot'][$i]['itmnam'] = $row2['itmnam']; 
      $payload['kot'][$i]['Modifier'] = array();
      $payload['kot'][$i]['QUANTY'] = $row2['itmqty']; 
      $payload['kot'][$i]['RATAMT'] = $row2['itmrat']; 
      $sql3 = "select * from posrat where property_id = $property_id and itmcod = $itmcod and rescod='$rescod'";
      $result3 = mysqli_query($conn, $sql3);
      while ($row3 = mysqli_fetch_assoc($result3)) {
         $payload['kot'][$i]['TAXSTR'] = $row3['TAXSTR']; 
      } 
      $payload['kot'][$i]['TAXAMT'] = $row2['taxamt']; 
      $payload['kot'][$i]['MODAMT'] = 0; 
      $sql3 = "select * from posmas where property_id = $property_id and itmcod = $itmcod";
      $result3 = mysqli_query($conn, $sql3);
      while ($row3 = mysqli_fetch_assoc($result3)) {
         $payload['kot'][$i]['MENGRP'] = $row3['MENGRP']; 
         $payload['kot'][$i]['MENCOD'] = $row3['MENTYP'];
      } 
      $i++;
   }
}

$post_url = "http://122.166.197.63:98/PosIntegration.svc/PostOrderData";
$curl = curl_init($post_url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'content-type: application/json'));
$response = curl_exec($curl);
print_r($response);
if (curl_errno($curl)) {
    $error_msg = curl_error($curl);
}
curl_close($curl);
$response = json_decode($response);
$status = $response->Status;
$kotnub = $response->KotNub;
$response = array();
$response['status'] = $Status;
$response['kotnub'] = $kotnub;
echo json_encode($response);
