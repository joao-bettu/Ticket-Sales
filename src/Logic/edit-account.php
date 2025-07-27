<?php 

session_start();

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../Core/database.php';

use Tickets\Client;

$client = new Client($db, "clientes");

$loged_client = $client->find([
    "id" => $_SESSION["id"]
]);

if (!$loged_client) {
    header("Location: /../../public/login.html?mensagem=cliente-nao-encontrado");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET["account"])) {
    echo "<h3>Editar Conta</h3>";
    echo "<form action=\"/src/Logic/edit-account.php\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id-edit\" value=\"" . $loged_client["id"] . "\">";
    echo "<label for=\"name\">Nome:</label>";
    echo "<input type=\"text\" id=\"name\" name=\"name\" value=\"" . htmlspecialchars($loged_client["nome"]) . "\" required>";
    echo "<br>";
    echo "<label for=\"email\">E-mail:</label>";
    echo "<input type=\"email\" id=\"email\" name=\"email\" value=\"" . htmlspecialchars($loged_client["email"]) . "\" required>";
    echo "<br>";
    echo "<label for=\"password\">Senha:</label>";
    echo "<input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Digite sua senha\">";
    echo "<br>";
    echo "<input type=\"submit\" value=\"Salvar Alterações\">";
    echo "<br>";
    echo "</form>";
    
    echo "<br>";

    echo "<h3>Alterar Senha</h3>";
    echo "<form action=\"/src/Logic/edit-account.php\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id-password\" value=\"" . $loged_client["id"] . "\">";
    echo "<label for=\"current_password\">Senha Atual:</label  >";
    echo "<input type=\"password\" id=\"current_password\" name=\"current_password\" required>";
    echo "<br>";
    echo "<label for=\"new_password\">Nova Senha:</label>";
    echo "<input type=\"password\" id=\"new_password\" name=\"new_password\" required>";
    echo "<br>";
    echo "<label for=\"confirm_password\">Confirmar Nova Senha:</label>";
    echo "<input type=\"password\" id=\"confirm_password\" name=\"confirm_password\" required>";
    echo "<br>";
    echo "<input type=\"submit\" value=\"Alterar Senha\">";
    echo "<br>";
    echo "</form>";

    echo "<br>";

    echo "<h3>Excluir Conta</h3>";
    echo "<form action=\"/src/Logic/edit-account.php\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"id-delete\" value=\"" . $loged_client["id"] . "\">";
    echo "<p>Tem certeza que deseja excluir sua conta? Esta ação não pode ser desfeita.</p>";
    echo "<label for=\"password\">Senha:</label>";
    echo "<input type=\"password\" id=\"password\" name=\"password\" placeholder=\"Digite sua senha\">";  
    echo "<br>";
    echo "<input type=\"submit\" value=\"Excluir Conta\">";
    echo "<br>";
    echo "</form>";

    echo "<br>";
    echo "<a href=\"/public/client.php\">Voltar para o menu principal</a>";
} else if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $error = [];
    if (isset($_POST["id-edit"])) {
        $new_name = filter_var(trim($_POST["name"]), FILTER_UNSAFE_RAW, FILTER_FLAG_STRIP_LOW | FILTER_FLAG_STRIP_HIGH);
        if (empty($new_name)) {
            $error[] = "O nome é obrigatório!";
        }
        $new_email = filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL);
        if (!$new_email) {
            $error[] = "Digite um e-mail válido!";
        }
        
        if (empty($error)) {
            if(password_verify($_POST["password"], $loged_client["senha"])){
                $client->update([
                    "id" => intval($_POST["id-edit"]),
                    "nome" => $new_name,
                    "email" => $new_email
                ]);
                header("Location: /src/Logic/logout.php");
                exit;
            } else {
                header("Location: /public/client.php?mensagem=senha-incorreta");
                exit;
            }
        } else {
            $mensagem = implode("-", $error);
            header("Location: /public/client.php?mensagem=" . urlencode($mensagem));
            exit;
        }
    } else if (isset($_POST["id-password"])) {
        if (empty($_POST["current_password"]) || empty($_POST["new_password"]) || empty($_POST["confirm_password"])) {
            $error[] = "Todos os campos de senha são obrigatórios!";
        }

        if ($_POST["new_password"] !== $_POST["confirm_password"]) {
            $error[] = "As novas senhas não coincidem!";
        }

        if(empty($error)) {
            if(password_verify($_POST["current_password"], $loged_client["senha"])){
                $new_password_hash = password_hash($_POST["new_password"], PASSWORD_BCRYPT);
                $client->update([
                    "id" => intval($_POST["id-password"]),
                    "senha" => $new_password_hash
                ]);
                header("Location: /src/Logic/logout.php");
                exit;
            } else {
                header("Location: /public/client.php?mensagem=senha-incorreta");
                exit;
            }
        } else {
            $mensagem = implode("-", $error);
            header("Location: /public/client.php?mensagem=" . urlencode($mensagem));
            exit;
        }
        
    } else if (isset($_POST["id-delete"])) {
        if (empty($_POST["password"])) {
            $error[] = "A senha é obrigatória para excluir a conta!";
        }
        if (empty($error)) {
            if(password_verify($_POST["password"], $loged_client["senha"])){
                $client->delete($_POST["id-delete"]);
                header("Location: /src/Logic/logout.php");
                exit;
            } else {
                header("Location: /public/client.php?mensagem=senha-incorreta");
                exit;
            }
        } else {
            $mensagem = implode("-", $error);
            header("Location: /public/client.php?mensagem=" . urlencode($mensagem));
            exit;
        }
    } else {
        header("Location: /public/client.php?mensagem=acao-nao-permitida");
        exit;
    }
} else {
    header("Location: /public/client.php");
    exit;
}

?>