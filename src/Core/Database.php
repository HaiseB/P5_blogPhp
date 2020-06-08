<?php

namespace src\Core;

class Database{

    private $pdo;

    public function __construct(){
        $dns = 'mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=UTF8';

        try {
            $this->pdo = new \PDO($dns,$_ENV['DB_USER'], $_ENV['DB_PASS'], [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ
                ]
            );
        } catch (\PDOException $e) {
            echo 'Connexion failed : ' . $e->getMessage();
        }
    }

    public function fetchAll(string $query, array $submit=[]) :array {
        $statement = $this->pdo->prepare($query);
        $statement->execute($submit);

        return $statement->fetchAll();
    }

    public function fetch(string $query, array $submit=[]) :?object {
        $statement = $this->pdo->prepare($query);
        $statement->execute($submit);
        $result = $statement->fetch();

        $result = (is_bool($result)) ? null : $result ;

        return $result;
    }

    public function create(string $query, array $submit=[]) :void {
        $statement = $this->pdo->prepare($query);
        $statement->execute($submit);
    }

    public function update(string $query, array $submit=[]) :void {
        $statement = $this->pdo->prepare($query);
        $statement->execute($submit);
    }

    public function delete(string $query, array $submit=[]) :void {
        $statement = $this->pdo->prepare($query);
        $statement->execute($submit);
    }

    public function getLastId(string $table) {
        $query = "SELECT MAX(id) as maxId FROM " . $table;
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $lastID = $statement->fetch();

        return $lastID->maxId;
    }

}