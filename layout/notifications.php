<?php 
    require_once __DIR__ . '/../controllers/calendario-controller.php';
    require_once __DIR__ . '/../controllers/task-controller.php';
    require_once __DIR__ . '/../controllers/project-controller.php';
    require_once __DIR__ . '/../controllers/usuario-controller.php';

    $controller = new CalendarioController();
    $usuarioController = new UsuarioController();

    $daysBeforeDeadline = $usuarioController->getDeadlinePreferences();

    $notificationProjects = $controller->getAllProjectsUntil($daysBeforeDeadline);
    $notificationTasks = $controller->getAllTasksUntil($daysBeforeDeadline);

    $amountOfNotifications = count($notificationTasks) + count($notificationProjects);
    

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

        <?= (empty($notificationTasks) && empty($notificationProjects))? 
            '<div class="no-activity-container">
                <i class="fa-solid fa-calendar-check"></i>
                <h3>Tudo em dia!</h3>
                <span> Nenhuma atividade para mostrar. </span>
            </div>' 
        : '' ?>

        <?php foreach($notificationTasks as $item): ?>
            <div class="notification-card">
                <span class="notification-card-title">
                    <i class="fa-solid fa-list-check light-icon"></i>
                    <?= $item['task_description'] ?>
                </span>
                <hr class="light-separator">
                <div class="notification-card-row">
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


        <?php foreach($notificationProjects as $item): ?>
            <div class="notification-card">
                <span class="notification-card-title">
                    <i class="fa-solid fa-diagram-project light-icon"></i>
                    <?= $item['project_name'] ?>
                </span>
                <hr class="light-separator">
                <div class="notification-card-row">
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


    <hr class="solid-separator">
    <div class="notification-footer">
        <a role="button" class="inline-button secondary" id="clearNotificationsButton">
            <i class="fa-solid fa-broom"></i>
            Limpar
        </a>
        <a role="button" class="inline-button secondary" id="preferencesButton">
            <i class="fa-solid fa-user-gear"></i>
            Preferências
        </a>
    </div>

</div>

<a  role="button" 
    class="inline-button notification-menu" 
    id="openNotifications">

    <i class="fa-solid fa-bell"></i>
    
    <?= $amountOfNotifications?
        '<span class="notification-amount" id="notificationCounter">' . $amountOfNotifications . '</span>'
    : '' ?>

</a>

<div class="preferencesOverlay"></div>
<div class="modal" id="preferencesModal">
    <div class="modal-wrapper">
        <div class="modal-header">
            <h2>
                <i class="fa-solid fa-user-gear"></i>
                Preferências
            </h2>
        </div>

        <div class="modal-body">
            
            <form method="POST" id="preferencesForm" name="preferencesForm">
                <div class="input-row">
                    <label for="daysBeforeDeadlineWarning">Dias antes do vencimento:</label>
                    <input
                        type="number"
                        min="1"
                        id="daysBeforeDeadlineWarning"
                        name="daysBeforeDeadlineWarning"
                        value="<?= $daysBeforeDeadline ?>"
                        placeholder="Avisar com quantos dias de antecedência?"
                    >
                </div>
                
                <div class="modal-footer">
                    <button
                        type="button"
                        id="closePreferencesModal"
                        class="pill-button secondary"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        id="submitPreferences"
                        class="pill-button"
                    >
                        <i class="fa-solid fa-floppy-disk"></i>
                        Salvar
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
    

<script src="../scripts/notification.js"></script>