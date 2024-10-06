<?php
    require_once('../controllers/project-controller.php');
    require_once('../controllers/status-controller.php');
    require_once('../controllers/priority-controller.php');

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
    include('layout/side-menu.php'); 
    include('layout/header.php');

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/global.css">    
    <link rel="stylesheet" href="../styles/projetos.css">
    <link rel="icon" type="image/svg+xml" href="../images/favicon.svg">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Tarefas | Journalling </title>
</head>

<body>
    <div class="side-menu">
        <div class="side-menu-header">
            <div class="logo">
                <img src="../images/logo.svg" alt="logo: journalling">
                <span>Journalling</span>
            </div>
            <hr class="light-separator">
        </div>
        <div class="side-menu-body">
            <ul>
                <li class="menu-item">
                    <i class="fa-solid fa-calendar-days"></i>
                    Calendário Pessoal
                </li>
                <li class="menu-item">
                    <i class="fa-solid fa-diagram-project"></i>
                    Gestão de Projetos
                </li>
                <li class="menu-item active">
                    <i class="fa-solid fa-list-check"></i>
                    Tarefas
                </li>
                <li class="menu-item">
                    <i class="fa-solid fa-book"></i>
                    Diário Digital
                </li>
                <li class="menu-item">
                    <i class="fa-regular fa-user"></i>
                    Usuários
                </li>
            </ul>
        </div>
        <div class="side-menu-footer">
            <hr class="light-separator">
            <span>© Projeto LDPD5</span>
            <span>2024</span>             
        </div>
    </div>

    <div class="content">
        <?php //include('pages/tasklist.php'); ?>
        <?php include('pages/projects.php'); ?>
    </div>
</body>

</html> 