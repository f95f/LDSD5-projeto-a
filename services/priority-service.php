<?php

require_once('database/conn.php');

class PriorityService {
    private $sql;
    private $pdo;
    
    function __construct() {
        $this->pdo = require 'database/conn.php';
    }

    public function getAllPriorities() {
        $tasks = [];
        $query = 'select * from tb_priorities';
        try{
            $this -> sql = $this->pdo->query($query);
            if($this -> sql -> rowCount() > 0) {
                $tasks = $this -> sql -> fetchAll(PDO::FETCH_ASSOC);
            }
            return $tasks;
        } catch (PDOException $e) {
            throw new Exception("Error fetching priorities: " . $e->getMessage());
        }
    }
}