<?php

$database = 'db_journalling';
$host = 'localhost';
$user = 'root';
$pass = 'senha';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $pass);

    $sql = 'SELECT * FROM tb_task';
    $stmt = $pdo->query($sql);

    if ($stmt === false) {
        die('Error executing query');
    }

    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
catch (PDOException $e) {
    echo "Erro: $e -> getMessage()";
}

return $pdo;