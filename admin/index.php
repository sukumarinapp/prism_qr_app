<?php
session_start();
include "../config.php";
$error = "";
$property_id = 0;
if(isset($_GET['id'])){
  $property_id = $_GET['id'];
}else{
  echo "Property not found";
  die;
}
if (isset($_POST['submit'])) {
    $USERID = trim($_POST['USERID']);
    $PASSWD = trim($_POST['PASSWD']);
    $stmt = $conn->prepare("SELECT a.*,b.comnam FROM prmusr a,prmlic b WHERE a.property_id=b.id and a.property_id = ? AND USERID = ?");
    $stmt->bind_param("ss", $property_id,$USERID);
    $stmt->execute();
    $result = $stmt->get_result();
    if($result->num_rows > 0){
      $row = $result->fetch_assoc();
      if($PASSWD == decrypt_password($row['PASSWD'])){
        $_SESSION['timestamp'] = time();
        $_SESSION['comnam'] = $row['comnam'];
        $_SESSION['property_id'] = $row['property_id'];
        $_SESSION['USERID'] = $row['USERID'];
        $_SESSION['LNGNAM'] = $row['LNGNAM'];
        $_SESSION['CATGRY'] = $row['CATGRY'];
        if($row['CATGRY'] == "0" || $row['CATGRY'] == "1" || $row['CATGRY'] == "3")
          header("location: dashboard.php");
      }else{
        $error = "Your User Name or Password is invalid";
      }
    }else{
      $error = "Your User Name or Password is invalid";
    }
    $stmt->close();
}    
                   
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p style="color:red">
        <?php
          echo $error;
        ?>
      </p>
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="post">
        <div class="input-group mb-3">
          <input type="text" name="USERID" required="required" class="form-control" placeholder="Username">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-user"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="PASSWD" required="required" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12" style="text-align: center;">
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
