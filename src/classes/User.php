<?php
class User{
    
    private $dbCon;

    public function __construct($db){
        $this->dbCon = $db;
    }

    public function getUserById(string $id){
        return $this->dbCon->getUserById($id);
    }
}