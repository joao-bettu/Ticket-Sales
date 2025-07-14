<?php 

namespace Tickets;

use PDO;

abstract class AbstracClass {
    protected PDO $pdo;
    protected string $table;
    
    public function __construct(PDO $pdo, string $table) {
        $this->pdo =  $pdo;
        $this->table = $table;
    }

    abstract public function create();
    abstract public function read();
    abstract public function readAll();
    abstract public function update();
    abstract public function delete();
    
}

?>