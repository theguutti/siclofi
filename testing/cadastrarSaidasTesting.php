<?php
// CADASTRAR SAÃDA LOTE - EM ANDAMENTO
elseif ($acao === 'updateSaida') {
    session_start();
    
    if (!isset($_SESSION['usuario_cpf']) || !isset($_SESSION['usuario_udm'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'NÃ£o autorizado']);
        exit;
    }
    
    // RECEBER DADOS
    $tipoSaida = mysqli_real_escape_string($mysqli, $_POST['tipoSaida'] ?? '');
    $dataSaida = mysqli_real_escape_string($mysqli, $_POST['dataSaida'] ?? '');
    $origemSaida = mysqli_real_escape_string($mysqli, $_POST['origemSaida'] ?? '');
    $formulaNumeracao = intval($_POST['formulaNumeracao'] ?? 0);
    $dataValidade = mysqli_real_escape_string($mysqli, $_POST['dataValidade'] ?? '');
    $numLote = mysqli_real_escape_string($mysqli, $_POST['numLote'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);
    
    // VALIDAR
    if ($tipoSaida === '' || $dataSaida === '' || $origemSaida === '' || 
        $formulaNumeracao === 0 || $dataValidade === '' || $numLote === '' || $quantidade <= 0) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha todos os campos obrigatÃ³rios']);
        exit;
    }
    
    // INICIAR TRANSAÃ‡ÃƒO
    $mysqli->begin_transaction();
    
    try {
        // 1. UPDATE LOTE
        $sql_lote = "UPDATE SET dataSaida = '$dataSaida',
            origemSaida = '$origemSaida',
            tipoSaida = '$tipoSaida'
            WHERE numLote = '$numLote'";
        
        if (!$mysqli->query($sql_lote)) {
            throw new Exception('Erro ao inserir lote: ' . $mysqli->error);
        }
        
        $lote_id = $mysqli->insert_id;
        
        // 2. VERIFICAR/ATUALIZAR ESTOQUE
        $udm = $_SESSION['usuario_udm'];
        $sql_check = "SELECT id, saldoFinal FROM estoque WHERE udm = $udm";
        $result = $mysqli->query($sql_check);
        
        if ($result->num_rows > 0) {
            // ATUALIZAR ESTOQUE EXISTENTE
            $estoque = $result->fetch_assoc();
            $estoque_id = $estoque['id'];
            $novo_saldo = $estoque['saldoFinal'] + $quantidade;
            
            $sql_update = "UPDATE estoque SET 
                           saldoTotal = saldoTotal - $quantidade,
                           saldoFinal = $novo_saldo
                           WHERE id = $estoque_id";
            
            if (!$mysqli->query($sql_update)) {
                throw new Exception('Erro ao atualizar estoque: ' . $mysqli->error);
            }
        } else {
            // CRIAR ESTOQUE
            $sql_estoque = "INSERT INTO estoque (udm, saldoAnterior, saldoTotal, saldoFinal)
                            VALUES ($udm, 0, $quantidade, $quantidade)";
            
            if (!$mysqli->query($sql_estoque)) {
                throw new Exception('Erro ao criar estoque: ' . $mysqli->error);
            }
            
            $estoque_id = $mysqli->insert_id;
        }
        
        // 3. VINCULAR LOTE AO ESTOQUE
        $sql_vinculo = "INSERT INTO estoque_lote (estoque_id, lote_id, quantidade)
                        VALUES ($estoque_id, $lote_id, $quantidade)";
        
        if (!$mysqli->query($sql_vinculo)) {
            throw new Exception('Erro ao vincular lote ao estoque: ' . $mysqli->error);
        }
        
        // 4. REGISTRAR LOG
        $cpf = $_SESSION['usuario_cpf'];
        $sql_log = "INSERT INTO log_auditoria (usuario_cpf, acao, tabela_afetada, registro_id, dados_novos)
                    VALUES ('$cpf', 'UPDATE_Saida', 'lote', $lote_id, 
                    'SaÃ­da: $tipoSaida | Origem: $origemSaida | Lote: $numLote')";
        
        $mysqli->query($sql_log);
        
        $mysqli->commit();
        
        echo json_encode([
            'status' => 'sucesso', 
            'mensagem' => 'SaÃ­da cadastrada com sucesso!',
            'lote_id' => $lote_id
        ]);
        
    } catch (Exception $e) {
        $mysqli->rollback();
        echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
    }
    
    exit;
}
?>