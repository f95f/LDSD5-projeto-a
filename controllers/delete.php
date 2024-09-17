<?php

require_once('../database/conn.php');

$id = filter_input(INPUT_GET, 'id');

if($id) {
    $sql = $pdo -> prepare('delete from tb_task where id = :id');
    $sql -> bindValue(':id', $id);
    $sql -> execute();
}

header('Location: ../index.php');
exit;