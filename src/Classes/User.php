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
      "editar",
      "deletar"
    ];
    
}

?>