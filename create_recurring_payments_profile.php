<?php
include "Library.php";
session_start();
$libraryObj = new Library();

$getPostfields = array(
    "METHOD"                         => "GetExpressCheckoutDetails",
    "PWD"                            => $_SESSION['credentials']->pwd,
    "USER"                           => $_SESSION['credentials']->user,
    "SIGNATURE"                      => $_SESSION['credentials']->signature,
    "VERSION"                        => 204,
    "TOKEN"                          => $_SESSION['setArray']['TOKEN']
);

$get = $libraryObj->curl($_SESSION['endpoint'], $getPostfields);
$_SESSION['getArray'] = $libraryObj->regex($get);


$createRC_Paym_Profile_Postfields = array(
    "METHOD"                         => "CreateRecurringPaymentsProfile",
    "PWD"                            => $_SESSION['credentials']->pwd,
    "USER"                           => $_SESSION['credentials']->user,
    "SIGNATURE"                      => $_SESSION['credentials']->signature,
    "VERSION"                        => 204,
    "TOKEN"                          => $_SESSION['setArray']['TOKEN'],
    "PAYERID"                        => $_SESSION['getArray']['PAYERID'],
    "PROFILESTARTDATE"               => '2019-10-23T15:20:00Z0300',
    "DESC"                           => "Plano de Assinatura de Revistas",
    "MAXFAILEDPAYMENTS"              => 3,
    "BILLINGPERIOD"                  => "Month",
    "BILLINGFREQUENCY"               => 12,
    "TOTALBILLINGCYCLES"             => 0,
    "AMT"                            => $_SESSION['AMT'],
    "CURRENCYCODE"                   => $_SESSION['CURRENCY']
);

$createRC_Paym_Profile = $libraryObj->curl($_SESSION['endpoint'], $createRC_Paym_Profile_Postfields);
$_SESSION['createRC_Paym_Profile_array'] = $libraryObj->regex($createRC_Paym_Profile);
$profileID = $_SESSION['createRC_Paym_Profile_array']['PROFILEID'];


$getRecurringPostfields = array(
    "METHOD"                         => "GetRecurringPaymentsProfileDetails",
    "PWD"                            => $_SESSION['credentials']->pwd,
    "USER"                           => $_SESSION['credentials']->user,
    "SIGNATURE"                      => $_SESSION['credentials']->signature,
    "VERSION"                        => 204,
    "PROFILEID"                      => $_SESSION['createRC_Paym_Profile_array']['PROFILEID']
    //"PROFILEID"                      => "I-J2W50Y91G28W"
);

$getRecurringPostfields = $libraryObj->curl($_SESSION['endpoint'], $getRecurringPostfields);
$getRecurringPostfields_Array = $libraryObj->regex($getRecurringPostfields);

$succesURL = "http://localhost/EC-ClassicAPI/PayPalExpressCheckout/success-url.html";

if(isset($getRecurringPostfields_Array['STATUS']) == true)
{
    header('Location: '.$succesURL);
}
else
{
    header('Location: '.$_SESSION['cancelURL']);
}


?>