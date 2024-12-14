<?php

require_once __DIR__ . '/../database/conn.php';

class DiarioService {
    private $sql;
    private $pdo;
    
    function __construct() {
        $this->pdo = require __DIR__ . '/../database/conn.php';
    }


    public function getAllDiarios() {
        $diarios = [];
        $query = 'select * from tb_note';
        try{
            $this -> sql = $this->pdo->query($query);
            if($this -> sql -> rowCount() > 0) {
                $diarios = $this -> sql -> fetchAll(PDO::FETCH_ASSOC);
            }
            return $diarios;
        } catch (PDOException $e) {
            throw new Exception("Error fetching diarios: " . $e->getMessage());
        }
    }


    public function searchDiarios($term) {
        $diarios = [];
        $query = "select * from tb_note where content like :term";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':term', '%' . $term . '%'); 

        try{
            $stmt->execute();
            $diarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $diarios;
        } catch (PDOException $e) {
            throw new Exception("Error fetching project: " . $e->getMessage());
        }
    }


    public function createDiario($diario) {
        error_log($diario['content'].$diario['title']);
        $query = '
            INSERT INTO tb_note (
                content, 
                title, 
                created_at
            ) 
            VALUES(
                :content, 
                :title, 
                :createdAt
            )';

        try {
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':content', $diario['content']);
            $sql->bindValue(':title', $diario['title']);
            $sql->bindValue(':createdAt', $diario['created_at']);
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error creating note: " . $e->getMessage());
        }
    }


    public function updateDiario($diario) {
        $query = '
            UPDATE tb_note 
            SET content = :content, 
                title = :title 
            WHERE id = :id';
    
        try {
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':content', $diario['content']);
            $sql->bindValue(':title', $diario['title']);
            $sql->bindValue(':id', $diario['id']);

            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error creating note: " . $e->getMessage());
        }
    }
    

    public function deleteDiario($diarioId) {
        try{
            $query = 'delete from tb_note where id = :id';
            $sql = $this->pdo->prepare($query);
            $sql->bindValue(':id', $diarioId);
            return $sql->execute();
        } catch (PDOException $e) {
            throw new Exception("Error deleting diario: " . $e->getMessage());
        }
    }
}

return new DiarioService();