<?php 

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\Client;

$client = new Client($db, "clientes");

$selected = $client->find([
    "email" => $_GET["email-client"],
]) ?? false;
    
if(!$selected){
    header("Location: /../../public/login.html?mensagem=e-mail-informado-inexistente");
    exit;
}
    
if(password_verify($_GET["password-client"], $selected["senha"])){
    $_SESSION["id_client"] = $selected["id"];
    $_SESSION["email_client"] = $selected["email"];
    header("Location: ");
    exit;
} else {
    header("Location: /../../public/login.html?mensagem=senha-incorreta");
    exit;
}
?>