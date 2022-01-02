<?php
session_start();
$page = "link steward";
include "../config.php";
if (($_SESSION['CATGRY'] != "0") && ($_SESSION['CATGRY'] != "1")) header("location: index.php");
$property_id = $_SESSION['property_id'];
$appdat="";
$rescod="";
$tblnub="";
$userid="";
if (isset($_POST['submit'])) {
  $appdat = trim($_POST['appdat']); 
  $appdat = explode("-",$appdat);
  $appdat = $appdat[0].$appdat[1].$appdat[2];
  $rescod= trim($_POST['rescod']);
  $tblnub= trim($_POST['tblnub']);
  $userid= trim($_POST['userid']);
  $stmt = $conn->prepare("INSERT INTO posout (property_id,appdat,rescod,tblnub,userid) VALUES (?,?,?,?,?)");
  $stmt->bind_param("sssss",$property_id,$appdat,$rescod,$tblnub,$userid);
  $stmt->execute();
  header("location: link_steward.php");
} 
?>
<!DOCTYPE html>
<html lang="en">


<body class="hold-transition sidebar-mini">
  <div class="wrapper">
   <?php include "header.php"; ?>
   <?php include "menu.php"; ?>
   <div class="content-wrapper">
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
              <form method="post" action="" >
                <div class="card-body">
                  <div class="form-group">
                    <label for="appdat">Applicable Date</label>
                    <input min="<?php echo date("Y-m-d"); ?>" value="<?php echo $appdat; ?>" required="required" type="date" name="appdat" class="form-control" id="appdat" placeholder="">
                  </div>
                  <div class="form-group">
                    <label for="rescod">Outlet</label>
                    <select value="<?php echo $rescod; ?>" required="required" id="outlet_name" name="rescod" class="form-control select2" style="width: 100%;">
                      <option selected="selected" value="">Select Outlet</option>
                      <?php
                      $sql = "select * from set090 where property_id=$property_id";
                      $result = mysqli_query($conn, $sql);
                      while ($row = mysqli_fetch_array($result)) {
                        echo '<option value="' . $row['rescod'] . '">' . $row['lngnam'] . '</option>';
                      }
                      ?>
                    </select>
                  </div>
                  <div class="form-group" id="table_div">
                    <label for="tblnub">Table#</label>
                    <select required="required" name="tblnub" class="form-control" >
                      <option value="" >Select Table</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Select Steward</label>
                    <select value="<?php echo $userid; ?>" required="required" name="userid" class="form-control" style="width: 100%;">
                      <option value="">Select Steward</option>
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
                   <input class="btn btn-primary" type="submit" name="submit" value="Save"/>
                 </div>
               </form>
             </div>


           </div>
           <!--/.col (right) -->
         </div>
       </div><!-- /.container-fluid -->
     </section>

     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-secondary">
                <h3 class="card-title">View Steward</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="table-responsive">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                        <th>Applicable Date</th>
                        <th>Outlet</th>
                        <th>Table #</th>
                        <th>Steward</th>
                        <th>Delete</th>
                      </tr>
                    </thead>
                    <tbody>
                     <?php
                     $sql = "select * from posout where property_id=$property_id";
                     $result = mysqli_query($conn, $sql);
                     while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                      <tr> 
                        <td> <?php echo date('d/m/Y', strtotime($row['appdat'])); ?> </td>
                        <td> <?php echo $row['rescod']; ?></td>
                        <td> <?php echo $row['tblnub']; ?></td>
                        <td> <?php echo $row['userid']; ?></td>
                        <td><a href="delete_steward.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Delete</a></td>
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
    $(document).ready(function () {
      $("#outlet_name").change(function() {
        var property_id = "<?php echo $property_id; ?>";
        var rescod = $("#outlet_name").val();
        $.ajax({
          url: "load_table.php",
          type: "get",
          data: {property_id: property_id, rescod: rescod},
          success: function (response) {
            $("#table_div").html(response);
          },
          error : function(error){
            console.log(error);
          }
        });
      });
    });
</script>
</body>
</html>
