<?php 

namespace Core;

use PDO;
use PDOException;

class DB {
    public static function connect(){
        try {
            $db_path = __DIR__ . '/../../db/db.sqlite';
            $pdo = new PDO("sqlite:" . $db_path);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erro ao conectar com banco de dados: " . $e->getMessage());
        }
    }
}

?>