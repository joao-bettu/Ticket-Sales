<?php 

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\Client;

$client = new Client($db, "clientes");

$selected = $client->find([
    "email" => $_GET["email-client"]
]) ?? false;
    
if(!$selected){
    header("Location: /../../public/login.html?mensagem=e-mail-informado-inexistente");
    exit;
}
    
if(password_verify($_GET["password-client"], $selected["senha"])){
    $_SESSION["id"] = $selected["id"];
    $_SESSION["email"] = $selected["email"];
    header("Location: /../../public/client.php?mensagem=usuario-logado-com-sucesso");
    exit;
} else {
    header("Location: /../../public/login.html?mensagem=senha-incorreta");
    exit;
}
?>