<?php
include "Library.php";
session_start();
$libraryObj = new Library();
$_SESSION['total'] = $_POST['total'];
$_SESSION['endpoint'] = "https://api-3t.sandbox.paypal.com/nvp";

$setPostfields = array(
    "LOCALECODE"                     => "pt_BR",
    "PAYMENTREQUEST_0_PAYMENTACTION" => "Sale",
    "PAYMENTREQUEST_0_AMT"           => 0,
    "PAYMENTREQUEST_0_CURRENCYCODE"  => "BRL",
    "L_PAYMENTREQUEST_0_NAME0"       => "Teste%20Reference",
    "L_PAYMENTREQUEST_0_DESC0"       => "Assinatura", 
    "L_PAYMENTREQUEST_0_AMT0"        => 0, 
    "RETURNURL"                      => "https://wesleygomes022.herokuapp.com/createBA.php", 
    "CANCELURL"                      => "https://wesleygomes022.herokuapp.com/cancel-url.html",
    "METHOD"                         => "SetExpressCheckout",
    "VERSION"                        => 204,
    "PWD"                            => "N74TBF7UWSVUEDP9",
    "USER"                           => "master_api1.ultragaz.com.br",
    "SIGNATURE"                      => "AJl1dt6HKFjg4eshTbaC9x9ukD65AESolhabg0wYRECLjumt4egNShse",
    "L_BILLINGTYPE0"                 => "MerchantInitiatedBillingSingleAgreement",
    "L_BILLINGAGREEMENTDESCRIPTION0" => "Termo%20de%20Cobran%C3%A7a"
);

$_SESSION['set'] = $libraryObj->curl($_SESSION['endpoint'], $setPostfields);
$_SESSION['setResponseArray'] = $libraryObj->regex($_SESSION['set']);

$getPostfields = array(
    "TOKEN"     => $_SESSION['setResponseArray']['TOKEN'],
    "METHOD"    => "GetExpressCheckoutDetails",
    "VERSION"   => "204",
    "PWD"       => "N74TBF7UWSVUEDP9",
    "USER"      => "master_api1.ultragaz.com.br",
    "SIGNATURE" => "AJl1dt6HKFjg4eshTbaC9x9ukD65AESolhabg0wYRECLjumt4egNShse"
);

$get = $libraryObj->curl($_SESSION['endpoint'], $getPostfields);
$getArray = $libraryObj->regex($get);

$redirectUrl = "https://www.sandbox.paypal.com/webapps/hermes/?ul=landing&token=".$_SESSION['setResponseArray']['TOKEN'];
header('Location: '.$redirectUrl);

?>