<?php 

require_once __DIR__ . "/../../vendor/autoload.php";
require_once "/../src/Core/database.php";

use Tickets\Client;
use Tickets\User;

$user = new User($db, "usuarios");
$client = new Client($db, "clientes");

function registerClient($name = '', $email = '', $senha = ''){
    global $client;
    $errors = [];

    //$name =  $_POST["client-name"] ?? '';
    $clean_name = filter_var($name, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    if(empty(trim($clean_name))){
        $errors[] = "O nome é obrigatório!";
    }

    //$email =  $_POST["client-email"] ?? '';
    $clean_email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if(!$clean_email){
        $errors[] = "Digite um e-mail válido!";
    }

    $client_email = $client->find([
        "email" => $clean_email
    ]) ?? false;
    if(!$client_email){
        $errors[] = "E-mail já está em uso. Tente outro e-mail.";
    }

    //$password = $_POST["client-password"] ?? '';
    if(strlen($senha) < 8){
        $errors[] = "A senha deve ter pelo menos 8 caracteres.";
    }
    $hash_password = password_hash($senha, PASSWORD_BCRYPT);

    if(empty($errors)){
        $client->create([
            "nome" => $clean_name,
            "email" => $clean_email,
            "senha" => $hash_password
        ]);
        echo "Cliente cadastrado com sucesso, redirecionado a tela de login.";
        sleep(5);
        header("Location: /../View/Auth/login.html");
        exit;
    } else {
        $mensagem = implode("<br>", $errors);
        echo $mensagem;
        header("Location: /../View/Auth/register.html");
        exit;
    }
}

function registerUser($name = '', $email = '', $senha = '', $edit, $delete){
    global $user;
    $errors = [];

    //$name =  $_POST["user-name"] ?? '';
    $clean_name = filter_var($name, FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    if(empty(trim($clean_name))){
        $errors[] = "O nome é obrigatório!";
    }

    //$email =  $_POST["user-email"] ?? '';
    $clean_email = filter_var($email, FILTER_VALIDATE_EMAIL);
    if(!$clean_email){
        $errors[] = "Digite um e-mail válido!";
    }

    $user_email = $user->find([
        "email" => $clean_email
    ]) ?? false;
    if($user_email){
        $errors[] = "E-mail já está em uso. Tente outro e-mail.";
    }

    //$password = $_POST["user-password"] ?? '';
    if(strlen($senha) < 8){
        $errors[] = "A senha deve ter pelo menos 8 caracteres.";
    }
    $hash_password = password_hash($senha, PASSWORD_BCRYPT);

    //$edit = filter_var($_POST["edit-ticket"] ?? false, FILTER_VALIDATE_BOOL);
    //$delete = filter_var($_POST["delete-ticket"] ?? false, FILTER_VALIDATE_BOOL);

    if(empty($errors)){
        $user->create([
            "nome" => $clean_name,
            "email" => $clean_email,
            "senha" => $hash_password,
            "editar" => $edit,
            "delete" => $delete
        ]);
        echo "Usuário cadastrado com sucesso, redirecionado a tela de login.";
        sleep(5);
        header("Location: /../View/Auth/login.html");
        exit;
    } else {
        $mensagem = implode("<br>", $errors);
        echo $mensagem;
        header("Location: /../View/Auth/register.html");
        exit;
    }
}

function loginClient($email, $senha){
    global $client;
    $selected = $client->find([
        "email" => $email,
    ]) ?? false;
    
    if(!$selected){
        echo "E-mail informado inexistente!";
        echo "Redirecionado de volta para a tela de login.";
        sleep(5);
        header("Location: /../View/Auth/login.html");
        exit;
    }
    
    if(password_verify($senha, $selected["senha"])){
        $_SESSION["id_client"] = $selected["id"];
        $_SESSION["email_client"] = $selected["email"];
        header("Location: /../View/Main/client.html");
        exit;
    } else {
        echo "Senha incorreta! Tente novamente.";
        sleep(5);
        header("Location: /../View/Auth/login.html");
        exit;
    }
}

function loginUser($email, $senha){
    global $user;
    $selected = $user->find([
        "email" => $email,
    ]) ?? false;
    
    if(!$selected){
        echo "E-mail informado inexistente!";
        echo "Redirecionado de volta para a tela de login.";
        sleep(5);
        header("Location: /../View/Auth/login.html");
        exit;
    }
    
    if(password_verify($senha, $selected["senha"])){
        $_SESSION["id_user"] = $selected["id"];
        $_SESSION["email_user"] = $selected["email"];
        header("Location: /../View/Main/user.html");
        exit;
    } else {
        echo "Senha incorreta! Tente novamente.";
        sleep(5);
        header("Location: /../View/Auth/login.html");
        exit;
    }
}
?>