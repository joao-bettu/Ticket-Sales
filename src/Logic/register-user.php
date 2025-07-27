<?php 

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\User;

$user = new User($db, "usuarios");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /../../public/register.html?mensagem=metodo-invalido");
    exit;
}

$errors = [];

$clean_name = filter_var($_POST["user-name"], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
if(empty(trim($clean_name))){
    $errors[] = "O nome é obrigatório!";
}

$clean_email = filter_var($_POST["user-email"], FILTER_VALIDATE_EMAIL);
if(!$clean_email){
    $errors[] = "Digite um e-mail válido!";
}

$user_email = $user->find([
    "email" => $clean_email
]) ?? false;
if($user_email){
    $errors[] = "E-mail já está em uso. Tente outro e-mail.";
}

if(strlen($_POST["user-password"]) < 8){
    $errors[] = "A senha deve ter pelo menos 8 caracteres.";
}
$hash_password = password_hash($_POST["user-password"], PASSWORD_BCRYPT);

$edit_bool = filter_var($_POST["edit-ticket"] ?? false, FILTER_VALIDATE_BOOL);
$delete_bool = filter_var($_POST["delete-ticket"] ?? false, FILTER_VALIDATE_BOOL);

if(empty($errors)){
    $user->create([
        "nome" => $clean_name,
        "email" => $clean_email,
        "senha" => $hash_password,
        "editar" => $edit_bool,
        "deletar" => $delete_bool
    ]);

    header("Location: /../../public/login.html?mensagem=usuario-cadastrado-com-sucesso");
    exit;
} else {
    $mensagem = implode("-", $errors);
    header("Location: /../../public/register.html?mensagem=" . urlencode($mensagem));
    exit;
}
?>