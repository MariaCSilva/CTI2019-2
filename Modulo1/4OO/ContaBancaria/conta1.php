<?php require "Conta.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transações da Conta 1</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>

<body>

    <?php
    $conta1 = null;
    $conta2 = null;
    //Se a conta não existe cria se uma nova Instancia de conta e adiciona no cookie
    if (!isset($_COOKIE["numeroConta1"])) {
        $conta1 = new Conta("2121", "Majo",  0);
        setcookie("numeroConta1", $conta1->numero);
        setcookie("nomeClienteConta1", $conta1->cliente);
        setcookie("saldoConta1", $conta1->getSaldo());

    } else {
        //Se a conta já existe cria uma nova conta a partir do cookie
        $conta1 = new Conta($_COOKIE["numeroConta1"], $_COOKIE["nomeClienteConta1"], $_COOKIE["saldoConta1"]);
    }

    ?>
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h1>Numero da Conta: <?= $conta1->numero ?></h1>
            </div>
            <div class="col-sm-6">
                <h1> Cliente: <?= $conta1->cliente ?></h1>
            </div>
        </div>
        
    </div>
</body>

</html>