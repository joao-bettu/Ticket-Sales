<?php 

namespace Tickets;

use PDO;
use PDOException;

use Tickets\AbstractClass;

class Client extends AbstractClass {
    private array $columns = [
        "id",
        "nome",
        "email",
        "senha"
    ];
    
}

?>