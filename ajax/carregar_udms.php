<?php
require_once '../config/conecta.php';

header('Content-Type: application/json; charset=utf-8');

$uf = $_GET['uf'] ?? '';

if (empty($uf)) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'UF não informada']);
    exit;
}

try {
    $stmt = $pdo->prepare("
        SELECT codigo, nome 
        FROM udm 
        WHERE EXISTS (
            SELECT 1 FROM farmaceutico 
            WHERE farmaceutico.udm = udm.codigo 
            AND farmaceutico.uf = ?
        )
        AND ativo = TRUE
        ORDER BY nome
    ");
    $stmt->execute([$uf]);
    $udms = $stmt->fetchAll();
    
    echo json_encode(['sucesso' => true, 'udms' => $udms]);
    
} catch(PDOException $e) {
    echo json_encode(['sucesso' => false, 'mensagem' => 'Erro ao carregar UDMs: ' . $e->getMessage()]);
}
?>
