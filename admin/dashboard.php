<?php
session_start();
include "../config.php";
$page = "Dashboard";
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
                <h3 class="card-title">Orders</h3>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Order Id</th>
                    <th>Mobile No</th>
                    <th>Outlet</th>
                    <th>Table No</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                   <?php
                     $sql = "select * from posord where property_id=$property_id and status ='ordered' ";
                     $result = mysqli_query($conn, $sql);
                     while ($row = mysqli_fetch_assoc($result)) {
                      ?>
                  <tr>
                    <td> <?php echo $row['order_id']; ?> </td>
                    <td> <?php echo $row['mobile']; ?> </td>
                    <td> <?php echo $row['rescod']; ?> </td>
                    <td> <?php echo $row['tblnub']; ?> </td>
                    <td><button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i> Accept</button>
                    <button type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Decline</button></td>
                   
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
<script src="plugins/jszip/jszip.min.js"></script>
<script src="plugins/pdfmake/pdfmake.min.js"></script>
<script src="plugins/pdfmake/vfs_fonts.js"></script>
<script src="plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false,
     // "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>
</body>
</html>
