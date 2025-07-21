<?php 

require_once __DIR__ . "/../vendor/autoload.php";
require_once "database.php";

use Tickets\Client;

session_start();

$client = new Client($db, "clientes");

$errors = [];

$name =  $_POST["client-name"] ?? '';
$clean_name = filter_var($name, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if(empty(trim($clean_name))){
    $errors[] = "O nome é obrigatório!";
}

$email =  $_POST["client-email"] ?? '';
$clean_email = filter_var($email, FILTER_VALIDATE_EMAIL);
if(!$clean_email){
    $errors[] = "Digite um e-mail válido!";
}

$password = $_POST["client-password"] ?? '';
if(strlen($password) < 8){
    $errors[] = "A senha deve ter pelo menos 8 caracteres.";
}
$hash_password = password_hash($password, PASSWORD_BCRYPT);


if(empty($errors)){
    $client->create([
        "nome" => $clean_name,
        "email" => $clean_email,
        "senha" => $hash_password
    ]);
} else {
    $mensagem = implode("<br>", $errors);
    echo $mensagem;
    header("Location: register.html");
    exit;
}
?>