<?php
session_start();
include "Library.php";
$libraryObj = new Library();
$payerId = $_POST['PAYERID'];
//echo $payerId;
$executePayment_header = array(
    'Content-Type: application/json',
    'Authorization: Bearer '.$_SESSION['oAuth']['access_token']
);
$executePayment_postfields_array = array(
    "payer_id" => $payerId
);
$executePayment_postfields = json_encode($executePayment_postfields_array);
$executePayment = $libraryObj->curlRest($_SESSION['executePayment_endpoint'], $executePayment_postfields, $executePayment_header);
print_r($executePayment);
$state = $executePayment['transactions'][0]['related_resources'][0]['sale']['state'];
$succesUrl = "https://wesleygomes022.herokuapp.com/success-url.html";
$cancelUrl = "https://wesleygomes022.herokuapp.com/cancel-url.html";

/*
Anotações: Essa intregração de PayPal Plus atualmente possui uma limitação, ela apenas processa pagamentos com cartões que sejam
installments. Da linha 81 à linha 85 da página "pp_plus.php" está decrito um laço condicional que valida se informações de installments 
estão presentes no message do iframe PPP. No caso de "Verdadeiro", é armazenado um valor de installments selecionado pelo usuário, 
e no caso de "Falso", a variável (que por sinal já foi criada previamente na linha 76) armazena o valor de 1. Quando é inserido um 
cartão no iframe que não seja installments, aparentemente o código ainda está buscando os dados de installments que está na validação 
do laço e por não encontrar, não cai no else, onde seria armazenado o valor 1 para que o fluxo possa avançar normalmente.

Outro detalhe incompreensível é o fato do usuário do Pedro estar sendo considerado no parâmetro de "soft_descriptor" que fica no index
de "Payee". 
*/

if($state == "completed")
{
    //header('Location: '.$succesUrl);
}
else
{
    //header('Location: '.$cancelUrl);
}

?>