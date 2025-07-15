<?php 

namespace Tickets;

use PDO;
use PDOException;

use Tickets\AbstracClass;

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

    public function find(array $filter) {}
}

?>