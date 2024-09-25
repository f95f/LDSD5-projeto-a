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

    public function getTaskById($taskId) {
        $query = 'SELECT * FROM tb_task WHERE id = :id';
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id', $taskId, PDO::PARAM_INT);
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
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
        $query = 'update tb_task set task_description = :description where id = :id';
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

    public function changeTaskStatus($taskId) {
        $task = $this -> getTaskById($taskId);
            
        error_log(json_encode($tasks)); // Log the fetched tasks
        try {
            $query = 'update tb_task set task_completed = :status where id = :id';
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':status', $task->completed);
            $sql->bindValue(':id', $taskId);
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting task: " . $e->getMessage());
        }
    }

}

return new TaskService();