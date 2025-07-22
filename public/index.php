<?php 

require_once __DIR__ . "/../vendor/autoload.php";
define("ROTH_PATH", __DIR__ . "/..");
session_start();

// Usará rotas nos forms HTML para chamar o arquivo necessário login user/client ou register user/client
// exemplo da action do form action="index.php?route=login-user"
// chamará os arquivos responsáveis usando require
// exemplo require_once "/../src/Controller/login_user.php"
?>