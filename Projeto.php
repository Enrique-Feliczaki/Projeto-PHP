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

function verificarLogin($login, $senha)
{
    global $usuarios;
    foreach ($usuarios as $usuario) {
        if ($usuario[$login] === $login && $usuario[$senha] === $senha) {
            return true;
        }
    }
    return false;
}

function exibirMenu()
{
    global $totalVendas;
    echo "Bem-Vindo ao Serviço de Gerencialmento de Caixa do mano Smigol!!\n";
    echo "Usuario Logado: \n" . $_SESSION['usuario'] . "/n";
    echo "Total de Vendas: R$" . number_format($totalVendas, 2, ',', '.' . '/n/n');
    echo "1-Realizar venda\n";
    echo "2-Cadastrar novo Usuario\n";
    echo "3-Verificar Login\n";
    echo "4-Deslogar\n";
    echo "Escolha uma opcao";
}

function realizarLogin()
{
    echo "Digite seu login: \n";
    $login = trim(fgets(STDIN));
    echo "Digite sua senha: \n";
    $senha = trim(fgets(STDIN));
    if (verificarLogin($login, $senha)) {
        $_SESSION['usuario'] = $login;
        registrarLog("Usuario $login fez login\n");
        limparTela();
        echo "Login Bem-Sucedido\n";
    } else {
        echo "Login ou senha incorretos, Tente novamente\n";
    }
}

function realizarVendas()
{
    global $totalVendas;
    echo "Informe o nome do item vendido: ";
    $item = trim(fgets(STDIN));
    echo "Informe o valor do item: ";
    $valor = trim(fgets(STDIN));
    $totalVendas += $valor;
    registrarLog("Usuario" . $_SESSION['usuario'] . "realizou uma venda do item $item com o valor de: R$" . number_format($valor, 2, ',', '.' . '/n/n'));
    echo "Venda realizada com Sucesso\n";
}

function cadastrarUsuario()
{
    global $usuarios;
    echo "Digite o login do novo usuario: ";
    $login = trim(fgets(STDIN));
    echo "Digite a senha do novo usuario: ";
    $senha = trim(fgets(STDIN));
    $usuarios[] = ['login' => $login, 'senha' => $senha];
    registrarLog("Novo usuario cadastrado: $login");
    echo "Usuário cadastrado com sucesso\n";
}

function verificarLog()
{
    global $log;
    echo "Historico de acoes:\n";
    foreach ($log as $entrada) {
        echo $entrada . "\n";
    }
}


function deslogar()
{
    registrarLog("Usuario" . $_SESSION['usuario'] . "realizou logout");
    unset($_SESSION['usuario']);
    echo "Usuario deslogado com sucesso!\n";
}
