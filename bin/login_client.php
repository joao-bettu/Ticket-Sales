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

$clientLogin = $client->find([
    "email" => $_GET["email-client"],
    "senha" => $_GET["password-client"]
]) || null;

if($clientLogin === null){
    echo "E-mail ou senha incorretos!";
    echo "Redirecionado de volta para a tela de login em 5 segundos.";
    sleep(5);
    header("Location: login.html");
    exit;
} else {
    $_SESSION["id_client"] = $clientLogin["id"];
    $_SESSION["email_client"] = $clientLogin["email"];
    //header("Location: "); Redirecionar a tela de cliente
    //exit;
}

?>