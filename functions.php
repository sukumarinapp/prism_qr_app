<?php
//include_once("config.php");
//insert_tax("1","100.00","AKO","1");
//tax_on_tax("1","AKO","1");
function insert_tax($taxstr,$amount,$rescod,$order_id){
	$appdat = date("Ymd");
	$sql = "SELECT * FROM set250 WHERE TRGTAX > 900 AND MODCOD = '$rescod' and TAXSTR='$taxstr'";
	$sql = $sql . " AND DELFLG = 0 AND APPDAT = (SELECT MAX(APPDAT) FROM set250 WHERE";
	$sql = $sql . " TRGTAX > 900 AND MODCOD = '$rescod' AND DELFLG = 0 AND TAXSTR ='$taxstr' AND APPDAT <= '$appdat') ORDER BY SRLNUB";
	$result = mysqli_query($GLOBALS['conn'], $sql) or die(mysqli_error($conn));
	while($row = mysqli_fetch_array($result)){
		$taxcod = $row['SCRTAX'];
		$srlnub = $row['SRLNUB'];
		$taxper = number_clean($row['AMOUNT']);

		$descrp = $row['SCRTAX']."@".$taxper."%";
		$taxamt = $amount * $taxper/100;
		$taxabl = 0;
		$sql2 = "select * from postax where order_id='$order_id' and taxcod='$taxcod'";
		$result2 = mysqli_query($GLOBALS['conn'], $sql2) or die(mysqli_error($conn));
		if(mysqli_num_rows($result2) > 0){
			$sql3 = "update postax set taxamt=taxamt+$taxamt,taxabl=taxabl+$amount where order_id='$order_id' and taxcod='$taxcod'";
			mysqli_query($GLOBALS['conn'], $sql3) or die(mysqli_error($conn));
		}else{
			$sql3 = "insert into postax (order_id,taxcod,srlnub,descrp,taxper,taxabl,taxamt) values ('$order_id','$taxcod',$srlnub,'$descrp','$taxper','$amount','$taxamt')";
			mysqli_query($GLOBALS['conn'], $sql3) or die(mysqli_error($conn));
		}
	}
}

function tax_on_tax($taxstr,$rescod,$order_id){
	$tax = 0;
	$appdat = date("Ymd");
	$sql = "SELECT * FROM set250 WHERE TRGTAX < 900 AND MODCOD = '$rescod' and TAXSTR='$taxstr'";
	$sql = $sql . " AND DELFLG = 0 AND APPDAT = (SELECT MAX(APPDAT) FROM set250 WHERE";
	$sql = $sql . " TRGTAX < 900 AND MODCOD = '$rescod' AND DELFLG = 0 AND TAXSTR ='$taxstr' AND APPDAT <= '$appdat') ORDER BY SRLNUB";
	$result = mysqli_query($GLOBALS['conn'], $sql) or die(mysqli_error($conn));
	while($row = mysqli_fetch_array($result)){
		$taxcod = $row['SCRTAX'];		
		$trgtax = $row['TRGTAX'];		
		$taxper = $row['AMOUNT'];
		$sql2 = "select * from postax where order_id='$order_id' and srlnub=$trgtax";
		$result2 = mysqli_query($GLOBALS['conn'], $sql2) or die(mysqli_error($conn));
		if(mysqli_num_rows($result2) > 0){
			while($row2 = mysqli_fetch_array($result2)){
				$amount = $row2['taxamt'];
				$tax = $tax + $amount;
				$taxamt = $amount * $taxper/100;
				$tax = $tax + $taxamt;
				$sql3 = "update postax set taxamt=taxamt+$taxamt,taxabl=taxabl+$amount where order_id='$order_id' and taxcod='$taxcod'";
				mysqli_query($GLOBALS['conn'], $sql3) or die(mysqli_error($conn));
			}
		}
	}
	return $tax;
}

function calculate_tax($taxstr,$amount,$rescod){
	$appdat = date("Ymd");
	$sql = "SELECT * FROM set250 WHERE TRGTAX > 900 AND MODCOD = '$rescod' and TAXSTR='$taxstr'";
	$sql = $sql . " AND DELFLG = 0 AND APPDAT = (SELECT MAX(APPDAT) FROM set250 WHERE";
	$sql = $sql . " TRGTAX > 900 AND MODCOD = '$rescod' AND DELFLG = 0 AND TAXSTR ='$taxstr' AND APPDAT <= '$appdat') ORDER BY SRLNUB";
	$result = mysqli_query($GLOBALS['conn'], $sql) or die(mysqli_error($conn));
	$taxamt = 0.0;
	while($row = mysqli_fetch_array($result)){
		$taxper = number_clean($row['AMOUNT']);
		$taxamt = $taxamt +($amount * $taxper/100);		
	}
	return $taxamt;
}

function number_clean($num){ 

  //remove zeros from end of number ie. 140.00000 becomes 140.
  $clean = rtrim($num, '0');
  //remove zeros from front of number ie. 0.33 becomes .33
  $clean = ltrim($clean, '0');
  //remove decimal point if an integer ie. 140. becomes 140
  $clean = rtrim($clean, '.');

  return $clean;
}