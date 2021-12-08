<?php

$kot_url = "";
$sql = "select * from prmmne where property_id='$property_id' and SRLNUB='997'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
  $kot_url = trim($row['STR001']);
}
if((trim($kot_url)=="") || (trim($kot_url) == "IIS_IP_AND_PORT")){
	$kot_url = "http://prismblr.com/kot/payapi.php";
}else{
	$kot_url = "http://" .$kot_url . "/PosIntegration.svc/PostPayment";
}

$data2['ORDER_ID'] = $order_id;
$data2['RESCOD'] = $rescod;
$data2['TBLNUB'] = $tblnub;
$data2['BILDAT'] = date("Ymd");
$data2['BILNUB'] = $order_id;
$data2['AMOUNT'] = $TOTAMT + $TAXAMT;
$data2['TIPS'] = 0;
$ch = curl_init($kot_url);
$payload = json_encode($data2);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
