<?php 

namespace Tickets;

use PDO;
use PDOException;

use Tickets\AbstracClass;
use Tickets\DB;

class User extends AbstracClass {
    private array $columns = [
      "id",
      "nome",
      "email",
      "senha",
      "criar",
      "editar",
      "deletar",
      "visualizar"  
    ];

    public function create() {}

    public function read() {}

    public function readAll() {}

    public function update() {}

    public function delete() {}
}

?>