<?php
include "Library.php";
session_start();
$libraryObj = new Library();
$updateProfilePostfields = array(
    "METHOD"                         => "ManageRecurringPaymentsProfileStatus",
    "PWD"                            => $_SESSION['credentials']->pwd,
    "USER"                           => $_SESSION['credentials']->user,
    "SIGNATURE"                      => $_SESSION['credentials']->signature,
    "VERSION"                        => 204,
    //"PROFILEID"                      => $_SESSION['createRC_Paym_Profile_array']['PROFILEID'],
    "PROFILEID"                      => "I-J2W50Y91G28W",
    "MAXFAILEDPAYMENTS"              => 2,
    "TOTALBILLINGCYCLES"             => 0,
    "AMT"                            => 50,
    "PROFILESTARTDATE"               => '2019-10-21T17:37:00Z0300',
);

$updateProfile = $libraryObj->curl($_SESSION['endpoint'], $updateProfilePostfields);
$updateProfileArray = $libraryObj->regex($updateProfile);




?>