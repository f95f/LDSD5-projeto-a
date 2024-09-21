<?php
    require_once('controllers/task-controller.php');
    $controller = new TaskController();
    $tasks = $controller->getTasks();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $taskDescription = isset($_POST['taskDescription']) ? $_POST['taskDescription'] : '';
        $controller->createTask($taskDescription);
        $tasks = $controller->getTasks();
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
    <div class="wrapper">
        <form action="" method="POST" id="addTaskForm" name="addTaskForm">
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
            <?php foreach($tasks as $task): ?>
                <div class="task">
                    <input
                        type="checkbox"
                        name="progress"
                        class="progress <?= $task['completed'] ? 'done' : '' ?>"
                        data-task-id="<?= $task['id']?>"
                        <?= $task['completed'] ? 'checked' : '' ?>
                    >
                    <p class="task-description">
                        <?= $task['description'] ?>
                    </p>
                    <div class="task-actions">
                        <a class="action-button edit-button">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <a href="../controllers/delete.php?id=<?= $task['id']?>" class="action-button delete-button">
                            <i class="fa-regular fa-trash-can"></i>
                        </a>
                    </div>
                    <form action="../controllers/update.php" method="POST" class="to-do-form edit-task hidden">
                        <input type="text" class="hidden" name="id" value="<?= $task['id']?>">
                        <input
                            class="inline-input"
                            type="text"
                            name="description"
                            placeholder="Edit your task here"
                            value="<?= $task['description']?>"
                        >
                        <button type="submit" class="pill-button confirm-button">
                            <i class="fa-solid fa-check"></i>
                        </button>
                    </form>
                </div>
            <?php endforeach ?>
        </ul>
    </div>
                
    <script src="../scripts/script.js"></script>
</body>
</html> 