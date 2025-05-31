<?php
session_start();
include('conexao.php');

if (!isset($_POST['acao']) || !isset($_POST['tipo'])) {
    $_SESSION['mensagem'] = 'Erro!';
    header('Location: ../../Viewer/telaCRUDadmin.php');
    exit();
}

$acao = $_POST['acao'];
$tipo = $_POST['tipo'];

try {
    if ($acao === 'inserir') {
        $nome = $_POST['nome'] ?? '';

        if ($tipo === 'medico') {
            $crm = $_POST['crm'] ?? '';
            $stmt = $conexao->prepare("INSERT INTO medico (crm, nome) VALUES (?, ?)");
            $stmt->bind_param("ss", $crm, $nome);
        } elseif ($tipo === 'paciente') {
            $cpf = $_POST['cpf'] ?? '';
            $medico_id = $_POST['medico_id'] ?? null;
            $stmt = $conexao->prepare("INSERT INTO paciente (cpf, nome, id_medico) VALUES (?, ?, ?)");
            $stmt->bind_param("ssi", $cpf, $nome, $medico_id);
        }

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Sucesso!';
        } else {
            $_SESSION['mensagem'] = 'Erro!';
        }

    } elseif ($acao === 'atualizar') {
        $cpf_crm = $_POST['cpf_crm'] ?? '';
        $novo_nome = $_POST['novo_nome'] ?? '';

        if ($tipo === 'medico') {
            $stmt = $conexao->prepare("UPDATE medico SET nome = ? WHERE crm = ?");
            $stmt->bind_param("ss", $novo_nome, $cpf_crm);
        } elseif ($tipo === 'paciente') {
            $stmt = $conexao->prepare("UPDATE paciente SET nome = ? WHERE cpf = ?");
            $stmt->bind_param("ss", $novo_nome, $cpf_crm);
        }

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $_SESSION['mensagem'] = 'Sucesso!';
        } else {
            $_SESSION['mensagem'] = 'Erro!';
        }

    } elseif ($acao === 'deletar') {
        $cpf_crm = $_POST['cpf_crm'] ?? '';

        if ($tipo === 'medico') {
            $stmt = $conexao->prepare("DELETE FROM medico WHERE crm = ?");
            $stmt->bind_param("s", $cpf_crm);
        } elseif ($tipo === 'paciente') {
            $stmt = $conexao->prepare("DELETE FROM paciente WHERE cpf = ?");
            $stmt->bind_param("s", $cpf_crm);
        }

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $_SESSION['mensagem'] = 'Sucesso!';
        } else {
            $_SESSION['mensagem'] = 'Erro!';
        }
    }
} catch (Exception $e) {
    $_SESSION['mensagem'] = 'Erro!';
}

header('Location: ../../Viewer/telaCRUDadmin.php');
exit();