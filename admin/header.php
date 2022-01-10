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
    <?php
    $CATGRY = $_SESSION['CATGRY'];
    $USERID = $_SESSION['USERID'];
    $order_count=0;
    if($CATGRY == 3){
    $sql5 = "select count(*) as ordcnt from posord a where property_id=$property_id and tblnub in (select tblnub from posout b where a.rescod=b.rescod and userid='$USERID' and property_id=$property_id and appdat = (select max(appdat) from posout c where b.userid=c.userid and appdat <= $today )) and order_id in (select distinct order_id from poskot d where a.order_id=d.order_id amd status ='ordered')";
    }else{
    $sql5 = "select count(*) as ordcnt from posord a where property_id=$property_id and order_id in (select distinct order_id from poskot d where a.order_id=d.order_id and property_id=$property_id and  status ='ordered')";
    }
    $result = mysqli_query($conn, $sql5);
    while ($row = mysqli_fetch_assoc($result)) {
      $order_count = $row['ordcnt'];
    }
    ?>
    <ul class="navbar-nav">
        <li class="nav-item" style="padding-left: 20px;">
          <div id="order_count_badge" class="badge badge-success"><?php echo $order_count; ?></div>
        </li>
      </ul>
  </nav>
