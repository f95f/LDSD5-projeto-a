<?php 

    function isActive($item) {
        return (PAGE == $item)? 'active' : '';
    }

?>

<div class="side-menu">
    <div class="side-menu-header">
        <div class="logo">
            <a href="inicio.php">
                <img src="../images/logo.svg" alt="logo: journalling">
                <span>Journalling</span>
            </a>
        </div>
        <hr class="light-separator">
    </div>
    <div class="side-menu-body">
        <ul>
            <li class="menu-item <?= isActive('CALENDARIO'); ?>">
                <a href="calendario.php">
                    <i class="fa-solid fa-calendar-days"></i>
                    Calendário Pessoal
                </a>
            </li>
            <li class="menu-item <?= isActive('PROJETOS'); ?>">
                <a href="projects.php">
                    <i class="fa-solid fa-diagram-project"></i>
                    Gestão de Projetos
                </a>
            </li>
            <li class="menu-item <?= isActive('TASKS'); ?>">
                <a href="tasklist.php">
                    <i class="fa-solid fa-list-check"></i>
                    Tarefas
                </a>
            </li>
            <li class="menu-item <?= isActive('DIARIO'); ?>">
                <a href="diario.php">
                    <i class="fa-solid fa-book"></i>
                    Diário Digital
                </a>
            </li>
        </ul>
    </div>
    <div class="side-menu-footer">
        <hr class="light-separator">
        <span>© Projeto LDPD5</span>
        <span>2024</span>             
    </div>
</div>