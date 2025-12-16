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
    
    // ÚLTIMA DISPENSAÇÃO
    $stmt = $pdo->prepare("
        SELECT 
            DATE_FORMAT(dataDispensacao, '%d/%m/%Y') as dataDispensacao_fmt,
            DATE_FORMAT(proximaDispensacao, '%d/%m/%Y') as proximaDispensacao_fmt,
            quantidadeFI,
            numeracaoFI
        FROM consultaDispensacao
        WHERE bebeCPF = ?
        ORDER BY dataDispensacao DESC
        LIMIT 1
    ");
    $stmt->execute([$cpf]);
    $ultimaDispensacao = $stmt->fetch();
    
    echo json_encode([
        'status' => 'sucesso', 
        'dados' => $bebe,
        'ultimaDispensacao' => $ultimaDispensacao ?: null
    ]);
    
} catch(PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro: ' . $e->getMessage()]);
}