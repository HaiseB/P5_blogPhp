<?php

class Database{

    public function __construct(){
        $dns = 'mysql:dbname=' . $_ENV['DB_NAME'] . ';host=' . $_ENV['DB_HOST'] . ';charset=UTF8';

        try {
            $this->pdo = new PDO($dns,$_ENV['DB_USER'], $_ENV['DB_PASS'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
                ]
            );
        } catch (PDOException $e) {
            echo 'Connexion failed : ' . $e->getMessage();
        }
    }

    public function fetchAll(string $query) :array {
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function fetch(string $query) :?object {
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $result = $statement->fetch();

        $result = (is_bool($result)) ? null : $result ;

        return $result;
    }

    public function create(string $query) :void {
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    public function update(string $query) :void {
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    public function delete(string $query ) :void {
        $statement = $this->pdo->prepare($query);
        $statement->execute();
    }

    public function getLastId(string $table ) {
        $query = "SELECT MAX(id) as maxId FROM " . $table;
        $statement = $this->pdo->prepare($query);
        $statement->execute();
        $lastID = $statement->fetch();

        return $lastID->maxId;
    }

}