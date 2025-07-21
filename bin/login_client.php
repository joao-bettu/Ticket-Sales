<?php 

require_once __DIR__ . "/../vendor/autoload.php";
require_once "database.php";

use Tickets\Client;

/*
 * Ordem da session:
 * 1 - session_start(): inicia ou retoma a sessão
 * 2 - $_SESSION: array para armazenar informação do usuário da sessão, como id e e-mail
 * 3 - session_unsset(): libera todas as variáveis de sessão registradas no $_SESSION
 * 4 - session_destroy(): encerra a sessão
 * 5 - session_id(): retorna o id alfanumérico da sessão
 * 6 - session_regenerate_id(): gera um novo id de sessão. Boa prática de segurança chamá-lo após um login
 */

session_start();

$client = new Client($db, "clientes");

$client_selected = $client->find([
    "email" => $_GET["email-client"]
]) || null;

if($client_selected === null){
    echo "E-mail informado inexistente!";
    echo "Redirecionado de volta para a tela de login.";
    sleep(5);
    header("Location: login.html");
    exit;
}

// If para verificar se a senha passada está correta
if(password_verify($_GET["password-client"], $client_selected->columns["senha"])){}

//$_SESSION["id_client"] = $clientLogin["id"];
//$_SESSION["email_client"] = $clientLogin["email"];
//header("Location: "); Redirecionar a tela de cliente
//exit;

?>