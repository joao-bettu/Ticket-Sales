<?php 

namespace Tickets;

use PDO;
use PDOException;
use Tickets\DB;

class Ticket {
    private array $columns = [
        "id",
        "evento",
        "descricao",
        "valor",
        "data_evento",
        "quantidade",
        "reservado",
        "data_ultima_reserva",
        "vendedor"
    ];

    private PDO $pdo;
    private string $table = "ingressos";

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;        
    }

    public function create() {}

    public function read() {}

    public function readAll() {}

    public function update() {}

    public function delete() {}
}

?>