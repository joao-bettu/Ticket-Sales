<?php 

require_once __DIR__ . "/../vendor/autoload.php";
require_once "database.php";

use Tickets\Client;

session_start();

$client = new Client($db, "clientes");

$client->create([
    "nome" => $_POST["client-name"],
    "email" => $_POST["client-email"],
    "senha" => $_POST["client-password"]
])

?>