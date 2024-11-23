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

    public function updateTask($taskId, $taskData) {
        $query = '
            update tb_task set 
                task_description = :description,
                task_completed = :completed,
                task_priority = :priority,
                project_id = :project,
                deadline = :deadline,
                created_at = :createdAt 
            where id = :id';
        try{
            $sql = $this->pdo->prepare($query);            
            $sql->bindValue(':description', $taskData -> getTaskDescription());
            $sql->bindValue(':priority', $taskData -> getTaskPriority());
            $sql->bindValue(':completed', $taskData -> isTaskCompleted());
            $sql->bindValue(':project', $taskData -> getProjectId());
            $sql->bindValue(':createdAt', $taskData -> getCreatedAt());
            $sql->bindValue(':deadline', $taskData -> getDeadline());
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
            // print_r($sql->execute());
            return $sql->execute();
        } catch (PDOException $e) {
            print_r($e->getMessage());
            throw new Exception("Error deleting task: " . $e->getMessage());
        }
    }

    public function changeTaskStatus($taskId, $status) {
        
        try {
            $query = 'update tb_task set task_completed = :status where id = :id';
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':status', $status);
            $sql->bindValue(':id', $taskId);
            $sql->execute();

            $task = $this -> getTaskById($taskId);

            return $task[0]['task_completed'];
        } catch (PDOException $e) {
            throw new Exception("Error deleting task: " . $e->getMessage());
        }
    }

    public function getTasksFromProject($projectId) {
        $tasks = [];
        $query = 'SELECT * FROM tb_task WHERE project_id = :id';
        try {
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':id', $projectId, PDO::PARAM_INT);
            $sql->execute();
    
            if ($sql->rowCount() > 0) {
                $tasks = $sql->fetchAll(PDO::FETCH_ASSOC);
            }
            return $tasks;
        } catch (PDOException $e) {
            throw new Exception("Error fetching tasks: " . $e->getMessage());
        }
    }

    public function filterTasksByStatus($status) {
        $tasks = [];
        $query = "select * from tb_task where task_priority = :status";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':status', $status); 

        try{
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $tasks;
        } catch (PDOException $e) {
            throw new Exception("Error fetching tasks: " . $e->getMessage());
        }
    }
}

return new TaskService();

// --- Novo código para edição e exclusão pelo calendário --- 

// Função para deletar uma tarefa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    
    if ($action == 'delete' && isset($_POST['task_id'])) {
        $task_id = intval($_POST['task_id']);
        $stmt = $conn->prepare("DELETE FROM tasks WHERE id = ?");
        $stmt->bind_param("i", $task_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Tarefa deletada com sucesso."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao deletar tarefa."]);
        }
        $stmt->close();
        exit;
    }

    // Função para atualizar uma tarefa
    if ($action == 'update' && isset($_POST['task_id'], $_POST['title'], $_POST['start_date'], $_POST['end_date'])) {
        $task_id = intval($_POST['task_id']);
        $title = $_POST['title'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $stmt = $conn->prepare("UPDATE tasks SET title = ?, start_date = ?, end_date = ? WHERE id = ?");
        $stmt->bind_param("sssi", $title, $start_date, $end_date, $task_id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Tarefa atualizada com sucesso."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Erro ao atualizar tarefa."]);
        }
        $stmt->close();
        exit;
    }
}
