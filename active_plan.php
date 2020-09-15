<?php
include "Library.php";
session_start();
$libraryObj = new Library();
$activate_URL = "https://api.sandbox.paypal.com/v1/payments/billing-plans/".$_SESSION['createPlan']['id'];
$activate_header = array(
    "Content-Type: application/json",
    "Authorization: Bearer ".$_SESSION['oAuth']['access_token']
);
$activate_postfields_array = array(
    0 => array(
        "op" => "replace",
        "path" => "/",
        "value" => array(
            "state" => "ACTIVE"
        )     
    )
);


$activate_postfields = json_encode($activate_postfields_array);
//echo $activate_postfields;

$activate_plan = $libraryObj->curlRestPatch($activate_URL, $activate_postfields, $activate_header);

$headers = get_headers($activate_URL, true);
$crate_agreement_url = "https://wesleygomes022.herokuapp.com/create_agreement.php";

if($activate_plan == NULL)
{
    header('Location: '.$crate_agreement_url);
}
else
{
    echo "A chamada deu errado!";
}


?>