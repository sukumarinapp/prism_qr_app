<?php 
include "config.php";
$response = array();
$sync_status = 'synchronized';
if(isset($_REQUEST['order_reference_id'])) $order_reference_id = $_REQUEST['order_reference_id'];
$i = 0;
foreach($order_reference_id as $ref_id){
	$stmt = $conn->prepare("UPDATE urban_payload set sync_status=? where id=?");
	$stmt->bind_param("ss", $sync_status,$ref_id);
	$stmt->execute() or die($stmt->error);
	$response['order_reference_id'][$i] = $ref_id;
	$i++;
}
$response['message'] = "success";
$response['sync_status'] = $sync_status;

echo json_encode($response);