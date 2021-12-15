<?php
include_once("config.php");
$MENTYP = isset($_REQUEST['menu_type']) ? $_REQUEST['menu_type'] : 0;
$property_id = isset($_REQUEST['property_id']) ? $_REQUEST['property_id']:0; 
$rescod = isset($_REQUEST['rescod']) ? $_REQUEST['rescod']:0; 
?>
<div class="scrollmenu">
  
<?php
  $sql2 = "select * from set100 where property_id='$property_id' and GRPCOD in (select distinct(MENGRP) from posmas a,posrat b where a.ITMCOD=b.ITMCOD and a.property_id=b.property_id and b.RESCOD='$rescod' and a.MENTYP='$MENTYP' and a.property_id='$property_id') order by GRPCOD";
  $result2 = mysqli_query($conn, $sql2);
  $i=0;
  if(mysqli_num_rows($result2) > 1){
    ?>
<?php
  }
  while ($row2 = mysqli_fetch_assoc($result2)) {
    $backcolor = "#355bc8";
    if($i == 0) $backcolor = "#ff4a4b";
    $i++;
?>
<a style="border:2px;background-color:<?php echo $backcolor; ?>;color:whitesmoke" class="changeable" onclick="load_menu2(this,<?php echo $row2['GRPCOD']; ?>)" ><b><?php echo ucwords(strtolower($row2['LNGNAM'])); ?></b></a>
<?php
  }
?>
</div>

