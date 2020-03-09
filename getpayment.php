<?php
session_start();
include "Library.php";
$libraryObj = new Library();
$getURL = "https://api.sandbox.paypal.com/v1/payments/payment/".$_SESSION['createPayment']['id'];
$getHeader = array(
  "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
  "Content-Type: application/json",
  "cache-control: no-cache"
);

$_SESSION['get'] = $libraryObj->curlRestGet($getURL, $getHeader);
$_SESSION['payer_id'] = $_SESSION['get']['payer']['payer_info']['payer_id'];
$redirectUrl = "http://localhost/EC-ClassicAPI/PayPalExpressCheckout/executepayment.php";

if (isset($_SESSION['payer_id'])) 
{
  header('Location: '.$redirectUrl);
}
else
{
  echo "Erro na chamada!";
}


?>
