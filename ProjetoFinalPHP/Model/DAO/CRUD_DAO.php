<?php
session_start();
include('conexao.php');

if (!isset($_POST['acao']) || !isset($_POST['tipo'])) {
    $_SESSION['mensagem'] = 'Erro not set!';
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
            $leito = $_POST['leito'] ?? null;
            $medico_id = $_POST['medico_id'] ?? null;
            $stmt = $conexao->prepare("INSERT INTO paciente (cpf, nome, id_medico, leito) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssii", $cpf, $nome, $medico_id, $leito);
        }

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Sucesso!';
        } else {
            $_SESSION['mensagem'] = 'Erro!';
        }
        header('Location: ../../Viewer/telaCRUDadmin.php');
        exit();

    } elseif ($acao === 'atualizar') {
        $cpf_crm = $_POST['cpf_crm'] ?? '';
        $novo_nome = $_POST['novo_dado'] ?? '';
        $coluna = $_POST['coluna'] ?? '';

        if ($tipo === 'medico') {
            if($coluna === 'cpfcrm'){$coluna = "crm";}
            $stmt = $conexao->prepare("UPDATE medico SET ".$coluna." = ? WHERE crm = ?");
            $stmt->bind_param("ss", $novo_nome, $cpf_crm);
        } elseif ($tipo === 'paciente') {
            if($coluna === 'cpfcrm'){$coluna = "cpf";}
            $stmt = $conexao->prepare("UPDATE paciente SET ".$coluna." = ? WHERE cpf = ?");
            $stmt->bind_param("ss", $novo_nome, $cpf_crm);
        }

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $_SESSION['mensagem'] = 'Sucesso!';
        } else {
            $_SESSION['mensagem'] = 'Erro!';
        }
        header('Location: ../../Viewer/telaPesquisaAdmin.php');
        exit();

    } elseif ($acao === 'deletar') {
        $cpf_crm_username = $_POST['cpf_crm_username'] ?? '';

        if ($tipo === 'medico') {
            $stmt = $conexao->prepare("DELETE FROM medico WHERE crm = ?");
            $stmt->bind_param("s", $cpf_crm_username);
        } elseif ($tipo === 'paciente') {
            $stmt = $conexao->prepare("DELETE FROM paciente WHERE cpf = ?");
            $stmt->bind_param("s", $cpf_crm_username);
        } elseif($tipo === 'usuario'){
           $stmt = $conexao->prepare("DELETE FROM usuario WHERE usuario = ?");
        $stmt->bind_param("s", $cpf_crm_username);
         if ($stmt->execute() && $stmt->affected_rows > 0) {
            $_SESSION['mensagem'] = 'Sucesso!';
        } else {
            $_SESSION['mensagem'] = 'Erro!';
        }
        header('Location: ../../Viewer/telaCRUDadmin.php');
        exit();
        }

        if ($stmt->execute() && $stmt->affected_rows > 0) {
            $_SESSION['mensagem'] = 'Sucesso!';
        } else {
            $_SESSION['mensagem'] = 'Erro!';
        }
        header('Location: ../../Viewer/telaPesquisaAdmin.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['mensagem'] = 'Erro!';
}


