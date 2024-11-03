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
            'title' => $project['name'],
            'start' => $project['created_at'],
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

    <script src="../scripts/calendario.js">
      
    </script>
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
    <script src="../scripts/calendario.js"></script>
</footer>

</body>
</html>
