<?php

require_once('../database/conn.php');

$description = filter_input(INPUT_POST, 'taskDescription');

if($description) {
    $sql = $pdo -> prepare("insert into tb_task (description) values (:description)");
    $sql -> bindValue(":description", $description);
    $sql -> execute();
}

header('Location: ../index.php');
exit;