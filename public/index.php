<?php 

require_once __DIR__ . "/../vendor/autoload.php";
define("ROOT_PATH", __DIR__ . "/..");
session_start();

// Usará rotas nos forms HTML para chamar o arquivo necessário login user/client ou register user/client
// exemplo da action do form action="index.php?route=login-user"
// chamará os arquivos responsáveis usando require
// exemplo require_once "/../src/Controller/login_user.php"

$path = $_GET["route"] ?? '/';
$path = trim($path, "/");

if($path === "login-client"){
    require ROOT_PATH . "/src/Controllers/login_client.php";
} else if ($path === "login-user") {
    require ROOT_PATH . "/src/Controllers/login_user.php";
} else if ($path === "register-client") {
    require ROOT_PATH . "/src/Controllers/register_client.php";
} else if ($path === "register-user") {
    require ROOT_PATH . "/src/Controllers/register_user.php";
} else {
    http_response_code(404);
    echo "404 - Página Não Encontrada";
}
?>