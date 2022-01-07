<?php
include_once("config.php");
$cstcod = isset($_GET['cstcod']) ? $_GET['cstcod']: "";
$rescod = isset($_GET['rescod']) ? $_GET['rescod']: "";
$tblnub = isset($_GET['tblnub']) ? $_GET['tblnub']: "";
$mobile = isset($_GET['mobile']) ? $_GET['mobile']: "";
if($cstcod=="" || $rescod==""){
  die("Prism Bangalore");
}
$sql = "select * from prmlic where cstcod='$cstcod'";
$result = mysqli_query($conn, $sql);
$property_id = 0;
$MENTYP = 1;
$MENGRP = 0;
$comnam = "";
while($row = mysqli_fetch_array($result)){
  $comnam = trim($row['comnam']);
  $property_id = $row['id'];
}
$outnam = "";
$sql = "select * from set090 where property_id='$property_id' and rescod='$rescod'";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
  $outnam = trim($row['lngnam']);
}

$sql = "select b.* from posord a,poskot b where a.order_id=b.order_id and a.rescod='$rescod' and  a.property_id='$property_id' and a.tblnub='$tblnub' and a.mobile='$mobile' and  b.status='pending'";
$result = mysqli_query($conn, $sql);
$cart_quantity = 0;                    
while($row = mysqli_fetch_array($result)){
  $cart_quantity = $cart_quantity + $row['itmqty'];
}

$sql = "select b.* from posord a,poskot b where a.order_id=b.order_id and a.rescod='$rescod' and  a.property_id='$property_id' and a.tblnub='$tblnub' and a.mobile='$mobile' and b.status='ordered' ";
$result = mysqli_query($conn, $sql);
$bill_quantity = 0;                    
while($row = mysqli_fetch_array($result)){
  $bill_quantity = $bill_quantity + $row['itmqty'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title><?php echo $outnam; ?></title>
  <link rel="icon" href="favico.ico">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- Bootstrap core CSS -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <!-- Your custom styles (optional) -->
  <link href="css/style.css" rel="stylesheet">
  <style type="text/css">
    .colorToggle{
      background-color : red;
    }
    .qty .count {
      color: #000;
      display: inline-block;
      vertical-align: top;
      font-size: 25px;
      font-weight: 700;
      line-height: 30px;
      padding: 0 2px
      ;min-width: 35px;
      text-align: center;
    }
    .qty .plus {
      cursor: pointer;
      display: inline-block;
      vertical-align: top;
      color: white;
      width: 30px;
      height: 30px;
      font: 30px/1 Arial,sans-serif;
      text-align: center;
      border-radius: 50%;
    }
    .qty .minus {
      cursor: pointer;
      display: inline-block;
      vertical-align: top;
      color: white;
      width: 30px;
      height: 30px;
      font: 30px/1 Arial,sans-serif;
      text-align: center;
      border-radius: 50%;
      background-clip: padding-box;
    }
    body {
      
    }
    .pluspop {
      cursor: pointer;
      display: inline-block;
      vertical-align: top;
      color: white;
      width: 30px;
      height: 30px;
      font: 30px/1 Arial,sans-serif;
      text-align: center;
      border-radius: 50%;
    }
    body.modal-open {
      overflow: hidden;
      width: 100%;
      /* NO position:fixed here*/
    }
    .btn-circle.btn-sm { 
      width: 30px; 
      height: 30px; 
      padding: 6px 0px; 
      border-radius: 15px; 
      font-size: 8px; 
      text-align: center; 
    } 
    .table-striped>tbody>tr:nth-child(even)>td,
    .table-striped>tbody>tr:nth-child(even)>th {
      background-color: #dee2e6 !important;
    }        
    .table-striped>tbody>tr:nth-child(odd)>td,
    .table-striped>tbody>tr:nth-child(odd)>th {
      background-color: #dee2e6 !important;
    }   

    .btn:active:after {
     padding: 0;
     margin: 0;
     opacity: 1;
     transition: 10s 
   }   
   div.scrollmenu {
    overflow: auto;
    white-space: nowrap;
    color: whitesmoke;
  }

  div.scrollmenu a {
    display: inline-block;
    color: white;
    text-align: center;
    padding: 14px;
    text-decoration: none;
  }

  div.scrollmenu a:hover {
    background-color: ;
  } 

  .red_ribbon {
   position: absolute;
   right: -6px; top: -6px;
   z-index: 1;
   overflow: hidden;
   width: 80px; height: 80px; 
   text-align: right;
}
.red_ribbon span {
   font-size: 15px;
   color: #fff; 
   text-align: center;
   font-weight: bold; line-height: 22px;
   transform: rotate(45deg);
   -webkit-transform: rotate(45deg); 
   width: 110px; display: block;
   background: #c55c58;
   background: linear-gradient(#c55c58 0%, #c55c58 100%);
   box-shadow: 0 3px 10px -5px rgba(0, 0, 0, 1);
   position: absolute;
   top: 20px; right: -22px;
}

</style>
</head>

<body style="background-color: white;">

  <div class="container my-4">    

    <hr class="my-4">

    <nav style="background-color: #18b1b1" class="navbar fixed-top navbar-expand-lg navbar-dark">
      <a style="color: white;" class="navbar-brand font-weight-bold" href="#"><?php echo " ".$outnam."&nbsp;Table# ".$tblnub; ?></a>
      <button  class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" onclick="place_order()">Add to Cart</a>
          </li>
          <?php
          if($cart_quantity>0){
            ?>
            <li class="nav-item">
              <a class="nav-link" href="cart.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>">View Cart</a>
            </li>
            <?php
          }
          ?>
          <?php
      if($bill_quantity>0){
        ?>
          <li class="nav-item">
              <a class="nav-link" href="bill.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>">View Bill</a>
            </li>
             <?php
          }
          ?>
        </ul>
      </div>
    </nav>

    <!--Main layout-->
    <main>


      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content" style="background-color: white;">
            <div class="modal-body" id="modalbody"></div>
            <div class="text-center" style="text-align: center !important">
              <button type="button" onclick="cancel_order()" style="background-color: #c55c58" class="btn btn-sm text-center" >Cancel</button>
              <button id="confirm_button" type="button" onclick="confirm_order()" style="background-color: #18b1b1" class="btn  btn-sm text-center" >Confirm</button>
            </div>
          </div>
        </div>
      </div>

        <br>
        <div class="row">
          <div class="col-md-12">
            <select class="form-control" id="menu_type">
              <?php
                $sql="";
                  $sql = "select * from sys001 where RECCOD=5 and property_id='$property_id' order by RECTYP";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)){
                  echo "<option value='".$row['RECTYP']."'>".$row['DESCRP']."</option>";
                }
                ?>
            </select>
          </div>
        </div> 
<br>
        <div class="row">
         <div class="col-md-12" id="menu_group_div">
          <nav>
            <div class="w3-top">


              <div class="w3-bar w3-black w3-card">
                <div class="scrollmenu">
                  <?php
                  $sql2 ="select * from set100 where property_id='$property_id' and GRPCOD in (select distinct(MENGRP) from posmas a,posrat b where a.ITMCOD=b.ITMCOD and a.property_id=b.property_id and b.RESCOD='$rescod' and a.MENTYP='$MENTYP' and a.property_id='$property_id') order by GRPCOD";
                  $result2 = mysqli_query($conn, $sql2);
                  $i=0;
                  while ($row2 = mysqli_fetch_assoc($result2)) {

                    $backcolor = "#18b1b1";
                    if($i == 0) {
                      $backcolor = "#c55c58";
                      $MENGRP = $row2['GRPCOD'];
                    }
                    $i++;
                    ?>
                    <a style="background-color:<?php echo $backcolor; ?>;color:whitesmoke;border:2px;" class="changeable" onclick="load_menu2(this,<?php echo $row2['GRPCOD']; ?>)" ><b><?php echo ucwords(strtolower($row2['LNGNAM'])); ?></b></a>
                    <?php
                  }
                  ?>
                </div>
              </div>
            </div>
          </nav>
        </div> 
      </div>
      <br>
      <script>
        var item_obj = {};
      </script>
      <div id="menu_item" >
      <?php
        $sql = "select a.MENGRP,a.ITMNAM,a.ITMCOD,b.PRICE,b.TAXSTR,c.LNGNAM,a.DESCRP,a.STKOUT from posmas a,posrat b,set100 c where  a.MENGRP=c.GRPCOD and a.property_id=b.property_id and a.property_id=c.property_id and a.property_id='$property_id' and a.ITMCOD=b.ITMCOD and b.RESCOD='$rescod'"; 
        if($MENTYP!=0) $sql .= " and MENTYP='$MENTYP'"; 
        if($MENGRP!=0) $sql .= " and MENGRP='$MENGRP'"; 
        $sql .= " order by GRPCOD,ITMNAM";
        $result = mysqli_query($conn, $sql);
        while($row = mysqli_fetch_array($result)){
      ?>
      <div class="row clearfix no-gutters">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div style="background-color:whitesmoke;" class="card text-black">
        <div class="card-body ">  
<?php if($row['STKOUT'] == 1) { ?>
          <div class="red_ribbon"><span>out of stock</span></div>
          <?php } ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 font-weight-bold">
            <?php echo ucwords(strtolower($row['ITMNAM'])); ?>
              </div>
          </div>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
            <?php echo strtolower($row['DESCRP']); ?>
              </div>
          </div>
         
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 font-weight-bold">
            <span class="align-middle">&#2352; <?php echo number_format($row['PRICE'],2); ?></span>
            </div>
          </div>
        <div class="row" >
          <div class="col col-lg-6 col-md-6 col-sm-6 col-xs-6">
            &nbsp;
          </div>
          <div class="col col-lg-6 col-md-6 col-sm-6 col-xs-6 quantity_span pull-right">
            <span class="add_button_span" style="position: absolute;right:0;bottom:0">
              <?php if($row['STKOUT'] == 0) { ?>
              <button style="background-color:#c55c58;border-radius: 15px;color: white;" class="pull-right btn btn-sm font-weight-bold add_qty" >Add</button>
            <?php } ?>
            </span>
            <span class="plus_minus_span qty" style="display: none;position: absolute;right:0;bottom:0">
              <input type="hidden" class="itmcod" value="<?php echo $row['ITMCOD']; ?>" />
              <input type="hidden" class="itmrat" value="<?php echo $row['PRICE']; ?>" />
              <input type="hidden" class="taxstr" value="<?php echo $row['TAXSTR']; ?>" />
              <input type="hidden" class="itmnam" value="<?php echo $row['ITMNAM']; ?>" />
              <input type="hidden" class="mentyp" value="<?php echo $MENTYP; ?>" />
              <input type="hidden" class="mengrp" value="<?php echo $row['MENGRP']; ?>" />
                          <span class="minus bg-danger">-</span>
                          <input style="color:black;width:25px" readonly="readonly" type="text" maxlength="2" size="2" class="qty_text" name="qty_text" value="0">
                          <span class="plus bg-success">+</span>
                      </span>
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
        }
      ?>
      </div>



      <div class=" container">
        <div class='row'><div class='col-md-12'><br></div></div>
        <div class='row'><div class='col-md-12'><br></div></div>
      </div>

    </main>
    </div>

    <nav style="background-color:#18b1b1;color:white" class="navbar fixed-bottom">
      <a style="background-color: #c55c58;color:white" class="btn btn-sm" onclick="place_order()" >Add to Cart</a>
      <?php
      if($cart_quantity > 0){
        ?>
        <a style="background-color: #c55c58;color:white" class="btn btn-sm" href="cart.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>">View Cart</a>
        <?php
      }
      ?>
      <?php
      if($bill_quantity>0){
        ?>
        <a style="background-color: #c55c58;color:white" class="btn btn-sm" href="bill.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>">View Bill</a>
        <?php
      }
      ?>
    </nav>


<!-- Start your project here-->

<!-- /Start your project here-->

<!-- SCRIPTS -->
<!-- JQuery -->
<script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
<!-- Bootstrap tooltips -->
<script type="text/javascript" src="js/popper.min.js"></script>
<!-- Bootstrap core JavaScript -->
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<!-- MDB core JavaScript -->
<script type="text/javascript" src="js/mdb.min.js"></script>



<script type="text/javascript">
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
    var object4 = $(object1).find(".qty_text");
    $(object4).val("1");
    var itmcod = $(object1).find(".itmcod").val();
    var itmrat = $(object1).find(".itmrat").val();
    var taxstr = $(object1).find(".taxstr").val();
    var itmnam = $(object1).find(".itmnam").val();
    var mentyp = $(object1).find(".mentyp").val();
    var mengrp = $(object1).find(".mengrp").val();
    item_obj[itmcod] = {};
    item_obj[itmcod]['qty'] = 1;
    item_obj[itmcod]['itmrat'] = itmrat;
    item_obj[itmcod]['taxstr'] = taxstr;
    item_obj[itmcod]['itmnam'] = itmnam;
    item_obj[itmcod]['mentyp'] = mentyp;
    item_obj[itmcod]['mengrp'] = mengrp;
    $(object2).slideUp("slow");
    $(object3).slideDown("slow");
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
    var mentyp = $(object1).find(".mentyp").val();
    var mengrp = $(object1).find(".mengrp").val();
    item_obj[itmcod] = {};
    item_obj[itmcod]['qty'] = v;
    item_obj[itmcod]['itmrat'] = itmrat;
    item_obj[itmcod]['taxstr'] = taxstr;
    item_obj[itmcod]['itmnam'] = itmnam;
    item_obj[itmcod]['mentyp'] = mentyp;
    item_obj[itmcod]['mengrp'] = mengrp;
  });

  $('.minus').click(function () {
    var object1 = $(this).parent(); 
    var object2 = $(object1).find(".qty_text");
    var v = parseInt($(object2).val());
    v = v - 1;
    object2.val(v);
    var object3 = $(this).parent().parent('.quantity_span'); 
    var object4 = $(object3).find(".add_button_span");
    var object5 = $(object3).find(".plus_minus_span");
    if(v == 0){
      $(object5).slideUp("slow");
      $(object4).slideDown("slow");
    }
    var itmcod = $(object1).find(".itmcod").val();
    var itmrat = $(object1).find(".itmrat").val();
    var taxstr = $(object1).find(".taxstr").val();
    var itmnam = $(object1).find(".itmnam").val();
    var mentyp = $(object1).find(".mentyp").val();
    var mengrp = $(object1).find(".mengrp").val();
    item_obj[itmcod] = {};
    item_obj[itmcod]['qty'] = v;
    item_obj[itmcod]['itmrat'] = itmrat;
    item_obj[itmcod]['taxstr'] = taxstr;
    item_obj[itmcod]['itmnam'] = itmnam;
    item_obj[itmcod]['mentyp'] = mentyp;
    item_obj[itmcod]['mengrp'] = mengrp;
  });

});
  function load_menu2(ev,menu_group){
    $(".changeable").each(function() {
      $(this).css("background-color","#18b1b1")
    });
    ev.style.backgroundColor = "#c55c58";
    var property_id = "<?php echo $property_id; ?>";
    var rescod = "<?php echo $rescod; ?>";
    load_menu(0,menu_group,property_id,rescod);
  };

  function load_menu_group(menu_type,property_id,rescod){
    $.ajax({
      url: "load_menu_group.php",
      type: "get",
      data: {menu_type: menu_type, property_id: property_id, rescod: rescod},
      success: function (html) {
        $('#menu_group_div').html(html);
        var menu_type = $("#menu_type").val();
        var firstElementWithClass = document.querySelector('.changeable');
        var menu_group = $(firstElementWithClass).data("id");
        if(menu_group == null) menu_group = 0;
        load_menu(menu_type,menu_group,property_id,rescod);
      },
      error : function(error){
        console.log(error);
      }
    });
  }
  function load_menu(menu_type,menu_group,property_id,rescod){
    $.ajax({
      url: "load_menu.php",
      type: "get",
      data: {menu_type: menu_type,menu_group: menu_group, property_id: property_id, rescod: rescod},
      success: function (html) {
        $('#menu_item').html(html);
        $(".itmcod").each(function () {
          var itmcod2 = $(this).val();
          if (itmcod2 in item_obj) {
            var object1 = $(this).parent().parent().parent().parent('.card-body'); 
            var object2 = $(object1).find(".qty");
            var object3 = $(this).parent().find(".qty_text");
            if(item_obj[itmcod2]["qty"] != 0){
              var object6 = object1.find(".add_button_span");
              object6.slideUp("fast");
              var object4 = $(this).parent();
              object4.slideDown("fast");
              var object5 = object1.find(".add_qty_div");
              var quantity = parseInt(item_obj[itmcod2]["qty"]);
              object3.val(quantity);
              object5.slideUp("fast");
            }
          }
        });
      },
      error : function(error){
        console.log(error);
      }
    });
  }
  $(document).ready(function () {
    var menu_type = $("#menu_type").val();
    var menu_group = $("#menu_group").val();
    var property_id = "<?php echo $property_id; ?>";
    var rescod = "<?php echo $rescod; ?>";
    //load_menu(menu_type,menu_group,property_id,rescod);

    $("#menu_type").change(function() {
      var menu_type = $("#menu_type").val();
      load_menu_group(menu_type,property_id,rescod);
    });

    $("#menu_group").change(function() {
      var menu_type = $("#menu_type").val();
      var menu_group = $("#menu_group").val();
      var property_id = "<?php echo $property_id; ?>";
      var rescod = "<?php echo $rescod; ?>";
      load_menu(menu_type,menu_group,property_id,rescod);
    });
  });

  function remove_item(row,id){
    var item_selected = false;
    $("#addr" + row).remove();
    $("#addr" + (row-1)).remove();
    item_obj[id]['qty'] = 0;
    for (var key in item_obj) {
      if(item_obj[key]['qty']>0){
        item_selected=true;
        
      }
    }
    if(!item_selected){
      window.location.href = "menu.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>";
    }
  }

  function cancel_order(){
    if (confirm("All items will be removed. Are you Sure?") == true) {
      window.location.href = "menu.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>";
    }
  }

  function confirm_order() {
    $("#confirm_button").attr("disabled","true");
    var item_selected = false;
    var sales = new Array();
    var property_id = "<?php echo $property_id; ?>";
    var rescod = "<?php echo $rescod; ?>";
    var tblnub = "<?php echo $tblnub; ?>";
    var mobile = "<?php echo $mobile; ?>";
    for (var key in item_obj) {
      if(item_obj[key]['qty']>0){
        item_selected=true;
        var record = {
          'itmcod': key,
          'itmrat': item_obj[key]['itmrat'],
          'taxstr': item_obj[key]['taxstr'],
          'itmnam': item_obj[key]['itmnam'],
          'quantity': item_obj[key]['qty'],
          'mentyp': item_obj[key]['mentyp'],
          'mengrp': item_obj[key]['mengrp']
        };
        sales.push(record);
      }
    }
    var sales_data = JSON.stringify(sales);
    $.ajax({
      type: 'POST',
      url: 'save_sales.php',
      data: {
        rescod: rescod,
        property_id: property_id,
        sales: sales_data,
        tblnub: tblnub,
        mobile: mobile
      },
      success: function (response) {
        if(response.includes("Success")){
          window.location.href = "cart.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>";
        }else{
          alert("Something went wrong.Cannot place order");
        }
      },
      error : function(error){
        console.log(error);
      }
    });
  }

  function place_order() {
    var item_selected = false;
    var sales = new Array();
    var property_id = "<?php echo $property_id; ?>";
    var rescod = "<?php echo $rescod; ?>";
    var tblnub = "<?php echo $tblnub; ?>";
    var mobile = "<?php echo $mobile; ?>";
    for (var key in item_obj) {
      if(item_obj[key]['qty']>0){
        item_selected=true;
        var record = {
          'itmcod': key,
          'itmrat': item_obj[key]['itmrat'],
          'taxstr': item_obj[key]['taxstr'],
          'itmnam': item_obj[key]['itmnam'],
          'quantity': item_obj[key]['qty'],
          'mentyp': item_obj[key]['mentyp'],
          'mengrp': item_obj[key]['mengrp']
        };
        sales.push(record);
      }
    }
    if(!item_selected){
      alert("Please add an item");
      return;
    }

    $("#myModal").modal({backdrop: 'static', keyboard: false});
    var html='<div class="table-responsive"><table class="table table-bordered table-striped">';
    html+='<tbody>';    
    var i=0;
    for (var key in item_obj) {
      if(item_obj[key]['qty']>0){
        var rate=item_obj[key]['itmrat'];
        rate = parseInt(rate, 10);
        html+='<tr  id="addr'+i+'">';
        html += "<td style='text-align: left;font-weight:bold;border-color:grey' colspan='2'>"+item_obj[key]['itmnam']+"<br>&#2352;"+rate+"<br>";
        html +='<div class="qty text-center" style="text-align:center !important">';
        html +="<span onclick='minus_item("+i+","+key+",this)' class='minus bg-danger'>-</span>";
        html +='&nbsp;<input style="color:black;width:25px;" readonly="readonly" type="text" maxlength="2" size="2" class="quantity" value="'+item_obj[key]['qty']+'">&nbsp;';
        html +="<span onclick='plus_item("+i+","+key+",this)' class='plus bg-success'>+</span>";
        html +="<span style='font-size:20px;font-weight:bold;color:red;vertical-align:middle' onclick='remove_item("+i+","+key+")' class='fa fa-remove  pull-right'></span>";
        html +='</div>';
        html += "</td></tr>";
        i++;
      }
    }
    html+='</tbody>';    
    html +='</table></div>';
    $("#modalbody").html(html);
  }  

  function minus_item(row,id,self){
    var divUpd = $(self).parent().parent().find('.quantity');
    newVal = parseInt(divUpd.val(), 10) - 1;
    item_obj[id]['qty'] = newVal;
    if (newVal >= 1) {
      divUpd.val(newVal);
      return;
    }else{
      var item_selected = false;
      $("#addr" + row).remove();
      item_obj[id]['qty'] = 0;
      for (var key in item_obj) {
        if(item_obj[key]['qty']>0){
          item_selected=true;
        }
      }
      if(!item_selected){
        window.location.href = "menu.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>";
      }
    }
  }

  function plus_item(row,id,self){
    var divUpd = $(self).parent().parent().find('.quantity');
    newVal = parseInt(divUpd.val(), 10) + 1;
    divUpd.val(newVal);
    item_obj[id]['qty'] = newVal;
  }

  function remove_item(row,id){
    var item_selected = false;
    $("#addr" + row).remove();
    item_obj[id]['qty'] = 0;
    for (var key in item_obj) {
      if(item_obj[key]['qty']>0){
        item_selected=true;        
      }
    }
    if(!item_selected){
      window.location.href = "menu.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>";
    }
  }

  $('.modal').on('show.bs.modal', function (ev) { // prevent body from scrolling when modal opens
    $('body').bind('touchmove', function(e){
        if (!$(e.target).parents().hasClass( '.modal' )){ //only prevent touch move if it is not the modal
          e.preventDefault()
        }
      })
  })
  $('.modal').on('hide.bs.modal', function (e) { //unbind the touchmove restrictions from body when modal closes
    $('body').unbind('touchmove');
  })
</script>
<?php include "noback.php"; ?>
</body>
</html>