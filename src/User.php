<?php 

namespace Tickets;

use PDO;
use PDOException;

use Tickets\AbstractClass;

class User extends AbstractClass {
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