<?php 

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\Ticket;

$ticket = new Ticket($db, "ingressos");

if (isset($_SESSION["id"]) && $_SERVER["REQUEST_METHOD"] === "POST") {
    $error = [];
    
    $event = filter_var($_POST["evento"], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    if (empty(trim($event))) {
        $error[] = "O nome do evento é obrigatório!";
    }

    $description = filter_var($_POST["descricao"], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
    
    $value = filter_var($_POST["valor"], FILTER_VALIDATE_FLOAT);
    if ($value === false || $value <= 0) {
        $error[] = "O valor do ingresso deve ser um número positivo!";
    }
    
    $eventDate = DateTime::createFromFormat('Y-m-d', $_POST["data_evento"]);
    if (!$eventDate || $eventDate < new DateTime()) {
        $error[] = "A data do evento deve ser uma data válida e futura!";
    }
    
    $quantity = filter_var($_POST["quantidade"], FILTER_VALIDATE_INT);
    if ($quantity === false || $quantity <= 0) {
        $error[] = "A quantidade deve ser um número inteiro positivo!";
    }
    $reserved = false;
    $reservedDate = DateTime::createFromFormat('Y-m-d', "0000-00-00");;
    $vendor = $_SESSION["id"];

    $format_event_date = $eventDate->format('Y-m-d');
    $format_reserved_date = $reservedDate->format('Y-m-d');

    if(empty($error)){
        $ticket->create([
            "evento" => $event,
            "descricao" => $description,
            "valor" => $value,
            "data_evento" => $format_event_date,
            "quantidade" => $quantity,
            "reservado" => $reserved,
            "data_ultima_reserva" => $format_reserved_date,
            "vendedor" => $vendor
        ]);
        
        header("Location: /../../public/user.php?mensagem=ingresso-adicionado-com-sucesso");
        exit;
    } else {
        $mensagem = implode("-", $error);
        header("Location: /../../public/register.html?mensagem=" . urlencode($mensagem));
        exit;
    }
}

?>