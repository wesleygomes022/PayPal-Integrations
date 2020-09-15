<?php
include "Library.php";
session_start();
$libraryObj = new Library();
$execute_agreement_header = array(
    "Content-Type: application/json",
    "Authorization: Bearer ".$_SESSION['oAuth']['access_token']
);
$execute_agreement_postfields = "";
$execute_agreement = $libraryObj->curlRest($_SESSION['execute_url'], $execute_agreement_postfields, $execute_agreement_header);
$succes_url = "https://wesleygomes022.herokuapp.com/success-url.html";
$cancel_url = "https://wesleygomes022.herokuapp.com/cancel-url.html";

if(isset($execute_agreement['state']) == true)
{
    header('Location: '.$succes_url);
}
else
{
    header('Location: '.$cancel_url);
}
//print_r($execute_agreement);

?>