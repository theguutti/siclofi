<?php
require_once '../config/conecta.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

// VERIFICAR LOGIN
if (!isset($_SESSION['usuario_udm'])) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Não autorizado']);
    exit;
}

$lote_id = $_GET['lote_id'] ?? '';
$udm = $_SESSION['usuario_udm'];

if (empty($lote_id)) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Lote não informado']);
    exit;
}

try {
    // BUSCAR QUANTIDADE DISPONÍVEL DO LOTE NA UDM
    $stmt = $pdo->prepare("
        SELECT 
            l.quantidade as quantidade_lote,
            COALESCE(SUM(el.quantidade), 0) as quantidade_estoque
        FROM lote l
        LEFT JOIN estoque_lote el ON el.lote_id = l.id
        LEFT JOIN estoque e ON e.id = el.estoque_id AND e.udm = ?
        WHERE l.id = ?
        GROUP BY l.quantidade
    ");
    $stmt->execute([$udm, $lote_id]);
    $resultado = $stmt->fetch();
    
    if (!$resultado) {
        echo json_encode(['sucesso' => false, 'mensagem' => 'Lote não encontrado']);
        exit;
    }
    
    echo json_encode([
        'sucesso' => true,
        'quantidade' => $resultado['quantidade_estoque']
    ]);
    
} catch(PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro: ' . $e->getMessage()]);
}
?>