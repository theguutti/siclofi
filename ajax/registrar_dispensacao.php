<?php
error_reporting(0);
ini_set('display_errors', 0);
session_start();
require_once '../config/conecta.php';

header('Content-Type: application/json; charset=utf-8');

if (!isset($_SESSION['usuario_cpf']) || !isset($_SESSION['usuario_udm'])) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Não autorizado']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Método inválido']);
    exit;
}

$cpf = $_POST['cpf'] ?? '';
$lote_id = intval($_POST['lote_id'] ?? 0);
$quantidade = intval($_POST['quantidade'] ?? 0);
$proximaConsulta = $_POST['proximaConsulta'] ?? null;

if (empty($cpf) || $lote_id === 0 || $quantidade <= 0) {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha todos os campos obrigatórios']);
    exit;
}

try {
    $pdo->beginTransaction();

    if ($proximaConsulta && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $proximaConsulta)) {
        throw new Exception('Data inválida');
    }
    
    // BUSCA NUMERACAO DE FI PARA BEBE
    $cpf = preg_replace('/[^0-9]/', '', $cpf);

    // Verificar se CPF tem 11 dígitos
    if (strlen($cpf) !== 11) {
        throw new Exception("CPF inválido: deve ter 11 dígitos (recebido: " . strlen($cpf) . ")");
    }
    
    $stmt = $pdo->prepare("
        SELECT cpf, formulaInfantilNumeracao, statusCadastro 
        FROM bebeHIV 
        WHERE REPLACE(REPLACE(REPLACE(cpf, '.', ''), '-', ''), ' ', '') = ?
    ");
    $stmt->execute([$cpf]);
    $bebe = $stmt->fetch();

    if (!$bebe) {
        throw new Exception('Bebê não encontrado no sistema');
    }

    if ($bebe['statusCadastro'] !== 'ativo') {
        throw new Exception('Bebê não está com status ativo');
    }

    $cpf = $bebe['cpf'];
    
    if (!$bebe) {
        throw new Exception('Bebê não encontrado');
    }
    
    $numeracaoFI = $bebe['formulaInfantilNumeracao'];
    
    // BUSCA ESTOQUE_ID
    $udm = $_SESSION['usuario_udm'];
    $stmt = $pdo->prepare("SELECT id FROM estoque WHERE udm = ?");
    $stmt->execute([$udm]);
    $estoque = $stmt->fetch();
    
    if (!$estoque) {
        throw new Exception('Estoque não encontrado para esta UDM');
    }
    
    $estoque_id = $estoque['id'];
    
    // VERIFICA SE HÁ SUFICIENTE
    $stmt = $pdo->prepare("SELECT quantidade FROM lote WHERE id = ?");
    $stmt->execute([$lote_id]);
    $lote = $stmt->fetch();
    
    if (!$lote || $lote['quantidade'] < $quantidade) {
        throw new Exception('Quantidade insuficiente no lote');
    }
    
    // INSERIR
    $dataDispensacao = date('Y-m-d');
    $farmaceutico = $_SESSION['usuario_cpf'];
    
    $stmt = $pdo->prepare("
        INSERT INTO consultaDispensacao 
        (bebeCPF, dataDispensacao, proximaDispensacao, farmaceuticoResponsavel, estoque_id, numeracaoFI, quantidadeFI)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $cpf,
        $dataDispensacao,
        $proximaConsulta ?: null,
        $farmaceutico,
        $estoque_id,
        $numeracaoFI,
        $quantidade
    ]);
    
    // ATUALIZA LOTE
    $stmt = $pdo->prepare("UPDATE lote SET quantidade = quantidade - ? WHERE id = ?");
    $stmt->execute([$quantidade, $lote_id]);
    
    // ATUALIZA ESTOQUE
    $stmt = $pdo->prepare("
        UPDATE estoque SET 
            saldoTotal = saldoTotal - ?,
            saldoFinal = saldoFinal - ?
        WHERE id = ?
    ");
    $stmt->execute([$quantidade, $quantidade, $estoque_id]);
    
    // ATUALIZA ESTOQUE_LOTE
    $stmt = $pdo->prepare("
        UPDATE estoque_lote SET quantidade = quantidade - ?
        WHERE estoque_id = ? AND lote_id = ?
    ");
    $stmt->execute([$quantidade, $estoque_id, $lote_id]);
    
    // LOG
    $stmt = $pdo->prepare("
        INSERT INTO log_auditoria (usuario_cpf, acao, tabela_afetada, registro_id, dados_novos)
        VALUES (?, 'INSERT', 'consultaDispensacao', ?, ?)
    ");
    $stmt->execute([
        $farmaceutico,
        $pdo->lastInsertId(),
        "Dispensação: CPF $cpf | Qtd: $quantidade | Lote: $lote_id"
    ]);
    
    $pdo->commit();
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Dispensação registrada com sucesso!']);
    
} catch (Exception $e) {
    $pdo->rollback();
    echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
}