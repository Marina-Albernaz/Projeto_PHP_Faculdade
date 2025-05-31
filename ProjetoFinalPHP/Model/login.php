<?php
session_start();
include('DAO/conexao.php');

if (empty($_POST['usuario']) || empty($_POST['senha'])) {
    header('Location: ../index.php');
    exit();
}

$usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);

// Verifica usuário e senha (criptografada com md5)
$query = "SELECT usuario_id, nome, tipo_usuario FROM usuario WHERE usuario = '{$usuario}' AND senha = md5('{$senha}')";

$result = mysqli_query($conexao, $query);

if (mysqli_num_rows($result) == 1) {
    $usuario_bd = mysqli_fetch_assoc($result);

    // Armazena ID e Nome na sessão
    $_SESSION['id_usuario'] = $usuario_bd['usuario_id'];
    $_SESSION['nome_usuario'] = $usuario_bd['nome'];
	$_SESSION['tipo_usuario'] = $usuario_bd['tipo_usuario'];

	if ($_SESSION['tipo_usuario'] == 1) {
    	header('Location: ../Viewer/telaPesquisa.php');
   		exit();
	} else if ($_SESSION['tipo_usuario'] == 2) {
    	header('Location: ../Viewer/telaPesquisaAdmin.php');
    	exit();
	} else {
    	echo "Erro";
	}
} else {
    $_SESSION['nao_autenticado'] = true;
    header('Location: ../index.php');
    exit();
}
?>