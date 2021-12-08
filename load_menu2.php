<?php
include_once("config.php");

function get_item_image($itmcod){
	$ITMIMG = "";
	$sql = "select ITMIMG from set102 where ITMCOD=$itmcod and SRLNUB=5"; 
	$result = mysqli_query($GLOBALS['conn'], $sql);
	while($row = mysqli_fetch_array($result)){
		$ITMIMG = $row['ITMIMG'];
	}
	return $ITMIMG;
}

function get_readmore($itmcod){
	$readmore = "";
	$sql = "select STR001 from set102 where ITMCOD=$itmcod and SRLNUB=4"; 
	$result = mysqli_query($GLOBALS['conn'], $sql);
	while($row = mysqli_fetch_array($result)){
		$readmore = $row['STR001'];
	}
	return $readmore;
}

$MENTYP = isset($_REQUEST['menu_type']) ? $_REQUEST['menu_type'] : 1;
$MENGRP = isset($_REQUEST['menu_group']) ? $_REQUEST['menu_group'] : 0;
$property_id = isset($_REQUEST['property_id']) ? $_REQUEST['property_id'] : 0;
$rescod = isset($_REQUEST['rescod']) ? $_REQUEST['rescod'] : 0;
$sql = "select a.MENGRP,a.ITMNAM,a.ITMCOD,b.PRICE,b.TAXSTR,c.LNGNAM,a.DESCRP from posmas a,posrat b,set100 c where MENTYP=$MENTYP and  a.MENGRP=c.GRPCOD and a.property_id=b.property_id and a.property_id=c.property_id and a.property_id='$property_id' and a.ITMCOD=b.ITMCOD and b.RESCOD='$rescod'"; 
if($MENGRP!=0) $sql .= " and MENGRP='$MENGRP'"; 
$sql .= " order by GRPCOD,ITMNAM";
$result = mysqli_query($conn, $sql);
$MENGRP2 = -1;
while($row = mysqli_fetch_array($result)){
	if($MENGRP2 != $row['MENGRP'] && $MENGRP==0){
		echo "<div class='row clearfix'><div class='col-md-12 col-sm-12 col-xs-12'><div class='card bg-success text-black '><div class='card-body text-center'><h5 class='font-weight-bold'>".strtoupper($row['LNGNAM'])."</h5></div></div></div></div>";
		echo "<div class='row'><div class='col-md-12 col-sm-12 col-xs-12'><br></div></div>";
	}
?>
	<div class="row clearfix no-gutters">
		<div class="col-md-12 col-sm-12 col-xs-12">
		    <div class="card bg-light text-black">
			  <div class="card-body ">
			  	<div class="row">
			  		<div class="col-md-12 col-sm-12 col-xs-12 font-weight-bold">
			 			<?php echo ucwords(strtolower($row['ITMNAM'])); ?>
		        	</div>
    			</div>
 				<div class="row">
			  		<div class="col-md-12 col-sm-12 col-xs-12 font-weight-bold">
 						<span class="align-middle">&#2352; <?php echo number_format($row['PRICE'],2); ?></span>
	  				</div>
	  			</div>
	 			<div class="row" >
	 				<div class="col col-lg-6 col-md-6 col-sm-6 col-xs-6">
	 					<?php
			  			$ITMIMG = get_item_image($row['ITMCOD']);
			  			if($ITMIMG<>""){
							echo "<img style='padding-bottom:0px' class='card-img-top' src='data:image/jpeg;base64,{$ITMIMG}' />";
			  			} 
			  			?>
 					</div>
 					<div class="col col-lg-6 col-md-6 col-sm-6 col-xs-6 quantity_span">
 						<span class="add_button_span">&nbsp;&nbsp;&nbsp;
 							<button class="pull-right btn btn-sm btn-danger font-weight-bold add_qty">Add</button>&nbsp;&nbsp;&nbsp;
 						</span>
 						<span class="plus_minus_span qty pull-right" style="display: none">
	 						<input type="hidden" class="itmcod" value="<?php echo $row['ITMCOD']; ?>" />
	 						<input type="hidden" class="itmrat" value="<?php echo $row['PRICE']; ?>" />
	 						<input type="hidden" class="taxstr" value="<?php echo $row['TAXSTR']; ?>" />
	 						<input type="hidden" class="itmnam" value="<?php echo $row['ITMNAM']; ?>" />
                        	<span class="minus bg-danger">-</span>
                        	<input style="color:black" type="text" maxlength="2" size="2" class="qty_text" name="qty_text" value="0">
                        	<span class="plus bg-success">+</span>
                    	</span>
					</div>
 				</div>
 				<div class="row add_qty_div" >
 					<div class="col col-md-12 col-sm-12 col-xs-12 pull-right">
 						
 					</div>
 				</div>
 				<div class="row">
	 				<div style="text-align: right !important" class="col-md-12 col-sm-12 col-xs-12">
	 					
	 				</div>
 				</div>
 				<?php
 					$readmore = get_readmore($row['ITMCOD']);
 				?>
    			<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
			 			<span>
				 			<p style="display: none" class="itemdesc"><?php echo trim($readmore); ?></p>
			 			</span>
			 			<?php if(trim($readmore)!="") {?>
			 			<span class="font-weight-bold" >
					    	<a class="morebutton text-danger">Read More</a>
				    	</span>
						<?php } ?>
		 			</div>
	 			</div>
			  </div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<br>
		</div>
	</div>
<?php
	$MENGRP2 = $row['MENGRP'];
}
?>
<script>
$(document).ready(function () {

	$('.morebutton').click(function () {
		//$('p:eq(0)').slideToggle();
		var object1 = $(this).parent().parent().parent().parent('.card-body'); 
		var object2 = $(object1).find(".itemdesc");
		(object2).slideToggle();
		if($(this).text()=="Read More")
			$(this).text("Read Less");
		else
			$(this).text("Read More");
	});

	$('.add_qty').click(function () {
		var object1 = $(this).parent().parent('.quantity_span'); 
		var object2 = $(object1).find(".add_button_span");
		var object3 = $(object1).find(".plus_minus_span");
		$(object2).slideUp("slow");
		$(object3).slideDown("slow");
		$(object3).val("1");
		
		return;
		var itmcod = $(object1).find(".itmcod").val();
		var itmrat = $(object1).find(".itmrat").val();
		var taxstr = $(object1).find(".taxstr").val();
		var itmnam = $(object1).find(".itmnam").val();
		item_obj[itmcod] = {};
		item_obj[itmcod]['qty'] = 1;
		item_obj[itmcod]['itmrat'] = itmrat;
		item_obj[itmcod]['taxstr'] = taxstr;
		item_obj[itmcod]['itmnam'] = itmnam;
		$(this).parent().parent().slideUp();
		
	});

	$('.plus').click(function () {
		var object1 = $(this).parent(); 
		var object2 = $(object1).find(".qty_text");
		var v = parseInt($(object2).val());
		v = v + 1;
		object2.val(v);
		var itmcod = $(object1).find(".itmcod").val();
		var itmrat = $(object1).find(".itmrat").val();
		var taxstr = $(object1).find(".taxstr").val();
		var itmnam = $(object1).find(".itmnam").val();
		item_obj[itmcod] = {};
		item_obj[itmcod]['qty'] = v;
		item_obj[itmcod]['itmrat'] = itmrat;
		item_obj[itmcod]['taxstr'] = taxstr;
		item_obj[itmcod]['itmnam'] = itmnam;
	});

	$('.minus').click(function () {
var object1 = $(this).parent().parent().parent('.quantity_span'); 
		var object2 = $(object1).find(".add_button_span");
		var object3 = $(object1).find(".plus_minus_span");
				var object4 = $(object1).find(".add_qty_div");
		var v = parseInt($(object3).val());
		v = v - 1;
		object3.val(v);
		if(v == 0){
			$(object3).slideUp();
			$(object2).slideDown();
		}
		return;
		var itmcod = $(object1).find(".itmcod").val();
		var itmrat = $(object1).find(".itmrat").val();
		var taxstr = $(object1).find(".taxstr").val();
		var itmnam = $(object1).find(".itmnam").val();
		item_obj[itmcod] = {};
		item_obj[itmcod]['qty'] = v;
		item_obj[itmcod]['itmrat'] = itmrat;
		item_obj[itmcod]['taxstr'] = taxstr;
		item_obj[itmcod]['itmnam'] = itmnam;
	});

});
</script>