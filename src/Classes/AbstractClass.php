<?php 

namespace Tickets;

use PDO;
use PDOException;

abstract class AbstractClass {
    protected PDO $pdo;
    protected string $table;
    
    /**
     * Função construct:
     * Cada instância das classes filhas vai informar o PDO recebido da função Tickets\DB e o nome da tabela a qual se refere
     */
    public function __construct(PDO $pdo, string $table) {
        $this->pdo =  $pdo;
        $this->table = $table;
    }

    /**
     * Função create:
     * Insere registro na tabela usando um array associativo recebido como parâmetro
     * O array deve conter as informações (obrigatórias) para inserir na tabela
     */
    public function create(array $data) {
        try {
        $columns = implode(", ", array_keys($data));
        $values = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($data);
      } catch (PDOException $e) {
        echo "Erro ao criar registro na tebela: {$this->table}. Erro: " . $e->getMessage() . PHP_EOL;
      }
    }
    
    /**
     * Função read:
     * Lê todos os registros de uma tabela
     */
    public function read() {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erro ao ler todos os registros na tebela: {$this->table}. Erro: " . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * Função update:
     * Edita algum registro de uma tabela
     * Precisa do ID do registro para realizar a edição
     */
    public function update(array $data) {
        try {
            if (!isset($data['id'])) {
                throw new \Exception("ID não informado para edição.");
            }

            $id = $data['id'];
            unset($data['id']);

            $set = implode(', ', array_map(fn($column) => "$column = :$column", array_keys($data)));
            $sql = "UPDATE {$this->table} SET $set WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
        
            $data['id'] = $id;
            return $stmt->execute($data);
        } catch (PDOException $e) {
            echo "Erro editando registro da tabela: {$this->table}. Erro: " . $e->getMessage() . PHP_EOL;
        } catch (\Exception $e) {
            echo "Erro: " . $e->getMessage() . PHP_EOL;
        }
    }
    
    /**
     * Função delete:
     * Exclúi um registro de uma tabela
     */
    public function delete(int $id) {
        try {
            $sql = "DELETE FROM {$this->table} WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Erro deletando registro da tabela: {$this->table}. Erro: " . $e->getMessage() . PHP_EOL;
        }
    }

    /**
     * Função find:
     * Busca na tabela todos os itens correspondente ao filtro recebido
     */
    public function find(array $filter) {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $wheres = [];
            $parameters = [];
            if (!empty($filter)) {
                foreach ($filter as $column => $value) {
                    $wheres[] = "$column = :$column";
                    $parameters[":$column"] = $value;
                }
                $sql .= " WHERE " . implode(" AND ", $wheres) . " LIMIT 1";
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            
            return $result === false ? null : $result;
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar registro: " . $e->getMessage());
            return null;
        }
    }

    public function findAllBy(array $filter) {
        try {
            $sql = "SELECT * FROM {$this->table}";
            $wheres = [];
            $parameters = [];
            if (!empty($filter)) {
                foreach ($filter as $column => $value) {
                    $wheres[] = "$column = :$column";
                    $parameters[":$column"] = $value;
                }
                $sql .= " WHERE " . implode(" AND ", $wheres);
            }

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($parameters);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            error_log("Erro ao buscar registros: " . $e->getMessage());
            return [];
        }
    }

}

?>