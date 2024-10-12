<?php

    require_once __DIR__ . '/../database/conn.php';
    require_once __DIR__ . '/../services/usuario-service.php';

    $service = new UsuarioService();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        
        $action = isset($_POST['action']) ? $_POST['action'] : '';

        if($action === 'SIGNUP') {

            
            // if(strlen($_POST['email'])==0){
            //     // echo "Preencha seu email";
            // }else if(strlen($_POST['senha'])==0){
            //     echo "Preencha sua senha";
            // }else{
                
                
            $nome = $_POST['nome'];
            $email = $_POST['email'];
            $senha = $_POST['senha'];
            
            $usuario = $service->signup($nome, $email, $senha);

            if(!$usuario){
                echo json_encode(['success' => false, 'message' => 'Usuário não encontrado']);
            }
            else {
                echo json_encode(['success' => true, 'message' => 'Autenticado com sucesso']);    
                
                // if(!isset($_SESSION)){
                //     session_start();
                // }
                // $_SESSION['id'] = $usuario['id'];
                // $_SESSION['name'] = $usuario['name'];

                // header("Location: login.php");
            }

        }
        // }
    }
?>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Cadastre-se | Journalling</title>
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
            <h1 class="login-header">Cadastre-se</h1>
            <hr class="light-separator">

            <form id="signinForm" class="login-form" action="" method="POST">
                <div class="input-group">
                    <label for="nome">Nome</label>
                    <input type="text" name="nome" id="nome" class="inline-input" placeholder="Informe o seu nome">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" class="inline-input" placeholder="Informe o seu email">
                </div>
                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input type="password" name="senha" id="senha" class="inline-input" placeholder="Informe a sua senha">
                </div>
                <div class="input-group">
                    <label for="senha">Confirme a senha</label>
                    <input type="password" name="confirmarSenha" id="confirmarSenha" class="inline-input" placeholder="Confirme a senha">
                </div>
                <hr class="light-separator">
                <button type="submit" class="pill-button">Cadastrar</button>
            </form>
            <p class="light-text">Já tem uma conta? <a href="../pages/login.php">Entrar</a></p>

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
