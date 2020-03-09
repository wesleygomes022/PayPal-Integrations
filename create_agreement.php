<?php
include "Library.php";
session_start();
$libraryObj = new Library();
$create_agreement_header_array = array(
    "Content-Type: application/json",
    "Authorization: Bearer ".$_SESSION['oAuth']['access_token'] 
);

$create_agreement_header_postfields_array = array(
    "name" => "Magazine Subscription",
    "description" => "Monthly agreement with a regular monthly payment definition and two-month trial payment definition.",
    "start_date" => "2019-12-26T17:00:00Z",
    "plan" => array(
        "id" => $_SESSION['createPlan']['id']
    ),
    "payer" => array(
        "payment_method" => "paypal",
    ),
    "shipping_address" => array(
        "line1" => "Avenida Paulista",
        "line2" => "1048",
        "city" => "São Paulo",
        "state" => "SP",
        "postal_code" => "01310-100",
        "country_code" => "BR",
    )
);

$create_agreement_header_postfields = json_encode($create_agreement_header_postfields_array);
$create_agreement_header_endpoint = "https://api.sandbox.paypal.com/v1/payments/billing-agreements/";
$create_agreement = $libraryObj -> curlRest($create_agreement_header_endpoint, $create_agreement_header_postfields, $create_agreement_header_array);
$_SESSION['approval_url'] = $create_agreement['links'][0]['href'];
$_SESSION['execute_url'] = $create_agreement['links'][1]['href'];

if(isset($create_agreement['plan']['id']) == true)
{
    header('Location: '.$_SESSION['approval_url']);
}
else
{
    echo "Deu erro!";
}


?>