<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>PayPal - Wesley</title>
    <!-- <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>        
    <script type="text/javascript">
      function validaSubject(){
        if($("#subject").val()=="true"){
            $("#subject_field").css('display','inline');
        }else{
            $("#subject_field").css('display','none');
            $("#subject_email").val('');
        }
      }
    </script> -->
    <style>
        img#logopypl
        {
        width: 110px;
        height: 40px;
        margin-top: 3px;        
        }

        h3#paragrafo{
            text-align: center
        }
        div#ppplus{
            margin-left: 300px;
            margin-right: 300px;
        }
        button#continueButton{
          margin-left: 370px;
        }
    </style>

<script src="https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js" type="text/javascript"></script>
<script type="application/javascript">
    var approval_url = "<?php echo $_SESSION['approval_url']; ?>";
    var ppp = PAYPAL.apps.PPP({ 
      "approvalUrl": approval_url,
      "placeholder": "ppplus",
      "payerFirstName":"Wesley",
      "payerLastName":"Gomes",
      "payerEmail":"wgomes@paypal.com",
      "payerTaxId":"22988294895",
      "payerTaxIdType":"BR_CPF",
      "payerPhone":"1128999120",
      "language":"pt_BR",
      "country":"BR",
      "mode": "sandbox",
      "disableContinue": "continueButton",
      "enableContinue": "continueButton",
      "rememberedCards": "FXzgsoU5XoJUwTGfADeR1OsS-Jg3vF4DyPmYhR4594NalEhTik-CEB1m8BvJ6qiGAX6ONydRO6Ch5MSqvykEs7EesPVGx-xGawGTD3qD_-Kx6d9k1YIOVj0Q4KljB7cbT0nwfweMJFtDFYBP"
    });

    if(window.addEventListener){
    window.addEventListener("message", receiveMessage, false);
    console.log("addEventListener successful", "debug");  
} 

function receiveMessage(event){
    //try{
        var message = JSON.parse(event.data);

        if(message['action'] == 'checkout'){ //PPPlus session approved, do logic here
        	  var rememberedCard = null;
            var payerID = null;
            var installmentsValue = null;

            rememberedCard = message['result']['rememberedCards']; //save on user BD record
            payerID = message['result']['payer']['payer_info']['payer_id']; //use it on executePayment API
            
            if ( typeof message['result']['term'] === 'undefined'  ){

              installmentsValue = 1;

            } else {

              installmentsValue = message['result']['term']['term'];

            }

            /*if(message['result']['term']['term']){
              installmentsValue = message['result']['term']['term']; //installments value
            }else{
              installmentsValue = 1; //no installments
            }*/

            /* Next steps:
            console.log ("ID de RememberCard: ", rememberedCard);
            console.log (payerID);
            console.log (installmentsValue);

                1) Save the rememberedCard value on the user record on your Database.
                2) Save the installmentsValue value into the order (Optional).
                3) Call executePayment API using payerID value to capture the payment.
            */

            //<<Insert Code Here>>
            var pagamento = document.getElementById("PAYERID");
            //console.log(pagamento);
            console.log ("ID de RememberCard: ", rememberedCard);
            console.log("WESLEY! O CÓDIGO ESTA CHEGANDO ATÉ AQUI!");
            pagamento.value = payerID;
            document.forms[1].submit();
        }
    //}catch(e){ //treat exceptions here
    	// <<Insert Code Here>>
    //}
}
</script>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a href="index.php"><img class="navbar-brand" src="paypallogo.png" id="logopypl"><img/></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a class="nav-link" href="index.php">Menu <span class="sr-only"></span></a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">GPS</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Produtos
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item" href="ecclassic.html">EC Classic</a>
            <a class="dropdown-item" href="ec_rest.html">EC REST</a>
            <a class="dropdown-item" href="reference_transaction.html">Reference Transaction (NVP)</a>
            <a class="dropdown-item" href="rt_rest.html">Reference Transaction (REST)</a>
            <a class="dropdown-item" href="ec_recurring.html">EC Recurring (NVP)</a>
            <a class="dropdown-item" href="ec_recurring_rest.html">Subscription</a>
            <a class="dropdown-item" href="pp_checkout.html">PayPal Plus</a>
            <!-- <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="#">Something else here</a> -->
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Desabilitado</a>
        </li>
      </ul>
      <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-info my-2 my-sm-0" type="submit">Pesquisar</button>
      </form>
    </div>
</nav>

<div class="jumbotron jumbotron-fluid">
    <div class="container">
        <h1 class="display-4">PayPal Plus</h1>
        <p class="lead">Aqui são demonstradas as integrações de nosso produto PayPlus que é uma solução de checkout transparente para 
          os merchants que desejam processar pagamentos com PayPal para usuários que não possuem conta. O modelo de arquitetura 
          definido é REST. <br/>As APIs disponíveis são: OAuth, CreatPayment_EC, ExecutePayment_EC, GetPayment.
        </p>
    </div>
</div>
    
<h3 id="paragrafo">Informações de Checkout</h3>
<br/><br/>

<div id="ppplus"></div>


<form id="PAYLOAD" method="POST" action="https://wesleygomes022.herokuapp.com/execute_payment_pp.php"> 
  <input name="PAYERID" type="hidden" value="" id="PAYERID"/>
</form>

<button type="submit" id="continueButton" class="btn btn-info" onclick="ppp.doContinue(); return false;">Enviar</button>

<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<br/>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>