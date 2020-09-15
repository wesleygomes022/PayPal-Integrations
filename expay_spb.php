<?php
session_start();
include "Library.php";
$libraryObj = new Library;

$getURL = "https://api.sandbox.paypal.com/v1/payments/payment/".$_SESSION['createPayment']['id'];
//$getURL = "https://api.sandbox.paypal.com/v1/payments/payment/"."PAYID-LXVL2OI7HM314128B374640R";
$getHeader = array(
  "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
  "Content-Type: application/json",
  "cache-control: no-cache"
);

$_SESSION['get'] = $libraryObj->curlRestGet($getURL, $getHeader);
//$_SESSION['payer_id'] = $_SESSION['get']['payer']['payer_info']['payer_id'];
//$redirectUrl = "https://wesleygomes022.herokuapp.com/executepayment.php";
//print_r($_SESSION['get']);
//echo "<br/><br/><br/>";
//echo $_SESSION['get']['payer']['payer_info']['payer_id'];
//echo "<br/><br/><br/>";


$execPayURL = "https://api.sandbox.paypal.com/v1/payments/payment/".$_SESSION['get']['id']."/execute";
$execPayPostfields = "{\r\n  \"payer_id\": \"".$_SESSION['get']['payer']['payer_info']['payer_id']."\"\r\n}";
$execPayArray = array(
  "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
  "Content-Type: application/json",
  "cache-control: no-cache"
);

$execPay = $libraryObj->curlRest($execPayURL, $execPayPostfields, $execPayArray);
//echo json_encode($execPay);
echo $execPay['transactions'][0]['related_resources'][0]['sale']['state'];

//$_SESSION['get'] = $libraryObj->curlRestGet($getURL, $getHeader);

?>