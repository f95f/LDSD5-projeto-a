<?php

require_once('../database/conn.php');

$id = filter_input(INPUT_POST, 'id');
$description = filter_input(INPUT_POST, 'description');

if($description) {
    $sql = $pdo -> prepare("update tb_task set description = :description where id = :id");
    $sql -> bindValue(":description", $description);
    $sql -> bindValue(":id", $id);
    $sql -> execute();
}

header('Location: ../index.php');
exit;