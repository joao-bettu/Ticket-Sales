<?php 

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\Client;

$client = new Client($db, "clientes");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Acesso negado. Método enviado $_SERVER[REQUEST_METHOD]. Apenas POST é permitido.");
}

$errors = [];

$clean_name = filter_var($_POST["client-name"], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if(empty(trim($clean_name))){
    $errors[] = "O nome é obrigatório!";
}

$clean_email = filter_var($_POST["client-email"], FILTER_VALIDATE_EMAIL);
if(!$clean_email){
    $errors[] = "Digite um e-mail válido!";
}

$client_email = $client->find([
    "email" => $clean_email
]) ?? false;
if($client_email){
    $errors[] = "E-mail já está em uso. Tente outro e-mail.";
}

if(strlen($_POST["client-password"]) < 8){
    $errors[] = "A senha deve ter pelo menos 8 caracteres.";
}
$hash_password = password_hash($_POST["client-password"], PASSWORD_BCRYPT);

if(empty($errors)){
    $client->create([
        "nome" => $clean_name,
        "email" => $clean_email,
        "senha" => $hash_password
    ]);

    header("Location: /../../public/login.html?mensagem=cliente-cadastrado-com-sucesso");
    exit;
} else {
    $mensagem = implode("-", $errors);
    header("Location: /../../public/register.html?mensagem=" . urlencode($mensagem));
    exit;
}
?>