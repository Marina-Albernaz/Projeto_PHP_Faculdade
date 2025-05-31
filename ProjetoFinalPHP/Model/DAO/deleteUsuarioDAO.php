<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id_usuario"])) {
    $id = intval($_POST["id_usuario"]);

    require_once("conexao.php"); 

    $sql = "DELETE FROM usuario WHERE usuario_id = ?";
    $stmt = $conexao->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            session_destroy();
            header("Location: ../../index.php");
            exit();
        } else {
            echo "Erro ao excluir usuário.";
        }
        $stmt->close();
    } else {
        echo "Erro na preparação da consulta.";
    }

    $conexao->close();
} else {
    echo "Requisição inválida.";
}
?>