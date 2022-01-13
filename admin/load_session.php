<?php
include_once("../config.php");
$property_id = isset($_REQUEST['property_id']) ? $_REQUEST['property_id']:0; 
$rescod = isset($_REQUEST['rescod']) ? $_REQUEST['rescod']:0; 
$sql = "select * from set190 a where property_id='$property_id' and rescod='$rescod' order by FRMTIM";
$result = mysqli_query($conn, $sql);
?>
<label for="SESSON">Session</label>
<select required="required" name="sesson" class="form-control" >
<option value="" >Select Session</option>
<?php
while($row = mysqli_fetch_assoc($result)) {
echo "<option value='" . $row['SESSON'] . "'>" . $row['LNGNAM'] . " (".$row['FRMTIM']."-".$row['TOOTIM'].")</option>";
}
?>
</select>

