<?php
include_once("../config.php");
$property_id = isset($_REQUEST['property_id']) ? $_REQUEST['property_id']:0; 
$rescod = isset($_REQUEST['rescod']) ? $_REQUEST['rescod']:0; 
$sql = "select * from set220 where property_id='$property_id' and rescod='$rescod' order by tblnub";
$result = mysqli_query($conn, $sql);
?>
<label for="tblnub">Table#</label>
<select required="required" name="tblnub" class="form-control" >
<option value="" >Select Table</option>
<?php
while($row = mysqli_fetch_assoc($result)) {
echo '<option value="' . $row['tblnub'] . '">' . $row['tblnub'] . '</option>';
}
?>
</select>

