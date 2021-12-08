<?php
include "config.php";
$rescod="AKO";
$NETAMT = 5.3;
$sql = "select * from set090 where rescod='$rescod'";
$result = mysqli_query($conn, $sql);
$RNDTYP =  0;
$RNDAMT =  0;
while($row = mysqli_fetch_array($result)){
	$RNDTYP = $row['RNDTYP'];
	$RNDAMT = $row['RNDAMT'];
}

$RNDTYP  =3;
$RNDAMT = 1;

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


echo $NETAMT;

echo "<br>";

echo $NETAMT2;

$RONDOF = $NETAMT2-$NETAMT;

echo "<br>";

echo $RONDOF;