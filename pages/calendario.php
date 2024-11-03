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
    <link rel="stylesheet" href="../styles/custom.css">
</head>
<body>

<header>
    <div class="title">
        <i class="fa-solid fa-calendar-days"></i>
        <h1>Calendário</h1>
    </div>
</header>
<main>
<div id='calendar'></div>
    
    <script src="../scripts/index.global.min.js"></script>
    <script src="../scripts/core/locales-all.global.min.js"></script>
    <script src="../scripts/custom.js"></script>
</main>
<footer>
    
</footer>

</body>
</html>
