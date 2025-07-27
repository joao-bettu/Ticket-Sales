<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cliente</title>
    <link rel="stylesheet" href="/public/css/client.css">
</head>

<body>
    <div class="container">
        <h1>Sistema de Compra de Ingressos</h1>

        <div class="options">
            <h3>Opções de Cliente</h3>
            <div class="forms">
                <form class="account-form" action="/src/Logic/edit-account.php" method="get">
                    <input type="submit" name="account" value="Editar Conta">
                </form>
                <form class="logout-form" action="/src/Logic/logout.php" method="post">
                    <input type="submit" value="Sair">
                </form>
            </div>
        </div>
        <div class="ingressos">
            <h2>Ingressos</h2>

            <div class="ingressos-lista">
                <?php 
                session_start();
                session_regenerate_id();
                require_once __DIR__ . '/../vendor/autoload.php';
                require_once __DIR__ . '/../src/Core/database.php';
                use Tickets\Ticket;
                $tickets = new Ticket($db, "ingressos");
                if (isset($_SESSION["id"])){
                    $ingressos = $tickets->read();
                    if (!empty($ingressos)) {
                        foreach ($ingressos as $ingresso) {
                            echo "<div class='ticket'>";
                            echo "<h3>" . htmlspecialchars($ingresso["evento"]) . "</h3>";
                            echo "<p><strong>Descrição</strong>: " . htmlspecialchars($ingresso["descricao"]) . "</p>";
                            echo "<p><strong>Valor</strong>: R$" . htmlspecialchars($ingresso["valor"]) . "</p>";
                            echo "<p><strong>Data</strong>: " . htmlspecialchars($ingresso["data_evento"]) . "</p>";
                            echo "<p><strong>Quantidade</strong>: " . ($ingresso["quantidade"] > 0 ? $ingresso["quantidade"] : "Esgotado") . "</p>";
                            echo "<p><strong>Reservado</strong>: " . ($ingresso["reservado"] ? "Sim" : "Não" ) . "</p>";
                            echo "<form action=\"/src/Logic/buy-ticket.php\" method=\"get\">
                                    <input type=\"hidden\" name=\"ticket_id\" value=\"" . $ingresso["id"] . "\">
                                    <input type=\"submit\" name=\"buy_ticket\" value=\"Comprar\">
                                </form>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Nenhum ingresso disponível.</p>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>