<?php 

namespace Tickets;

use PDO;
use PDOException;

use Tickets\AbstracClass;
use Tickets\DB;

class Client extends AbstracClass {
    private array $columns = [
        "id",
        "nome",
        "email",
        "senha"
    ];
    
    public function create() {}

    public function read() {}

    public function readAll() {}

    public function update() {}

    public function delete() {}
}

?>