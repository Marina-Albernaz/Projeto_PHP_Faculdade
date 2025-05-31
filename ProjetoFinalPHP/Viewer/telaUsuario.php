<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="../Images/logo hospital.avif" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Usuário</title>
</head>
<body>
    <header>
        <img src="../Images/logo hospital.avif">
        <h1>Hospital Regional de Xique-Xique</h1>
        <nav>
            <a href="telaUsuario.php">Página do Usuário</a>
            <a href="telaPesquisa.php">Pesquisar</a>
            <a href="../Model/logout.php">Sair</a>
        </nav>
    </header>

    <section>
        <div>
            <?php
            session_start();
            if (isset($_SESSION['nome_usuario'])) {
                $nome = htmlspecialchars($_SESSION['nome_usuario']);
                echo "<h1>Olá, $nome</h1>";
            } else {
                echo "<h1>Olá, Usuário</h1>";
            }
            ?>
        </div>


        <div>
            <form action="../Model/DAO/deleteUsuarioDAO.php" method="post">
                <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id_usuario']; ?>">
                <input type="submit" value="Excluir usuário" onclick="return confirm('Tem certeza que deseja excluir sua conta?');">
            </form>
        </div>
    </section>

<style>
    body {
    font-family: Arial, sans-serif;
    background-color: #f0f8ff;
    margin: 0;
    padding: 0;
    color: #333;
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

    section {
    padding: 40px 20px;
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
    }

    section h1 {
    font-size: 28px;
    margin-bottom: 30px;
    color: #007bff;
    }

    form {
    display: flex;
    justify-content: center;
    margin-top: 20px;
    }

    input[type="submit"] {
    padding: 12px 24px;
    font-size: 16px;
    border: none;
    background-color: #007bff;
    color: #fff;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.3s;
    }

    input[type="submit"]:hover {
    background-color: #0056b3;
    }
</style>
</body>
</html>