<?php
    require_once __DIR__ . '/../controllers/task-controller.php';
    require_once __DIR__ . '/../controllers/priority-controller.php';

    $controller = new TaskController();
    $priorityController = new PriorityController();

    $tasks = $controller->getTasks();
    $priorities = $priorityController->getAllPriorities();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? $_POST['action'] : '';


        switch ($action) {

            case 'DELETE_TASK':
                $taskId = $_POST['taskId'];
                $controller->deleteTask($taskId);
                echo json_encode(['success' => true, 'message' => 'Task deleted']);
                break;

            case 'ADD_TASK':
                $request = $_POST;
                $controller->createTask($request);
                echo json_encode(['success' => true, 'message' => 'Task added']);
                break;

            case 'UPDATE':
                $taskId = $_POST['id'];
                $newDescription = $_POST['description'];
                $newDeadline = $_POST['deadline'];
                
                $controller->updateTask($taskId, $newDescription, $newDeadline);
                echo json_encode(['success' => true, 'message' => 'Task updated']);
                break;
                
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }


        exit();

    }

    // if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    //     parse_str(file_get_contents("php://input"), $_PUT);
    //     if (isset($_PUT['completed'])) {
    //         $taskId = isset($_PUT['id']) ? $_PUT['id'] : '';
    //         $completed = isset($_PUT['completed']) ? $_PUT['completed'] : '';
    //         $controller->changeTaskStatus($taskId, $completed);
            
    //         // Return a JSON response
    //         echo json_encode(['success' => true]);
    //         exit(); 
    //     } else {
    //         $taskId = isset($_PUT['id']) ? $_PUT['id'] : '';
    //         $taskDescription = isset($_PUT['description']) ? $_PUT['description'] : '';
    //         $controller->updateTask($taskId, $taskDescription);
        
    //         // Return a JSON response
    //         echo json_encode(['success' => true]);
    //         exit(); 
    //     }
    // }
    
    // if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //     parse_str(file_get_contents("php://input"), $_DELETE);
    //     $taskId = isset($_DELETE['id']) ? $_DELETE['id'] : '';
    //     $controller->deleteTask($taskId);
    
    //     // Return a JSON response
    //     echo json_encode(['success' => true]);
    //     exit(); 
    // }    
    
    function getStatusColor($value) {

        switch($value) {
            case 'BACKLOG':
                $class = 'neutral';
                break;
            case 'CONCLUIDO':
                case 'BAIXA':
                $class = 'success';
                break;
            case 'PARADO':
            case 'ATRASADO':
            case 'ALTA':
                $class = 'warning';
                break;
            case 'CANCELADO':
            case 'CRITICA':
                $class = 'danger';
                break;
            default:
                $class = '';
        }
        
        return $class;
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
        
        <form method="POST" 
            id="addTaskForm" 
            name="addTaskForm" 
            class="form-row">

            <div class="input-row">
                <label for="projectName">Descrição da task:</label>
                <input
                    type="text"
                    id="taskDescription"
                    name="taskDescription"
                    class="inline-input"
                    placeholder="O que você quer fazer?"
                >
            </div>
            <div class="input-row small">
                <label for="deadline">Deadline</label>
                <input
                    type="date"
                    id="deadline"
                    name="deadline"
                    class="inline-input"
                >
            </div>
            <div class="input-row small">
                <label for="taskPriority">Prioridade</label>
                <select
                    id="taskPriority"
                    name="taskPriority"
                    class="inline-input"
                >   
                <?php foreach($priorities as $item): ?>
                    <option value="<?= $item['id']?>">
                    <?= $item['priority']?>
                    </option>
                <?php endforeach ?>
                </select>
            </div>
            

            <button type="submit"
                    id="submitTask"
                    class="pill-button add-task-button">
                <i class="fa-solid fa-check"></i>
            </button>
        </form>


        <div class="info-row">
            <?php foreach($tasks as $item): ?>
                <div class="task-card">
                    <div class="left-card-wrapper">
                        <i class="fa-solid fa-list-check light-text"></i>
                        <span class="light-text">|</span>

                        <i class="fa-solid 
                        <?php

                            echo getStatusColor($item['task_priority']).' ';

                            switch($item['task_priority']){
                                case 'BAIXA':
                                    echo 'fa-circle-minus';
                                break;
                                case 'ALTA':
                                    echo 'fa-circle-info';
                                break;
                                case 'CRITICA':
                                    echo 'fa-circle-exclamation';
                                break;
                                default:
                                    echo 'fa-circle';
                            }

                        ?> light-text status">
                        </i>

                        <span><?= $item['task_description'] ?></span>
                    </div>
                    <div class="right-card-wrapper">
                        
                        <span class="light-text">até</span>
                        <span><?= $item['deadline'] ?></span>
                        <span class="light-text">|</span>
                        <i class="fa-solid fa-edit light-text"></i>
                        <a  role="button"
                            class="inline-button deleteTaskButton"
                            data-task-id="<?= $item['id'] ?>">
                            <i class="fa-solid fa-trash light-text"></i>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
            <?php if(!is_array($tasks)): ?>
                <span class="light-text large">
                    Nenhuma task adicionada ao projeto...
                </span>
            <?php endif?>
        </div>
    </div>
</main>

<div class="toast" id="toast" style="display:none;">
    <div class="icon" id="icon"></div>
    <div class="toast-text">
        <div class="toast-header">
            <span class="toast-title" id="toastTitle"></span>
        </div>
        <div class="toast-body">
            <span class="toast-message" id="toastMessage"></span>
        </div>
    </div>
</div>
            
<footer>
    <script type="module"  src="../scripts/task.js"></script>
</footer>
