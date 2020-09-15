<?php
session_start();
include "Library.php";
$libraryObj = new Library();

$shipping = $_POST["shipping"];
$price = $_POST["price"];
$quantity = $_POST["quantity"];
$subtotal = $price*$quantity;
$total = $_POST["total"];
$rand = rand(10000,999999);
$urlOauth = "https://api.sandbox.paypal.com/v1/oauth2/token";
$postfieldsOauth = "grant_type=client_credentials";
$headerOauth = array(
  "Accept: application/json",
  "Accept-Language: pt_BR",
  "Authorization: Basic ".base64_encode("AUgj9N0Is-Dztg4o7CJwtn2NpWj3RdToO33Sq2q3-KmWte7qNR_8nLxI_fPraSm-M4bPC0ur7RsuhGU6:EDLpdhBUgQRXRJ9le02mHEFJLU8zFWBWrxoUiO7KVOm0_sQYeYnX7_o8cfGwj6CES7zDxrWA7wGOgOVc"),
  "Content-Type: application/x-www-form-urlencoded",
  "cache-control: no-cache"
);

$_SESSION['oAuth'] = $libraryObj->curlRest($urlOauth, $postfieldsOauth, $headerOauth);

$jsonCreatePayment = "{\r\n  \"intent\":\"sale\",\r\n  \"payer\":{  \r\n    
  \"payment_method\":\"paypal\"\r\n  },\r\n  \"application_context\":{  \r\n    
    \"brand_name\":\"Rolim Store\",\r\n    \"shipping_preference\":\"NO_SHIPPING\"\r\n  
  },\r\n  \"transactions\":[\r\n    {  \r\n      \"amount\":{  \r\n        \"currency\":\"BRL\",
    \r\n        \"total\":\"$total\",\r\n        \"details\":{  \r\n          \"shipping\":\"$shipping\",\r\n 
  \"subtotal\":\"$subtotal\"\r\n          } \r\n      },\r\n      \"description\":\"Order xxxx\",\r\n  
  \"payment_options\":{\r\n        \"allowed_payment_method\":\"IMMEDIATE_PAY\"\r\n      },\r\n    
  \"invoice_number\":\".$rand.\",\r\n      \"item_list\":{\r\n        \"items\":[\r\n   
  {\r\n            \"name\":\"Product 1\",\r\n            \"description\":\"Prod description\",\r\n  
  \"quantity\":\"$quantity\",\r\n            \"price\":\"$price\",\r\n    
  \"sku\":\"product_id\",\r\n            \"currency\":\"BRL\"\r\n      
  }\r\n          ]\r\n      }\r\n    }\r\n    ],\r\n    \"redirect_urls\":{
  \r\n      \"return_url\":\"https://wesleygomes022.herokuapp.com/getpayment.php\",\r\n 
  \"cancel_url\":\"http://www.example.com/cancel\"\r\n    }\r\n  }";

//$err = curl_error($curl);
//curl_close($curl);
//if ($err) {
//  //echo "cURL Error #:".$err;
//} 

$urlCreatePayment = "https://api.sandbox.paypal.com/v1/payments/payment";
$headerCreatePayment = array(
  "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
  "Content-Type: application/json",
  "cache-control: no-cache"
);

$_SESSION['createPayment'] = $libraryObj->curlRest($urlCreatePayment, $jsonCreatePayment, $headerCreatePayment);
$redirectUrl = $_SESSION['createPayment']['links'][1]['href'];
header('Location: '.$redirectUrl);

?>
