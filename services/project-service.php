<?php

require_once __DIR__ . '/../database/conn.php';

class ProjectService {
    private $sql;
    private $pdo;
    
    function __construct() {
        $this->pdo = require __DIR__ . '/../database/conn.php';
    }

    public function getAllProjects() {
        $project = [];
        $query = 'select * from tb_project';
        try{
            $this -> sql = $this->pdo->query($query);
            if($this -> sql -> rowCount() > 0) {
                $project = $this -> sql -> fetchAll(PDO::FETCH_ASSOC);
            }
            return $project;
        } catch (PDOException $e) {
            throw new Exception("Error fetching project: " . $e->getMessage());
        }
    }


    public function getProjectNames() {
        $project = [];
        $query = 'select id, project_name from tb_project';
        try{
            $this -> sql = $this->pdo->query($query);
            if($this -> sql -> rowCount() > 0) {
                $project = $this -> sql -> fetchAll(PDO::FETCH_ASSOC);
            }
            return $project;
        } catch (PDOException $e) {
            throw new Exception("Error fetching project: " . $e->getMessage());
        }
    }


    // try{
    //     $query = 'SELECT * FROM tb_user WHERE email = "' . $email . '" AND senha = "' . $senha . '"';
    //     error_log($query);
    //     $sql = $this->pdo->query($query);
    //     $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    //     //print_r($result);
    //     return $result;
    // } catch (PDOException $e) {
    //     return ['success' => false, 'message' => $e->getMessage()];
    // }




    public function searchProjects($term) {
        $projects = [];
        $query = "select * from tb_project where project_name like '%". $term ."%'";
        $stmt = $this->pdo->prepare($query);
        // $stmt->bindValue(':term', '%' . $term . '%'); 

        try{
            $stmt->execute();
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $projects;
        } catch (PDOException $e) {
            throw new Exception("Error fetching project: " . $e->getMessage());
        }
    }




    // public function searchProjects($term) {
    //     $projects = [];
    //     $query = "select * from tb_project where project_name like :term";
    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindValue(':term', '%' . $term . '%'); 

    //     try{
    //         $stmt->execute();
    //         $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
    //         return $projects;
    //     } catch (PDOException $e) {
    //         throw new Exception("Error fetching project: " . $e->getMessage());
    //     }
    // }


    public function getProjectById($projectId) {
        $query = 'SELECT * FROM tb_project WHERE id = :id';
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':id', $projectId, PDO::PARAM_INT);
            $stmt->execute();
            $project = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $project;
        } catch (PDOException $e) {
            throw new Exception("Error fetching project: " . $e->getMessage());
        }
    }

    
    public function createProject($project) {
        $query = '
            INSERT INTO tb_project (
                project_name, 
                project_priority, 
                project_status, 
                project_description, 
                start_date, 
                created_at, 
                deadline
            ) 
            VALUES(
                :name, 
                :priority, 
                :status,
                :description,
                :startDate,
                :createdAt, 
                :deadline
            )';

        try {
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':name', $project -> getProjectName());
            $sql->bindValue(':priority', $project -> getProjectPriority());
            $sql->bindValue(':status', 1);
            $sql->bindValue(':description', $project -> getDescription());
            $sql->bindValue(':startDate', $project -> getStartDate());
            $sql->bindValue(':createdAt', $project -> getCreatedAt());
            $sql->bindValue(':deadline', $project -> getDeadline());
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error creating project: " . $e->getMessage());
        }
    }

    public function updateProject($projectId, $project) {
        $query = 'update tb_project set 
                    project_name = :name,
                    project_priority = :priority,
                    project_status = :status,
                    project_description = :description,
                    start_date = :startDate,
                    deadline = :endDate
                  where id = :id';
        try{
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':id', $projectId);
            $sql->bindValue(':name', $project->getProjectName());
            $sql->bindValue(':priority', $project->getProjectPriority());
            $sql->bindValue(':status', $project->getProjectStatus());
            $sql->bindValue(':description', $project->getDescription());
            $sql->bindValue(':startDate', $project->getStartDate());
            $sql->bindValue(':endDate', $project->getDeadline());
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating project: " . $e->getMessage());
        }
    }
    

    public function deleteProject($projectId) {
        try{
            $query = 'delete from tb_project where id = :id';
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':id', $projectId);
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting project: " . $e->getMessage());
        }
    }

    public function changeProjectStatus($projectId, $status) {
        $project = $this -> getProjectById($projectId);
            
        error_log(json_encode($project));
        try {
            $query = 'update tb_project set status = :status where id = :id';
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':status', $status);
            $sql->bindValue(':id', $projectId);
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error updating project: " . $e->getMessage());
        }
    }

}

return new ProjectService();