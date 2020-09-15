<?php
include "Library.php";
session_start();
$_SESSION['CURRENCY'] = $_POST['currency'];
$_SESSION['AMT'] = $_POST['total'];

$libraryObj = new Library();
$_SESSION['credentials'] = $libraryObj->getCredential("sandbox");
$returnURL = "https://wesleygomes022.herokuapp.com/create_recurring_payments_profile.php";
$_SESSION['endpoint'] = "https://api-3t.sandbox.paypal.com/nvp";
$setPostfields = array(
    "METHOD"                         => "SetExpressCheckout",
    "PWD"                            => $_SESSION['credentials']->pwd,
    "USER"                           => $_SESSION['credentials']->user,
    "SIGNATURE"                      => $_SESSION['credentials']->signature,
    "VERSION"                        => 204,
    "RETURNURL"                      => $returnURL,
    "CANCELURL"                      => $_SESSION['cancelURL'],
    "LOCALECODE"                     => "pt_BR",
    "L_BILLINGTYPE0"                 => "RecurringPayments",
    "L_BILLINGAGREEMENTDESCRIPTION0" => "Plano de assinatura de revistas"
);

$set = $libraryObj->curl($_SESSION['endpoint'], $setPostfields);
$_SESSION['setArray'] = $libraryObj->regex($set);

$paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr";
$pyplCheckout = $paypalURL.'?cmd=_express-checkout&useraction=commit&token='.$_SESSION['setArray']['TOKEN'];

$_SESSION['cancelURL'] = "https://wesleygomes022.herokuapp.com/cancel-url.html";

if(isset($_SESSION['setArray']['TOKEN']) == true)
{
    header('Location: '.$pyplCheckout);
}
else
{
    header('Location: '.$_SESSION['cancelURL']);
}


?>