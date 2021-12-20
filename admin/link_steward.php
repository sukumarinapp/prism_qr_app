<?php
session_start();
include "../config.php";
$property_id = $_SESSION['property_id'];
?>
<!DOCTYPE html>
<html lang="en">
      

<body class="hold-transition sidebar-mini">
<div class="wrapper">
   <?php include "header.php"; ?>
     <?php include "menu.php"; ?>
  <div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
      </div>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-info">
              <div class="card-header">
                <h3 class="card-title">Link Steward</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <form>
                <div class="card-body">
                  <div class="form-group">
                    <label for="appdat">Applicable Date</label>
                    <input type="date" name="appdat" class="form-control" id="appdat" placeholder="">
                  </div>
                   <div class="form-group">
                    <label for="rescod">Outlet</label>
                    <select name="rescod" class="form-control select2" style="width: 100%;">
                    <option selected="selected">Select Outlet</option>
                    <?php
  $sql = "select * from set090 where property_id=$property_id";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['rescod'] . '">' . $row['lngnam'] . '</option>';
  }
?>
                  </select>
                  </div>
                  <div class="form-group">
                    <label for="tblnub">Table#</label>
                    <select name="tblnub" class="form-control select2" style="width: 100%;">
                    <option selected="selected">Select Table</option>
                    <?php
  $sql = "select * from set090 where property_id=$property_id";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_array($result)) {
    echo '<option value="' . $row['rescod'] . '">' . $row['lngnam'] . '</option>';
  }
?>
                  </select>
                  </div>
                  

                 <div class="form-group">
                  <label>Select Steward</label>
                  <select name="userid" class="form-control select2" style="width: 100%;">
                    <option selected="selected">Select Steward</option>
                    <?php
  $sql = "select * from prmusr where property_id=$property_id and CATGRY=3";
  $result = mysqli_query($conn, $sql);
  while ($row = mysqli_fetch_array($result)) {
  echo '<option value="' . $row['USERID'] . '">' . $row['LNGNAM'] . '</option>';
  }
  ?>
                  </select>
                </div>

                <div class="card-footer text-center">
                  <button type="submit" name="submit" class="btn btn-primary">Save</button>
                </div>
              </form>
            </div>
        

          </div>
          <!--/.col (right) -->
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- /.content -->
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
<script>
$(function () {
  bsCustomFileInput.init();
});
</script>
</body>
</html>
