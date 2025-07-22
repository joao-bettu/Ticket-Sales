<?php 

namespace Tickets;

use PDO;
use PDOException;

class CreateTables{
    private PDO $pdo;

    public function __construct(PDO $db) {
        try {
            $this->pdo = $db;
            $this->criarTabelaIngressos();
            $this->criarTabelaUsuarios();
            $this->criarTabelaCliente();
        } catch (PDOException $e) {
            echo "Erro criando tabelas: " . $e->getMessage() . PHP_EOL;
        }
    }

    private function criarTabelaUsuarios() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            senha TEXT NOT NULL.
            editar BOOLEAN,
            deletar BOOLEAN
        )");
    }

    /*
     * Tabela de usuario deve ter:
     * ID
     * nome
     * email
     * senha
     * permissões (deletar, editar)
     * 
     */

    private function criarTabelaCliente() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS clientes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nome TEXT NOT NULL,
            email TEXT UNIQUE NOT NULL,
            senha TEXT NOT NULL,
        )");
    }

    /*
     * Tabela de cliente deve ter:
     * ID
     * nome
     * email
     * senha
     * 
     */

    private function criarTabelaIngressos() {
        $this->pdo->exec("CREATE TABLE IF NOT EXISTS ingressos (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            evento TEXT NOT NULL,
            descricao TEXT,
            valor REAL NOT NULL,
            data_evento DATE NOT NULL,
            quantidade INTEGER,
            reservado BOOLEAN,
            data_ultima_reserva DATE,
            vendedor INTEGER,
            FOREIGN KEY (vendedor) REFERENCES usuarios(id)
        )");
    }

    /*
     * Tabela de ingresso deve ter:
     * ID
     * nome do evento
     * descrição do evento
     * data do evento
     * quantidade disponível
     * reservado
     * data e hora da última reserva
     * usuario que criou este ingresso (para visualização dos usuários)
     * 
     */    
}

?>