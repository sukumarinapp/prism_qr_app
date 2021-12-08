<?php
//http://192.168.1.4:81/vegefoods/?cstcod=1175&rescod=AKO&tblnub=10
include_once("config.php");
$cstcod = isset($_GET['cstcod']) ? $_GET['cstcod']: "";
$rescod = isset($_GET['rescod']) ? $_GET['rescod']: "";
$tblnub = isset($_GET['tblnub']) ? $_GET['tblnub']: "";
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
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favico.ico">
    <title>PRISM</title>
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <style type="text/css">
      body {
        min-height: 2000px;
        padding-top: 70px;
      }
    </style>
  </head>
  <body>
    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>"><?php echo $outnam; ?></a>
          <a class="btn btn-lg btn-success" onclick="place_order()"  href="#">Place Order</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="index.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>">Home</a></li>
            <li><a href="#">Place Order</a></li>
            <li><a href="cart.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>">Cart</a></li>
            <li><a href="#">Checkout</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    <div class="container">
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
<div class='row'><div class='col-md-12'><br></div></div>
<div id="menu_item"></div>
</div>

    </div> <!-- /container -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha384-nvAa0+6Qg9clwYCGGPpDQLVpLNn0fRaROjHqs13t4Ggj3Ez50XnGQqc/r8MhnRDZ" crossorigin="anonymous"></script>
    <script src="dist/js/bootstrap.min.js"></script>


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
          url: "load_menu.php",
          type: "get",
          data: {menu_type: menu_type,menu_group: menu_group, property_id: property_id, rescod: rescod},
          success: function (html) {
              $('#menu_item').html(html);
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
        $(".qty_text").each(function () {
            if (parseFloat(this.value)) {
                var quantity = parseFloat(this.value);                
                var div = $(this).parent();
                if(quantity != 0){
                  var itmcod = $(div).children(".itmcod").val();                
                  var itmrat = $(div).children(".itmrat").val();                
                  var itmnam = $(div).children(".itmnam").val();                
                  var record = {
                    'itmcod': itmcod,
                    'itmrat': itmrat,
                    'itmnam': itmnam,
                    'quantity': quantity
                };
                sales.push(record);
            }
        }
      });
        var sales_data = JSON.stringify(sales);
      $.ajax({
          type: 'POST',
          url: 'save_sales.php',
          data: {
              rescod: rescod,
              property_id: property_id,
              sales: sales_data,
              tblnub: tblnub,
          },
          success: function (response) {
            //console.log(response);
              //var res = JSON.parse(response);
              window.location.href = "cart.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>";
          },
          error : function(error){
              console.log(error);
          }
      });
  }  
  </script>
  </body>
</html>
