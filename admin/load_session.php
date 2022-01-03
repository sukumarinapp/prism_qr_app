<?php
include_once("../config.php");
$property_id = isset($_REQUEST['property_id']) ? $_REQUEST['property_id']:0; 
$rescod = isset($_REQUEST['rescod']) ? $_REQUEST['rescod']:0; 
$sql = "select * from set190 where property_id='$property_id' and SESSON='$SESSON' order by SESSON";
$result = mysqli_query($conn, $sql);
?>
<label for="SESSON">Session</label>
<select required="required" name="SESSON" class="form-control" >
<option selected="selected" >Select Session</option>
<?php
while($row = mysqli_fetch_assoc($result)) {
echo '<option value="' . $row['SESSON'] . '">' . $row['SESSON'] . '</option>';
}
?>
</select>

