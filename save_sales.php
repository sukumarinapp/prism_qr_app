'<?php
session_start();
$order_id = 0;
include "config.php";
include_once("functions.php");
$rescod = $_REQUEST['rescod'];
$property_id = $_REQUEST['property_id'];
$tblnub = $_REQUEST['tblnub'];
$mobile = $_REQUEST['mobile'];
$sales = $_REQUEST['sales'];
$sales = stripslashes($sales);
$sales_array = array();
$sales_array = json_decode($sales);
$status = "pending";

$conn->autocommit(FALSE);

$table_suffix = "";

$sql = "select * from posord where property_id='$property_id' and rescod='$rescod' and tblnub='$tblnub' and status='ordered' and mobile='$mobile'"; 
$result = mysqli_query($conn, $sql);
if(mysqli_num_rows($result) > 0){
	$row = mysqli_fetch_array($result);
	$order_id = $row['order_id'];
}else{
    
    $sql2 = "select * from posord where property_id='$property_id' and rescod='$rescod' and tblnub='$tblnub' and status='ordered' and mobile<>'$mobile' order by order_id desc limit 1"; 
    $result2 = mysqli_query($conn, $sql2);
    if(mysqli_num_rows($result2) > 0){
        $row2 = mysqli_fetch_array($result2);
        $table_suffix = $row2['table_suffix'];
        if($table_suffix==""){
            $table_suffix = 'A';
        }else{
            $table_suffix = ++$table_suffix;
        }
    }

	$stmt = $conn->prepare("INSERT INTO posord (property_id,rescod,tblnub,table_suffix,status,mobile) VALUES (?,?,?,?,?,?)");
	$stmt->bind_param("ssssss",$property_id, $rescod,$tblnub,$table_suffix,$status,$mobile);
	$stmt->execute() or die($stmt->error);
	$order_id = $stmt->insert_id;	
}
$itmval = 0;
$kotdat = date("Ymd");
for ($i = 0; $i < count($sales_array); $i++) {
    $sales_array[$i]->itmval = $sales_array[$i]->itmrat * $sales_array[$i]->quantity;
    insert_tax($sales_array[$i]->taxstr,$sales_array[$i]->itmval,$rescod,$order_id);
    tax_on_tax($sales_array[$i]->taxstr,$rescod,$order_id);    
    $sales_array[$i]->tax = calculate_tax($sales_array[$i]->taxstr,$sales_array[$i]->itmval,$rescod);
}
include "insert_kot.php";
if (strpos($response, 'Success') == false) {
    $conn->rollback();
}else{
    $response = json_decode($response);
    $kotnub = $response[0]->KotNub;
    $kotsrl = 1;
    $status = "pending";
    for ($i = 0; $i < count($sales_array); $i++) {
        $itmcod = $sales_array[$i]->itmcod;
        $itmnam = $sales_array[$i]->itmnam;
        $itmrat = $sales_array[$i]->itmrat;
        $quantity = $sales_array[$i]->quantity;
        $itmval = $sales_array[$i]->itmval;
        $taxamt = $sales_array[$i]->tax;
        //ALTER TABLE `poskot` ADD `taxamt` DECIMAL(10,0) NOT NULL DEFAULT '0' AFTER `itmval`;
        $sql = "INSERT INTO poskot (order_id,kotdat,kotnub,kotsrl,itmcod,itmnam,itmrat,itmqty,itmval,taxamt,status) VALUES  ($order_id,'$kotdat','$kotnub',$kotsrl,'$itmcod','$itmnam',$itmrat,$quantity,$itmval,$taxamt,'$status')";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        $kotsrl++;
    }
    $conn->commit();    
}
