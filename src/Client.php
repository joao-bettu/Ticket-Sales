<?php 

namespace Tickets;

use PDO;
use PDOException;

use Tickets\AbstracClass;

class Client extends AbstracClass {
    private array $columns = [
        "id",
        "nome",
        "email",
        "senha"
    ];
    
    public function find(array $filter) {}
}

?>