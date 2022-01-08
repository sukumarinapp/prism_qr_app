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
    $notification_count=0;
    if($_SESSION['CATGRY']=="1"){ 
    $notification_sql = "select * from posord where status='ordered'";
  
  
    }else 
    {
      $USERID=$_SESSION['USERID'];
      $notification_sql = "select * from posord where status='ordered'";
  
    }
      $notification_result = mysqli_query($conn, $notification_sql);
        while ($notification_row = mysqli_fetch_assoc($notification_result)) {
      
            $notification_count++;
        }
    
  ?>
             

        <li class="nav-item" style="padding-left: 20px;">
          <div class="badge badge-success"><?php echo $notification_count; ?></div>
        </li>
      </ul>
  </nav>
