<?php
$data = array();
$data['BilNub'] = 0;
$data['Message'] = "";
$data['Status'] = "Success";
$response = array();
array_push($response, $data);
echo json_encode($response);
