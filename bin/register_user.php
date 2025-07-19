<?php 

require_once __DIR__ . "/../vendor/autoload.php";
require_once "database.php";

use Tickets\User;

session_start();

$user = new User($db, "usuarios");

$user->create([
    "nome" => $_POST["user-name"],
    "email" => $_POST["user-email"],
    "senha" => $_POST["user-password"],
    "editar" => $_POST["edit-ticket"],
    "deletar" => $_POST["delete-ticket"]
])

?>