<?php
include "config.php";
$order_id = 'dummy';
$bilnub = 0;
$stmt = $conn->prepare("INSERT INTO bill (order_id) VALUES (?)");
$stmt->bind_param("s",$order_id);
$stmt->execute() or die($stmt->error);
$bilnub = $stmt->insert_id;	
$data = array();
$data['BilNub'] = $bilnub;
$data['Message'] = "";
$data['Status'] = "Success";
$response = array();
array_push($response, $data);
echo json_encode($response);
