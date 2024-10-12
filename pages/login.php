<?php

    include('../database/conn.php');

    if(isset($_POST['email']) || isset($_POST['senha']));
        if(strlen($_POST['email'])==0){
            echo "Preencha seu email";
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

                    header("Location: tasklist.php");
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
    <title>Login</title>
    <link rel="stylesheet" href="../styles/cadastro.css">
</head>
<body>
<form action="post">
    <div class="login-wrapper">
        <div class="login-box">
            <h1 class="title">Login</h1>
            <form class="login-form" action="#">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" class="inline-input" placeholder="Entre com sua email">
                </div>
                <div class="input-group">
                    <label for="senha">Senha</label>
                    <input type="password" id="senha" class="inline-input" placeholder="Entre com sua senha">
                </div>
                <button type="submit" class="pill-button">Entrar</button>
            </form>
            <p class="light-text">Ainda não tem uma conta? <a href="../pages/cadastro.php">Cadastra-se</a></p>
        </div>
    </div>
</form>
</body>
</html>
