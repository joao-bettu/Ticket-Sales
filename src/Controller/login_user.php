<?php 

require_once __DIR__ . "/../../vendor/autoload.php";
require_once "/../src/Core/database.php";

use Tickets\User;

$user = new User($db, "usuarios");

$user_selected = $user->find([
    "email" => $_GET["email-user"]
]) ?? false;

if(!$user_selected){
    echo "E-mail informado inexistente!";
    echo "Redirecionado de volta para a tela de login.";
    sleep(5);
    header("Location: login.html");
    exit;
}

if(password_verify($_GET["password-user"], $user_selected["senha"])){
    $_SESSION["id_user"] = $user_selected["id"];
    $_SESSION["email_user"] = $user_selected["email"];
    header("Location: /../View/Main/user.html");
    exit;
} else {
    echo "Senha incorreta! Tente novamente.";
    sleep(5);
    header("Location: login.html");
    exit;
}

?>