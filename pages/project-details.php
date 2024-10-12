<?php
    require_once __DIR__ . '/../controllers/project-controller.php';
    require_once __DIR__ . '/../controllers/status-controller.php';
    require_once __DIR__ . '/../controllers/priority-controller.php';
    require_once __DIR__ . '/../controllers/task-controller.php';

    $controller = new ProjectController();
    $statusController = new StatusController();
    $priorityController = new PriorityController();
    $taskController = new TaskController();

    $projectId = htmlspecialchars($_GET["id"]);

    $projects = $controller->getAllProjects();
    $status = $statusController->getAllStatus();
    $priorities = $priorityController->getAllPriorities();

    $tasks = $taskController->getTasksFromProject($projectId);
    $selectedProject = $controller->getProjectById($projectId)[0];

    function getStatus($id, $status) {
        $filtered = array_filter($status, function($item) use ($id) {
            return $item['id'] == $id;
        });
    
        return !empty($filtered) ? array_values($filtered)[0]['status'] : 'Desconhecido';
    }

    function getPriority($id, $priorities) {
        $filtered = array_filter($priorities, function($item) use ($id) {
            return $item['id'] == $id;
        });

        return !empty($filtered)? array_values($filtered)[0]['priority'] : 'Desconhecida'; 
    }

    function getStatusColor($statusId, $type) {
        global $status;
        global $priorities;

        if($type == 'STATUS') {
            $value = getStatus($statusId, $status);
        }
        else {
            $value = getPriority($statusId, $priorities);
        }

        switch($value) {
            case 'BAIXA':
            case 'BACKLOG':
                $class = 'neutral';
                break;
            case 'CONCLUIDO':
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


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = isset($_POST['action']) ? $_POST['action'] : '';


        switch ($action) {

            case 'DELETE_PROJECT':
                $controller->deleteProject($projectId);
                echo json_encode(['success' => true, 'message' => 'Project deleted']);
                break;

            case 'DELETE_TASK':
                $taskId = $_POST['id'];
                $taskController->deleteTask($taskId);
                echo json_encode(['success' => true, 'message' => 'Task deleted']);
                break;

            case 'ADD_TASK':
                $request = $_POST;
                $taskController->createTask($request);
                echo json_encode(['success' => true, 'message' => 'Task added']);
                break;

            case 'UPDATE':
                $taskId = $_POST['id'];
                $newDescription = $_POST['description'];
                $newDeadline = $_POST['deadline'];
                
                $taskController->updateTask($taskId, $newDescription, $newDeadline);
                echo json_encode(['success' => true, 'message' => 'Task updated']);
                break;
                
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }


        exit;
    }

    define("TITLE", "Projetos | Journalling");
    define("PAGE", "PROJETOS");
    define("STYLESHEET", "projetos");
    include __DIR__ . '/../layout/side-menu.php'; 
    include __DIR__ . '/../layout/header.php';

?>

<header>
    <div class="title">
        <i class="fa-solid fa-diagram-project"></i>
        <h1>Detalhes do Projeto</h1>
    </div>
</header>
<main>
    <div class="wrapper">
        <div class="project-title">
            <h3>
                <i class="fa-solid fa-diagram-project icon"></i>
                <?= $selectedProject['project_name']; ?>
            </h3>
            <span class="light-text">|</span>
            <a  role="button">
                <i class="fa-solid fa-edit light-text"></i>
            </a>
            <a  role="button"
                class="inline-button deleteProjectButton">
                <i class="fa-solid fa-trash light-text"></i>
            </a>
        </div>

        <hr class="light-separator form-separator">

        <div class="info-row">
            <span class="label">Status:</span>
            <span class="status"><?= getStatus($selectedProject['project_status'], $status);?></span>
        </div>
        <div class="info-row">
            <span class="label">Prioridade:</span>
            <span class="status <?= getStatusColor($selectedProject['project_priority'], 'PRIORITY')?>">
                <?= getPriority($selectedProject['project_priority'], $priorities);?>
            </span>
        </div>
        <div class="info-row">
            <span class="label">Criado em:</span>
            <span><?= $selectedProject['created_at'];?></span>
        </div>
        <div class="info-row">
            <span class="label">Prazo:</span>
            <span><?= $selectedProject['deadline'];?></span>
        </div>

        <hr class="light-separator form-separator">

        <div class="info-row">
            <div class="add-task-row">
                <h4>Tasks</h4>
                <span class="light-text">|</span>
                <button class="inline-button"
                        id="toggleTaskButton">
                    <i class="fa-solid fa-plus"></i>
                    Adicionar
                </button>
            </div>
            
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
                        placeholder="O que você quer fazer?"
                    >
                </div>
                <div class="input-row small">
                    <label for="deadline">Deadline</label>
                    <input
                        type="date"
                        id="deadline"
                        name="deadline"
                    >
                </div>
                <div class="input-row small">
                    <label for="taskPriority">Prioridade</label>
                    <select
                        id="taskPriority"
                        name="taskPriority"
                    >   
                    <?php foreach($priorities as $item): ?>
                        <option value="<?= $item['id']?>">
                        <?= $item['priority']?>
                        </option>
                    <?php endforeach ?>
                    </select>
                </div>
                <input type="hidden" name="projectId" value="<?= $projectId ?>">
     
                <!-- <button type="button"
                        id="closeForm"
                        class="pill-button secondary">
                    <i class="fa-solid fa-xmark"></i>
                </button> -->
                <button type="submit"
                        id="submitTask"
                        class="pill-button add-task-button">
                    <i class="fa-solid fa-check"></i>
                </button>
            </form>

        </div>
        <div class="info-row">
            <?php foreach($tasks as $item): ?>
                <div class="task-card">
                    <div class="left-card-wrapper">
                        <i class="fa-solid fa-list-check light-text"></i>
                        <span class="light-text">|</span>
                        <span><?= $item['task_description'] ?></span>
                    </div>
                    <div class="right-card-wrapper">
                        <?php /*
                        <span><?= getStatus($selectedProject['project_status'], $status); ?></span>
                        <span class="light-text">|</span>
                        <span><?= getPriority($selectedProject['project_priority'], $priority); ?></span>
                        <span class="light-text">|</span>
                        */?>
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

    <div class="overlay"></div>
    <!-- <div class="modal" id="createModal">
        <div class="modal-wrapper">
            <div class="modal-header">
                <h2>Adicionar Task</h2>
            </div>
            <div class="modal-body">
                
            <form method="POST" id="addTaskForm" name="addTaskForm">
                <div class="input-row">
                    <label for="projectName">Descrição da task:</label>
                    <input
                        type="text"
                        id="taskDescription"
                        name="taskDescription"
                        placeholder="O que você quer fazer?"
                    >
                </div>
                <div class="input-row">
                    <label for="deadline">Deadline</label>
                    <input
                        type="date"
                        id="deadline"
                        name="deadline"
                    >
                </div>
                <div class="input-row">
                    <label for="projectPriority">Prioridade</label>
                    <select
                        id="projectPriority"
                        name="projectPriority"
                    >   
                    <?php foreach($priorities as $item): ?>
                        <option value="<?= $item['id']?>">
                        <?= $item['priority']?>
                        </option>
                    <?php endforeach ?>
                    </select>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        id="closeCreateModal"
                        class="pill-button secondary"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        id="submitProject"
                        class="pill-button"
                    >
                        <i class="fa-solid fa-plus"></i>
                        Adicionar
                    </button>
                </div>
            </form>
        </div>
    </div> -->
</main>

<footer>
    <script src="../scripts/project-details.js"></script>
</footer>
