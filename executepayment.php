<?php
session_start();
include "Library.php";
$libraryObj = new Library();

$execPayURL = "https://api.sandbox.paypal.com/v1/payments/payment/".$_SESSION['get']['id']."/execute";
$execPayPostfields = "{\r\n  \"payer_id\": \"".$_SESSION['payer_id']."\"\r\n}";
$execPayArray = array(
  "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
  "Content-Type: application/json",
  "cache-control: no-cache"
);

$execPay = $libraryObj->curlRest($execPayURL, $execPayPostfields, $execPayArray);


if($execPay['transactions'][0]['related_resources'][0]['sale']['state'] == "completed")
{
  header('location: '."https://wesleygomes022.herokuapp.com/success-url.html");
}
else
{
  header('location: '."https://wesleygomes022.herokuapp.com/cancel-url.html");
}


?>