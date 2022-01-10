<?php 
include "config.php";
$response = array();
$status = 'settled';
$ordrid = $_REQUEST['ordrid'];
$cstcod = $_REQUEST['cstcod'];
$property_id = 0;
$sql = "select * from prmlic where cstcod='$cstcod'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
	$property_id = $row['id'];
}
$sql = "update posord set status='$status' where order_id=$ordrid and property_id = $property_id";
$result = mysqli_query($conn, $sql);
$sql = "update poskot set status='$status' where order_id=$ordrid";
$result = mysqli_query($conn, $sql);
$response['message'] = "success";
$response['status'] = $status;
echo json_encode($response);