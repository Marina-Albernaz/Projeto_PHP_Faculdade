<!DOCTYPE html>
<html lang="pt-br">
<head>
    <link rel="icon" href="../Images/logo hospital.avif" type="image/x-icon">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisar</title>
</head>
<body>
     <header>
        <img src="../Images/logo hospital.avif">
        <h1>Hospital Regional de Xique-Xique</h1>
        <nav>
            <a href="telaUsuarioAdmin.php">Página do Usuário</a>
            <a href="telaPesquisaAdmin.php">Pesquisar</a>
            <a href="cadastro.php">Cadastrar</a>
            <a href="telaLogAdmin.php">Log</a>
            <a href="../Model/logout.php">Sair</a>
        </nav>
    </header>

    <section>
        <div>
            <form action="telaLogAdmin.php" method="post">
                <input type="date" name="searchbardate" class="searchbar">
                <br>
                <input type="time" name="searchbar" class="searchbar">
                <input type="submit" name="botao" value="🔍">
            </form>
        </div>
        
        <div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST["searchbar"]) || isset($_POST["searchbardate"])) && isset($_POST["botao"])) {
    $acao = $_POST["botao"];
            if(!($_POST["searchbar"] === "")  && !($_POST["searchbardate"] === "")){
    $pesquisa = $_POST["searchbardate"]." ".$_POST["searchbar"];
    } elseif(!($_POST["searchbardate"] === "")  && ($_POST["searchbar"] === "")){
    $pesquisa = $_POST["searchbardate"];
    } elseif(($_POST["searchbardate"] === "")  && !($_POST["searchbar"] === "")){
    $pesquisa = $_POST["searchbar"];
    } else{
        $pesquisa = "";
    }
    include_once("../Model/DAO/conexao.php");
    $pesquisa = mysqli_real_escape_string($conexao, $pesquisa);

        
        $query = "SELECT operacao, tabela, datahora FROM trigger_table WHERE datahora LIKE '%$pesquisa%' ";
        $resultado = mysqli_query($conexao, $query);
        if (mysqli_num_rows($resultado) > 0) {
            echo "<table border='1'>
            <tr>
            <th>Operação</th>
            <th>Tabela</th>
            <th>Data e Horário</th>
            </tr>";
            while ($linha = mysqli_fetch_assoc($resultado)) {
                echo "<tr>
                <td>{$linha['operacao']}</td>
                <td>{$linha['tabela']}</td>
                <td>{$linha['datahora']}</td>
                </tr>";
            }
            echo "</table>";
        } else {
                echo "<table>";
                echo "<tr>";
                echo "<th class='errormsg'>Nenhum resultado encontrado.</th>";
                echo "</tr>";
                echo "</table>";
        } 
           
    }else{
                echo"<table>";
                echo"<tr>";
                echo"<th>Selecione 🔍 para Pesquisar!</th>";
                echo"</tr>";
                echo"</table>";
            }
            
        ?>
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
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
}

form {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.searchbar {
    padding: 10px;
    font-size: 16px;
    border: 2px solid #007bff;
    border-radius: 4px 0 0 4px;
    width: 300px;
    outline: none;
    transition: border-color 0.3s;
}

.searchbar:focus {
    border-color: #0056b3;
}

input[type="submit"] {
    padding: 20px 20px;
    font-size: 16px;
    border: none;
    background-color: #007bff;
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #0056b3;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #007bff;
    color: #fff;
}

th.errormsg{
    text-align: center;
    background-color: red;
}

tr:nth-child(even) {
    background-color: #f9f9f9;
}

tr:hover {
    background-color: #f1f1f1;
}

p {
    text-align: center;
    font-size: 18px;
    color: #555;
}


</style>

</body>

</html>