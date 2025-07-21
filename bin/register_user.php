<?php 

require_once __DIR__ . "/../vendor/autoload.php";
require_once "database.php";

use Tickets\User;

session_start();

$user = new User($db, "usuarios");

$errors = [];

$name =  $_POST["user-name"] ?? '';
$clean_name = filter_var($name, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if(empty(trim($clean_name))){
    $errors[] = "O nome é obrigatório!";
}

$email =  $_POST["user-email"] ?? '';
$clean_email = filter_var($email, FILTER_VALIDATE_EMAIL);
if(!$clean_email){
    $errors[] = "Digite um e-mail válido!";
}

$password = $_POST["user-password"] ?? '';
if(strlen($password) < 8){
    $errors[] = "A senha deve ter pelo menos 8 caracteres.";
}
$hash_password = password_hash($password, PASSWORD_BCRYPT);

$edit = filter_var($_POST["edit-ticket"] ?? false, FILTER_VALIDATE_BOOL);
$delete = filter_var($_POST["delete-ticket"] ?? false, FILTER_VALIDATE_BOOL);

if(empty($errors)){
    // Criação do usuário no banco de dados
} else {
    $mensagem = implode("<br>", $errors);
    echo $mensagem;
    header("Location: register_user.php");
    exit;
}

?>