<?php

    define("TITLE", "Calendário | Journalling");
    define("PAGE", "CALENDARIO");
    define("STYLESHEET", "Calendário");
    include __DIR__ . '/../layout/side-menu.php'; 
    include __DIR__ . '/../layout/header.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth'
             
        });
        calendar.render();
      });

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
            <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
            <div id='calendar'></div>
</main>
<footer>
    <script src="../scripts/calendario.js"></script>
</footer>

</body>
</html>
