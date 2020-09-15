<?php
include "Library.php";
session_start();
$libraryObj = new Library();

$createBA_Postfields = array(
  "METHOD"    => "CreateBillingAgreement",
  "TOKEN"     => $_SESSION['setResponseArray']['TOKEN'],
  "VERSION"   => 204,
  "PWD"       => "N74TBF7UWSVUEDP9",
  "USER"      => "master_api1.ultragaz.com.br",
  "SIGNATURE" => "AJl1dt6HKFjg4eshTbaC9x9ukD65AESolhabg0wYRECLjumt4egNShse"
);

$createBA = $libraryObj->curl($_SESSION['endpoint'], $createBA_Postfields);
$createBaArray = $libraryObj->regex($createBA);

$doRT_Postfields = array(
  "USER"          => "master_api1.ultragaz.com.br",
  "PWD"           => "N74TBF7UWSVUEDP9",
  "SIGNATURE"     => "AJl1dt6HKFjg4eshTbaC9x9ukD65AESolhabg0wYRECLjumt4egNShse",
  "METHOD"        => "DoReferenceTransaction",
  "REFERENCEID"   => $createBaArray['BILLINGAGREEMENTID'],
  "VERSION"       => 204,
  "AMT"           => $_SESSION['total'],
  "CURRENCYCODE"  => "BRL",
  "PAYMENTACTION" => "Sale",
  "NOTIFYURL"     => "http%3A%2F%2Frequestbin.fullcontact.com%2F1dn15x61",
  "DESC"          => "Cobranca%20de%20Fatura"
);

$doRT = $libraryObj->curl($_SESSION['endpoint'], $doRT_Postfields);
$doRTArray = $libraryObj->regex($doRT);

$getTrnsDtlsPostfields = array(
  "USER"          => "master_api1.ultragaz.com.br",
  "PWD"           => "N74TBF7UWSVUEDP9",
  "SIGNATURE"     => "AJl1dt6HKFjg4eshTbaC9x9ukD65AESolhabg0wYRECLjumt4egNShse",
  "METHOD"        => "GetTransactionDetails",
  "TRANSACTIONID" => "8DD009086M903093V",
  "VERSION"       => 204
);

$getTrnsDtls = $libraryObj->curl($_SESSION['endpoint'], $getTrnsDtlsPostfields);


if($doRTArray['PAYMENTSTATUS'] == "Completed")
{
  header('Location: '."https://wesleygomes022.herokuapp.com/success-url.html");
}
else
{
  header('Location: '."https://wesleygomes022.herokuapp.com/cancel-url.html");
}


?>