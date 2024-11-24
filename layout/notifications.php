<?php 
    require_once __DIR__ . '/../controllers/calendario-controller.php';
    require_once __DIR__ . '/../controllers/task-controller.php';
    require_once __DIR__ . '/../controllers/project-controller.php';
    require_once __DIR__ . '/../controllers/usuario-controller.php';

    $controller = new CalendarioController();
    $usuarioController = new UsuarioController();

    $daysBeforeDeadline = 3; // TODO trazer das configurações do usuário

    $projects = $controller->getAllProjectsUntil($daysBeforeDeadline);
    $tasks = $controller->getAllTasksUntil($daysBeforeDeadline);

    $amountOfNotifications = count($tasks) + count($projects);

?>

<div class="notification-modal" id="notificationModal">
    <div class="notification-header">
        <h2>
            <i class="fa-solid fa-bell"></i>
            Notificações
        </h2>
        <a role="button" class="inline-button" id="closeNotifications">
            <i class="fa-solid fa-xmark"></i>
        </a>
    </div>
    <hr class="solid-separator">

    <div class="notification-content">

        <?= (empty($tasks) && empty($projects))? 
            '<div class="no-activity-container">
                <i class="fa-solid fa-calendar-check"></i>
                <h3>Tudo em dia!</h3>
                <span> Nenhuma atividade para mostrar. </span>
            </div>' 
        : '' ?>

        <?php foreach($tasks as $item): ?>
            <div class="notification-card">
                <span class="notification-card-title">
                    <i class="fa-solid fa-list-check light-icon"></i>
                    <?= $item['task_description'] ?>
                </span>
                <hr class="light-separator">
                <div class="notification-card-row">
                    <!-- <hr class="light-separator"> -->
                    <span>
                        Até <?= $item['deadline'] ?>
                    </span>
                    <a  role="button"
                        id="showDetails"
                        class="inline-button">
                        <i class="fa-solid fa-circle-info"></i>
                        Ver mais...
                    </a>
                </div>
            </div>
        <?php endforeach ?>


        <?php foreach($projects as $item): ?>
            <div class="notification-card">
                <span class="notification-card-title">
                    <i class="fa-solid fa-diagram-project light-icon"></i>
                    <?= $item['project_name'] ?>
                </span>
                <hr class="light-separator">
                <div class="notification-card-row">
                    <!-- <hr class="light-separator"> -->
                    <span>
                        Até <?= $item['deadline'] ?>
                    </span>
                    <a  role="button"
                        id="showDetails"
                        class="inline-button">
                        <i class="fa-solid fa-circle-info"></i>
                        Ver mais...
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    </div>

</div>

<a  role="button" 
    class="inline-button notification-menu" 
    id="openNotifications">

    <i class="fa-solid fa-bell"></i>
    
    <?= $amountOfNotifications?
        '<span class="notification-amount">' . $amountOfNotifications . '</span>'
    : '' ?>

</a>

<script src="../scripts/notification.js"></script>