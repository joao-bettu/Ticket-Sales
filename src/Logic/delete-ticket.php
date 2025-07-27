<?php 

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\Ticket;
use Tickets\User;

$user = new User($db, "usuarios");
$tickets = new Ticket($db, "ingressos");

$loged_user = $user->find([
    "id" => intval($_SESSION["id"])
]);

if (!$loged_user) {
    header("Location: /../../public/login.html?mensagem=usuario-nao-encontrado");
    exit;
}

if ($loged_user["deletar"]){
    $delete_ticket = $tickets->find([
        "id" => $_GET["ticket-id"]
    ]);
    if ($delete_ticket) {
        $tickets->delete($delete_ticket["id"]);
        header("Location: /../../public/user.php?mensagem=ingresso-excluido-com-sucesso");
        exit;
    } else {
        header("Location: /../../public/user.php?mensagem=ingresso-nao-encontrado");
        exit;
    }
} else {
    header("Location: /../../public/user.php?mensagem=usuario-sem-permissao-para-excluir-ingressos");
    exit;
}

?>