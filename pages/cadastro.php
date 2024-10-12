<?php

    include('../database/conn.php');

    if(isset($_POST['email']) || isset($_POST['senha']));
        if(strlen($_POST['email'])==0){
            //echo "Preencha seu email";
        }else if(strlen($_POST['senha'])==0){
            echo "Preencha sua senha";
        }else{
            $email = $mysqli->real_escape_string($_POST['email']);
            $senha = $mysqli->real_escape_string($_POST['senha']);

            $sql_code = "SELECT * FROM tb_user WHERE email = '$email' AND senha = '$senha'";
            $sql_query = $mysqli->query($sql_code) or die("Falha na execução do código SQL: ". $mysqli->error);
            
            $qntd = $sql_query->num_rows;

            if($qntd == 1){
                $usuario = $sql_query->fetch_assoc();

                if(!isset($_SESSION)){
                    session_start();
                }
                    $_SESSION['id'] = $usuario['id'];
                    $_SESSION['name'] = $usuario['name'];

                    header("Location: .php");
            } 
                else{
                    echo("Falha ao logar! Email ou senha invalidos");
                }
            }
?>
</html>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Cadastro | Journalling</title>
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
            <h1 class="login-header">Cadastro</h1>
            <hr class="light-separator">

            <form class="login-form" action="" method="POST">
                <div class="input-group">
                    <label for="name">Nome</label>
                    <input type="text" id="name" class="inline-input" placeholder="Entre com sua nome">
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" class="inline-input" placeholder="Entre com sua email">
                </div>
                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" class="inline-input" placeholder="Entre com sua senha">
                </div>
                <hr class="light-separator">
                <button type="submit" class="pill-button">Cadastrar</button>
            </form>
            <p class="light-text">Já tem uma conta? <a href="../pages/login.php">Entrar</a></p>

        </div>
    </div>
</div>
</body>
</html>
