<?php

require_once __DIR__ . '/../database/conn.php';

class CalendarioService {
    private $sql;
    private $pdo;
    
    function __construct() {
        $this->pdo = require __DIR__ . '/../database/conn.php';
    }

    public function getAllProjects($startDate, $endDate) {
        $projects = [];
        $query = "select * from tb_project where deadline between :start and :end";
        
        try{

            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':start', $startDate);
            $stmt->bindValue(':end', $endDate);
            $stmt->execute();
            $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $projects;
        } catch (PDOException $e) {
            throw new Exception("Error fetching priorities: " . $e->getMessage());
        }
    }


    public function getAllTasks($startDate, $endDate) {
        $tasks = [];
        $query = "select * from tb_task where deadline between :start and :end";
        
        try{

            $stmt = $this->pdo->prepare($query);
            $stmt->bindValue(':start', $startDate);
            $stmt->bindValue(':end', $endDate);
            
            $stmt->execute();
            $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $tasks;
        } catch (PDOException $e) {
            throw new Exception("Error fetching priorities: " . $e->getMessage());
        }
    }
}