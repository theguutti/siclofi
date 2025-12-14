<?php
elseif ($acao === 'selectSaida') {
    session_start();
    
    if (!isset($_SESSION['usuario_udm'])) {
        echo json_encode(["status" => "erro", "mensagem" => "Não autorizado."]);
        exit;
    }
    
    $tipoSaida = trim($_POST['tipoSaida'] ?? '');
    $formulaNumeracao = trim($_POST['formulaNumeracao'] ?? '');
    $dataValidade = trim($_POST['dataValidade'] ?? '');
    $lote_id = trim($_POST['lote_id'] ?? '');
    $udm = $_SESSION['usuario_udm'];
    
    // CONSTRUIR WHERE DINAMICAMENTE
    $where = [];
    $params = [];
    $types = "";
    
    // FILTRAR POR SAÃDA
    if (!empty($tipoSaida) && $tipoSaida !== 'Selecione') {
        $where[] = "l.tipoSaida = ?";
        $params[] = intval($tipoSaida);
        $types .= "i";
    }
    
    // FILTRAR POR FÃ“RMULA
    if (!empty($formulaNumeracao) && $formulaNumeracao !== 'Selecione') {
        $where[] = "l.formulaNumeracao = ?";
        $params[] = intval($formulaNumeracao);
        $types .= "i";
    }

    // FILTRAR POR VALIDADE
    if (!empty($dataValidade) && $dataValidade !== 'Selecione') {
        $where[] = "l.dataValidade = ?";
        $params[] = $dataValidade;
        $types .= "s";
    }
    
    // FILTRAR POR LOTE
    if (!empty($lote_id) && $lote_id !== 'Selecione') {
        $where[] = "l.id = ?";
        $params[] = intval($lote_id);
        $types .= "i";
    }
    
    // FILTRAR POR UDM (sempre)
    $where[] = "e.udm = ?";
    $params[] = $udm;
    $types .= "i";
    
    // MONTAR SQL
    $whereClause = count($where) > 0 ? "WHERE " . implode(' AND ', $where) : "";
    
    $sql = "SELECT 
                l.id as lote_id,
                l.tipoSaida as tipoSaida,
                l.formulaNumeracao as formulaNumeracao,
                DATE_FORMAT(l.dataValidade, '%d/%m/%Y') as dataValidade_fmt,
                DATE_FORMAT(l.dataSaida, '%d/%m/%Y') as dataSaida_fmt,
                l.quantidade,
                e.udm
            FROM lote l
            INNER JOIN estoque_lote el ON el.lote_id = l.id
            INNER JOIN estoque e ON e.id = el.estoque_id
            WHERE tipoSaida = ?
            GROUP BY l.id
            ORDER BY l.id DESC
            LIMIT 50";
    
    $stmt = $mysqli->prepare($sql);
    
    if (!$stmt) {
        echo json_encode(["status" => "erro", "mensagem" => "Erro no prepare: " . $mysqli->error]);
        exit;
    }
    
    // BIND PARAMS
    if (count($params) > 0) {
        $refs = [];
        $refs[] = $types;
        
        foreach ($params as $key => $value) {
            $refs[] = &$params[$key];
        }
        
        call_user_func_array([$stmt, 'bind_param'], $refs);
    }
    
    if (!$stmt->execute()) {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao executar: " . $stmt->error]);
        exit;
    }
    
    $res = $stmt->get_result();
    
    $dados = [];
    while ($row = $res->fetch_assoc()) {
        $dados[] = $row;
    }
    
    $stmt->close();
    
    if (count($dados) === 0) {
        echo json_encode([
            "status" => "vazio", 
            "mensagem" => "Nenhuma saída encontrada para esta UDM."
        ]);
    } else {
        echo json_encode([
            "status" => "sucesso", 
            "dados" => $dados
        ]);
    }
    
    exit;
}
?>  