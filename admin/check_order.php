<?php
include_once("../config.php");
$order_count = $_REQUEST['order_count'];
$property_id = $_REQUEST['property_id'];
$userid = $_REQUEST['userid'];
$catgry = $_REQUEST['catgry'];
$today = date("Ymd");
$order = array();
$order_count = 0;
if($catgry == 3){
  $notification_sql = "select count(*) as ordcnt from posord a where property_id=$property_id and tblnub in (select tblnub from posout b where a.rescod=b.rescod and userid='$userid' and property_id=$property_id and appdat = (select max(appdat) from posout c where b.userid=c.userid and appdat <= $today )) and order_id in (select distinct order_id from posord where status ='ordered')";
}else{
  $notification_sql = "select count(*) as ordcnt from posord where property_id=$property_id and order_id in (select distinct order_id from posord where property_id=$property_id and  status ='ordered')";
}
$notification_result = mysqli_query($conn, $notification_sql);
while ($notification_row = mysqli_fetch_assoc($notification_result)) {
  $order_count = $notification_row['ordcnt'];
}
$order['order_count'] = $order_count;
echo json_encode($order,true);