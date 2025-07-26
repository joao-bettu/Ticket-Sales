<?php 

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\User;

$user = new User($db, "usuarios");

$selected = $user->find([
    "email" => $_GET["email-user"],
]) ?? false;
    
if(!$selected){
    header("Location: /../../public/login.html?mensagem=e-mail-informado-inexistente");
    exit;
}
    
if(password_verify($_GET["password-user"], $selected["senha"])){
    $_SESSION["id_user"] = $selected["id"];
    $_SESSION["email_user"] = $selected["email"];
    header("Location: /../../public/user.html?mensagem=usuario-logado-com-sucesso");
    exit;
} else {
    header("Location: /../../public/login.html?mensagem=senha-incorreta");
    exit;
}
?>