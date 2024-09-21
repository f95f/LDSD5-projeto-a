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
        try{
            $this -> sql = $this->pdo->query($query);
            if($this -> sql -> rowCount() > 0) {
                $tasks = $this -> sql -> fetchAll(PDO::FETCH_ASSOC);
            }
            return $tasks;
        } catch (PDOException $e) {
            throw new Exception("Error fetching tasks: " . $e->getMessage());
        }
    }

    public function createTask($taskDescription) {
        $query = 'INSERT INTO tb_task (description) VALUES (:description)';
        try {
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':description', $taskDescription);
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error creating task: " . $e->getMessage());
        }
    }

    public function updateTask($taskId, $taskDescription) {
        $query = 'update tb_task set description = :description where id = :id';
        try{
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':description', $taskDescription);
            $sql->bindValue(':id', $taskId);
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating task: " . $e->getMessage());
        }
    }

    public function deleteTask($taskId) {
        try{
            $query = 'delete from tb_task where id = :id';
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':id', $taskId);
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting task: " . $e->getMessage());
        }
    }

}

return new TaskService();