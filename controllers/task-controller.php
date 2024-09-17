<?php

require_once('database/conn.php');

class TaskController{
    private $sql;
    
    private $pdo; // Add a property to hold the PDO instance
    
    function __construct() {
        $this->pdo = require 'database/conn.php'; // Initialize the PDO instance
    }

    public function getTasks() {
        $tasks = [];
        $query = 'select * from tb_task';

        $this -> sql = $this->pdo->query($query);
        if($this -> sql -> rowCount() > 0) {
            $tasks = $this -> sql -> fetchAll(PDO::FETCH_ASSOC);
        }
        return $tasks;
    }


}