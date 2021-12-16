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

$sql = "select b.* from posord a,poskot b where a.order_id=b.order_id and a.rescod='$rescod' and  a.property_id='$property_id' and a.tblnub='$tblnub' and a.mobile='$mobile' and  (a.status='pending' or a.status='ordered' )";
$result = mysqli_query($conn, $sql);
$cart_quantity = 0;                    
while($row = mysqli_fetch_array($result)){
  $cart_quantity = $cart_quantity + $row['itmqty'];
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
  <!-- Material Design Bootstrap -->
  <link href="css/mdb.min.css" rel="stylesheet">
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
            <a class="nav-link" href="menu.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=$mobile">Menu</a>
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
              <button type="button" onclick="cancel_order()" style="background-color: #ff4a4b" class="btn btn-sm text-center" >Cancel</button>
              <button id="confirm_button" type="button" onclick="confirm_order()" style="background-color: #38ab2c" class="btn  btn-sm text-center" >Confirm</button>
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
        $sql = "select a.MENGRP,a.ITMNAM,a.ITMCOD,b.PRICE,b.TAXSTR,c.LNGNAM,a.DESCRP from posmas a,posrat b,set100 c where  a.MENGRP=c.GRPCOD and a.property_id=b.property_id and a.property_id=c.property_id and a.property_id='$property_id' and a.ITMCOD=b.ITMCOD and b.RESCOD='$rescod'"; 
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
              <button style="background-color:#c55c58;border-radius: 15px;" class="pull-right btn btn-sm font-weight-bold add_qty" >Add</button>
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
    <!--Main layout-->

    <nav style="background-color:#18b1b1" class="navbar fixed-bottom navbar-expand-lg navbar-dark">
      <button type="button" id="order_button" style="background-color: #c55c58" class="btn btn-sm font-weight-bold" onclick="place_order()" />Add to Cart</button>
      <?php
      if($cart_quantity>0){
        ?>
        <a style="background-color: #c55c58" class="btn btn-sm font-weight-bold" href="cart.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>">View Cart</a>
        <?php
      }
      ?>
    </nav>

  </strong>
</div>

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
        var menu_group = $("#menu_group").val();
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
              var object4 = $(this).parent();
              object4.slideDown();
              var object5 = object1.find(".add_qty_div");
              var quantity = parseInt(item_obj[itmcod2]["qty"]);
              object3.val(quantity);
              object5.slideUp();
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
    load_menu(menu_type,menu_group,property_id,rescod);

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
        console.log(response);
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
        html +='<input style="color:black;width:25px;" readonly="readonly" type="text" maxlength="2" size="2" class="quantity" value="'+item_obj[key]['qty']+'">';
        html +="<span onclick='plus_item("+i+","+key+",this)' class='plus bg-success'>+</span>";
        html +="<span style='font-weight:bold;color:red;vertical-align:middle' onclick='remove_item("+i+","+key+")' class='fa fa-2x fa-trash-o pull-right'></span>";
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