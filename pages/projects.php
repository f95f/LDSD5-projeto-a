<?php
    require_once('controllers/project-controller.php');
    $controller = new ProjectController();
    $projects = $controller->getProjects();

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
