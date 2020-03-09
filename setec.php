<?php
include("Library.php");//inclui dependencia entre PHPs
$library = new Library();

session_start();
$_SESSION['ENDPOINT'] = $_POST["ENDPOINT"];
$_SESSION['MOEDA'] = $_POST["currency"];
$_SESSION['AMT'] = $_POST['price'];
//$AMT1 = $_POST['L_PAYMENTREQUEST_0_AMT0'];
$_SESSION['type'] = $_POST["credentials"];

$credential = $library->getCredential($_SESSION['type']);

$nvp = array(//pegando todas as inf. do formulario e passando para array
    'LOCALECODE'                        => 'pt_BR',
	'PAYMENTREQUEST_0_PAYMENTACTION'	=> 'Sale',//SALE, ORDER, AUTHORIZATION
	'PAYMENTREQUEST_0_AMT'              => $_SESSION['AMT'],
    'PAYMENTREQUEST_0_CURRENCYCODE'     => "BRL", 
    'PAYMENTREQUEST_0_ITEMAMT'          => $_SESSION['AMT'],
    'L_PAYMENTREQUEST_0_NAME0'          => 'Produto Teste',
    'L_PAYMENTREQUEST_0_DESC0'          => 'Descrição Produto Teste',
    'ADDROVERRIDE'						=> '1',
    'PAYMENTREQUEST_0_SHIPTONAME'		=> 'Nome Recebedor', 
    'PAYMENTREQUEST_0_SHIPTOSTREET'		=> 'Gregorio Rolim de Oliveira, 42',	
    'PAYMENTREQUEST_0_SHIPTOSTREET2'	=> 'JD Serrano II', 
    'PAYMENTREQUEST_0_SHIPTOCITY'		=> 'Votorantim', 
    'PAYMENTREQUEST_0_SHIPTOSTATE'		=> 'Sao Paulo', 
    'PAYMENTREQUEST_0_SHIPTOZIP'		=> '18117-134', 
    'PAYMENTREQUEST_0_SHIPTOCOUNTRYCODE'=> 'BR',
    'PAYMENTREQUEST_0_SHIPTOPHONENUM'	=> '11912341234',
    'TAXID'                             => '43261491833', //prefill
    'TAXIDTYPE'                         => 'BR_CPF', //prefill
    'EMAIL'                             => 'heliopersonal2@paypal.com', //prefill
	'HDRIMG'			                => 'https://www.paypal-brasil.com.br/logocenter/headers/header556/vidafuncional.png',
	'L_PAYMENTREQUEST_0_AMT0'			=> $_SESSION['AMT'],
  	'RETURNURL'							=> 'http://localhost/EC-ClassicAPI/PayPalExpressCheckout/getdoec.php',
  	'NOTIFYURL'							=> 'http://localhost/EC-ClassicAPI/PayPalExpressCheckout/ipn_server.php',
	'CANCELURL'							=> 'http://localhost/EC-ClassicAPI/PayPalExpressCheckout/cancel-url',
    'METHOD'                            => 'SetExpressCheckout',
	'VERSION'					        => '204',
	'PWD'						        => $credential->pwd,
	'USER'						        => $credential->user,
	'SIGNATURE'                         => $credential->signature,
	//'SUBJECT'							=> $_SESSION['SUBJECT']
);

$response = $library->curl($_SESSION['ENDPOINT'], $nvp);//chamando o método
$responseNvp = $library->regex($response);
//print_r($responseNvp);

//Aponta o endpoint (produção/sandbox)

if (isset($responseNvp["ACK"]) && $responseNvp["ACK"] == "Success") 
{
    $paypalURL = "https://www.sandbox.paypal.com/cgi-bin/webscr";
    if($_SESSION['ENDPOINT'] == "https://api-3t.paypal.com/nvp")
    {
	    $paypalURL = "https://www.paypal.com/cgi-bin/webscr";
    }    
     $redirectURL = $paypalURL.'?cmd=_express-checkout&useraction=commit&token='.$responseNvp["TOKEN"];
    header('Location: '.$redirectURL);	
} 

?>