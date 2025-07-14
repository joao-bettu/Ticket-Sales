<?php 

namespace Tickets;

use PDO;

class CreateTables{
    private $pdo;

    public function __construct(PDO $db) {
        $this->pdo = $db;
        $this->criarTabelaIngressos();
        echo "Tabela de Ingressos criada!\n";
        $this->criarTabelaUsuarios();
        echo "Tabela de Usuários criada!\n";
        $this->criarTabelaCliente();
        echo "Tabela de Clientes criada!\n";
    }

    private function criarTabelaIngressos() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS ingresso ()");
    }

    /*
     * Tabela de ingresso deve ter:
     * ID
     * nome do evento
     * descrição
     * data do evento
     * quantidade disponível
     * reservado
     * data e hora da última reserva
     * usuario que criou este ingresso (para visualização dos usuários)
     * 
    */

    private function criarTabelaUsuarios() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS usuario ()");
    }

    /*
     * Tabela de usuario deve ter:
     * ID
     * nome
     * email
     * senha
     * permissões (deletar, editar, criar ou ver)
     * 
    */

    private function criarTabelaCliente() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS cliente ()");
    }

    /*
     * Tabela de cliente deve ter:
     * ID
     * nome
     * email
     * senha
     * ingressos comprados
    */
}

?>