<?php
    require_once __DIR__ . '/../controllers/task-controller.php';
    require_once __DIR__ . '/../controllers/priority-controller.php';
    require_once __DIR__ . '/../controllers/project-controller.php';

    $controller = new TaskController();
    $projectController = new ProjectController();
    $priorityController = new PriorityController();

    $tasks = $controller->getTasks();
    $priorities = $priorityController->getAllPriorities();
    $projects = $projectController->getProjectNames();

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

            case 'FILTER_STATUS':
                $taskStatus = $_POST['status'];
                
                $filteredTasks = $controller->filterByStatus($taskStatus);
                echo json_encode([
                    'success' => true,
                    'content' => $filteredTasks
                ]);
                break;

            case 'FILTER_PROJECT':
                $projectId = $_POST['projectId'];
                
                $filteredTasks = $controller->getTasksFromProject($projectId);
                echo json_encode([
                    'success' => true,
                    'content' => $filteredTasks
                ]);
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


    function getStatusColor($value) {

        switch($value) {
            case 'BACKLOG':
                $class = 'neutral';
                break;
            case 'CONCLUIDO':
            case 'MEDIA':
            case 2:
                $class = 'success';
                break;
            case 'PARADO':
            case 'ATRASADO':
            case 'ALTA':
            case 3:
                $class = 'warning';
                break;
            case 'CANCELADO':
            case 'CRITICA':
            case 4:
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
    include __DIR__ . '/../layout/notifications.php';
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

        <div class="filter-wrapper">
            <h4 class="light-text">Filtros:</h4>
            <div class="filter-row">

                <div class="priority-filters">
                    <a  role="button"
                        data-status="1"
                        id="lowPriorityFilter"
                        class="inline-button priority-filter-button">
                        <i class="fa-solid fa-circle light-text status"></i>
                        Baixa
                    </a>
                    <a  role="button"
                        data-status="2"
                        id="mediumPriorityFilter"
                        class="inline-button priority-filter-button success">
                        <i class="fa-solid fa-circle-minus light-text success status"></i>
                        Média
                    </a>
                    <a  role="button"
                        data-status="3"
                        id="highPriorityFilter"
                        class="inline-button priority-filter-button warning">
                        <i class="fa-solid fa-circle-info light-text warning status"></i>
                        Alta
                    </a>
                    <a  role="button"
                        data-status="4"
                        id="criticalPriorityFilter"
                        class="inline-button priority-filter-button danger">
                        <i class="fa-solid fa-circle-exclamation light-text danger status"></i>
                        Crítica
                    </a>
                </div>

                <div class="projectWrapper">
                    <label for="selectProject">Projeto:</label>
                    <select class="inline-input" id="selectProject">
                        <option value="0" selected>Todos</option>
                        <?php foreach($projects as $item): ?>
                            <option value="<?= $item['id']?>">
                                <?= $item['project_name'] ?>
                            </option>
                        <?php endforeach ?>
                    </select>
                </div>

                <button class="inline-button secondary" id="clearFilters">
                    <i class="fa-solid fa-filter-circle-xmark"></i>
                    Limpar
                </button>

            </div>
        </div>
        <hr class="light-separator">

        <div class="info-row" id="taskList">
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
                                case 1:
                                    echo 'fa-circle';
                                break;
                                case 'ALTA':
                                case 3:
                                    echo 'fa-circle-info';
                                break;
                                case 'CRITICA':
                                case 4:
                                    echo 'fa-circle-exclamation';
                                break;
                                default:
                                    echo 'fa-circle-minus';
                            }

                        ?> light-text status">
                        </i>
                        <?= $item['task_priority'] ?>
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
