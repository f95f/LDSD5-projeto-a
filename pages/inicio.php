<?php define("TITLE", "Início | Journalling"); ?>
<?php define("PAGE", null); ?>
<?php define("STYLESHEET", null); ?>
<?php include __DIR__ . '/../layout/side-menu.php'; ?>
<?php include __DIR__ . '/../layout/header.php'; ?>
<?php

    session_start();

    if (!isset($_SESSION['id'])) {
        header('Location: /path/to/login.php');
        exit;
    }
    
    $username = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest';

?>
<header>
    <div class="title">
        <i class="fa-solid fa-house"></i>
        <h1>Bem-vindo, <?= $username ?>!</h1>
    </div>
</header>
<main></main>