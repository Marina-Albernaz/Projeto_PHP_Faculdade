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
            <a href="telaCRUDadmin.php">Gerenciar</a>
            <a href="cadastro.php">Cadastrar</a>
            <a href="../Model/logout.php">Sair</a>
        </nav>
    </header>

    <section>
        <div>
            <form action="telaPesquisaAdmin.php" method="post">
                <input type="text" placeholder="Insira o nome do Paciente ou Médico" name="searchbar" id="searchbar" maxlength="100">
                <input type="submit" name="botao" value="🔍">
                <input type="submit" name="botao" value="🔗">
            </form>
        </div>
        
        <div>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["searchbar"]) && isset($_POST["botao"])) {
    $acao = $_POST["botao"];
    $pesquisa = trim($_POST["searchbar"]);

    include_once("../Model/DAO/conexao.php");
    $pesquisa = mysqli_real_escape_string($conexao, $pesquisa);

   

    if ($acao == "🔍") {
        $query = "
        SELECT nome, cpf, leito FROM paciente WHERE nome LIKE '$pesquisa%'
        UNION
        SELECT nome, crm AS cpf, leito FROM medico WHERE nome LIKE '$pesquisa%'
        ";
        $resultado = mysqli_query($conexao, $query);
        if (mysqli_num_rows($resultado) > 0) {
            echo "<table border='1'>
            <tr>
            <th>Nome</th>
            <th>CPF/CRM</th>
            <th>Leito</th>
            <th>Tipo</th>
            </tr>";
            while ($linha = mysqli_fetch_assoc($resultado)) {
                if (strlen($linha['cpf']) == 14) {
                    $type = "Paciente";
                } else {
                    $type = "Médico";
                }
                echo "<tr>
                <td>{$linha['nome']}</td>
                <td>{$linha['cpf']}</td>";
                if($linha['leito'] != 0){echo "<td>{$linha['leito']}</td>";} else {echo"<td>-</td>";}
                echo "<td>{$type}</td>
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
    } elseif ($acao == "🔗") {
        $query = "
            SELECT p.nome AS paciente_nome, m.nome AS medico_nome
            FROM paciente AS p
            INNER JOIN medico AS m ON p.id_medico = m.id
            WHERE p.nome LIKE '$pesquisa%'
            ";
        $resultado = mysqli_query($conexao, $query);
            if (mysqli_num_rows($resultado) > 0) {
                echo "<table border='1'>
                <tr>
                <th>Paciente</th>
                <th>Médico</th>
                </tr>";
                while ($linha = mysqli_fetch_assoc($resultado)) {
                    echo "<tr>
                    <td>{$linha['paciente_nome']}</td>
                    <td>{$linha['medico_nome']}</td>
                    </tr>";
                }
                echo "</table>";
            } else {
                echo "<table>";
                echo "<tr>";
                echo "<th class='errormsg'>Nenhum paciente encontrado para o critério.</th>";
                echo "</tr>";
                echo "</table>";
            }
            mysqli_close($conexao);

            }
            } else{
                echo"<table>";
                echo"<tr>";
                echo"<th>Selecione 🔍 para Pesquisar CPF/CRM de Pacientes/Médicos!</th>";
                echo"</tr>";
                echo"<tr>";
                echo"<th>Selecione 🔗 para Pesquisar qual o Médico de cada Paciente!</th>";
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

#searchbar {
    padding: 10px;
    font-size: 16px;
    border: 2px solid #007bff;
    border-radius: 4px 0 0 4px;
    width: 300px;
    outline: none;
    transition: border-color 0.3s;
}

#searchbar:focus {
    border-color: #0056b3;
}

input[type="submit"] {
    padding: 10px 20px;
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