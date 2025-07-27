<?php 

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\User;
use Tickets\Ticket;

$user = new User($db, "usuarios");
$tickets = new Ticket($db, "ingressos");

$loged_user = $user->find([
    "id" => intval($_SESSION["id"])
]);

if (!$loged_user) {
    header("Location: /../../public/login.html?mensagem=usuario-nao-encontrado");
    exit;
}

if ($loged_user["editar"]){
    $edit_ticket = $tickets->find([
        "id" => $_GET["ticket-id"]
    ]);
    if ($edit_ticket !== null) {
        $erros = [];
        echo "<h3>Editar Ingresso</h3>";
        echo "<form class=\"edit-ticket\" action=\"/src/Logic/edit-ticket.php\" method=\"post\">
                <input type=\"hidden\" name=\"ticket-id\" value=\"" . intval($edit_ticket["id"]) . "\">
                <input type=\"text\" id=\"evento\" name=\"evento\" value=\"" . htmlspecialchars($edit_ticket["evento"]) . "\" required>
                <input type=\"text\" id=\"descricao\" name=\"descricao\" value=\"" . htmlspecialchars($edit_ticket["descricao"]) . "\">
                <input type=\"text\" id=\"valor\" name=\"valor\" value=\"" . htmlspecialchars($edit_ticket["valor"]) . "\" required>
                <input type=\"date\" id=\"data_evento\" name=\"data_evento\" value=\"" . htmlspecialchars($edit_ticket["data_evento"]) . "\" required>
                <input type=\"number\" id=\"quantidade\" name=\"quantidade\" value=\"" . htmlspecialchars($edit_ticket["quantidade"]) . "\" required>
                <input type=\"submit\" value=\"Salvar Alterações\">
            </form>";
            echo "<br>";
            echo "<a href=\"/public/user.php\">Voltar para o menu principal</a>";
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $new_event = filter_var($_POST["evento"], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            if (empty(trim($new_event))) {
                $erros[] = "O nome do evento é obrigatório!";
            }
            $new_description = filter_var($_POST["descricao"], FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
            $new_value = filter_var($_POST["valor"], FILTER_VALIDATE_FLOAT);
            if (!$new_value || $new_value <= 0) {
                $erros[] = "O valor do ingresso deve ser um número positivo!";
            }
            $new_date = DateTime::createFromFormat('Y-m-d', $_POST["data_evento"]);
            if (!$new_date || $new_date < new DateTime()) {
                $erros[] = "A data do evento deve ser uma data válida e futura!";
            }
            $new_quantity = filter_var($_POST["quantidade"], FILTER_VALIDATE_INT);
            if (!$new_quantity || $new_quantity <= 0) {
                $erros[] = "A quantidade deve ser um número inteiro positivo!";
            }

            if (empty($erros)) {
                $format_new_date = $new_date->format('Y-m-d');
                $tickets->update([
                    "id" => intval($_POST["ticket-id"]),
                    "evento" => $new_event,
                    "descricao" => $new_description,
                    "valor" => $new_value,
                    "data_evento" => $format_new_date,
                    "quantidade" => $new_quantity
                ]);
                header("Location: /../../public/user.php?mensagem=ingresso-editado-com-sucesso");
                exit;
            } else {
                $mensagem = implode("-", $erros);
                header("Location: /../../public/user.php?mensagem=" . urlencode($mensagem));
                exit;
            }
        }
    } else {
        header("Location: /../../public/user.php?mensagem=ingresso-nao-encontrado");
        exit;
    }
} else {
    header("Location: /../../public/user.php?mensagem=usuario-sem-permissao-para-editar-ingressos");
    exit;
} 

?>