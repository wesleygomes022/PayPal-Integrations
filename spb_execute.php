<?php
session_start();
include "Library.php";
$libraryObj = new Library;

$BearToken = $_SESSION['oAuth']['access_token'];

$createBA_URL = "https://api.sandbox.paypal.com/v1/billing-agreements/agreements";
$createBA_header = array(
  "Content-Type: application/json",
  "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
  "cache-control: no-cache"
);
$createBA_TokenPostfields = "{\r\n    \"token_id\": \"".$_SESSION['token']."\"\r\n}";
$createBA = $libraryObj->curlRest($createBA_URL, $createBA_TokenPostfields, $createBA_header);
//print_r($createBA);
//echo $createBA['id'];
//echo json_encode($createBA);
//=======================================================================================================================================

$rand = rand(1000, 100000);
$createPaymentHeader = array(
  "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
  "Content-Type: application/json",
  "cache-control: no-cache"
);
$createPaymentPostfields = "{\r\n   \"intent\":\"sale\",\r\n   \"payer\"
    :{\r\n      \"payment_method\":\"paypal\",\r\n      \"funding_instruments\"
    :[\r\n         {\r\n            \"billing\"
    :{\r\n               \"billing_agreement_id\"
    :\"".$createBA['id']."\"\r\n            }\r\n         }\r\n      ]\r\n   },\r\n   \"transactions\"
    :[\r\n      {\r\n         \"amount\":{\r\n            \"currency\"
    :\"BRL\",\r\n            \"total\":\"20.00\",\r\n            \"details\"
    : {\r\n                \"shipping\": \"10.00\",\r\n                \"subtotal\"
    : \"10.00\"\r\n            }\r\n         },\r\n         \"description\"
    :\"This is the description of the transaction\",\r\n         \"custom\"
    :\"custom123\",\r\n         \"invoice_number\": \"".$rand."\",\r\n         \"item_list\"
    :{\r\n    \t\t\"shipping_address\":\r\n    \t\t{\r\n        \t\t\"line1\"
    : \"Av Paulista 1048\",\r\n        \t\t\"city\": \"Sao Paulo\",\r\n        \t\t\"state\"
    : \"SP\",\r\n        \t\t\"postal_code\": \"01310100\",\r\n        \t\t\"country_code\"
    : \"BR\",\r\n        \t\t\"recipient_name\"
    : \"John Doe\"\r\n    \t\t},\r\n            \"items\"
    :[\r\n               {\r\n                  \"name\"
    :\"Item Teste\",\r\n                  \"description\"
    :\"Descri\\u00e7\\u00e3o Item Teste\",\r\n                  \"quantity\"
    :\"1\",\r\n                  \"price\"
    :\"10.00\",\r\n                  \"tax\"
    :\"0\",\r\n                  \"sku\"
    :\"sku123\",\r\n                  \"currency\"
    :\"BRL\"\r\n               }\r\n            ]\r\n         }\r\n      }\r\n   ],\r\n   \"redirect_urls\"
    :{\r\n        \"return_url\"
    : \"https://example.com/return\",\r\n        \"cancel_url\"
    : \"https://example.com/cancel\"\r\n   }\r\n}";

$createPaymentURL = "https://api.sandbox.paypal.com/v1/payments/payment";

$createPaymentBA = $libraryObj->curlRest($createPaymentURL, $createPaymentPostfields, $createPaymentHeader);
//print_r($createPaymentBA);
//echo "<br/><br/><br/>";
//echo $createPaymentBA['transactions'][0]['related_resources'][0]['sale']['state'];

if($createPaymentBA['transactions'][0]['related_resources'][0]['sale']['state'] == "completed")
{
  echo "completed";
}
else
{
  echo "err";
}


?>
