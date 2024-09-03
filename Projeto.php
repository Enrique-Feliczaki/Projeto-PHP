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
    $log[] = $mesagem . " em:" . date("d/m/Y H:i:s");
}

function verificarLogin($login, $senha)
{
    global $usuarios;
    foreach ($usuarios as $usuario) {
        if ($usuario['login'] === $login && $usuario['senha'] === $senha) {
            return true;
        }
    }
    return false;
}

function exibirMenu()
{
    global $totalVendas;
    limparTela();
    echo "=== Bem-Vindo ao Serviço de Gerencialmento de Caixa do mano Smigol!! ===\n";
    echo "Usuario Logado: \n" . $_SESSION['usuario'] . "\n";
    echo "Total de Vendas: R$" . number_format($totalVendas, 2, ',', '.') . PHP_EOL;
    echo "=========================================================================\n";
    echo "1-Realizar venda\n";
    echo "2-Cadastrar novo Usuario\n";
    echo "3-Verificar Log\n";
    echo "4-Deslogar\n";
    echo "Escolha uma opcao: ";
}

function realizarLogin()
{
    limparTela();
    echo "=== Login do Sistema ===\n";
    echo "1-Acessar seu login\n";
    echo "2-Criar um novo Usuario\n";
    echo "Escolha uma opcao: \n";
    $opcao = trim(fgets(STDIN));
    if ($opcao === '1') {
        echo "Digite seu login: \n";
        $login = trim(fgets(STDIN));
        echo "Digite sua senha: \n";
        $senha = trim(fgets(STDIN));

        if (verificarLogin($login, $senha)) {
            $_SESSION['usuario'] = $login;
            registrarLog("Usuario $login fez login");
            limparTela();
            echo "Login realizado com sucesso!\n";
        } else {
            echo "Login ou senha incorreto, tente novamente\n";
        }
    }
}

function realizarVendas()
{
    global $totalVendas;
    limparTela();
    echo "=== Realizar Venda ===\n";
    echo "Informe o nome do item vendido (ou 'voltar' para retornar ao menu): ";
    $entrada = trim(fgets(STDIN));
    if (strtolower($entrada) === 'voltar') {
        return;
    }
    $item = (float)$entrada;
    echo "Informe o valor do item: ";
    $valor = trim(fgets(STDIN));

    $totalVendas += $valor;
    registrarLog("Usuario " . $_SESSION['usuario'] . " realizou uma venda do item $item com o valor de: R$" . number_format($valor, 2, ',', '.') . PHP_EOL);
    limparTela();
    echo "Venda realizada com Sucesso\n";
}

function cadastrarUsuario()
{
    global $usuarios;
    limparTela();
    echo "=== Cadastro de novo Usuario ===\n";
    echo "Digite o login do novo usuario (ou 'voltar' para retornar ao menu): ";
    $login = trim(fgets(STDIN));
    if (strtolower($login) === 'voltar') {
        return;
    }
    echo "Digite a senha do novo usuario: ";
    $senha = trim(fgets(STDIN));
    $usuarios[] = ['login' => $login, 'senha' => $senha];
    registrarLog("Novo usuario cadastrado: $login");
    limparTela();
    echo "Usuário cadastrado com sucesso\n";
}

function verificarLog()
{
    global $log;
    limparTela();
    echo "=== Verificacao de Log ===\n";
    echo "Historico de acoes:\n";
    foreach ($log as $entrada) {
        echo $entrada . "\n";
    }
    echo "\n Digite qualquer tecla para retornar ao menu principal...";
    fgets(STDIN);
}


function deslogar()
{
    registrarLog("Usuario" . $_SESSION['usuario'] . "Realizou logout");
    unset($_SESSION['usuario']);
    limparTela();
    echo "Usuario deslogado com sucesso!\n";
}

while (true) {
    if (isset($_SESSION['usuario'])) {
        exibirMenu();
        $opcao = trim(fgets(STDIN));
        switch ($opcao) {
            case '1':
                realizarVendas();

                break;
            case '2':
                cadastrarUsuario();

                break;
            case '3':

                verificarLog();

                break;
            case '4':
                deslogar();

                break;
            default:
                limparTela();
                echo "Opcao invalida, tente novamente\n";
                break;
        }
    } else {
        realizarLogin();
    }
}
