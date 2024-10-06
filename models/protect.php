<?php 
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_SESSION['id'])){
        die("Para acessar está página é necessário estar logar<p><a href=\"../pages/login.php\">Entrar</p>");
    }
?>