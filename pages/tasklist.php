<?php

    require_once('database/conn.php');

    $tasks = [];
    $sql = $pdo->query('select * from tb_task');

    if($sql -> rowCount() > 0) {
        $tasks = $sql -> fetchAll(PDO::FETCH_ASSOC);
    }
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/global.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Tarefas | Journalling </title>
    <style src></style>
</head>
<body>
    <h1>Gerenciamento de Tarefas</h1>
    <form action="../controllers/create.php" method="POST" id="addTaskForm">
        <div class="input-row">
            <input 
                type="text"
                id="taskDescription"
                name="taskDescription"
                class="inline-input"
                placeholder="O que deseja fazer?"
            >
            <button
                type="submit"
                id="submitTask"
                class="pill-button"
            >
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
    </form>
    <ul>
        <?php foreach($tasks as $item): ?>
            <li class="task-item">
                <i class="fa-solid fa-circle-info"></i>
                <input 
                    type="checkbox"
                    id="taskProgress"
                    class=""
                    <?= $item['completed']? 'checked' : ''?>
                    >
                <span>
                    <?= $item['description'] ?>
                </span>
                <div class="task-actions-wrapper">
                    <button
                        type="submit"
                        id="submitTask"
                        class="pill-button"
                    >
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                    <button
                        type="submit"
                        id="submitTask"
                        class="pill-button"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>
            </li>
        <?php endforeach ?>
    </ul>
    
    <script src="../scripts/script.js"></script>
</body>
</html>