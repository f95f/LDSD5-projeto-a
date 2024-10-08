<?php
    require_once __DIR__ . '/../controllers/task-controller.php';

    $controller = new TaskController();
    $tasks = $controller->getTasks();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $taskDescription = isset($_POST['taskDescription']) ? $_POST['taskDescription'] : '';
        $controller->createTask($taskDescription);

        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); 
    }

    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $_PUT);
        if (isset($_PUT['completed'])) {
            $taskId = isset($_PUT['id']) ? $_PUT['id'] : '';
            $completed = isset($_PUT['completed']) ? $_PUT['completed'] : '';
            $controller->changeTaskStatus($taskId, $completed);
            
            // Return a JSON response
            echo json_encode(['success' => true]);
            exit(); 
        } else {
            $taskId = isset($_PUT['id']) ? $_PUT['id'] : '';
            $taskDescription = isset($_PUT['description']) ? $_PUT['description'] : '';
            $controller->updateTask($taskId, $taskDescription);
        
            // Return a JSON response
            echo json_encode(['success' => true]);
            exit(); 
        }
    }
    
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        parse_str(file_get_contents("php://input"), $_DELETE);
        $taskId = isset($_DELETE['id']) ? $_DELETE['id'] : '';
        $controller->deleteTask($taskId);
    
        // Return a JSON response
        echo json_encode(['success' => true]);
        exit(); 
    }

    define("TITLE", "Tasks | Journalling");
    define("PAGE", "TASKS");
    define("STYLESHEET", "tasklist");
    include __DIR__ . '/../layout/side-menu.php'; 
    include __DIR__ . '/../layout/header.php';
?>
<header>
    <div class="title">
        <i class="fa-solid fa-list-check"></i>
        <h1>Gerenciamento de Tarefas</h1>
    </div>
</header>
<main>
    <div class="wrapper">
        <form method="POST" id="addTaskForm" name="addTaskForm">
            <div class="add-task-row">
                <input
                    type="text"
                    id="taskDescription"
                    name="taskDescription"
                    class="inline-input add-task-input"
                    placeholder="O que deseja fazer?"
                >
                <button
                    type="submit"
                    id="submitTask"
                    class="pill-button add-task-button"
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
                    <span class="light-text">|</span>
                    <p class="task-description">
                        <?= $task['description'] ?>
                    </p>
                    <div class="task-actions">
                        <a class="action-button edit-button">
                            <i class="fa-regular fa-pen-to-square"></i>
                        </a>
                        <a role="button" class="action-button delete-button">
                            <i class="fa-regular fa-trash-can"></i>
                        </a>
                    </div>
                    <form method="PUT" class="to-do-form edit-task hidden">
                        <input type="text" class="hidden" name="id" value="<?= $task['id']?>">
                        <input
                            class="inline-input edit-input"
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
</main>
            
<footer>
    <script src="../scripts/task.js"></script>
</footer>
