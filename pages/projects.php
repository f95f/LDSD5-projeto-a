<?php
    require_once __DIR__ . '/../controllers/project-controller.php';
    require_once __DIR__ . '/../controllers/status-controller.php';
    require_once __DIR__ . '/../controllers/priority-controller.php';
    require_once __DIR__ . '/../controllers/task-controller.php';


    $controller = new ProjectController();
    $statusController = new StatusController();
    $priorityController = new PriorityController();
    $taskController = new TaskController();

    $projects = $controller->getAllProjects();
    $status = $statusController->getAllStatus();
    $priorities = $priorityController->getAllPriorities();

    $selectedProject;
    function setItem($itemId) {
        global $projects, $selectedProject;
        foreach($projects as $item) {
            if ($item->id == $itemId) {
                $selectedProject = $item;
                break;
            }
        }   
    }
    
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

    define("TITLE", "Projetos | Journalling");
    include __DIR__ . '/../layout/side-menu.php'; 
    include __DIR__ . '/../layout/header.php';

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
            <button id="showFormModal" class="pill-button">
                <i class="fa-solid fa-plus"></i>
                Novo Projeto
            </button>
        </div>
        <ul class="card-grid">
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
            <button 
                type="button"
                class="showDetailsModal inline-button"
                >Ver mais...
            </button>
                </div>
            </li>
        <?php endforeach ?>
        </ul>
    </div>

    <div class="overlay"></div>
    <!-- <div class="modal" id="createModal">

        <div class="modal-wrapper">
            <div class="modal-header">
                <h2>Adicionar Projeto</h2>
            </div>
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

    </div>  -->


    <div class="modal" id="detailsModal">

        <div class="modal-wrapper">
            <div class="modal-header">
                <h2>Projeto</h2>
            </div>
            <div class="modal-body">
                Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatem corrupti rerum magnam maiores voluptatibus suscipit sapiente recusandae incidunt et delectus odit iure eveniet repellendus quisquam deserunt, natus molestiae vero accusamus.
            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    id="closeDetailsModal"
                    class="pill-button secondary"
                >
                    Fechar
                </button>
            </div>
        </div>

    </div> 
</main>

<footer>
    <script src="../scripts/project.js"></script>
</footer>