<?php
session_start();
include "../config.php";
$page = "menu";
$property_id = $_SESSION['property_id'];
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
          <div class="col-12">
            <div class="card">
              <div class="card-header bg-info">
                <h3 class="card-title">Menu</h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width:100px">Code</th>
                    <th style="width:200px">Name</th>
                    <th style="width:300px">Stock</th>
                  </tr>
                  </thead>
                  <tbody>
                   <?php
                     $sql = "select * from posmas where property_id=$property_id";
                     $result = mysqli_query($conn, $sql);
                     while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                  <tr>
                    <td> <?php echo $row['ITMCOD']; ?> </td>
                    <td> <?php echo $row['ITMNAM']; ?> </td>
                    <td> <input <?php if($row['STKOUT'] == "0") echo " checked='checked' "; ?> type="radio" value="0" name="stkradio<?php echo $row['ITMCOD']; ?>">
                        Available&nbsp;
                        <input <?php if($row['STKOUT'] == 1) echo " checked='checked' "; ?> type="radio" value="1" name="stkradio<?php echo $row['ITMCOD']; ?>">
                        Out of Stock&nbsp;
                        <button type="button" onclick="updatestock(<?php echo $row['ITMCOD']; ?>,'stkradio<?php echo $row['ITMCOD']; ?>')" class="btn btn-primary btn-sm"> update</button>
                         </td>
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
        </div>
      </div>
    </section>
  </div>
     <?php include "footer.php"; ?>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script src="plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
  $(document).ready(function () {
      $("#example1").DataTable();
  });

  function updatestock(itmcod,radioname) {
    var STKOUT = $("input[name='"+radioname+"']:checked").val();
    var property_id = "<?php echo $property_id; ?>";
    $.ajax({
      url: "update_stock.php",
      type: "post",
      data: {itmcod: itmcod, STKOUT: STKOUT,property_id: property_id},
      success: function (html) {
        if(STKOUT == 0){
          alert("Item status updated as available");
        }else{
          alert("Item status updated as out of stock");
        }
      },
      error : function(error){
        console.log(error);
      }
    });
  }


</script>
</body>
</html>
