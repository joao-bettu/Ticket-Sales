<?php 

session_start();
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\User;

$user = new User($db, "usuarios");

$loged_user = $user->find([
    "id" => intval($_SESSION["id"])
]);

if (!$loged_user) {
    header("Location: /../../public/login.html?mensagem=usuario-nao-encontrado");
    exit;
}

echo "<h3>Editar Permissões</h3>";
echo "<form class=\"permission-form\" action=\"/src/Logic/edit-permission.php\" method=\"post\">
        <label for=\"editar\">Permissão de Edição:</label>
        <input type=\"checkbox\" id=\"editar\" name=\"editar\" " . ($loged_user["editar"] ? "checked" : "") . ">
        <label for=\"delet  ar\">Permissão de Exclusão:</label>
        <input type=\"checkbox\" id=\"deletar\" name=\"deletar\"    " . ($loged_user["deletar"] ? "checked" : "") . ">
        <input type=\"submit\" value=\"Salvar Permissões\">
    </form>";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $editar = filter_var($_POST["editar"] ?? false, FILTER_VALIDATE_BOOL);
    $deletar = filter_var($_POST["deletar"] ?? false, FILTER_VALIDATE_BOOL);

    $user->update([
        "id" => intval($_SESSION["id"]),
        "editar" => $editar,
        "deletar" => $deletar
    ]);

    header("Location: /../../public/user.php?mensagem=permissoes-atualizadas-com-sucesso");
    exit;
}        
?>