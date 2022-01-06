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
													<th>Action</th>
													<th>Outlet</th>
													<th>Table#</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sql = "select * from posord where property_id=$property_id and order_id in (select distinct order_id from posord where status ='ordered')";
												$result = mysqli_query($conn, $sql);
												while ($row = mysqli_fetch_assoc($result)) {
													$order_id = $row['order_id'];
													?>
													<tr>
														<td> <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modal-xl<?php echo $order_id; ?>"><i class="fa fa-eye"></i>&nbsp;View</button>&nbsp;
															<button type="button" class="btn btn-success btn-sm"><i class="fa fa-check"></i>&nbsp;Accept</button>&nbsp;
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
								$sql = "select * from posord where property_id=$property_id and order_id in (select distinct order_id from posord where status ='ordered')";
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
																		<th>Quantity</th>
																		<th>Amount</th>
																		<th>Total</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$sql2 = "select * from poskot where status ='ordered' and order_id = $order_id";
																	$result2 = mysqli_query($conn, $sql2);
																	while ($row2 = mysqli_fetch_assoc($result2)) {
																		?>
																		<tr>
																			<td> <button type="button" class="btn btn-sm btn-danger click_item_cancel"><i class="fa fa-times">&nbsp;Remove</i></button> </td>
																			<td><?php echo $row2['itmnam']; ?></td>
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
	</script>
</body>
</html>
