<?php

require_once __DIR__ . '/../database/conn.php';

class TaskService {
    private $sql;
    private $pdo;
    
    function __construct() {
        $this->pdo = require __DIR__ . '/../database/conn.php';
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

    public function createTask($task) {
        $query = '
            INSERT INTO tb_task
                (task_description, task_priority, task_completed, project_id, created_at, deadline) 
            VALUES 
                (:description, :priority, :completed, :project, :createdAt, :deadline)';

        try {
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':description', $task -> getTaskDescription());
            $sql->bindValue(':priority', $task -> getTaskPriority());
            $sql->bindValue(':completed', 0);
            $sql->bindValue(':project', $task -> getProjectId());
            $sql->bindValue(':createdAt', $task -> getCreatedAt());
            $sql->bindValue(':deadline', $task -> getDeadline());
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

    public function changeTaskStatus($projectId) {
        try {
            $query = 'select * from tb_task where project_id = :id';
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':id', $projectId);
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error fetching tasks: " . $e->getMessage());
        }
    }

    public function getTasksFromProject($projectId) {

    }
}

return new TaskService();