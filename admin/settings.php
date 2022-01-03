<?php
session_start();
$page = "settings";
include "../config.php";
if (($_SESSION['CATGRY'] != "0") && ($_SESSION['CATGRY'] != "1")) header("location: index.php");
$property_id = $_SESSION['property_id'];
$LANIPA="";
if (isset($_POST['submit'])) {
  $LANIPA = trim($_POST['LANIPA']); 
  $stmt = $conn->prepare("INSERT INTO webser (property_id,LANIPA) VALUES (?,?)");
  $stmt->bind_param("ss",$property_id,$LANIPA);
  $stmt->execute();
  header("location: settings.php");
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
                <h3 class="card-title">Settings</h3>
              </div>
              <form method="post" action="" >
                <div class="card-body">
                  <div class="form-group">
                    <label for="LANIPA">Web Service URL</label>
                    <input required="required" type="text" name="LANIPA" class="form-control" id="LANIPA" placeholder="URL">
                  </div>

                  <div class="card-footer text-center">
                   <input class="btn btn-primary" type="submit" name="submit" value="Save"/>
                 </div>
               </form>
             </div>
           </div>
         </div>
       </div>
     </section>

      <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-secondary">
                <h3 class="card-title">View URL</h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>URL</th>
                      </tr>
                    </thead>
                    <tbody>

                     <?php
                     $sql = "select * from webser where property_id=$property_id";
                     $result = mysqli_query($conn, $sql);
                     while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                      <tr> 
                        <td> <?php echo $row['LANIPA']; ?></td>
                      </tr>
                      <?php
                    } 
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php include "footer.php"; ?>
  </div>

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- bs-custom-file-input -->
  <script src="plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <script src="plugins/select2/js/select2.full.min.js"></script>
</body>
</html>
