
<?php
session_start();
require_once '../Model/DAO/conexao.php'; 
$mensagem = '';
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
}
?>

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
     <?php if (!empty($mensagem)): ?>
    <div class="mensagem <?php echo strtolower(trim($mensagem)) === 'sucesso!' ? 'sucesso' : 'erro'; ?>">
        <?php echo $mensagem; ?>
    </div>
<?php endif; ?>

    <section>
        <div>
            <form action="telaPesquisaAdmin.php" method="post" class="formulario">
                <input type="text" placeholder="Insira o nome do Paciente ou Médico" name="searchbar" id="searchbar" maxlength="100">
                <input type="submit" name="botao" value="🔍">
                <input type="submit" name="botao" value="🔗">
                <input type="submit" name="botao" value="🛠️">
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
            <th>Excluir</th>
            <th>Alterar</th>
            </tr>";
            while ($linha = mysqli_fetch_assoc($resultado)) {
                if (strlen($linha['cpf']) == 14) {
                    $type = "Paciente";
                    $tipo = "paciente";
                } else {
                    $type = "Médico";
                    $tipo = "medico";
                }

                $cpf_crm = trim($linha['cpf']);

                echo "<tr>
                <td>{$linha['nome']}</td>
                <td>{$linha['cpf']}</td>";
                if($linha['leito'] != 0){echo "<td>{$linha['leito']}</td>";} else {echo"<td>-</td>";}
                echo "<td>{$type}</td>
                <td>
                <form action='../Model/DAO/CRUD_DAO.php' method='post' class='formulario'>
                <input type='hidden' value='deletar' name='acao'>
                <input type='hidden' value='{$tipo}' name='tipo'>
                <input type='hidden' value='{$cpf_crm}' name='cpf_crm_username'>
                <input type='submit' value='Excluir' id='del'>
                </form>
                </td>
                <td id='updtd'>
                <form action='../Model/DAO/CRUD_DAO.php' method='post' id='upd'>
                <select name='coluna'>
                <option value='ns'>Selecione</option>
                <option value='nome'>Nome</option>
                <option value='cpfcrm'>CPF/CRM</option>
                ";
                if($tipo === 'paciente'){echo"<option value='leito'>Leito</option>";}
                echo "</select>
                <br>
                <input type='hidden' value='atualizar' name='acao'>
                <input type='hidden' value='{$tipo}' name='tipo'>
                <input type='hidden' value='{$cpf_crm}' name='cpf_crm'>
                <input type='text' placeholder='Dado Novo' name='novo_dado' id='updatetext'>
                <br><br>
                <input type='submit' value='Alterar' id='alt'>
                </form>
                </td>
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

            } elseif($acao="🛠️"){
                echo "<iframe src='telaCRUDadmin.php' height='500vh' width='1000vw' title='Operações'></iframe>";
            }
            } else{
                echo"<table>";
                echo"<tr>";
                echo"<th>Selecione 🔍 para Pesquisar CPF/CRM de Pacientes/Médicos!</th>";
                echo"</tr>";
                echo"<tr>";
                echo"<th>Selecione 🔗 para Pesquisar qual o Médico de cada Paciente!</th>";
                echo"</tr>";
                echo"<tr>";
                echo"<th>Selecione 🛠️ para Inserir, Alterar ou Excluir um Paciente, Médico ou Usuário!</th>";
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

form.formulario {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

form #upd{
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

input[type="submit"]#del {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    background-color:rgb(255, 0, 0);
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]#del:hover {
    background-color:rgb(128, 9, 9);
}

input[type="submit"]#alt {
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    background-color:rgb(255, 183, 0);
    color: #fff;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]#alt:hover {
    background-color:rgb(108, 79, 11);
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

.mensagem {
    margin: 20px auto;
    padding: 20px;
    max-width: 400px;
    border-radius: 8px;
    text-align: center;
    font-size: 20px;
    font-weight: bold;
    border: 2px solid;
    background-color: #f0f8ff;
}

.sucesso {
    color: #28a745;
    border-color: #28a745;
}

.erro {
    color: #dc3545;
    border-color: #dc3545;
}

#updatetext{
    padding: 10px;
    font-size: 16px;
    border: 2px solid rgb(179, 155, 0);
    border-radius: 4px 0 0 4px;
    width: 100px;
    outline: none;
    transition: border-color 0.3s;
    padding-top: 10px;
    margin:10px;
}

#updatetext:focus {
    border-color:rgb(96, 84, 3);
}

select{
   padding: 10px 0px;
    font-size: 16px;
    border: 2px solid rgb(179, 155, 0);
    border-radius: 4px 0 0 4px;
    width: 90px;
    outline: none;
    transition: border-color 0.3s; 
    margin:10px;
}

#updatetext:focus {
    border-color:rgb(96, 84, 3);
}

#updtd{
    display:flex;
    justify-content:center;
    text-align: center

}




</style>

</body>

</html>