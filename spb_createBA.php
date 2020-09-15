<?php
session_start();
include "Library.php";
$libraryObj = new Library;
$oAuthURL = "https://api.sandbox.paypal.com/v1/oauth2/token";
$oAuthPostfields = "grant_type=client_credentials";
$oAuthHeader = array(
  "Accept-Encoding: gzip, deflate",
  "Authorization: Basic QVhOdlVzaHVqODdFWjBhQUNTZXN4bngxRUVPSFVfSWNtRkZVUGM2a1hhOXVBV01qVy0weXF2N2JBZmNfVkdjdWdad1FCbFJleUQzdS1WYnA6RVB6WXpNU3h6aDVLbW9TQ3h5dW5CMVZDQVdlVUs0VVFMVW1lNG5qTmFvME81Y3FhR0d6YUdnd183bDZ0Ulp3RTN1WHdzM21JUnNDaFgtN2s=",
  "Connection: keep-alive",
  "Content-Length: 29",
  "Content-Type: application/x-www-form-urlencoded",
  "Host: api.sandbox.paypal.com",
  "cache-control: no-cache"
);

$_SESSION['oAuth'] = $libraryObj->curlRest($oAuthURL, $oAuthPostfields, $oAuthHeader);

//=========================================================================================================================================
//Inicio da chamada de CreateBillingAgreementToken

$jsonCBAT = "{\r\n    \"description\": \"Billing Agreement\",\r\n    \"payer\"
  :\r\n    {\r\n        \"payment_method\": \"PAYPAL\"\r\n    },\r\n    \"plan\"
  :\r\n    {\r\n        \"type\"
  : \"MERCHANT_INITIATED_BILLING_SINGLE_AGREEMENT\",\r\n        \"merchant_preferences\"
  :\r\n        {\r\n            \"return_url\"
  : \"https://wesleygomes022.herokuapp.com/createPaymentBA_rest.php\",\r\n            \"cancel_url\"
  : \"cctexample://return\",\r\n            \"accepted_pymt_type\"
  : \"INSTANT\",\r\n            \"skip_shipping_address\"
  : true\r\n        }\r\n    }\r\n}";

$createBATokenURL = "https://api.sandbox.paypal.com/v1/billing-agreements/agreement-tokens";
$createBATokenHeader = array(
  "Accept: */*",
  "Accept-Encoding: gzip, deflate",
  "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
  "Content-Type: application/json",
  "cache-control: no-cache"
);
//$_SESSION['createBAToken'] = 
//$baToken = json_encode($libraryObj->curlRest($createBATokenURL, $jsonCBAT, $createBATokenHeader));
$baToken = $libraryObj->curlRest($createBATokenURL, $jsonCBAT, $createBATokenHeader);
$_SESSION['token'] = $baToken['token_id'];
//$_SESSION['token'];
//header('Location: https://wesleygomes022.herokuapp.com/spb_execute.php');
echo $_SESSION['token'];

?>