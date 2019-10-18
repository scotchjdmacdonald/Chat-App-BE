<?php

class Database  {

    private $connection;

    public function connect() {
        try {
            $this->connection = new PDO('sqlite:chatDB.sqlite');
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);      
            return $this->connection;
        } catch(PDOException $e) {
            echo 'DB connection exception thrown: ' . $e;
        }
    }
    public function createTables($db)
    {
        include 'queries/common.php';

        try {
            $db->exec($CREATE_QUERY);
        } catch(PDOException $e) {
            echo 'Exception thrown creating tables' . $e;
        }
    }
}
?>