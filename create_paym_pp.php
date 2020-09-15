<?php
session_start();
include "Library.php";
$libraryObj = new Library();

$quantidade = $_POST['quantidade'];
$subtotal = $_POST['total'];
$total = $quantidade * $subtotal;

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
//echo "RESPOSTA DA CHAMDA DE OAUTH<br/>";
//print_r($_SESSION['oAuth']);
//echo "<br/><br/><br/>";
//echo $_SESSION['oAuth']['access_token'];

$headerCreatePayment = array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$_SESSION['oAuth']['access_token']
);

$_SESSION['createPayment'] = array(
    "intent" => "sale",
    "payer" => array(
        "payment_method" => "paypal"
    ),
    "transactions" => array(
        0 => array(
            "amount" => array(
                "currency" => "BRL",
                "total" => $total,
                "details" => array(
                    "shipping" => 0,
                    "subtotal" => $total,
                    "shipping_discount" => 0,
                    "insurance" => 0,
                    "handling_fee" => 0,
                    "tax" => 0
                )
            ),
            "description" => "this is the payment transaction description",
            "payment_options" => array(
                "allowed_payment_method" => "IMMEDIATE_PAY"
            ),
            "item_list" => array(
                "shipping_address" => array(
                    "recipient_name" => "PP Plus Recipient",
                    "line1" => "Gregório Rolim de Oliveira, 43",
                    "line2" => "JD Serrano II",
                    "city" => "Votorantim",
                    "country_code" => "BR",
                    "postal_code" => "18117-134",
                    "state" => "São Paulo",
                    "phone" => "0800-761 - 0880"
                ),
                "items" => array(
                    0 => array(
                        "name" => "handbag",
                        "description" => "red diamond",
                        "quantity" => $quantidade,
                        "price" => $subtotal,
                        "tax" => 0,
                        "sku" => "product34",
                        "currency" => "BRL"
                    )
                )
            )
        )
    ),
    "redirect_urls" => array(
        "return_url" => "https://example.com/return",
        "cancel_url" => "https://example.com/cancel"
    )
);

//echo "ARRAY DE CREATE PAYMENT REQUEST<br/>";
//print_r($_SESSION['createPayment']);
//echo "<br/><br/><br/>";

$endpointCreatePayment = "https://api.sandbox.paypal.com/v1/payments/payment";
$json_createPayment = json_encode($_SESSION['createPayment']);
//echo $json_createPayment;
//echo "<br/><br/><br/>";

$_SESSION['createPayment'] = $libraryObj->curlRest($endpointCreatePayment, $json_createPayment, $headerCreatePayment);
//echo "RESPOSTA CREATE PAYMENT<BR/>";
//print_r($_SESSION['createPayment']);
//echo "<br/><br/><br/><br/>";
$_SESSION['executePayment_endpoint'] = $_SESSION['createPayment']['links'][2]['href'];
//echo $_SESSION['executePayment_endpoint'];
//var_dump($_SESSION['createPayment']);

$_SESSION['approval_url'] = $_SESSION['createPayment']['links'][1]['href'];
$redirectUrl = "https://wesleygomes022.herokuapp.com/pp_plus.php";

print_r($_SESSION['createPayment']);


if(isset($_SESSION['createPayment']))
{
    //print_r($_SESSION['createPayment']['id']);
    header('Location: '.$redirectUrl);
}
else
{
    echo "A chamada de Create Payment Request não está acontecendo corretamente.";
}

?>