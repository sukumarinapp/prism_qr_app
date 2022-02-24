<?php
session_start();
include_once("config.php");
$cstcod = isset($_GET['cstcod']) ? $_GET['cstcod']: "";
$rescod = isset($_GET['rescod']) ? $_GET['rescod']: "";
$tblnub = isset($_GET['tblnub']) ? $_GET['tblnub']: "";
if($cstcod =="" || $rescod =="" || $tblnub ==""){
  die("Prism Bangalore");
}
$sql = "select * from prmlic where cstcod='$cstcod'";
$result = mysqli_query($conn, $sql);
$property_id = 0;
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
if(isset($_POST['submit2'])){
    $mobile = trim($_POST['mobile']);
    /*$otp = rand(1001,9999);
    $url = "https://www.instaalerts.zone/SendSMS/sendmsg.php?uname=SAMRAT&pass=abc321&send=RIGHTC";
    $msg = urlencode("Your dining OTP is ".$otp);
    $url = $url . "&dest=".$mobile."&msg=".$msg;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, false);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);*/
    //$output = curl_exec($ch);
    //curl_close($ch);
    //$_SESSION['otp'] =  $otp;    
    $url = "menu.php?cstcod=$cstcod&rescod=$rescod&tblnub=$tblnub&mobile=$mobile";
    header("location: $url");
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Expires" content="0">
    <title><?php echo $outnam; ?></title>
    <link rel="icon" href="favico.ico">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
    <style> 
.button {
  background-color: #c55c58;
  padding: 15px;
  border-radius: 15px;
  color: white;
  border: none;
}
.button:hover {background-color: #c55c58}

.button:active {
  background-color: #c55c58;
  box-shadow: 0 5px #c55c58;
  transform: translateY(4px);

</style>
  </head>
  <body>
    <div class="container my-4">    
    <nav style="background-color: #18b1b1" class="navbar fixed-top navbar-expand-lg navbar-dark">
      <a class="navbar-brand font-weight-bold" href="#"><?php echo " ".$outnam."&nbsp;Table# ".$tblnub; ?></a>
    </nav>
    <hr class="my-4">
    <br>
    <main>
      <div class="container-fluid">
        <form action="" method="post" name="form">
        <div class="row">
          <div class="col-md-12">
            <div class="input-group">
                <input required="required" tabindex="0" autofocus placeholder="Please enter your mobile no" name="mobile" maxlength="10" class="Number form-control border-right-0">
                <span class="input-group-append bg-white border-left-0">
                    <span class="input-group-text bg-transparent">
                        <i class="fa fa-mobile"></i>
                    </span>
                </span>
            </div>
          </div>
        </div>
        <div style="padding-top:10px;" class="row">
          <div class="col-md-12 text-center">
                <input name="submit2" value="Submit"  type="submit" class="button text-center">
          </div>
        </div>
        </form>
      </div>
    </main>      
    </div>
    <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
    <script type="text/javascript" src="js/popper.min.js"></script>
    <!-- Bootstrap core JavaScript -->
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!-- MDB core JavaScript -->
    <script type="text/javascript" src="js/mdb.min.js"></script>
  <script type="text/javascript">
    $('.Number').keypress(function (event) {
        var keycode = event.which;
        if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
          event.preventDefault();
        }
      });

  </script>
  </body>
</html>