<?php require "Conta.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transações da Conta 2</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

</head>

<body>

    <?php
    $conta1 = null;
    $conta2 = null;
  
    //Se a conta não existe cria se uma nova Instancia de conta e adiciona no cookie
    if (!isset($_COOKIE["numConta2"])) {
        $conta2 = new Conta("2323", "Pedro",  0);
        setcookie("numConta2", $conta2->numero);
        setcookie("clienteConta2", $conta2->cliente);
        setcookie("saldo2", $conta2->getSaldo());
    } else {
        //Se a conta já existe cria uma nova conta a partir do cookie
        $conta2 = new Conta($_COOKIE["numConta2"], $_COOKIE["clienteConta2"], $_COOKIE["saldo2"]);
    }

    ?>
    <div class="container">
        <h1>Conta 2</h1>
        <div class="row">
            <div class="col-sm-6">
                <form action="conta2.php" method="get">
                    <input type="hidden" name="saldo">
                    <button type="submit" class="btn btn-primary form-control">Exibir Saldo</button>
                </form>
            </div>
            <div class="col-sm-6">
                <h2>

                    Saldo:
                    <?php
                    if (isset($_GET["saldo"])) {
                        $conta2->exibirSaldo();
                    }
                    ?>
                </h2>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <h2>Numero da Conta: <?= $conta2->numero ?></h2>
            </div>
            <div class="col-sm-6">
                <h2> Cliente: <?= $conta2->cliente ?></h2>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-3">
                <form action="conta2.php" method="get">
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
                <form action="conta2.php" method="get">
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

                <form action="conta2.php" method="get">
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
        if ($conta2->depositar($_GET["depValor"])) {
            setcookie("saldo2", $conta2->getSaldo());
            echo "<script>alert('Deposito realizado com sucesso')</script>";
        } else {

            echo "<script>alert('Deposito não realizado')</script>";
        }
    }
}

//Saque
if (isset($_GET["saqValor"])) {
    if (!empty($_GET["saqValor"])) {
        if ($conta2->sacar($_GET["saqValor"])) {
            setcookie("saldo2", $conta2->getSaldo());
            echo "<script>alert('Saque realizado com sucesso')</script>";
        } else {
            echo "<script>alert('Saldo insuficiente')</script>";
        }
    }
}
//Transferência
if (isset($_GET["traValor"]) && isset($_GET["traNumConta"])) {
    if (!empty($_GET["traValor"]) && !empty($_GET["traNumConta"])) {
        if (!isset($_COOKIE["numConta1"])) {
            echo "<script>alert('Conta inexistente')</script>";
        } else {
            $conta1 = new Conta($_COOKIE["numConta1"], $_COOKIE["clienteConta1"], $_COOKIE["saldo1"]);

            if ($conta1->numero == $_GET["traNumConta"]) {
                if ($conta2->transferir($_GET["traValor"], $conta1)) {

                    setcookie("saldo2", $conta2->getSaldo());
                    setcookie("saldo1", $conta1->getSaldo());
                    echo "<script>alert('Transferência Realizada com Sucesso!')</script>";
                } else {
                    echo "<script>alert('Transferência Não realizada')</script>";
                }
            }
        }
    }
}

?>