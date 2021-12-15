<?php
session_start();
include_once("config.php");
$otp = $_SESSION['otp'];
$cstcod = isset($_GET['cstcod']) ? $_GET['cstcod']: "";
$rescod = isset($_GET['rescod']) ? $_GET['rescod']: "";
$tblnub = isset($_GET['tblnub']) ? $_GET['tblnub']: "";
$mobile = isset($_GET['mobile']) ? $_GET['mobile']: "";
if($cstcod =="" || $rescod =="" || $tblnub =="" || $mobile ==""){
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
$msg = "";
if(isset($_POST['submit'])){
    $otp = $_POST['otp1'].$_POST['otp2'].$_POST['otp3'].$_POST['otp4'];
    if(isset($_SESSION['otp']) && $_SESSION['otp'] ==  $otp){
        $url = "menu.php?cstcod=$cstcod&rescod=$rescod&tblnub=$tblnub&mobile=$mobile";
        header("location: $url");
    }else{
        $msg = "Invalid OTP";
    }    
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
    <style> 
.button {
  background-color: #016135;
  padding: 15px;
  border-radius: 15px;
  color: white;
  border: none;
}
.button:hover {background-color: #016135}

.button:active {
  background-color: #016135;
  box-shadow: 0 5px #016135;
  transform: translateY(4px);

</style>

  </head>
  <body style="background-color: #6c757d">
    <div class="container-fluid">    
    <nav style="background-color: #355bc8" class="navbar fixed-top navbar-expand-lg navbar-dark">
      <a class="navbar-brand font-weight-bold" href="#"><?php echo " ".$outnam."&nbsp;Table# ".$tblnub; ?></a>
    </nav>
    
    <hr class="my-4">
    <main>
        <br>
        <div class="row">
          <div class="col-md-12 text-center text-danger font-weight-bold">
            <span><?php echo $msg; ?></span>
          </div>
        </div>
        <form action="" method="post">
       <div class="row">
        <div class="col-md-12" style="text-align: center !important">
          <input  value="<?php echo substr($otp,0,1); ?>"autofocus="autofocus" size="1" maxlength="1" name="otp1" class="inputs Number">
          <input value="<?php echo substr($otp,1,1); ?>" size="1" maxlength="1" name="otp2" class="inputs Number">
          <input value="<?php echo substr($otp,2,1); ?>"size="1" maxlength="1" name="otp3" class="inputs Number">
          <input value="<?php echo substr($otp,3,1); ?>" size="1" maxlength="1" name="otp4" class="inputs Number">
        </div>
       </div>
       <div style="padding-top: 10px;" class="row">
        <div class="col-md-12 text-center">

          <input name="submit" value="Verify OTP"  type="submit" class="button text-center">
        </div>
      </div>
        </form>
        </div>
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
    $(".inputs").keyup(function () {
        if (this.value.length == this.maxLength) {
          $(this).next('.inputs').focus();
        }
    });

    $('.Number').keypress(function (event) {
        var keycode = event.which;
        if (!(event.shiftKey == false && (keycode == 46 || keycode == 8 || keycode == 37 || keycode == 39 || (keycode >= 48 && keycode <= 57)))) {
        event.preventDefault();
        }
        });
  </script>
<?php include "noback.php"; ?>
  </body>
</html>