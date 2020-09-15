<?php
include("Library.php");//inclui dependencia entre PHPs
$library = new Library();

session_start();
$token = $_GET['token'];
$payerid = $_GET['PayerID'];
$credential = $library->getCredential($_SESSION['type']);

$nvp = array(
	'token'		=> $token,
	'METHOD'	=> 'GetExpressCheckoutDetails',
	'VERSION'	=> '204', 
	'PWD'		=> $credential->pwd,
	'USER'		=> $credential->user,
	'SIGNATURE' => $credential->signature,
);

$response = $library->curl($_SESSION['ENDPOINT'], $nvp);//chamando o método
$responseNvp = $library->regex($response);

$nvp2 = array(
	'token'								=> $token,
	'METHOD'							=> "DoExpressCheckoutPayment",
	'VERSION'							=> "204", 
	'PWD'								=> $credential->pwd,
	'USER'								=> $credential->user,
	'SIGNATURE' 						=> $credential->signature,
    'PAYERID'                           => $payerid,
    'AMT'                               => $_SESSION['AMT'],
    'PAYMENTACTION'						=> "Sale",
	'CURRENCYCODE'     					=> $_SESSION['MOEDA'],
	//'SUBJECT'							=> $_SESSION['SUBJECT']
);

$response2 = $library->curl($_SESSION['ENDPOINT'], $nvp2);//chamando o método
$responseNvp2 = $library->regex($response2);

if($responseNvp2['PAYMENTSTATUS'] == "Completed")
{ 
	header('location: '."https://wesleygomes022.herokuapp.com/success-url.html");
}
else
{
	header('location: '."https://wesleygomes022.herokuapp.com/cancel-url");
}


?>
