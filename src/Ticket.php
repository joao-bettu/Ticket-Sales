<?php 

namespace Tickets;

use PDO;
use PDOException;

use Tickets\AbstracClass;

class Ticket extends AbstracClass {
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

    public function find(array $filter) {}
}

?>