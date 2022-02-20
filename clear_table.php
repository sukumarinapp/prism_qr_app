<?php
include_once("config.php");
$ordnub = isset($_REQUEST['ordnub']) ? $_GET['ordnub']: "";
$sql = "update posord set status='settled' where ORDNUB='$ordnub'";
mysqli_query($conn, $sql);

$order_id = 0;
$sql = "select * from  posord where ORDNUB='$ordnub'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
    $order_id = $row['order_id'];
}

$sql = "update poskot set status='settled' where order_id=$order_id";
mysqli_query($conn, $sql);

$response = array();
$response['message'] = "success";
echo json_encode($response);