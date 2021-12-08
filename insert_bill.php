<?php

$kot_url = "";
$sql = "select * from prmmne where property_id='$property_id' and SRLNUB='997'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
  $kot_url = trim($row['STR001']);
}
if((trim($kot_url)=="") || (trim($kot_url) == "IIS_IP_AND_PORT")){
	$kot_url = "http://prismblr.com/kot/bilapi.php";
}else{
	$kot_url = "http://" .$kot_url . "/PosIntegration.svc/PostBillPrint";
}
$data['ORDER_ID'] = $order_id;
$data['RESCOD'] = $rescod;
$data['TBLNUB'] = $tblnub;
$data['BILDAT'] = date("Ymd");
$data['BILNUB'] = $order_id;
$data['DISCNT'] = 0;
$data['TAX'] = array();
$TOTAMT = 0;
$TAXAMT = 0;

$sql = "select * from poskot where order_id='$order_id'";
$result = mysqli_query($conn, $sql);
$i=0;
while($row = mysqli_fetch_array($result)){
	$TOTAMT = $TOTAMT + $row['itmval'];
}

$sql = "select * from postax where order_id='$order_id'";
$result = mysqli_query($conn, $sql);
$i=0;
while($row = mysqli_fetch_array($result)){
	$TAXAMT = $TAXAMT + $row['taxamt'];
	$data['TAX'][$i]['TAXSTR'] = $row['taxcod'];
	$data['TAX'][$i]['VALAMT'] = $row['taxamt'];
	$data['TAX'][$i]['RATAMT'] = $row['taxper'];
	$data['TAX'][$i]['TAXABL'] = $row['taxabl'];
	$i++;
}

$data['TOTAMT'] = $TOTAMT;
$data['TAXAMT'] = $TAXAMT;
$NETAMT = $TOTAMT + $TAXAMT;

$sql = "select * from set090 where rescod='$rescod'";
$result = mysqli_query($conn, $sql);
$RNDTYP =  0;
$RNDAMT =  0;
while($row = mysqli_fetch_array($result)){
	$RNDTYP = $row['RNDTYP'];
	$RNDAMT = $row['RNDAMT'];
}
$NETAMT2 = 0;
if($RNDTYP==0){
	$NETAMT2 = $NETAMT;
}else if($RNDTYP==1){
	$NETAMT2 = round($NETAMT / $RNDAMT) * $RNDAMT;
}else if($RNDTYP==2){
	$NETAMT2 = ceil($NETAMT / $RNDAMT) * $RNDAMT;
}else if($RNDTYP==3){	
	$NETAMT2 = floor($NETAMT / $RNDAMT) * $RNDAMT;
}

$data['NETAMT'] = $NETAMT2;
$RONDOF = $NETAMT2-$NETAMT;
$data['RONDOF'] = $RONDOF;

$ch = curl_init($kot_url);
$payload = json_encode($data);
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
