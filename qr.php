<!DOCTYPE html>
<html lang="en">
<head>
	<title>Digital Menu</title>
	<link rel="icon" href="favico.ico">
	<style>
        tr:nth-child(even) {background-color: green;}
        tr:nth-child(odd) {background-color: green;}
    </style>
</head>
<body>
<?php
include "config.php";
$cstcod = $_REQUEST['cstcod'];
$property_id = 0;
$comnam = "";
$sql = "select * from prmlic where cstcod='$cstcod'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
	$property_id = $row['id'];
	$comnam = $row['comnam'];
}
if($property_id != 0){
	$sql = "select * from set090 where property_id='$property_id' order by RESCOD";
	$result = mysqli_query($conn, $sql);
	echo "<table style='width:100%' border='1' align='center'>";
	echo "<tr><td style='font-weight:bold;color:white' align='center' colspan='3'><h1>".$cstcod." ".$comnam."</h1></td></tr>";
	echo "<tr style='font-weight:bold;color:white'><td align='center'><h1>Table#</h1></td><td align='center'><h1>URL</h1></td><td align='center'><h1>QR Code</h1></td></tr>";
	while($row = mysqli_fetch_assoc($result)){
		$RESCOD =  $row['rescod'];
		echo "<tr style='background-color:orange;color:white;font-weight:bold;text-align:center'><td colspan='4'><h1>".$row['rescod']." ".$row['lngnam']."</h1></td></td></tr>";
		$sql2 = "select * from set220 where property_id='$property_id' and RESCOD='$RESCOD' order by TBLNUB";
		$result2 = mysqli_query($conn, $sql2);
		while($row2 = mysqli_fetch_assoc($result2)){
			echo "<tr style='color:white;font-weight:bold;'><td align='center' style='font-weight:bold'><h1>".$row2['tblnub']."</h1></td><td><a style='color:blue' href='".$row2['qr_code_url']."'>".$row2['qr_code_url']."</a></td><td><img width='300' height='300' src='qr/".$row2['qr_code']."' /></td></tr>";
		}
	}
	echo "<table>";
}else{
	echo "cstcod not found";
}
?>
</body>
</html>