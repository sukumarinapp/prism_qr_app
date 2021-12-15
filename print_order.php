<?php
session_start();
include "config.php";
include_once("functions.php");
$sales = $_REQUEST['sales'];
foreach($sales as $sale){
    echo $sale['printitemid']."\n";
}