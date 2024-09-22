<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="icon" type="image/svg+xml" href="../images/favicon.svg">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <title>Tarefas | Journalling </title>
</head>

<body>
    <div class="side-menu">
        <div class="side-menu-header">
            <div class="logo">
                <img src="../images/logo.svg" alt="logo: journalling">
                <span>Journalling</span>
            </div>
            <hr class="light-separator">
        </div>
        <div class="side-menu-body">
            <ul>
                <li class="menu-item">
                    <i class="fa-solid fa-diagram-project"></i>
                    Projetos
                </li>
                <li class="menu-item active">
                    <i class="fa-solid fa-list-check"></i>
                    Tarefas
                </li>
                <li class="menu-item">
                    <i class="fa-regular fa-user"></i>
                    Usuários
                </li>
            </ul>
        </div>
        <div class="side-menu-footer">
            <hr class="light-separator">
            <span>© Projeto LDPD5</span>
            <span>2024</span>             
        </div>
    </div>

    <div class="content">
        <?php include('pages/tasklist.php'); ?>
    </div>
</body>

</html> 