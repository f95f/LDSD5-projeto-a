<?php

require_once __DIR__ . '/../database/conn.php';

class UsuarioService {
    private $sql;
    private $pdo;
    
    function __construct() {
        $this->pdo = require __DIR__ . '/../database/conn.php';
    }
    
    public function login($email, $senha) {

        $query = 'select * from tb_user where email = :email and senha = :senha';
        $sql = $this->pdo->prepare($query);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':senha', $senha);

        try{
            $sql->execute();
            return $sql -> fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error logging in: " . $e->getMessage());
        }
    }
}

return new UsuarioService();