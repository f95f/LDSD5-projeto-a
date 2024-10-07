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

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $request = $_POST;
        $taskController->createTask($request);
        // header("Location: " . $_SERVER['PHP_SELF']);
        // exit(); 
    }

    define("TITLE", "Projetos | Journalling");
    define("PAGE", "PROJETOS");
    include __DIR__ . '/../layout/side-menu.php'; 
    include __DIR__ . '/../layout/header.php';

?>

<header>
    <div class="title">
        <i class="fa-solid fa-project"></i>
        <h1>Detalhes do Projeto</h1>
    </div>
</header>
<main>
    <div class="wrapper">
        <?= $selectedProject['project_name']; ?>
        <h3 class="project-title">
            <?= $selectedProject['project_name']; ?>
        </h3>
        <div class="info-row">
            <span class="label">Status:</span>
            <span><?= getStatus($selectedProject['project_status'], $status);?></span>
        </div>
        <div class="info-row">
            <span class="label">Prioridade:</span>
            <span><?= getPriority($selectedProject['project_priority'], $priorities);?></span>
        </div>
        <div class="info-row">
            <span class="label">Criado em:</span>
            <span><?= $selectedProject['created_at'];?></span>
        </div>
        <div class="info-row">
            <span class="label">Prazo:</span>
            <span><?= $selectedProject['deadline'];?></span>
        </div>
        <div class="info-row">
            <span class="label">Tasks:</span>
            <button class="inline-button">
                Adicionar Task
            </button>
            
            <form method="POST" 
                id="addTaskForm" 
                name="addTaskForm" 
                class="form-row">

                <div class="input-group">
                    <label for="projectName">Descrição da task:</label>
                    <input
                        type="text"
                        id="taskDescription"
                        name="taskDescription"
                        placeholder="O que você quer fazer?"
                    >
                </div>
                <div class="input-group">
                    <label for="deadline">Deadline</label>
                    <input
                        type="date"
                        id="deadline"
                        name="deadline"
                    >
                </div>
                <div class="input-group">
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
            </form>

        </div>
        <div class="info-row">
            <?php foreach($tasks as $item): ?>
                <span><?= $item['task_description'] ?></span>
            <?php endforeach ?>
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
