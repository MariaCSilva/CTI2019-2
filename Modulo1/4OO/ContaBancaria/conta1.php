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
        <h1>Conta 1</h1>
        <div class="row">
            <div class="col-sm-6">
                <form action="conta1.php" method="get">
                    <input type="hidden" name="saldo">
                    <button type="submit" class="btn btn-primary form-control">Exibir Saldo</button>
                </form>
            </div>
            <div class="col-sm-6">
                <h2>

                    Saldo:
                    <?php
                    if (isset($_GET["saldo"])) {
                        $conta1->exibirSaldo();
                    }
                    ?>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h2>Numero da Conta: <?= $conta1->numero ?></h2>
            </div>
            <div class="col-sm-6">
                <h2> Cliente: <?= $conta1->cliente ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <form action="conta1.php" method="get">
                    <fieldset>
                        <legend>Depósito Conta</legend>

                        <div class="form-group">
                            <label>Valor: </label>
                            <input type="number" name="depValor" class="form-control">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary form-control">Depositar</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="col-sm-3">
                <form action="conta1.php" method="get">
                    <fieldset>
                        <legend>Saque Conta</legend>

                        <div class="form-group">
                            <label>Valor: </label>
                            <input type="text" name="saqValor" class="form-control">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary form-control">Sacar</button>
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="col-sm-6">

                <form action="conta1.php" method="get">
                    <fieldset>
                        <legend>Tranferência Conta</legend>

                        <div class="row">
                            <div class="col-sm-6">
                            <div class="form-group">
                            <label>Numero da Conta: </label>
                            <input type="text" name="traNumConta" class="form-control">
                        </div>
                        
                            </div>
                            <div class="col-sm-6">
                            <div class="form-group">
                            <label>Valor: </label>
                            <input type="text" name="traValor" class="form-control">
                        </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary form-control">Transferir</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

    </div>
</body>

</html>

<?php

//Depósito
if (isset($_GET["depValor"])) {
    if (!empty($_GET["depValor"])) {
        $conta1->depositar($_GET["depValor"]);
        setcookie("saldoConta1", $conta1->getSaldo());
    }
}

//Saque
if (isset($_GET["saqValor"])) {
    if (!empty($_GET["saqValor"])) {
        $conta1->sacar($_GET["saqValor"]);
        setcookie("saldoConta1", $conta1->getSaldo());
    }
}
//Transferência
if (isset($_GET["traValor"]) && isset($_GET["traNumConta"])) {
    if (!empty($_GET["traValor"]) && !empty($_GET["traNumConta"])) {
        if (!isset($_COOKIE["numeroConta2"])) {
           echo "Conta não existe";
        } else {
            $conta2 = new Conta($_COOKIE["numeroConta2"], $_COOKIE["nomeClienteConta2"], $_COOKIE["saldoConta2"]);

            if ($conta2->numero == $_GET["traNumConta"]) {                       
                $conta1->transferir($_GET["traValor"], $conta2);
                setcookie("saldoConta1", $conta1->getSaldo());
                setcookie("saldoConta2", $conta2->getSaldo());
            }

        }
        
    }
}


?>