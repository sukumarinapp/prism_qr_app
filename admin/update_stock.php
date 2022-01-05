<?php
include_once("../config.php");
$itmcod = $_REQUEST['itmcod'];
$STKOUT = $_REQUEST['STKOUT'];
$property_id = $_REQUEST['property_id'];
$sql = "update posmas set STKOUT=$STKOUT where ITMCOD=$itmcod and property_id=$property_id";
mysqli_query($conn, $sql);
