<?php
include_once("config.php");
$MENTYP = isset($_REQUEST['menu_type']) ? $_REQUEST['menu_type'] : 0;
$property_id = isset($_REQUEST['property_id']) ? $_REQUEST['property_id']:0; 
$rescod = isset($_REQUEST['rescod']) ? $_REQUEST['rescod']:0; 
?>
<select class="form-control" id="menu_group">
<option value="0">All</option>	
<?php
$sql = "select * from set100 where property_id='$property_id' and GRPCOD in (select distinct(MENGRP) from posmas a,posrat b where a.ITMCOD=b.ITMCOD and a.property_id=b.property_id and b.RESCOD='$rescod' and a.MENTYP='$MENTYP' and a.property_id='$property_id') order by GRPCOD";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
	echo "<option value='".$row['GRPCOD']."'>".$row['LNGNAM']."</option>";
}
?>
</select>
<script type="text/javascript">
	$("#menu_group").change(function() {
        var menu_type = $("#menu_type").val();
        var menu_group = $("#menu_group").val();
		var property_id = "<?php echo $property_id; ?>";
		var rescod = "<?php echo $rescod; ?>";
        load_menu(menu_type,menu_group,property_id,rescod);
	});
</script>