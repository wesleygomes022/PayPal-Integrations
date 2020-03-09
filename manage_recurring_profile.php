<?php
include "Library.php";
session_start();
$libraryObj = new Library();
$getCredential = $libraryObj->getCredential("sandbox");

$manageRecurringPostfields = array(
    "METHOD"                         => "ManageRecurringPaymentsProfileStatus",
    "PWD"                            => $_SESSION['credentials']->pwd,
    "USER"                           => $_SESSION['credentials']->user,
    "SIGNATURE"                      => $_SESSION['credentials']->signature,
    "VERSION"                        => 204,
    //"PROFILEID"                      => $_SESSION['createRC_Paym_Profile_array']['PROFILEID']
    "PROFILEID"                      => "I-J2W50Y91G28W",
    "ACTION"                         => "Suspend"
);

$manageRecurringPostfields = $libraryObj->curl($_SESSION['endpoint'], $manageRecurringPostfields);
echo $manageRecurringPostfields;
echo "<br/><br/><br/>";


$manageRecurringArray = $libraryObj->regex($manageRecurringPostfields);
print_r($manageRecurringArray);


?>