<?php
require "IConta.php";

class Conta implements IConta
{
    public $numero;
    private $saldo;
    public $cliente;
    public function Conta($numero, $cliente, $saldo){
        $this->numero = $numero;
        $this->cliente = $cliente;
        $this->saldo = $saldo;
    }
    public function getSaldo(){
        return $this->saldo;
    }

    public function exibirSaldo(){
        echo $this->getSaldo();
    }

    public function depositar($valor){
        $sucesso = false;
        if ($valor >= 0) {
            $this->saldo += $valor;
            $sucesso = true;
        }
        return $sucesso;
    }
    public function sacar($valor){
        $sucesso = false;
        if ($this->saldo >= $valor) {
            $this->saldo -= $valor;
            $sucesso = true;
        }
        return $sucesso;
    }

    public function transferir($valor, $outraConta){
        $sucesso = false;
        if ($this->sacar($valor)) {
            $sucesso = $outraConta->depositar($valor);
        }
        return $sucesso;
    }
}
?>