<?php
$usuarios = [
    ["login" => "admin", "senha" => "12345"]
];

$log = [];
$totalVendas = 0;

function limparTela()
{
    system('clear');
}

function registrarLog($mesagem)
{
    global $log;
    $log[] = $mesagem . "em" . date("d/m/Y H:i:s");
}
