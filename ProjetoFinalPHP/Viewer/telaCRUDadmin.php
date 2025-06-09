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
    <title>Página de Gerenciamento</title>
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

h1 {
    font-size: 28px;
    margin-bottom: 20px;
    color:rgb(245, 245, 245);
}

form {
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #007bff;
    border-radius: 12px;
    background-color: #ffffff;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    text-align: left;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
    color: #007bff;
}

input[type="text"],
select {
    width: 90%;
    padding: 10px;
    margin-bottom: 15px;
    border: 2px solid #007bff;
    border-radius: 6px;
    font-size: 16px;
}

input[type="submit"],
button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 12px 20px;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px;
}

input[type="submit"]:hover,
button:hover {
    background-color: #0056b3;
}

input[type="number"]{
    width: 20%;
    padding: 10px;
    margin-bottom: 15px;
    border: 2px solid #007bff;
    border-radius: 6px;
    font-size: 16px;
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


</style>
</head>
<body>
    

        <?php if (!empty($mensagem)): ?>
    <div class="mensagem <?php echo strtolower(trim($mensagem)) === 'sucesso!' ? 'sucesso' : 'erro'; ?>">
        <?php echo $mensagem; ?>
    </div>
<?php endif; ?>

    <section>
        <h1>Gerenciar Médicos e Pacientes</h1>
        <h2>Inserir</h2>
        <form action="../Model/DAO/CRUD_DAO.php" method="POST">
            <label>
                Tipo:
                <select name="tipo">
                    <option value="medico">Médico</option>
                    <option value="paciente">Paciente</option>
                </select>
            </label><br><br>

            <div>
                <label>Nome: <input type="text" name="nome"></label><br>
                <label>CRM (para Médico): <input type="text" name="crm"></label><br>
                <label>CPF (para Paciente): <input type="text" name="cpf"></label><br>
                <label>Leito (para Paciente):<br> <input type="number" name="leito"></label><br>
                <label>Médico (para Paciente):
                    <select name="medico_id">
                        <option value="">Selecione</option>
                        <?php
                        $medicos = mysqli_query($conexao, "SELECT id, nome FROM medico");
                        while ($medico = mysqli_fetch_assoc($medicos)) {
                            echo "<option value='{$medico['id']}'>{$medico['nome']}</option>";
                        }
                        ?>
                    </select>
                </label><br>
            </div>

            <input type="hidden" name="acao" value="inserir">
            <input type="submit" value="Inserir">
        </form>

        <h2>Alterar Médico</h2>
        <form action="../Model/DAO/CRUD_DAO.php" method="POST">
            <input type="hidden" name="tipo" value="medico">

            <div>
                <label>Nome: <input type="text" name="nome"></label><br>
                <label>CRM : <input type="text" name="crm"></label><br>
                    <label>
                        Médico a Alterar:
                        <select name="coluna_id">
                        <option value="">Selecione</option>
                        <?php
                        $medicos = mysqli_query($conexao, "SELECT id, nome FROM medico");
                        while ($medico = mysqli_fetch_assoc($medicos)) {
                            echo "<option value='{$medico['id']}'>{$medico['nome']}</option>";
                        }
                        ?>
                    </select>
                </label><br>
            </div>

            <input type="hidden" name="acao" value="atualizarplus">
            <input type="submit" value="Atualizar">
        </form>

        <h2>Alterar Paciente</h2>
        <form action="../Model/DAO/CRUD_DAO.php" method="POST">
            <input type="hidden" name="tipo" value="paciente">

            <div>
                <label><br>
                        Paciente a Alterar:
                        <select name="coluna_id">
                        <option value="">Selecione</option>
                        <?php
                        $pacientes = mysqli_query($conexao, "SELECT id, nome FROM paciente");
                        while ($paciente = mysqli_fetch_assoc($pacientes)) {
                            echo "<option value='{$paciente['id']}'>{$paciente['nome']}</option>";
                        }
                        ?>
                    </select>
                </label><br>                
                <label>Nome: <input type="text" name="nome"></label><br>
                <label>CPF: <input type="text" name="cpf"></label><br>
                <label>Leito:<br> <input type="number" name="leito"></label><br>
                <label>Médico:
                    <select name="medico_id">
                        <option value="">Selecione</option>
                        <?php
                        $medicos = mysqli_query($conexao, "SELECT id, nome FROM medico");
                        while ($medico = mysqli_fetch_assoc($medicos)) {
                            echo "<option value='{$medico['id']}'>{$medico['nome']}</option>";
                        }
                        ?>
                    </select>
                    
            </div>

            <input type="hidden" name="acao" value="atualizarplus">
            <input type="submit" value="Atualizar">
        </form>

        <h2>Deletar Usuario</h2>
        <form action="../Model/DAO/CRUD_DAO.php" method="POST">
            <input type="hidden" value="usuario" name="tipo">
            <label>Nome de Usuário: <input type="text" name="cpf_crm_username"></label><br>
            <input type="hidden" name="acao" value="deletar">
            <input type="submit" value="Deletar">
        </form>
    </section>


</body>
</html>
