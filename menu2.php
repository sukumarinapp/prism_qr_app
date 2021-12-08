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

$sql = "select b.* from posord a,poskot b where a.order_id=b.order_id and a.rescod='$rescod' and  a.property_id='$property_id' and a.tblnub='$tblnub'";
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
          background-image: url("bg.jpg");
          background-repeat: none;
          background-size: 100% auto;
        }
    </style>
  </head>

  <body style="background-color: black">
    <div class="container my-4">    

    <hr class="my-4">

    <nav class="navbar fixed-top navbar-expand-lg navbar-dark info-color">
      <a class="navbar-brand font-weight-bold" href="menu.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=$mobile"><?php echo $outnam; ?></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
       <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="menu.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=$mobile">Menu</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="cart.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>">Cart</a>
          </li>
        </ul>
      </div>
    </nav>

    <!--Main layout-->
    <main>
        <br>
        <div class="row">
          <div class="col-md-12">
            <select class="form-control" id="menu_type">
              <?php
                $sql="";
                if($property_id == 2){
                  $sql = "select * from sys001 where RECCOD=5 and property_id='$property_id' order by RECTYP";
                }else{
                $sql = "select * from sys001 where RECTYP <> 2 and  RECCOD=5 and property_id='$property_id' order by RECTYP";
                }
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_array($result)){
                  echo "<option value='".$row['RECTYP']."'>".$row['DESCRP']."</option>";
                }
                ?>
            </select>
          </div>
        </div>


<div class="row">
  <div class="col-md-12" id="menu_group_div">
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
  </div>
</div>
<br>
<script>
  var item_obj = {};
</script>
<div id="menu_item" >
</div>

<div class=" container">
  <div class='row'><div class='col-md-12'><br></div></div>
  <div class='row'><div class='col-md-12'><br></div></div>
</div>

    </main>
    <!--Main layout-->

    <nav class="navbar fixed-bottom navbar-expand-lg bg-info">
      <a class="btn btn-sm btn-danger font-weight-bold" href="#" onclick="place_order()">Place Order</a>
      <a class="btn btn-sm btn-danger font-weight-bold" href="cart.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>">Cart</a>
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
  function load_menu_group(menu_type,property_id,rescod){
    $.ajax({
          url: "load_menu_group.php",
          type: "get",
          data: {menu_type: menu_type, property_id: property_id, rescod: rescod},
          success: function (html) {
              $('#menu_group_div').html(html);
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
          url: "load_menu2.php",
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

  function place_order() {
    var sales = new Array();
    var property_id = "<?php echo $property_id; ?>";
    var rescod = "<?php echo $rescod; ?>";
    var tblnub = "<?php echo $tblnub; ?>";
    var mobile = "<?php echo $mobile; ?>";
    for (var key in item_obj) {
      if(item_obj[key]['qty']>0){
        var record = {
          'itmcod': key,
          'itmrat': item_obj[key]['itmrat'],
          'taxstr': item_obj[key]['taxstr'],
          'itmnam': item_obj[key]['itmnam'],
          'quantity': item_obj[key]['qty']
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
          var res = JSON.parse(response);
          console.log(res);
          window.location.href = "cart.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>";
        },
        error : function(error){
            console.log(error);
        }
    });
  }  
</script>
<?php include "noback.php"; ?>
</body>
</html>