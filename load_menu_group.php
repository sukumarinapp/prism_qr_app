<?php
include_once("config.php");
$MENTYP = isset($_REQUEST['menu_type']) ? $_REQUEST['menu_type'] : 0;
$property_id = isset($_REQUEST['property_id']) ? $_REQUEST['property_id']:0; 
$rescod = isset($_REQUEST['rescod']) ? $_REQUEST['rescod']:0; 
?>
<div class="scrollmenu" style="max-width: 400px">
<?php
  $sql2 = "select * from set100 where property_id='$property_id' and GRPCOD in (select distinct(MENGRP) from posmas a,posrat b where a.ITMCOD=b.ITMCOD and a.property_id=b.property_id and b.RESCOD='$rescod' and a.MENTYP='$MENTYP' and a.property_id='$property_id') order by GRPCOD";
  $result2 = mysqli_query($conn, $sql2);
  $i=0;
  while ($row2 = mysqli_fetch_assoc($result2)) {
    $i++;
?>
<a class="changeable" href="#<?php echo $row2['GRPCOD']; ?>"><?php echo $row2['LNGNAM']; ?></a>
<?php
  }
?>
</div>

<script type="text/javascript">
	$("#menu_group").change(function() {
        var menu_type = $("#menu_type").val();
        var menu_group = $("#menu_group").val();
		var property_id = "<?php echo $property_id; ?>";
		var rescod = "<?php echo $rescod; ?>";
        load_menu(menu_type,menu_group,property_id,rescod);
	});
</script>