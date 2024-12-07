<?php

    require_once __DIR__ . '/../database/conn.php';
    require_once __DIR__ . '/../services/usuario-service.php';

    $service = new UsuarioService();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        header('Content-Type: application/json'); 


        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action === 'LOGIN') {
            if(isset($_POST['email']) || isset($_POST['senha'])) {

            
                // if(strlen($_POST['email'])==0){
                //     // echo "Preencha seu email";
                // }else if(strlen($_POST['senha'])==0){
                //     echo "Preencha sua senha";
                // }else{
                    
                    
                    $email = $_POST['email'];
                    $senha = $_POST['senha'];
                    
                    $usuario = $service->login($email, $senha);

                    if(!$usuario){
                        echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
                    }
                    else {
                        // if(!isset($_SESSION)){
                        //     session_start();
                        // }
                        session_start();

                        $_SESSION['id'] = $usuario['id'];
                        $_SESSION['name'] = $usuario['name'];
                        
                        echo json_encode(['success' => true, 'message' => 'Autenticado com sucesso']);    
                        
                    }

                // }
            }
        }
        exit(); 
    }
?>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Journalling</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="../styles/global.css">
    <link rel="stylesheet" href="../styles/cadastro.css">
    <link rel="icon" type="image/svg+xml" href="../images/favicon.svg">  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</head>
<body>
    <div class="content">
        <img src="../images/logo.png" alt="waterdrop" class="waterdrop">
        <div class="login-wrapper">        
            <div class="login-box">
                <div class="logo header-image">
                    <img src="../images/logo.svg" alt="logo: journalling">
                    <span>Journalling</span>
                </div>
                <h1 class="login-header">Login</h1>
                <hr class="light-separator">

                <form id="loginForm" class="login-form" method="post" action="#">
                    <div class="input-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="inline-input" placeholder="Entre com seu email">
                    </div>
                    <div class="input-group">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="senha"  class="inline-input" placeholder="Informe sua senha">
                    </div>
                    <hr class="light-separator">
                    <button type="submit" class="pill-button">Entrar</button>
                </form>

                <p class="light-text">Ainda não tem uma conta? <a href="../pages/cadastro.php">Cadastra-se</a></p>
            </div>
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

<footer>
    <script type="module" src="../scripts/login.js"></script>
</footer>

</body>
</html>
