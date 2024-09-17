<?php

require_once('database/conn.php');

class TaskService {
    private $sql;
    private $pdo;
    
    function __construct() {
        $this->pdo = require 'database/conn.php';
    }

    public function getAllTasks() {
        $tasks = [];
        $query = 'select * from tb_task';
        
        $this -> sql = $this->pdo->query($query);
        if($this -> sql -> rowCount() > 0) {
            $tasks = $this -> sql -> fetchAll(PDO::FETCH_ASSOC);
        }
        return $tasks;
    }
}

return new TaskService();