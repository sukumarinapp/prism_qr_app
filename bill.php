<?php
session_start();
include_once("config.php");
$cstcod = isset($_GET['cstcod']) ? $_GET['cstcod']: "";
$rescod = isset($_GET['rescod']) ? $_GET['rescod']: "";
$tblnub = isset($_GET['tblnub']) ? $_GET['tblnub']: "";
$mobile = isset($_GET['mobile']) ? $_GET['mobile']: "";

$tax_array = array();

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

$allow_checkout = 0;
$sql = "select * from prmmod where property_id='$property_id' and MODCOD='POS' and SRLNUB=110";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
  $allow_checkout = $row['YESNOO'];
}

$order_id = 0;
$_SESSION['order_id'] = $order_id;
$sql100 = "select b.* from posord a,poskot b where a.order_id=b.order_id and a.rescod='$rescod' and  a.property_id='$property_id' and a.tblnub='$tblnub' and a.mobile='$mobile' and b.status='pending' order by kotnub,kotsrl";
$result100 = mysqli_query($conn, $sql100);
$cart_quantity = 0;             
while($row100 = mysqli_fetch_array($result100)){
  $cart_quantity = $cart_quantity + $row100['itmqty'];
}
$sql = "select b.* from posord a,poskot b where a.order_id=b.order_id and a.rescod='$rescod' and  a.property_id='$property_id' and a.tblnub='$tblnub' and a.mobile='$mobile' and b.status in ('ordered','accepted')  order by kotnub,kotsrl";
$result = mysqli_query($conn, $sql);
while($row = mysqli_fetch_array($result)){
  $order_id = $row['order_id'];
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
  </style>
</head>

<body class="bg-white text-black">
  <div class="container my-4">    

    <hr class="my-4">

    <nav style="background-color:#18b1b1" class="navbar fixed-top navbar-expand-lg navbar-dark">
      <a class="navbar-brand font-weight-bold" href="#"><?php echo " ".$outnam."&nbsp;Table# ".$tblnub; ?></a>
    </nav>

    <!--Main layout-->

    <br>
    <div class="row">
      <div class="col-md-12">
        <div class="table-responsive">
          <table class="text-black bg-white table table-bordered table-striped" id="dataTables-example">
            <thead>
              <tr style="background-color: #18b1b1;color: whitesmoke; font-weight: bold !important">
                <!-- <th>Kot#</th> -->
                <th>Item</th>
                <th style="text-align: right">Rate</th>
                <th style="text-align: right">Qty</th>
                <th style="text-align: right">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $net_total = 0;

              

              $total = 0;
              $result = mysqli_query($conn, $sql);
              while($row = mysqli_fetch_array($result)){
                $total = $total + $row['itmval'];
                $net_total = $net_total + $row['itmval'];
                $itemstatus = $row['status'];
                $itemcolor = "black";
                ?>
                <tr>
                  <td style="color:<?php echo $itemcolor; ?>">
                    <input type="hidden" class="printitemid" name="itemid[]" value="<?php echo $row['id']; ?>">
                    <input type="hidden" class="itemstatus" name="itemstatus[]" value="<?php echo $row['status']; ?>">
                    <?php echo ucwords(strtolower($row['itmnam'])); ?></td>
                  <td style="text-align: right">&#2352;<?php echo $row['itmrat']; ?></td>
                  <td style="text-align: right"><?php echo $row['itmqty']; ?></td>
                  <td style="text-align: right">&#2352;<?php echo number_format($row['itmval'],2); ?></td>
                </tr>
                <?php
              }
              ?>
              <tr>
                <td align="right" colspan="3">Sub Total</td>
                <td align="right" colspan="2" >&#2352;<?php echo number_format($total,2); ?></td>
              </tr>

              <?php
              $sql2 = "select * from postax where order_id='$order_id'";
              $result2 = mysqli_query($conn, $sql2);
              while($row2 = mysqli_fetch_array($result2)){
                $net_total = $net_total + $row2['taxamt'];
                ?>
                <tr>
                  <td align="right" colspan="3"><?php echo $row2['descrp']; ?></td>
                  <td align="right" colspan="2" >&#2352;<?php echo number_format($row2['taxamt'],2); ?></td>
                </tr>
                <?php
              }

              $sql = "select * from set090 where rescod='$rescod'";
              $result = mysqli_query($conn, $sql);
              $RNDTYP =  0;
              $RNDAMT =  0;
              while($row = mysqli_fetch_array($result)){
                $RNDTYP = $row['RNDTYP'];
                $RNDAMT = $row['RNDAMT'];
              }
              $net_total2 = 0;
              if($RNDTYP==0){
                $net_total2 = $net_total;
              }else if($RNDTYP==1){
                $net_total2 = round($net_total / $RNDAMT) * $RNDAMT;
              }else if($RNDTYP==2){
                $net_total2 = ceil($net_total / $RNDAMT) * $RNDAMT;
              }else if($RNDTYP==3){ 
                $net_total2 = floor($net_total / $RNDAMT) * $RNDAMT;
              }

              $RONDOF = $net_total2-$net_total;
              ?>
              <tr>
                <td align="right" colspan="3">Round Off</td>
                <td align="right" colspan="2" >&#2352;<?php echo number_format($RONDOF,2); ?></td>
              </tr>
              <tr style="background-color: #18b1b1;color: whitesmoke; font-weight: bold !important">
                <td align="right" class="font-weight-bold" colspan="3">Net Total</td>
                <td align="right" class="font-weight-bold" colspan="2" >&#2352;<?php echo number_format($net_total2,2); ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class='row'><div class='col-md-12'><br></div></div>
    <div class='row'><div class='col-md-12'><br></div></div>
    <div class='row'><div class='col-md-12'><br></div></div>
    

    <!--Main layout-->

    <nav style="background-color:#18b1b1" class="navbar fixed-bottom navbar-expand-lg navbar-dark">
      <a style="background-color: #c55c58;color:white" class="btn btn-sm" href="menu.php?cstcod=<?php echo $cstcod; ?>&rescod=<?php echo $rescod; ?>&tblnub=<?php echo $tblnub; ?>&mobile=<?php echo $mobile; ?>" >Menu</a>
      <?php
      if($cart_quantity>0 && $allow_checkout==0){
        ?>
        <!-- <div class="col col-md-3 col-sm-3">
        <a style="background-color: #38ab2c" class="btn btn-xs" href="pay.php?cstcod=<?php echo $cstcod; ?>&oid=<?php //echo $order_id; ?>" ><i class="fa fa-credit-card"></i></a>
</div> -->
        <?php
        $_SESSION['net_total'] = $net_total2;
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
<script type="text/javascript">
  function print_order(){
    var salesprint = new Array();
    $(".printitemid").each(function() {
      var record = {
          'printitemid': $(this).val()
      };
      salesprint.push(record);
    });
    $.ajax({
      type: 'POST',
      url: 'print_order.php',
      data: {
        sales: salesprint
      },
      success: function (response) {
        alert("Your order is confirmed");
        location.reload();
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