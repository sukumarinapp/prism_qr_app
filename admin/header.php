<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo $_SESSION['comnam']; ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
</head>
<style>
   .badge {
     border-radius: 0;
     font-size: 20px;
     line-height: 1;
     padding: .375rem .5625rem;
     font-weight: bold;
     padding-left: 10px;
 }

</style>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <ul class="navbar-nav">

 <?php
  $order_count=0;
  if($CATGRY == 3){
    $notification_sql = "select count(*) as ordcnt from posord a where property_id=$property_id and tblnub in (select tblnub from posout b where a.rescod=b.rescod and userid='$USERID' and property_id=$property_id and appdat = (select max(appdat) from posout c where b.userid=c.userid and appdat <= $today )) and order_id in (select distinct order_id from posord where status ='ordered')";
  }else{
    $notification_sql = "select count(*) as ordcnt from posord where property_id=$property_id and order_id in (select distinct order_id from posord where property_id=$property_id and  status ='ordered')";
  }
  $notification_result = mysqli_query($conn, $notification_sql);
  while ($notification_row = mysqli_fetch_assoc($notification_result)) {
    $order_count = $notification_row['ordcnt'];
  }
?>
        <li class="nav-item" style="padding-left: 20px;">
          <div id="order_count_badge" class="badge badge-success"><?php echo $order_count; ?></div>
        </li>
      </ul>
  </nav>
