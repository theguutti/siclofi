<?php
session_start();
require_once '../config/conecta.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_cpf'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Não autorizado']);
    exit;
}

$cpf = $_GET['cpf'] ?? '';

if (empty($cpf)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'CPF não informado']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT 
            cpf,
            nomeCompleto,
            nomeSocial,
            DATE_FORMAT(dataNascimento, '%d/%m/%Y') as dataNascimento_fmt,
            dataNascimento,
            DATE_FORMAT(dataObito, '%d/%m/%Y') as dataObito_fmt,
            dataObito,
            cartaoSUS,
            responsavel,
            enderecoResponsavel,
            telefoneResponsavel,
            formulaInfantilNumeracao,
            statusCadastro
        FROM bebeHIV
        WHERE cpf = ?
    ");
    $stmt->execute([$cpf]);
    $bebe = $stmt->fetch();
    
    if (!$bebe) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Bebê não encontrado']);
        exit;
    }
    
    echo json_encode(['status' => 'sucesso', 'dados' => $bebe]);
    
} catch(PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro: ' . $e->getMessage()]);
}