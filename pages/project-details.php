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

    $projectId = htmlspecialchars($_GET["id"]);
    $selectedProject = controller->getProjectById($projectId);
    
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $request = $_POST;
        $controller->createProject($request);
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
        <?= $selectedProject->projectName ?>
    </div>
</main>

<footer>
    <script src="../scripts/project.js"></script>
</footer>
