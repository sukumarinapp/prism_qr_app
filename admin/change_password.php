<?php
session_start();
include "../config.php";
$property_id = $_SESSION['property_id'];
$USERID = $_SESSION['USERID'];
$msg="";
$color="green"; 
if (isset($_POST['submit'])) {
  $old_password = trim($_POST['old_password']);
  $new_password = trim($_POST['new_password']);
  $confirm_password = trim($_POST['confirm_password']);
  $flag=false;
  $sql = "SELECT * FROM prmusr WHERE USERID='$USERID' and PASSWD='$old_password'";
  $result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
  while($row = mysqli_fetch_array($result)){
    $flag=true;
  }
  if($flag==false){
    $msg="Invalid old password";
    $color="red";
  }else{
    if($new_password!=$confirm_password) {
      $msg = "Passwords does not match";
      $color = "red";
    }else{
      $stmt = $conn->prepare("update prmusr set PASSWD=? where USERID=?");
      $stmt->bind_param("ss", $new_password, $USERID);
      $stmt->execute();
      $stmt->close();
      $msg = "Password changed successfully";
      $color = "green";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<body class="hold-transition sidebar-mini">
    <div class="wrapper">
   <?php include "header.php"; ?>
   <?php include "menu.php"; ?>
   <div class="content-wrapper">
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
             <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Change Password</h3>
              </div>
           
      <form action="" method="post">
          <div class="card-body">
      <p style="color:<?php echo $color; ?>"><?php echo $msg; ?></p>
        <div class="input-group mb-3">
          <input type="password" name="old_password" required="required" class="form-control" placeholder="Old Password">
        </div>
        <div class="input-group mb-3">
          <input type="password" name="new_password" required="required" class="form-control" placeholder="New Password">
        </div>
        <div class="input-group mb-3">
          <input type="password" name="confirm_password" required="required" class="form-control" placeholder="Confirm Password">
        </div>
        <div class="row">
          <div class="col-12">
          <input required="required" class="btn btn-primary btn-block" type="submit"
           name="submit" value="Change Password"/>
          </div>
          <!-- /.col -->
        </div>
      </form>
    </div>
    </div>
         </div>
       </div><!-- /.container-fluid -->
     </section>
    </div>
    <?php include "footer.php"; ?>
  </div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
</body>
</html>
