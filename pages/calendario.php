<?php
    require_once __DIR__ . '/../controllers/calendario-controller.php';
    require_once __DIR__ . '/../controllers/task-controller.php';
    require_once __DIR__ . '/../controllers/project-controller.php';

    $controller = new CalendarioController();
    $projectController = new ProjectController();
    $taskController = new TaskController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        
        $action = isset($_POST['action']) ? $_POST['action'] : '';
        $type = isset($_POST['type']) ? $_POST['type'] : '';

        switch ($action) {


            case 'update':
                
                if($type == 'PROJECT') {

                    $project = array(
                        'id' => $_POST['id'],
                        'project_name' => $_POST['name'],
                        'project_priority' => $_POST['priority'],
                        'project_status' => 1,
                        'project_description' => $_POST['description'],
                        'project_status' => $_POST['status'],
                        'created_at' => $_POST['startDate'],
                        'start_date' => $_POST['startDate'],
                        'deadline' => $_POST['endDate']
                    );
    
                    $projectController->updateProject($project);
                } 
                else {
                    
                    $id = $_POST['id'];
                    
                    $task = array(
                        'id' => $_POST['id'],
                        'description' => $_POST['description'],
                        'taskPriority' => $_POST['priority'],
                        'projectId' => $_POST['projectId'],
                        'startDate' => $_POST['startDate'],
                        'deadline' => $_POST['endDate'],
                    );
                    $taskController->updateTask($id, $task);

                }

                echo json_encode('Item atualizado.');
                exit();
                break;
                

            case 'change-status':

                $id = $_POST['taskId'];
                $status = $_POST['completed'];

                $result = $taskController->changeStatus($id, $status);

                echo json_encode($result);
                exit();
                break;




            case 'delete':

                $id = $_POST['task_id'];

                if($type == 'PROJECT') {
                    $projectController->deleteProject($id);
                } 
                else {
                    $taskController->deleteTask($id);
                }

                echo json_encode('Item excluído.');
                exit();
                break;

            default:

                $projects = $controller->getAllProjectsPerMonth();
                $tasks = $controller->getAllTasksPerMonth();

                $events = [];

                foreach ($projects as $project) {
                    $events[] = [
                        'id' => $project['id'],
                        'type' => 'PROJECT',
                        'title' => $project['project_name'],
                        'description' => $project['project_description'],
                        'start' => $project['start_date'],
                        'createdAt' => $project['created_at'],
                        'end' => $project['deadline'],
                        'deadline' => $project['deadline'],
                        'priority' => $project['project_priority'],
                        'status' => $project['project_status']
                    ];
                }
                
                foreach ($tasks as $task) {
                    $events[] = [
                        'id' => $task['id'],
                        'type' => 'TASK',
                        'title' => $task['task_description'],
                        'description' => $task['task_description'],
                        'start' => $task['deadline'],
                        'createdAt' => $task['created_at'],
                        'end' => $task['deadline'],
                        'deadline' => $task['deadline'],
                        'priority' => $task['task_priority'],
                        'projectId' => $task['project_id'],
                        'status' => $task['task_completed']
                    ];
                }

                echo json_encode($events);
                exit();
                break;
        }
      

    }

    define("TITLE", "Calendário | Journalling");
    define("PAGE", "CALENDARIO");
    define("STYLESHEET", "calendario");
    include __DIR__ . '/../layout/side-menu.php'; 
    include __DIR__ . '/../layout/header.php';
    include __DIR__ . '/../layout/notifications.php';

?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Include FullCalendar's CSS for proper styling -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet" /> -->

    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script src="../scripts/calendario.js"></script>
</head>
<body>

<header>
    <div class="title">
        <i class="fa-solid fa-calendar-days"></i>
        <h1>Calendário</h1>
    </div>
</header>

<main>
    <div id="calendar"></div>
</main>
<footer>
    
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        
        // Inicializa o calendário com configuração padrão
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',  // Define o calendário em modo mensal por padrão
            locale: 'pt-br',              // Define o idioma para Português do Brasil
            headerToolbar: {
                left: 'prev,next today',  // Botões de navegação no lado esquerdo
                center: 'title',          // Título no centro
                right: 'dayGridMonth,timeGridWeek,timeGridDay' // Visões no lado direito
            },
            
            // Configura para buscar eventos do servidor
            events: function(fetchInfo, successCallback, failureCallback) {
                
                
                fetch('', {
                    method: 'POST',
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => successCallback(data))
                .catch(error => failureCallback(error));
            
            
            }, // Requsição para buscar eventos do banco de dados
            

            // Função acionada ao clicar em um evento (tarefa)
            eventClick: function(info) {
                
                let taskId = info.event.id; // Obtém o ID do evento
                // let action = confirm("Pressione OK para editar ou Cancelar para excluir");
                const data = {
                    id: info.event.id,
                    type: info.event.extendedProps.type,
                    title: info.event.title,
                    startDate: info.event.start.toISOString().split('T')[0],
                    endDate: info.event.extendedProps.deadline || '',
                    createdAt: info.event.extendedProps.createdAt || '',
                    description: info.event.extendedProps.description || '',
                    priority: info.event.extendedProps.priority || '',
                    status: info.event.extendedProps.status || 0
                };


                openDetails(data);
            }
        });

        // Renderiza o calendário
        calendar.render();
    });
</script>



    <div class="overlay" id="overlay"></div>
    
    <div class="modal" id="detailsModal">
        <div class="modal-wrapper">
            <div class="modal-header">
                <h2>Detalhes: <span id="eventDetails"></span></h2>
                <form method="POST" id="completeForm" name="completeForm">
                    <label class="switch" for="completed">
                        <input 
                            type="checkbox"
                            id="completed"
                            name="completed">
                        <span class="slider round"></span>
                    </label>
                    Concluída
                    <input type="hidden" id="taskId" name="taskId">
                </form>
            </div>
            <div class="modal-body">
                <div class="info-row">
                    <span class="label">Tipo:</span>
                    <span id="type"></span>
                </div>
                
                <div class="info-row">
                    <span class="label">Status:</span>
                    <span id="status"></span>
                </div>

                <div class="info-row">
                    <span class="label">Descrição:</span>
                    <span id="description"></span>
                </div>
                <div class="info-row">
                    <span class="label">Criado em:</span>
                    <span id="createdAt"></span>
                </div>
                <div class="info-row">
                    <span class="label">Prazo:</span>
                    <span>de</span>
                    <span id="startDate"></span>
                    <span>à</span>
                    <span id="endDate"></span>
                </div>
                
                <div class="info-row">
                    <span class="label">Prioridade:</span>
                    <span id="priority"></span>
                </div>

            </div>            
            <div class="modal-footer">
                <div class="left-wrapper">
                    <a role="button" class="inline-button" onClick="hideModals()">
                        <i class="fa-solid fa-xmark"></i>
                        Fechar
                    </a>
                </div>
                <div class="right-wrapper">
                    <a  role="button"
                        id="editButton" 
                        class="inline-button">
                        <i class="fa-solid fa-edit"></i>
                        Editar
                    </a>

                    <a  role="button"
                        id="deleteButton" 
                        class="inline-button danger">
                        <i class="fa-solid fa-trash"></i>
                        Excluir
                    </a>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="editModal">
        <div class="modal-wrapper">
            <div class="modal-header">
                <h2>Atualizar Evento</h2>
            </div>
            <div class="modal-body">
                
            <form method="POST" id="editForm" name="editForm">
                <div class="input-row" id="nameRow">
                    <label for="name">Nome:</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Nome do evento"
                    >
                </div>
                <div class="input-row">
                    <label for="description">Descrição</label>
                    <textarea name="description" 
                        id="description"
                        name="description"
                        placeholder="Informe a descrição...">
                    </textarea>
                </div>
                <div class="input-row">
                    <label for="startDate">Início</label>
                    <input
                        type="date"
                        id="startDate"
                        name="startDate"
                    >
                </div>
                <div class="input-row">
                    <label for="endDate">Deadline</label>
                    <input
                        type="date"
                        id="endDate"
                        name="endDate"
                    >
                </div>
                <div class="input-row">
                    <label for="priority">Prioridade</label>
                    <select
                        id="priority"
                        name="priority"
                    >   
                        <option value="0" selected disabled>Selecione</option>
                        <option value="1">Baixa</option>
                        <option value="2">Média</option>
                        <option value="3">Alta</option>
                        <option value="4">Crítica</option>

                    </select>
                </div>
                <div class="input-row" id="statusRow">
                    <label for="status">Status</label>
                    <select
                        id="status"
                        name="status"
                    >   
                        <option value="0" selected disabled>Selecione</option>
                        <option value="1">Backlog</option>
                        <option value="2">Em progresso</option>
                        <option value="3">Concluído</option>
                        <option value="4">Parado</option>
                        <option value="5">Atrasado</option>
                        <option value="6">Cancelado</option>

                    </select>
                </div>
                <input 
                    type="hidden"
                    name="projectId" 
                    id="projectId">
                <div class="modal-footer">
                    <a role="button" class="inline-button" onClick="hideModals()">
                        <i class="fa-solid fa-xmark"></i>
                        Cancelar
                    </a>
                    <button
                        type="button"
                        id="submitUpdate"
                        class="pill-button"
                    >
                        <i class="fa-solid fa-check"></i>
                        Confirmar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="toast" id="toast" style="display:none;">
        <div class="icon" id="icon"></div>
        <div class="toast-text">
            <div class="toast-header">
                <span class="toast-title" id="toastTitle"></span>
            </div>
            <div class="toast-body">
                <span class="toast-message" id="toastMessage"></span>
            </div>
        </div>
    </div>
</body>
</html>
