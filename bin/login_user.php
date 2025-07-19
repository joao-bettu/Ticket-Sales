<?php 

require_once __DIR__ . "/../vendor/autoload.php";
require_once "database.php";

use Tickets\User;

session_start();

$user = new User($db, "usuarios");

$userLogin = $user->find([
    "email" => $_GET["email-user"],
    "senha" => $_GET["password-user"]
]) || null;

if($userLogin === null){
    echo "E-mail ou senha incorretos!";
    echo "Redirecionado de volta para a tela de login em 5 segundos.";
    sleep(5);
    header("Location: login.html");
    exit;
} else {
    $_SESSION["id_user"] = $userLogin["id"];
    $_SESSION["email_user"] = $userLogin["email"];
    //header("Location: "); Redirecionar a tela de usuario
    //exit;
}

?>