<?php
session_start();
include("conexao.php");

$nome = mysqli_real_escape_string($conexao, trim($_POST['nome']));//trim serve para tirar o espaço do inicio e fim da string//

$usuario = mysqli_real_escape_string($conexao, trim($_POST['usuario']));
//função MD5 para criptografar a senha//

$senha = mysqli_real_escape_string($conexao, trim(md5($_POST['senha'])));
$tipo = mysqli_real_escape_string($conexao, trim($_POST['tipo']));

$sql = "select count(*) as total from usuario where usuario = '$usuario'";
$result = mysqli_query($conexao, $sql);
$row = mysqli_fetch_assoc($result);

if($row['total'] == 1) {
	$_SESSION['usuario_existe'] = true;
	header('Location: cadastro.php');
	exit;
}

$sql = "INSERT INTO usuario (nome, usuario, senha, data_cadastro, tipo_usuario) VALUES ('$nome', '$usuario', '$senha', NOW(), {$tipo})";

if($conexao->query($sql) === TRUE) {
	$_SESSION['status_cadastro'] = true;
}

$conexao->close();

header('Location: ../../Viewer/cadastro.php');
exit;
?>