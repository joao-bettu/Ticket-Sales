<?php 

namespace Tickets;

use DateInterval;
use DateTime;
use PDO;
use PDOException;

use Tickets\AbstractClass;

class Ticket extends AbstractClass {
    private array $columns = [
        "id",
        "evento",
        "descricao",
        "valor",
        "data_evento",
        "quantidade",
        "reservado",
        "data_ultima_reserva",
        "cliente_reservado",
        "vendedor"
    ];

}

?>