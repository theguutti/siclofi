<?php
require_once '../config/conecta.php';

header('Content-Type: application/json; charset=utf-8');

$formulaNumeracao = $_GET['formulaNumeracao'] ?? '';

if (empty($formulaNumeracao)) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Fórmula não informada']);
    exit;
}

try {
    // BUSCAR LOTES E VALIDADES DA FÓRMULA SELECIONADA
    $stmt = $pdo->prepare("
        SELECT 
            l.id as lote_id,
            l.dataValidade,
            DATE_FORMAT(l.dataValidade, '%d/%m/%Y') as dataValidade_fmt,
            l.quantidade,
            GROUP_CONCAT(DISTINCT l.id ORDER BY l.dataValidade) as lote_numero
        FROM lote l
        WHERE l.formulaInfantilNumeracao = ?
        AND l.quantidade > 0
        GROUP BY l.dataValidade, l.id, l.quantidade
        ORDER BY l.dataValidade ASC
    ");
    $stmt->execute([$formulaNumeracao]);
    $lotes = $stmt->fetchAll();
    
    if (count($lotes) === 0) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Nenhum lote disponível para esta fórmula']);
        exit;
    }
    
    // SEPARAR VALIDADES E LOTES
    $validades = [];
    $lotesPorValidade = [];
    
    foreach($lotes as $lote) {
        $validade = $lote['dataValidade'];
        
        // ADICIONAR VALIDADE (ÚNICA)
        if (!isset($validades[$validade])) {
            $validades[$validade] = [
                'data' => $validade,
                'data_fmt' => $lote['dataValidade_fmt']
            ];
        }
        
        // AGRUPAR LOTES POR VALIDADE
        if (!isset($lotesPorValidade[$validade])) {
            $lotesPorValidade[$validade] = [];
        }
        
        $lotesPorValidade[$validade][] = [
            'lote_id' => $lote['lote_id'],
            'quantidade' => $lote['quantidade']
        ];
    }
    
    echo json_encode([
        'sucesso' => true,
        'validades' => array_values($validades),
        'lotesPorValidade' => $lotesPorValidade
    ]);
    
} catch(PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro: ' . $e->getMessage()]);
}
?>