<?php
set_time_limit(0);
$kot_url = "";
$sql = "select * from prmmne where property_id='$property_id' and SRLNUB='997'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
  $kot_url = trim($row['STR001']);
}

if((trim($kot_url)=="") || (trim($kot_url) == "IIS_IP_AND_PORT")){
    $kot_url = "http://prismblr.com/kot/kotapi.php";
}else{
    $kot_url = "http://" .$kot_url . "/PosIntegration.svc/PostOrderData";
}

$data['ORDER_ID'] = $order_id;
$data['BilDat'] = date("Ymd");
$data['PaxPer'] = 1;
$data['Rescod'] = $rescod;
$data['Stwcod'] = "QR";
$data['TblNub'] = $tblnub.$table_suffix;
$data['kot'] = array();
for ($i = 0; $i < count($sales_array); $i++) {
	$data['kot'][$i]['ITMNAM'] = $sales_array[$i]->itmnam;
	$data['kot'][$i]['ITMVAL'] = $sales_array[$i]->itmval;
	$data['kot'][$i]['ITMCOD'] = $sales_array[$i]->itmcod;
	$data['kot'][$i]['QUANTY'] = $sales_array[$i]->quantity;
	$data['kot'][$i]['RATAMT'] = $sales_array[$i]->itmrat;
	$data['kot'][$i]['TAXSTR'] = $sales_array[$i]->taxstr;
	$data['kot'][$i]['TAXAMT'] = $sales_array[$i]->tax;
	$data['kot'][$i]['MODAMT'] = 0;
	$data['kot'][$i]['MENCOD'] = $sales_array[$i]->mentyp;
	$data['kot'][$i]['MENGRP'] = $sales_array[$i]->mengrp;
	$data['kot'][$i]['Modifier'] = array();
}
$ch = curl_init($kot_url);
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
echo $response;