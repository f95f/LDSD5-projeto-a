<?php
    require_once('controllers/project-controller.php');
    $controller = new ProjectController();
    $projects = $controller->getProjects();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        header("Location: " . $_SERVER['PHP_SELF']);
        exit(); 
    }
    if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
        parse_str(file_get_contents("php://input"), $_PUT);

        if (isset($_PUT['status'])) {
            $taskId = isset($_PUT['id']) ? $_PUT['id'] : '';
            $completed = isset($_PUT['project_status']) ? $_PUT['project_status'] : '';
            $controller->changeTaskStatus($taskId, $completed);

        }
        else {
            $taskId = isset($_PUT['id']) ? $_PUT['id'] : '';
            $status = isset($_PUT['project_status']) ? $_PUT['project_status'] : '';
            $priority = isset($_PUT['project_priority']) ? $_PUT['project_priority'] : '';
            $user_id = isset($_PUT['user_id']) ? $_PUT['user_id'] : '';
            $created_at = isset($_PUT['created_at']) ? $_PUT['created_at'] : '';
            $created_at = isset($_PUT['created_at']) ? $_PUT['created_at'] : '';
            $controller->changeTaskStatus($taskId, $completed);

        }

        echo json_encode(['success' => true]);
        exit(); 
    }

    // Delete a project
    if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
        parse_str(file_get_contents("php://input"), $_DELETE);

        $projectId = isset($_DELETE['id'])? $_DELETE['id'] : '';
        $controller -> deleteProject($projectId);
        echo json_encode(['success' => true]);
        exit(); 
    }

?>

<header>
    <div class="title">
        <i class="fa-solid fa-project"></i>
        <h1>Gerenciamento de Projetos</h1>
    </div>
</header>
<main>
    <div class="wrapper">
    </div>
</main>

<footer>
    <script src="../scripts/project.js"></script>
</footer>
