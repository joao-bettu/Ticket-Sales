<?php 

namespace Core;

use PDO;
use PDOException;

class DB {
    public static function connect(){
        try {
            $pdo = new PDO("sqlite:db.sqlite");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo "Erro ao conectar com banco de dados: " . $e->getMessage() . PHP_EOL;
        }
    }
}

?>