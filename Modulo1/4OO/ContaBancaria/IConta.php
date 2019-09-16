<?php
    interface IConta
    {
        public function getSaldo();
        public function depositar($valor);
        public function sacar($valor);
        public function transferir($valor, $outraConta);
    }
?>