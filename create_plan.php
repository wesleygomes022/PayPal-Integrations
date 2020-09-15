<?php
include "Library.php";
session_start();

$_SESSION['currency'] = $_POST['currency'];
$_SESSION['trial'] = $_POST['trial'];
$_SESSION['total'] = $_POST['total'];
$libraryObj = new Library();
$rand = rand(1, 100);
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
//print_r($_SESSION['oAuth']);

$createPlan_URL = "https://api.sandbox.paypal.com/v1/payments/billing-plans/";
$createPlan_header_array = array(
    "Content-Type: application/json",
    "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
    "cache-control: no-cache"
);

$createPlan_array = array(
    "name" => "Plan with Regular and Trial Payment Definitions",
    "description" => "Plan with regular and trial payment definitions.", 
    "type" => "fixed",
    "payment_definitions" => array(
        0 => array(
            "name" => "Regular payment definition", 
            "type" => "REGULAR", 
            "frequency" => "MONTH",
            "frequency_interval" => 5,
            "amount" => array(
                "value" => $_SESSION['total'], //valor total da recorrencia
                "currency" => $_SESSION['currency']
            ),
            "cycles" => $rand   
        ),
        1 => array(
            "name" => "Trial payment definition",
            "type" => "trial",
            "frequency" => "week",
            "frequency_interval" => 5,
            "amount" => array(
                "value" => $_SESSION['trial'], //valor do trial
                "currency" => "BRL"
            ),
            "cycles" => 3
        ),
    ),
    "merchant_preferences" => array(
        "setup_fee" => array(
            "value" => 2,
            "currency" => "BRL"
        ),
        "return_url" => "https://wesleygomes022.herokuapp.com/execute_agreement.php",
        "cancel_url" => "https://example.com/cancel",
        "auto_bill_amount" => "YES",
        "initial_fail_amount_action" => "CONTINUE",
        "max_fail_attempts" => 0
    )
);

$createPlan_postfields = json_encode($createPlan_array);
$_SESSION['createPlan'] = $libraryObj->curlRest($createPlan_URL, $createPlan_postfields, $createPlan_header_array);
$activePlan_URL = "https://wesleygomes022.herokuapp.com/active_plan.php";

if(isset($_SESSION['createPlan']['id']) == true)
{
    header('Location: '.$activePlan_URL);
}
else
{
    echo "Está dando erro!";
}


?>