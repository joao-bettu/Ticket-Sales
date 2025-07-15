<?php 

namespace Tickets;

use PDO;
use PDOException;

use Tickets\AbstracClass;
use Tickets\DB;

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

    public function create() {}

    public function read() {}

    public function readAll() {}

    public function update() {}

    public function delete() {}
}

?>