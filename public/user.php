<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuário</title>
    <link rel="stylesheet" href="/public/css/user.css">
</head>

<body>
    <div class="container">
        <h1>Sistema de Venda de Ingressos!</h1>

        <div class="options">
            <h3>Opções de Usuário</h3>
            <div class="forms">
                <form class="permission-form" action="/src/Logic/edit-permission.php" method="get">
                    <input type="submit" name="permissao" value="Editar Permissões">
                </form>
                <form class="logout-form" action="/src/Logic/logout.php" method="post">
                    <input type="submit" value="Sair">
                </form>
            </div>
        </div>

        <div class="ingressos">
            <h2>Ingressos</h2>
            <div class="form-ingressos">
                <h3>Adicionar ingressos</h3>
                <form class="add-ticket" action="/src/Logic/create-ticket.php" method="post">
                    <input type="text" id="evento" name="evento" placeholder="Nome do Evento" required>
                    <input type="text" id="descricao" name="descricao" placeholder="Descrição do Evento">
                    <input type="text" id="valor" name="valor" placeholder="Valor do Ingresso" required>
                    <input type="date" id="data_evento" name="data_evento" required>
                    <input type="number" id="quantidade" name="quantidade" placeholder="Quantidade" required>
                    <input type="submit" value="Adicionar Ingresso">
                </form>
            </div>
            <h3>Meus Ingressos</h3>
            <div class="ingressos-lista">
                <?php 
                session_start();
                session_regenerate_id();
                require_once __DIR__ . '/../vendor/autoload.php';
                require_once __DIR__ . '/../src/Core/database.php';
                use Tickets\Ticket;
                $tickets = new Ticket($db, "ingressos");
                if (isset($_SESSION["id"])){
                    $ingressos = $tickets->findAllBy(["vendedor" => $_SESSION["id"]]);
                    if (count($ingressos) > 0) {
                        echo "<h3>Ingressos Disponíveis</h3>";
                        foreach ($ingressos as $ingresso) {
                            echo "<div class='ticket'>";
                            echo "<h3>" . htmlspecialchars($ingresso["evento"]) . "</h3>";
                            echo "<p>Descrição: " . htmlspecialchars($ingresso["descricao"]) . "</p>";
                            echo "<p>Valor: R$" . htmlspecialchars($ingresso["valor"]) . "</p>";
                            echo "<p>Data: " . htmlspecialchars($ingresso["data_evento"]) . "</p>";
                            echo "<p>Quantidade: " . htmlspecialchars($ingresso["quantidade"]) . "</p>";
                            echo "<p>Reservado: " . ($ingresso["reservado"] ? "Sim" : "Não" ) . "</p>";
                            echo "<form class=\"edit\" action=\"/src/Logic/edit-ticket.php\" method=\"get\">
                                    <input type=\"hidden\" class=\"hidden\" name=\"ticket-id\" value=\"" . intval($ingresso["id"]) . "\">
                                    <input type=\"submit\" name=\"edit-button\" value=\"Editar\">
                                </form>";
                            echo "<form class=\"delete\" action=\"/src/Logic/delete-ticket.php\" method=\"get\">
                                    <input type=\"hidden\" class=\"hidden\" name=\"ticket-id\" value=\"" . intval($ingresso["id"]) . "\">
                                    <input type=\"submit\" name=\"delete-button\" value=\"Excluir\">
                                </form>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Nenhum ingresso encontrado.</p>";
                    }
                }
                ?>
            </div>
        </div>
</body>

</html>