<?php

class User {

    private $dbConnection;

    public $user_id;
    public $username;
    public $first_name;
    public $last_name;

    public function __construct($db) {
        $this->dbConnection = $db;
    }

    public function getAll(){
        include __DIR__ . '/../db/queries/user.php';
        $stmt = $this->dbConnection->query($GETALLUSERS_QUERY);
        return $stmt;
    }
}

?>