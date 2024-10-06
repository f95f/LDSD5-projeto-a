<?php
    require_once('controllers/project-controller.php');
    require_once('controllers/status-controller.php');
    require_once('controllers/priority-controller.php');

    $controller = new ProjectController();
    $statusController = new StatusController();
    $priorityController = new PriorityController();

    $projects = $controller->getAllProjects();
    $status = $statusController->getAllStatus();
    $priorities = $priorityController->getAllPriorities();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $request = $_POST;
        $controller->createProject($request);
        // header("Location: " . $_SERVER['PHP_SELF']);
        // exit(); 
    }
    // if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    //     parse_str(file_get_contents("php://input"), $_PUT);

    //     if (isset($_PUT['status'])) {
    //         $taskId = isset($_PUT['id']) ? $_PUT['id'] : '';
    //         $completed = isset($_PUT['project_status']) ? $_PUT['project_status'] : '';
    //         $controller->changeTaskStatus($taskId, $completed);

    //     }
    //     else {
    //         $taskId = isset($_PUT['id']) ? $_PUT['id'] : '';
    //         $status = isset($_PUT['project_status']) ? $_PUT['project_status'] : '';
    //         $priority = isset($_PUT['project_priority']) ? $_PUT['project_priority'] : '';
    //         $user_id = isset($_PUT['user_id']) ? $_PUT['user_id'] : '';
    //         $created_at = isset($_PUT['created_at']) ? $_PUT['created_at'] : '';
    //         $created_at = isset($_PUT['created_at']) ? $_PUT['created_at'] : '';
    //         $controller->changeTaskStatus($taskId, $completed);

    //     }

    //     echo json_encode(['success' => true]);
    //     exit(); 
    // }

    // // Delete a project
    // if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //     parse_str(file_get_contents("php://input"), $_DELETE);

    //     $projectId = isset($_DELETE['id'])? $_DELETE['id'] : '';
    //     $controller -> deleteProject($projectId);
    //     echo json_encode(['success' => true]);
    //     exit(); 
    // }

?>

<header>
    <div class="title">
        <i class="fa-solid fa-project"></i>
        <h1>Gerenciamento de Projetos</h1>
    </div>
</header>
<main>
    <div class="wrapper">
        <div class="menubar">
            <button id="showFormModal">
                Novo Projeto
            </button>
        </div>
        <ul>
        <?php foreach($projects as $item): ?>
            <li class="card-item">
                <div class="card-row">
                    <h3><?= $item['project_name']?></h3>
                    <span><?= $item['project_status']?></span>
                </div>
                <!-- <div class="card-body">
                    Project Description
                </div> -->
                <div class="card-row">
                    <span><?= $item['deadline']?></span>
                    <span><?= $item['project_priority']?></span>
                </div>
            </li>
        <?php endforeach ?>
        </ul>
    </div>

    <div id="overlay" style="display: none; background: rgba(0,0,0,0.5); position: fixed; top: 0; left: 0; width: 100%; height: 100%;"></div>
    <div id="modal">

        <div>
            <h2>Adicionar Projeto</h2>
            <div class="modal-body">
                
            <form method="POST" id="addProjectForm" name="addProjectForm">
                <div class="input-row">
                    <label for="projectName">Nome do projeto:</label>
                    <input
                        type="text"
                        id="projectName"
                        name="projectName"
                        placeholder="Qual o nome do projeto?"
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
                <button
                    type="submit"
                    id="submitProject"
                    class="pill-button add-task-button"
                >
                    <i class="fa-solid fa-plus"></i>
                </button>
            </form>
        </div>

    </div> 



    <!-- <? /*
    <div class="wrapper">
        <span>Status</span>
        <?php foreach($status as $item): ?>
            <ul>
                <li><?= $item['status']?></li>
            </ul>
        <?php endforeach ?>
        <hr>

        <span>Priorities</span>
        <?php foreach($priorities as $item): ?>
            <ul>
                <li><?= $item['priority']?></li>
            </ul>
        <?php endforeach ?>
    </div> ?*/?> -->
</main>

<footer>
    <script src="../scripts/project.js"></script>
</footer>
