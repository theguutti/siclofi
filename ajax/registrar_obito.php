<?php
session_start();
require_once '../config/conecta.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_cpf'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Não autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método inválido']);
    exit;
}

$cpf = $_POST['cpf'] ?? '';
$dataObito = $_POST['dataObito'] ?? '';

if (empty($cpf) || empty($dataObito)) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'CPF e data de óbito são obrigatórios']);
    exit;
}

try {
    // VALIDAR SE DATA ÓBITO > DATA DE NASCIMENTO
    $stmt = $pdo->prepare("SELECT dataNascimento FROM bebeHIV WHERE cpf = ?");
    $stmt->execute([$cpf]);
    $bebe = $stmt->fetch();
    
    if (!$bebe) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Bebê não encontrado']);
        exit;
    }
    
    if (strtotime($dataObito) <= strtotime($bebe['dataNascimento'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Data de óbito deve ser posterior à data de nascimento']);
        exit;
    }
    
    // ATUALIZAR BEBÊ
    $stmt = $pdo->prepare("
        UPDATE bebeHIV 
        SET dataObito = ?, statusCadastro = 'inativo_obito'
        WHERE cpf = ?
    ");
    $stmt->execute([$dataObito, $cpf]);
    
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Óbito registrado com sucesso']);
    
} catch(PDOException $e) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro: ' . $e->getMessage()]);
}