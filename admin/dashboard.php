<?php
session_start();
$property_id = $_SESSION['property_id'];
$CATGRY = $_SESSION['CATGRY'];
$USERID = $_SESSION['USERID'];
include "../config.php";
$page = "Dashboard";
$today = date("Ymd");
$item_count = 0;

if($CATGRY == 3){
  $sql = "select count(*) as item_count from posord a,poskot b where a.order_id=b.order_id and property_id=$property_id and b.status ='ordered' and tblnub in (select tblnub from posout c where a.rescod=c.rescod and userid='$USERID' and property_id=$property_id and appdat = (select max(appdat) from posout d where c.userid=d.userid and appdat <= $today )) ";
}else{
  $sql = "select count(*) as item_count from posord  a,poskot b where a.order_id=b.order_id and  property_id=$property_id and b.status ='ordered'";
}
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
  $item_count = $row['item_count'];
}

$order_count=0;
if($CATGRY == 3){
$sql = "select count(*) as ordcnt from posord a where property_id=$property_id and tblnub in (select tblnub from posout b where a.rescod=b.rescod and userid='$USERID' and property_id=$property_id and appdat = (select max(appdat) from posout c where b.userid=c.userid and appdat <= $today )) and order_id in (select distinct order_id from posord where status ='ordered')";
}else{
$sql = "select count(*) as ordcnt from posord where property_id=$property_id and order_id in (select distinct order_id from posord where property_id=$property_id and  status ='ordered')";
}
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)) {
$order_count = $row['ordcnt'];
}

if($CATGRY == 3){
$sql = "select * from posord a where property_id=$property_id and tblnub in (select tblnub from posout b where a.rescod=b.rescod and userid='$USERID' and property_id=$property_id and appdat = (select max(appdat) from posout c where b.userid=c.userid and appdat <= $today )) and order_id in (select distinct order_id from posord where status ='ordered')";
}else{
$sql = "select * from posord where property_id=$property_id and order_id in (select distinct order_id from posord where property_id=$property_id and  status ='ordered')";
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
		<div class="col-12">
			<div class="card">
				<div class="card-header bg-info">
					<h3 class="card-title">Orders</h3>
				</div>
				<form>
					<input value="<?php echo $item_count; ?>" type="hidden" name="item_count" id="item_count" />
				</form>
				<div class="card-body">
					<div class="table-responsive">
						<table id="example1" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Action</th>
									<th>Outlet</th>
									<th>Table#</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$result = mysqli_query($conn, $sql);
								while ($row = mysqli_fetch_assoc($result)) {
									$order_id = $row['order_id'];
									?>
									<tr>
										<td> <button  type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-xl<?php echo $order_id; ?>"><i class="fa fa-eye"></i>&nbsp;View</button>&nbsp;
											<button onclick="accept_order('modal-xl<?php echo $order_id; ?>',<?php echo $row['order_id']; ?>)" type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;Accept</button>&nbsp;
											<button type="button" class="btn btn-danger btn-sm"><i class="fa fa-times"></i>&nbsp;Decline</button>
										</td>
										<td> <?php echo $row['rescod']; ?> </td>
										<td> <?php echo $row['tblnub']; ?> </td>
									</tr>
									<?php
								} 
								?>
							</tbody>
						</table>
					</div>
				</div>
				<?php
				$result = mysqli_query($conn, $sql);
				while ($row = mysqli_fetch_assoc($result)) {
					$order_id = $row['order_id'];
					?>
<div class="modal fade" id="modal-xl<?php echo $order_id; ?>">
<div class="modal-dialog modal-xl">
<div class="modal-content">
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
<div class="modal-body"  style="width:100%">
	<div class="card-body">
		<div class="table-responsive">
			<table id="example1" class="table table-bordered table-striped">
				<thead>
					<tr>
						<th>Action</th>
						<th>Item</th>
						<th>Qty</th>
						<th>Rate</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
`											<?php
					$sql2 = "select * from poskot where status ='ordered' and order_id = $order_id";
					$result2 = mysqli_query($conn, $sql2);
					while ($row2 = mysqli_fetch_assoc($result2)) {
						?>
						<tr>
							<td> <button type="button" class="btn btn-sm btn-danger click_item_cancel"><i class="fa fa-times">&nbsp;Remove</i></button> </td>
							<td>
							<input value="<?php echo $row2['itmcod']; ?>" type="hidden" name="itmcod[]" />
							<input value="<?php echo $row2['itmnam']; ?>" type="hidden" name="itmnam[]" />
							<input value="<?php echo $row2['itmqty']; ?>" type="hidden" name="itmqty[]" />
							<input value="<?php echo $row2['itmrat']; ?>" type="hidden" name="itmrat[]" />
							<input value="<?php echo $row2['itmval']; ?>" type="hidden" name="itmval[]" />
								<?php echo $row2['itmnam']; ?></td>
							<td><?php echo $row2['itmqty']; ?></td>
							<td><?php echo $row2['itmrat']; ?></td>
							<td><?php echo $row2['itmval']; ?></td>
						</tr>
						<?php
					} 
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="modal-footer text-center">
	<button type="button" class="btn btn-primary text-center" data-dismiss="modal">Close</button>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
					<?php
				} 
				?>

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
<script src="plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
$(document).ready(function () {
$("#example1").DataTable();
$('.click_item_cancel').click(function() {
$("button", this).toggleClass("btn btn-success btn-sm click_item_cancel");
if ($(this).find('i').hasClass("fa-times")){
	$(this).find('i').removeClass('fa-times');
	$(this).find('i').html('&nbsp;Accept');
	$(this).removeClass('btn-danger');
	$(this).find('i').addClass('fa-check');
	$(this).addClass('btn-success');
} else {
	$(this).find('i').removeClass('fa-check');
	$(this).find('i').html('&nbsp;Remove');
	$(this).removeClass('btn-success');
	$(this).find('i').addClass('fa-times');
	$(this).addClass('btn-danger');
}
});
});

var item_count = "<?php echo $item_count; ?>";
var order_count = "<?php echo $order_count; ?>";
var property_id = "<?php echo $property_id; ?>";
var userid = "<?php echo $USERID; ?>";
var catgry = "<?php echo $CATGRY; ?>";

function check_order(){
	$.ajax({
      url: "check_order.php",
      type: "get",
      data: {catgry: catgry, order_count: order_count, property_id: property_id, userid: userid},
      success: function (response) {
      	response = JSON.parse(response);
      	var new_item_count = response.item_count;
      	if(item_count != new_item_count){
      		alert("Order Update");
      		window.location.href = "dashboard.php";
      	}
      },
      error : function(error){
        console.log(error);
      }
    });
}
setInterval(check_order, 10000);

function accept_order(modal_id,order_id){
	console.log(order_id);
	console.log($("#"+modal_id).find("#example1 > tbody").html());
}

</script>
</body>
</html>
