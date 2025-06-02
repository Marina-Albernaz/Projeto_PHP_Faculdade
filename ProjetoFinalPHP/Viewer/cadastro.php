<?php
    session_start();
   
?>
<!DOCTYPE html>
<html>
    
<head>
    <link rel="icon" href="../Images/logo hospital.avif" type="image/x-icon">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastrar</title>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/bulma.min.css" />
    <link rel="stylesheet" type="text/css" href="../CSS/login.css">
</head>

<body>

    <header>
        <img src="../Images/logo hospital.avif">
        <h1>Hospital Regional de Xique-Xique</h1>
        <nav>
            <a href="telaUsuarioAdmin.php">Página do Usuário</a>
            <a href="telaPesquisaAdmin.php">Pesquisar</a>
            <a href="telaCRUDadmin.php">Gerenciar</a>
            <a href="cadastro.php">Cadastrar</a>
            <a href="telaLogAdmin.php">Log</a>
            <a href="../Model/logout.php">Sair</a>
        </nav>
    </header>

    <section class="hero is-success is-fullheight">
        <div class="hero-body">
            <div class="container has-text-centered">
                <div class="column is-4 is-offset-4">
                    <h3 class="title has-text-grey">Cadastrar um Usuário</h3>
                    
                    
                    <?php
                     if(isset($_SESSION['status_cadastro'])): //os dois pontos ':' siginifica fechamento verdadeiro//
                    ?>
                    <div class="notification is-success">
                      <p>Cadastro efetuado!</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['status_cadastro']);
                    ?>
                    <?php
                    if(isset($_SESSION['usuario_existe'])):
                    ?>
                    <div class="notification is-info">
                        <p>O usuário escolhido já existe. Informe outro e tente novamente.</p>
                    </div>
                    <?php
                    endif;
                    unset($_SESSION['usuario_existe']);
                    ?> 
                    <div class="box">
                        <form action="../Model/DAO/cadastrar.php" method="POST">
                            <div class="field">
                                <div class="control">
                                    <input name="nome" type="text" class="input is-large" placeholder="Nome" autofocus>
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input name="usuario" type="text" class="input is-large" placeholder="Usuário">
                                </div>
                            </div>
                            <div class="field">
                                <div class="control">
                                    <input name="senha" class="input is-large" type="password" placeholder="Senha">
                                </div>
                            </div>
                            <button type="submit" class="button is-block is-link is-large is-fullwidth">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

        <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f0f8ff;
        color: #333;
        margin: 0;
        padding: 0;
    }

    header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #007bff;
    padding: 10px 20px;
    color: #f0f8ff;
    }

    header img {
    height: 60px;
    width: auto;
        }

    nav a {
    color: #fff;
    text-decoration: none;
    margin-left: 20px;
    font-weight: bold;
    transition: color 0.3s;
    }

    nav a:hover {
    color: #ffd700;
    }

    .hero.is-success {
        background-color: #e6f2ff;
    }

    .box {
        border: 1px solid #007bff;
        border-radius: 8px;
        padding: 30px;
        background-color: #fff;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .title.has-text-grey {
        color: #007bff !important;
        margin-bottom: 10px;
    }

    a {
        color: #007bff;
        text-decoration: none;
    }

    a:hover {
        color: #0056b3;
        text-decoration: underline;
    }

    .input.is-large {
        border: 2px solid #007bff;
        border-radius: 4px;
        padding: 12px;
        font-size: 16px;
        transition: border-color 0.3s;
    }

    .input.is-large:focus {
        border-color: #0056b3;
        box-shadow: none;
    }

    .button.is-link {
        background-color: #007bff;
        border: none;
        font-size: 16px;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .button.is-link:hover {
        background-color: #0056b3;
    }

    .notification.is-danger {
        background-color: #ffdddd;
        color: #cc0000;
        border: 1px solid #cc0000;
        border-radius: 4px;
        padding: 10px;
        margin-bottom: 20px;
    }

    h1{
        font-size: 28px;
        color:rgb(245, 245, 245);
        font-weight: bold;
    }

    </style>
    
</body>

</html>