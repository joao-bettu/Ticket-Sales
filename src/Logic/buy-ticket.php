<?php 

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php'; 

use Tickets\Ticket;
use Tickets\Client;
use Tickets\Sales;

$tickets = new Ticket($db, "ingressos");
$client = new Client($db, "clientes");
$sales = new Sales($db, "compras");
$fuso_horario = new DateTimeZone("America/Sao_Paulo");

function verificarUltimaReserva (DateTime $hora_ultima_reserva) {
    $now = new DateTime("now", new \DateTimeZone("America/Sao_Paulo"));
    
    $interval = new DateInterval("PT2M");
    $limit = clone $now;
    $limit->sub($interval);
    
    return $hora_ultima_reserva < $limit;
}

$loged_client = $client->find([
    "id" => intval($_SESSION["id"])
]);

if (!$loged_client) {
    header("Location: /../../public/login.html?mensagem=cliente-nao-encontrado");
    exit;
}

if($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["buy_ticket"])) {
    $ticket = $tickets->find(["id" => $_GET["ticket_id"]]);
    if (intval($ticket["quantidade"]) > 0) {    
        $data_ultima_reserva = new DateTime($ticket["data_ultima_reserva"], $fuso_horario);
        if (verificarUltimaReserva($data_ultima_reserva)){
            $tickets->update([
                "id" => $ticket["id"],
                "reservado" => false,
                "cliente_reservado" => null
            ]);
        }

        if ($ticket["reservado"] && $ticket["cliente_reservado"] !== intval($_SESSION["id"])) {
            header("Location: /../../public/client.php?mensagem=ingresso-reservado");
            exit;
        }

        if (intval($ticket["quantidade"]) === 1 && !$ticket["reservado"]) {
            $tickets->update([
                "id" => $ticket["id"],
                "reservado" => true,
                "data_ultima_reserva" => (new DateTime("now", $fuso_horario))->format("Y-m-d H:i:s"),
                "cliente_reservado" => intval($_SESSION["id"])
            ]);
        }

        echo "<h3>Compra de Ingresso</h3>";
        echo "<p>Evento: " . htmlspecialchars($ticket["evento"]) . "</p>";
        echo "<p>Descrição: " . htmlspecialchars($ticket["descricao"]) . "</p>";
        echo "<p>Valor: R$" . htmlspecialchars($ticket["valor"]) . "</p>";
        echo "<p>Data do Evento: " . htmlspecialchars($ticket["data_evento"]) . "</p>";
        echo "<p>Quantidade Disponível: " . ($ticket["quantidade"] > 0 ? $ticket["quantidade"] : "Esgotado") . "</p>";
        echo "<p>Reservado: " . ($ticket["reservado"] ? "Sim" : "Não") . "</p>";
        echo "<p>Você está prestes a comprar este ingresso. Confirme abaixo.</p>";
        echo "<form action=\"/src/Logic/buy-ticket.php\" method=\"post\">
            <input type=\"hidden\" name=\"ticket_id\" value=\"" . $ticket["id"] . "\">
            <input type=\"submit\" name=\"confirm_purchase\" value=\"Confirmar Compra\">
        </form>";
        echo "<br>";
        echo "<a href=\"/public/client.php\">Voltar para o menu principal</a>";
    } else {
        header("Location: /../../public/client.php?mensagem=ingresso-nao-encontrado-ou-esgotado");
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirm_purchase"])) {
    $ticket = $tickets->find(["id" => $_POST["ticket_id"]]);
    $sales->create([
        "id_ingresso" => intval($_POST["ticket_id"]),
        "id_cliente" => intval($_SESSION["id"]),
        "id_vendedor" => intval($ticket["vendedor"]),
        "valor" => floatval($ticket["valor"]),
        "data_compra" => (new DateTime("now", $fuso_horario))->format("Y-m-d H:i:s")
    ]);

    $new_quantidade = intval($ticket["quantidade"]) - 1;

    $tickets->update([
        "id" => $_POST["ticket_id"],
        "quantidade" => $new_quantidade,
        "reservado" => false
    ]);
    
    header("Location: /../../public/client.php?mensagem=compra-realizada-com-sucesso");
    exit;
}
?>