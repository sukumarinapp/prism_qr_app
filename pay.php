<?php
require('config.php');
require('razorpay-php/Razorpay.php');
session_start();

// Create the Razorpay Order

use Razorpay\Api\Api;

$cstcod = isset($_GET['cstcod']) ? $_GET['cstcod']: "";
$sql = "select a.id,b.SRLNUB,b.STR001 from prmlic a,prmmne b where a.id=b.property_id and a.cstcod='$cstcod'";
echo $sql;die;
$result = mysqli_query($conn, $sql);
$property_id = 0;
$keyId = "";
$keySecret = "";
while($row = mysqli_fetch_array($result)){
  $property_id = $row['id'];
  if($row['SRLNUB']=="998"){
    $keyId = $row['STR001'];
  }
  if($row['SRLNUB']=="999"){
    $keySecret = $row['STR001'];
  }
}
$_SESSION['keyId'] = $keyId;
$_SESSION['keySecret'] = $keySecret;


$api = new Api($keyId, $keySecret);

//
// We create an razorpay order using orders api
// Docs: https://docs.razorpay.com/docs/orders
//

$net_total = $_SESSION['net_total'];
$order_id2 = $_SESSION['order_id'];
$orderData = [
    'receipt'         => $order_id2,
    'amount'          => $net_total * 100, // 2000 rupees in paise
    'currency'        => 'INR',
    'payment_capture' => 1 // auto capture
];

$razorpayOrder = $api->order->create($orderData);

$razorpayOrderId = $razorpayOrder['id'];

$_SESSION['razorpay_order_id'] = $razorpayOrderId;

$displayAmount = $amount = $orderData['amount'];

if ($displayCurrency !== 'INR')
{
    $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
    $exchange = json_decode(file_get_contents($url), true);

    $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
}

$checkout = 'automatic';

if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
{
    $checkout = $_GET['checkout'];
}

$data = [
    "key"               => $keyId,
    "amount"            => $net_total,
    "name"              => "PRISM",
    "description"       => "PRISM CHECKOUt",
    "image"             => "prism.jpg",
    "prefill"           => [
    "name"              => "Hotel Sankam Residency",
    "email"             => "sankamresideny@gmail.com",
    "contact"           => "7795029956",
    ],
    "notes"             => [
    "address"           => "Bangalore",
    "merchant_order_id" => $order_id2,
    ],
    "theme"             => [
    "color"             => "#F37254"
    ],
    "order_id"          => $razorpayOrderId,
];

if ($displayCurrency !== 'INR')
{
    $data['display_currency']  = $displayCurrency;
    $data['display_amount']    = $displayAmount;
}

$json = json_encode($data);


require("checkout/{$checkout}.php");
