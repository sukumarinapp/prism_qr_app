<?php
#header('Access-Control-Allow-Origin: *'); 
#header('Access-Control-Allow-Methods: POST,GET,OPTIONS');
#header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
//ALTER TABLE `set090` ADD `qr_code_url` VARCHAR(500) NULL AFTER `shtnam`, ADD `qr_code` VARCHAR(500) NULL AFTER `qr_code_url`;

//ALTER TABLE `posmas` ADD `DESCRP` VARCHAR(500) NULL AFTER `MENTYP`;
set_time_limit(0);
$response['message'] = "";
include "config.php";
include "phpqrcode/qrlib.php";
$json = file_get_contents('php://input');
$data = json_decode($json, true);
//print_r($data);
$COMNAM = trim($data['COMNAM']);
$CSTCOD = isset($data['CSTCOD']) ? trim($data['CSTCOD']) : "";

if($CSTCOD==""){
	$response['message'] = "CSTCOD in empty in request";
	echo json_encode($response);
	die;
}
$property_id = 0;

$propert_inserted = false;
$sql = "select * from prmlic where cstcod='$CSTCOD'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
	$property_id = $row['id'];
	$propert_inserted = true;
}
if(!$propert_inserted){
	$stmt = $conn->prepare("insert into prmlic (cstcod,comnam) VALUES (?,?)");
	$stmt->bind_param("ss",$CSTCOD, $COMNAM);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
	$property_id = $stmt->insert_id;
}

$prmmne = $data['prmmne'];
$sql = "delete from prmmne where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($prmmne as $key => $value) {
	$SRLNUB =  $value['SRLNUB'];
	$STR001 =  $value['STR001'];
	$NUB001 =  $value['NUB001'];

	$stmt = $conn->prepare("insert into prmmne (property_id,SRLNUB,STR001,NUB001) VALUES (?,?,?,?)");
	$stmt->bind_param("ssss",$property_id,$SRLNUB,$STR001,$NUB001);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
}

$set250 = $data['set250'];
$sql = "delete from set250 where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($set250 as $key => $value) {
	$APPDAT =  $value['APPDAT'];
	$MODCOD =  $value['MODCOD'];
	$TAXSTR =  $value['TAXSTR'];
	$SRLNUB =  $value['SRLNUB'];
	$DESCRP =  $value['DESCRP'];
	$SCRTAX =  $value['SCRTAX'];
	$CALTYP =  $value['CALTYP'];
	$AMOUNT =  $value['AMOUNT'];
	$TRGTAX =  $value['TRGTAX'];
	$TRGSLB =  $value['TRGSLB'];
	$FUTER1 =  $value['FUTER1'];
	$FUTER2 =  $value['FUTER2'];
	$DELFLG =  $value['DELFLG'];

	$stmt = $conn->prepare("insert into set250 (property_id,APPDAT,MODCOD,TAXSTR,SRLNUB,DESCRP,SCRTAX,CALTYP,AMOUNT,TRGTAX,TRGSLB,FUTER1,FUTER2,DELFLG) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("ssssssssssssss",$property_id,$APPDAT,$MODCOD,$TAXSTR,$SRLNUB,$DESCRP,$SCRTAX,$CALTYP,$AMOUNT,$TRGTAX,$TRGSLB,$FUTER1,$FUTER2,$DELFLG);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
}

/*$set102 = $data['set102'];
$sql = "delete from set102 where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($set102 as $key => $value) {
	$ITMCOD =  $value['ITMCOD'];
	$SRLNUB =  $value['SRLNUB'];
	$STR001 =  $value['STR001'];
	$STR002 =  $value['STR002'];
	$NUB001 =  $value['NUB001'];
	$NUB002 =  $value['NUB002'];
	$ITMIMG =  $value['ITMIMG'];

	$stmt = $conn->prepare("insert into set102 (property_id,ITMCOD,SRLNUB,STR001,STR002,NUB001,NUB002,ITMIMG) VALUES (?,?,?,?,?,?,?,?)");
	$stmt->bind_param("ssssssss",$property_id,$ITMCOD,$SRLNUB,$STR001,$STR002,$NUB001,$NUB002,$ITMIMG);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
}*/

$outlet = $data['outlet'];
foreach ($outlet as $key => $value) {
	$RESCOD =  $value['RESCOD'];
	$sql = "select * from set090 where property_id='$property_id' and RESCOD='$RESCOD'";
	$result = mysqli_query($conn, $sql);
	if(!mysqli_num_rows($result)){
		$LNGNAM =  $value['LNGNAM'];
		$SHTNAM =  $value['SHTNAM'];
		$RNDTYP =  $value['RNDTYP'];
		$RNDAMT =  $value['RNDAMT'];
		$qr_code_url = "";//$base_url."?cstcod=$CSTCOD&rescod=$RESCOD";	
		$qr_file_name = "";//$CSTCOD."_".$RESCOD.".png";
		//QRcode::png($qr_code_url, "qr/$qr_file_name", QR_ECLEVEL_H, 3, 10);
		$stmt = $conn->prepare("insert into set090 (property_id,rescod,lngnam,RNDTYP,RNDAMT,shtnam,qr_code_url,qr_code) VALUES (?,?,?,?,?,?,?,?)");
		$stmt->bind_param("ssssssss",$property_id,$RESCOD,$LNGNAM,$RNDTYP,$RNDAMT,$SHTNAM,$qr_code_url,$qr_file_name);
		if(!$stmt->execute()){
			$response['message'] = $stmt->error;
			echo json_encode($response);
			die;
		}
	}
}

$table = $data['table'];
foreach ($table as $key => $value) {
	$RESCOD =  $value['RESCOD'];
	$TBLNUB =  $value['TBLNUB'];
	$sql = "select * from set220 where property_id='$property_id' and RESCOD='$RESCOD' and TBLNUB='$TBLNUB'";
	$result = mysqli_query($conn, $sql);
	if(!mysqli_num_rows($result)){
		$qr_code_url = $base_url."/login.php?cstcod=$CSTCOD&rescod=$RESCOD&tblnub=$TBLNUB";
		$qr_file_name = $CSTCOD."_".$RESCOD."_".$TBLNUB.".png";
		QRcode::png($qr_code_url, "qr/$qr_file_name", QR_ECLEVEL_H, 3, 10);
		$stmt = $conn->prepare("insert into set220 (
		property_id,rescod,tblnub,qr_code_url,qr_code) VALUES (?,?,?,?,?)");
		$stmt->bind_param("sssss",$property_id,$RESCOD,$TBLNUB,$qr_code_url,$qr_file_name);
		if(!$stmt->execute()){
			$response['message'] = $stmt->error;
			echo json_encode($response);
			die;
		}
		die;
	}
}

$prmmod = $data['prmmod'];
$sql = "delete from prmmod where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($prmmod as $key => $value) {
	$MODCOD =  $value['MODCOD'];
	$SRLNUB =  $value['SRLNUB'];
	$DESCRP =  $value['DESCRP'];
	$YESNOO =  $value['YESNOO'];

	$stmt = $conn->prepare("insert into prmmod (property_id,MODCOD,SRLNUB,DESCRP,YESNOO) VALUES (?,?,?,?,?)");
	$stmt->bind_param("sssss",$property_id,$MODCOD,$SRLNUB,$DESCRP,$YESNOO);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
}



$menuType = $data['menuType'];
$sql = "delete from sys001 where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($menuType as $key => $value) {
	$RECCOD =  $value['RECCOD'];
	$RECTYP =  $value['RECTYP'];
	$DESCRP =  $value['DESCRP'];

	$stmt = $conn->prepare("insert into sys001 (property_id,RECCOD,RECTYP,DESCRP) VALUES (?,?,?,?)");
	$stmt->bind_param("ssss",$property_id,$RECCOD,$RECTYP,$DESCRP);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
}


$menuGroup = $data['menuGroup'];
$sql = "delete from set100 where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($menuGroup as $key => $value) {
	$GRPCOD =  $value['GRPCOD'];
	$LNGNAM =  $value['LNGNAM'];
	$SHTNAM =  $value['SHTNAM'];

	$stmt = $conn->prepare("insert into set100 (property_id,GRPCOD,LNGNAM,SHTNAM) VALUES (?,?,?,?)");
	$stmt->bind_param("ssss",$property_id,$GRPCOD,$LNGNAM,$SHTNAM);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
}

$menu = $data['menu'];
$sql = "delete from posmas where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($menu as $key => $value) {
	$ITMCOD =  $value['ITMCOD'];
	$ITMNAM =  $value['ITMNAM'];
	$MENGRP =  $value['MENGRP'];
	$MENTYP =  $value['MENTYP'];
	$DESCRP =  $value['DESCRP'];

	$stmt = $conn->prepare("insert into posmas (property_id,ITMCOD,ITMNAM,MENGRP,MENTYP,DESCRP) VALUES (?,?,?,?,?,?)");
	$stmt->bind_param("ssssss",$property_id,$ITMCOD,$ITMNAM,$MENGRP,$MENTYP,$DESCRP);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
}

$menuRate = $data['menuRate'];
$sql = "delete from posrat where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($menuRate as $key => $value) {
	$RESCOD =  $value['RESCOD'];
	$ITMCOD =  $value['ITMCOD'];
	$PRICE =  $value['PRICE'];
	$TAXSTR =  $value['TAXSTR'];
	$sql = "insert into posrat (property_id,RESCOD,ITMCOD,PRICE,TAXSTR) values ('$property_id','$RESCOD','$ITMCOD','$PRICE','$TAXSTR')";
	if(!mysqli_query($conn, $sql)){
		$response['message'] = mysqli_error($conn);
		echo json_encode($response);
		die;
	}

}

$set190 = $data['set190'];
$sql = "delete from set190 where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($set190 as $key => $value) {
	$RESCOD =  $value['RESCOD'];
	$SESSON =  $value['SESSON'];
	$FRMTIM =  $value['FRMTIM'];
	$LNGNAM =  $value['LNGNAM'];
	$SHTNAM =  $value['SHTNAM'];
	$TOOTIM =  $value['TOOTIM'];
	$STATUS =  $value['STATUS'];
	$FUTER1 =  $value['FUTER1'];
	$FUTER2 =  $value['FUTER2'];
	$USERID =  $value['USERID'];
	$LSTDAT =  $value['LSTDAT'];

	$stmt = $conn->prepare("insert into set190 (property_id,RESCOD,SESSON,FRMTIM,LNGNAM,SHTNAM,TOOTIM,STATUS,FUTER1,FUTER2,USERID,LSTDAT) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("ssssssssssss",$property_id,$RESCOD,$SESSON,$FRMTIM,$LNGNAM,$SHTNAM,$TOOTIM,$STATUS,$FUTER1,$FUTER2,$USERID,$LSTDAT);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
}

$prmusr = $data['prmusr'];
$sql = "delete from prmusr where property_id='$property_id'";
mysqli_query($conn, $sql);
foreach ($prmusr as $key => $value) {
	$USERID =  $value['USERID'];
	$LNGNAM =  $value['LNGNAM'];
	$SHTNAM =  $value['SHTNAM'];
	$ISUPER =  $value['ISUPER'];
	$CATGRY =  $value['CATGRY'];
	$PASSWD =  $value['PASSWD'];
	$REQSCH =  $value['REQSCH'];
	$SUNDAY =  $value['SUNDAY'];
	$MONDAY =  $value['MONDAY'];
	$TUEDAY =  $value['TUEDAY'];
	$WEDDAY =  $value['WEDDAY'];
	$THUDAY =  $value['THUDAY'];
	$FRIDAY =  $value['FRIDAY'];
	$SATDAY =  $value['SATDAY'];
	$USRADR =  $value['USRADR'];
	$USRCTY =  $value['USRCTY'];
	$USRSTA =  $value['USRSTA'];
	$USRZIP =  $value['USRZIP'];
	$USRTEL =  $value['USRTEL'];
	$USREML =  $value['USREML'];
	$USRDOJ =  $value['USRDOJ'];
	$USRSAL =  $value['USRSAL'];
	$DELFLG =  $value['DELFLG'];
	$BYWHOM =  $value['BYWHOM'];
	$LSTDAT =  $value['LSTDAT'];
	$RECTYP =  $value['RECTYP'];

	$stmt = $conn->prepare("insert into prmusr (USERID,LNGNAM,SHTNAM,ISUPER,CATGRY,PASSWD,REQSCH,SUNDAY,MONDAY,TUEDAY,WEDDAY,THUDAY,FRIDAY,SATDAY,USRADR,USRCTY,USRSTA,USRZIP,USRTEL,USREML,USRDOJ,USRSAL,DELFLG,BYWHOM,LSTDAT,RECTYP,property_id) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
	$stmt->bind_param("sssssssssssssssssssssssssss",$USERID,$LNGNAM,$SHTNAM,$ISUPER,$CATGRY,$PASSWD,$REQSCH,$SUNDAY,$MONDAY,$TUEDAY,$WEDDAY,$THUDAY,$FRIDAY,$SATDAY,$USRADR,$USRCTY,$USRSTA,$USRZIP,$USRTEL,$USREML,$USRDOJ,$USRSAL,$DELFLG,$BYWHOM,$LSTDAT,$RECTYP,$property_id);
	if(!$stmt->execute()){
		$response['message'] = $stmt->error;
		echo json_encode($response);
		die;
	}
}

$response['message'] = "Uploded successfully";
echo json_encode($response);