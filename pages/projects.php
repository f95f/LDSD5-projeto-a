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
        $action = isset($_POST['action']) ? $_POST['action'] : '';


        switch ($action) {

            case 'CREATE':
                $request = $_POST;
                $controller->createProject($request);
                echo json_encode(['success' => true, 'message' => 'Project deleted']);
                break;

            case 'SEARCH':
                $query = $_POST;
                $controller->createProject($request);
                echo json_encode(['success' => true, 'message' => 'Task deleted']);
                break;
                
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid action']);
                break;
        }


        exit();
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
        <h1>Gerenciamento de Projetos</h1>
    </div>
</header>
<main>
    <div class="wrapper">
        

        <div class="menubar">
            <form   method="PUT"
                    id="searchForm"
                    class="searchbar">
                <input  type="text" 
                        id="searchInput"
                        name="searchInput"
                        placeholder="Pesquisar..."
                        class="inline-input" >
                <button type="submit" role='button' 
                    class="inline-button">
                    <i class="fa-solid fa-magnifying-glass icon search-icon"></i>
                </button>
            </form>
            <button id="showFormModal" class="pill-button">
                <i class="fa-solid fa-plus"></i>
                Novo Projeto
            </button>
        </div>


        <ul class="card-grid">
        <?php foreach($projects as $item): ?>
            <li class="card-item">
                <div class="card-row">
                    <h3>
                        <i class="fa-solid fa-sitemap icon"></i>
                        <?= $item['project_name']?>
                    </h3>
                    <span class="status secondary"><?= getStatus($item['project_status'], $status);?></span>
                </div>
                <div class="card-body">
                    Lorem ipsum dolor sit, amet consectetur adipisicing elit. Veniam porro quas sapiente, fugiat facere distinctio magnam. 
                </div>
                <div class="card-row">
                    <span><?= $item['deadline']?></span>
                    <a href="project-details.php?id=<?= $item['id']?>"
                        class="inline-button">
                        <i class="fa-solid fa-circle-info"></i>
                        Mais detalhes...
                    </a>
            <!-- <button 
                type="button"
                class="showDetailsModal inline-button"
                >Ver mais...
            </button> -->
                </div>
            </li>
        <?php endforeach ?>
        </ul>
    </div>

    <div class="overlay"></div>
    <div class="modal" id="createModal">
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
    </div>
<!-- TODO Fechar modal ao adicionar  -->

    <!-- <div class="modal" id="detailsModal">

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

    </div>  -->
</main>

<footer>
    <script src="../scripts/project.js"></script>
</footer>
