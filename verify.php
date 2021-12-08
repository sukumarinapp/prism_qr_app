<?php
require('config.php');
session_start();

//print_r($_REQUEST);

$order_id = '';
$tblnub = '';
$property_id = 0;
$rescod = "";
$mobile = "";
$shopping_order_id = $_REQUEST['shopping_order_id'];
$sql = "select a.*,b.tblnub,b.table_suffix,b.property_id,b.rescod,b.mobile from payment a,posord b where a.order_id=b.order_id and payment_id='$shopping_order_id'";
$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));
while($row = mysqli_fetch_assoc($result)){
    $order_id = $row['order_id'];
    $tblnub = $row['tblnub'].$row['table_suffix'];
    $property_id = $row['property_id'];
    $rescod = $row['rescod'];
    $mobile = $row['mobile'];
}

$sql = "select a.*,b.cstcod from prmmne a,prmlic b where  a.property_id=b.id and property_id=$property_id";
$result = mysqli_query($conn, $sql);
$keyId = "";
$keySecret = "";
$cstcod = "";
while($row = mysqli_fetch_array($result)){
  $cstcod = $row['cstcod'];  
  if($row['SRLNUB']=="998"){
    $keyId = $row['STR001'];
  }
  if($row['SRLNUB']=="999"){
    $keySecret = $row['STR001'];
  }
}

require('razorpay-php/Razorpay.php');
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($_POST['razorpay_payment_id']) === false)
{
    $api = new Api($keyId, $keySecret);

    try
    {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_POST['razorpay_order_id'],
            'razorpay_payment_id' => $_POST['razorpay_payment_id'],
            'razorpay_signature' => $_POST['razorpay_signature']
        );

        $api->utility->verifyPaymentSignature($attributes);
    }
    catch(SignatureVerificationError $e)
    {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta http-equiv="Expires" content="0">
    <title>Razor Pay</title>
    <link rel="icon" href="favico.ico">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="css/mdb.min.css" rel="stylesheet">
    <!-- Your custom styles (optional) -->
    <link href="css/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="container my-4">    
        <div class="row">
          <div class="col-md-12 text-center">
<?php
    if ($success === true)
    {
   
    $conn->autocommit(FALSE);
    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$_POST['razorpay_payment_id']}</p>";
    include "insert_bill.php";
    if (strpos($response, 'Success') == false) {
        $conn->rollback();
    }else{
        $response = json_decode($response);
        $prism_bilnub = $response[0]->BilNub;
        include "insert_pay.php";
        if (strpos($response, 'Success') == false) {
            $conn->rollback();  
        }else{
            $sql = "update posord set status='paid' where order_id='$order_id'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $sql = "update poskot set status='paid' where order_id='$order_id'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $sql = "update payment set status='paid',prism_bilnub=$prism_bilnub where order_id='$order_id'";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $_SESSION['otp'] = "";
            $conn->commit();
            echo $html;
        }
    }
}
else
{
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
    echo $html;
}

?>
</div>
</div>
</div>
<?php include "noback.php"; ?>
</body>
</html>