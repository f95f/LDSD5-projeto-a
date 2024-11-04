<?php
    require_once __DIR__ . '/../controllers/calendario-controller.php';

    $controller = new CalendarioController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $startDate = date('Y-m-01');
      $endDate = date('Y-m-t');

      $projects = $controller->getAllProjectsPerMonth($startDate, $endDate);
      $tasks = $controller->getAllTasksPerMonth($startDate, $endDate);

      $events = [];

      foreach ($projects as $project) {
        $events[] = [
            'title' => $project['project_name'],
            'start' => $project['start_date'],
            'end' => $project['deadline']
        ];
      }

      foreach ($tasks as $task) {
        $events[] = [
            'title' => $task['task_description'],
            'start' => $task['deadline'],
            'end' => $task['deadline'],
        ];
      }

      echo json_encode($events);

      exit();
    }

    define("TITLE", "Calendário | Journalling");
    define("PAGE", "CALENDARIO");
    define("STYLESHEET", "Calendário");
    include __DIR__ . '/../layout/side-menu.php'; 
    include __DIR__ . '/../layout/header.php';

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
            events: '/path/to/fetch-events', // URL para buscar eventos do banco de dados
            
            // Função acionada ao clicar em um evento (tarefa)
            eventClick: function(info) {
                let taskId = info.event.id; // Obtém o ID do evento
                let action = confirm("Pressione OK para editar ou Cancelar para excluir");
                
                if (action) {
                    // Edição
                    let title = prompt("Novo título:", info.event.title);
                    let startDate = prompt("Nova data de início (YYYY-MM-DD):", info.event.start.toISOString().split('T')[0]);
                    let endDate = prompt("Nova data de fim (YYYY-MM-DD):", info.event.end ? info.event.end.toISOString().split('T')[0] : startDate);

                    if (title && startDate && endDate) {
                        updateTask(taskId, title, startDate, endDate); // Chama a função de atualização
                    }
                } else {
                    // Exclusão
                    deleteTask(taskId); // Chama a função de exclusão
                }
            }
        });

        // Renderiza o calendário
        calendar.render();
    });
</script>

</body>
</html>
