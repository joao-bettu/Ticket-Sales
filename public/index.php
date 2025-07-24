<?php 

require_once __DIR__ . "/../vendor/autoload.php";
require_once __DIR__ . "/../src/Controller/auth.php";
define("ROOT_PATH", __DIR__ . "/..");
session_start();

/*
 * Ordem da session:
 * 1 - session_start(): inicia ou retoma a sessão
 * 2 - $_SESSION: array para armazenar informação do usuário da sessão, como id e e-mail
 * 3 - session_unsset(): libera todas as variáveis de sessão registradas no $_SESSION
 * 4 - session_destroy(): encerra a sessão
 * 5 - session_id(): retorna o id alfanumérico da sessão
 * 6 - session_regenerate_id(): gera um novo id de sessão. Boa prática de segurança chamá-lo após um login
 */

// Usará rotas nos forms HTML para chamar a função de login ou register user ou client
// exemplo da action do form action="index.php?route=login-user"
// chamará a função loginUser() do auth.php

$path = $_GET["route"] ?? '/';
$path = trim($path, "/");
$request_method = $_SERVER["REQUEST_METHOD"];

if($path === "login-client"){
    loginUser(
        $_GET["email-user"], 
        $_GET["password-user"]
    );
} else if ($path === "login-user") {
    loginClient(
        $_GET["email-client"], 
        $_GET["password-client"]
    );
} else if ($path === "register-client") {
    registerClient(
        $_POST["client-name"], 
        $_POST["client-email"], 
        $_POST["client-password"]
    );
} else if ($path === "register-user") {
    registerUser(
        $_POST["user-name"],
        $_POST["user-email"],
        $_POST["user-password"],
        $_POST["edit-ticket"],
        $_POST["delete-ticket"]
    );
} else {
    http_response_code(404);
    echo "404 - Página Não Encontrada";
}
?>