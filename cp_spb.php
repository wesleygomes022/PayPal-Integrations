<?php
session_start();
include "Library.php";
$libraryObj = new Library;
$_SESSION['rand'] = rand(1000, 9999);

/*
$shipping = $_POST["shipping"];
$price = $_POST["price"];
$quantity = $_POST["quantity"];
$subtotal = $price*$quantity;
$total = $_POST["total"];
*/

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
//==============================================================================================================
$jsonCreatePayment = json_encode(array(
    "intent" => "sale",
    "payer" => array(
        "payment_method" => "paypal"
    ),
    "application_context" => array(
        "brand_name" => "Rolim Store",
        "shipping_preference" => "NO_SHIPPING",
	    "brand_name" => "Wesley - Artigos de Tênis",
	    "locale" => "pt_BR"
    ),
    "transactions" => array(
        0 => array(
            "amount" => array(
                "total" => "30.11",
                "currency" => "BRL",
                "details" => array(
                    "subtotal" => "30.00",
                    "tax" => "0.07",
                    "shipping" => "0.03",
                    "handling_fee" => "1.00",
                    "shipping_discount" => "-1.00",
                    "insurance" => "0.01"
                )
            ),
            "description" => "Venda de um produto teste.",
            "custom" => "EBAY_EMS_90048630024435",
            "invoice_number" => $_SESSION['rand'],
            "payment_options" => array(
                "allowed_payment_method" => "INSTANT_FUNDING_SOURCE"
            ),
            "soft_descriptor" => "ECHI5786786",
            "item_list" => array(
                "items" => array(
                    0 => array(
                        "name" => "hat",
                        "description" => "Brown hat.",
                        "quantity" => "5",
                        "price" => "3",
                        "tax" => "0.01",
                        "sku" => "1",
                        "currency" => "BRL"
                    ),
                    1 => array(
                        "name" => "handbag",
                        "description" => "Black handbag.",
                        "quantity" => "1",
                        "price" => "15",
                        "tax" => "0.02",
                        "sku" => "product34",
                        "currency" => "BRL"
                    )
                ),
                "shipping_address" => array(
                    "recipient_name" => "Brian Robinson",
                    "line1" => "4th Floor",
                    "line2" => "Unit #34",
                    "city" => "San Jose",
                    "country_code" => "US",
                    "postal_code" => "95131",
                    "phone" => "011862212345678",
                    "state" => "CA"
                )
            )
        )
    ),
    "note_to_payer" => "Contact us for any questions on your order.",
    "redirect_urls" => array(
        "return_url" => "https://example.com/return",
        "cancel_url" => "https://example.com/cancel"
    )
));

$urlCreatePayment = "https://api.sandbox.paypal.com/v1/payments/payment";
$headerCreatePayment = array(
  "Authorization: Bearer ".$_SESSION['oAuth']['access_token'],
  "Content-Type: application/json",
  "cache-control: no-cache"
);

$_SESSION['createPayment'] = $libraryObj->curlRest($urlCreatePayment, $jsonCreatePayment, $headerCreatePayment);
echo json_encode($_SESSION['createPayment']);

?>