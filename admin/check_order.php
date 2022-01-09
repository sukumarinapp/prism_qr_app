<?php
include_once("../config.php");
$order_count = $_REQUEST['order_count'];
$property_id = $_REQUEST['property_id'];
$userid = $_REQUEST['userid'];
$catgry = $_REQUEST['catgry'];
$today = date("Ymd");
$order = array();
$item_count = 0;
if($catgry == 3){
  $sql = "select count(*) as item_count from posord a,poskot b where a.order_id=b.order_id and property_id=$property_id and b.status ='ordered' and tblnub in (select tblnub from posout c where a.rescod=c.rescod and userid='$userid' and property_id=$property_id and appdat = (select max(appdat) from posout d where c.userid=d.userid and appdat <= $today )) ";
}else{
  $sql = "select count(*) as item_count from posord  a,poskot b where a.order_id=b.order_id and  property_id=$property_id and b.status ='ordered'";
}
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
  $item_count = $row['item_count'];
}
$order['item_count'] = $item_count;
echo json_encode($order,true);