<?php
session_start();
ob_start();
error_reporting(E_ALL);
header('Content-Type: application/json; charset=utf-8');

// TESTE DIRETO (apenas para debug)
if (!isset($_POST['acao'])) {
    $_POST['acao'] = 'selectEntrada';
    $_POST['formulaNumeracao'] = '1';
    $_POST['dataValidade'] = '';
    $_POST['lote_id'] = '';
    $_SESSION['usuario_udm'] = 2;
}

ob_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
header('Content-Type: application/json; charset=utf-8');

$mysqli = new mysqli("localhost", "root", "", "siclofi");
if ($mysqli->connect_errno) {
    echo json_encode(["status" => "erro", "mensagem" => "Falha na conexão com o banco de dados: " . $mysqli->connect_error]);
    exit;
}

$acao = $_POST['acao'] ?? '';

// INSERT
if ($acao === 'insert') {
    $cadastradoPor = $_SESSION['usuario_cpf'] ?? '';

    if ($cadastradoPor === '') {
        echo json_encode(["status" => "erro", "mensagem" => "Usuário não está logado."]);
        exit;
    }

    $cpf = trim($_POST['cpf'] ?? '');
    $nomeCompleto = trim($_POST['nomeCompleto'] ?? '');
    $nomeSocial = trim($_POST['nomeSocial'] ?? '') ?: null;
    $dataNascimento = trim($_POST['dataNascimento'] ?? '');
    $cartaoSUS = trim($_POST['cartaoSUS'] ?? '') ?: null;
    $responsavel = trim($_POST['responsavel'] ?? '') ?: null;
    $enderecoResponsavel = trim($_POST['enderecoResponsavel'] ?? '') ?: null;
    $telefoneResponsavel = trim($_POST['telefoneResponsavel'] ?? '') ?: null;

    if ($cpf === '' || $nomeCompleto === '' ||  $responsavel == '' || $dataNascimento === '') {
        echo json_encode(["status" => "erro", "mensagem" => "CPF, Nome e Data de Nascimento são obrigatórios."]);
        exit;
    }

    // CALC IDADE EM MESES (ANO, MESES, DIAS)
    $dataNascimento_dt = new DateTime($dataNascimento);
    $hoje = new DateTime();

    $anos = $hoje->format('Y') - $dataNascimento_dt->format('Y');
    $meses = $hoje->format('m') - $dataNascimento_dt->format('m');
    $dia = $hoje->format('d') - $dataNascimento_dt->format('d');

    $idadeMeses = $anos * 12 + $meses;
    if ($dia < 0) {
        $idadeMeses -= 1;
    }

    // SELECIONA NUMERACAO FI
    $formulaNumeracao = null;
    $sqlFormula = "SELECT numeracao FROM formulaInfantil 
                WHERE (faixaEtaria = 1 AND ? < 6) 
                    OR (faixaEtaria = 2 AND ? >= 6 AND ? < 12) 
                LIMIT 1";
    $stmtFormula = $mysqli->prepare($sqlFormula);
    if ($stmtFormula) {
        $stmtFormula->bind_param("iii", $idadeMeses, $idadeMeses, $idadeMeses);
        $stmtFormula->execute();
        $resFormula = $stmtFormula->get_result();
        if ($resFormula && $resFormula->num_rows > 0) {
            $formulaNumeracao = $resFormula->fetch_assoc()['numeracao'];
        }
        $stmtFormula->close();
    }

    $dataNascimento_sql = $dataNascimento;
    $dataCadastro = date('Y-m-d');
    $horaCadastro = date('H:i:s');
    $statusCadastro = 'ativo';

    $sql = "INSERT INTO bebeHIV (
                cpf, nomeCompleto, nomeSocial, dataNascimento, cartaoSUS, responsavel, enderecoResponsavel, telefoneResponsavel, formulaInfantilNumeracao, dataCadastro, horaCadastro, statusCadastro, cadastradoPor) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($sql);
    if (!$stmt) {
        echo json_encode(["status" => "erro", "mensagem" => "Erro no prepare: " . $mysqli->error]);
        exit;
    }

    $types = str_repeat("s", 13);
    $values = [
        $cpf,
        $nomeCompleto,
        $nomeSocial ?? "",
        $dataNascimento_sql,
        $cartaoSUS ?? "",
        $responsavel ?? "",
        $enderecoResponsavel ?? "",
        $telefoneResponsavel ?? "",
        $formulaNumeracao ?? "",
        $dataCadastro,
        $horaCadastro,
        $statusCadastro,
        $cadastradoPor
    ];

    $bind_names[] = $types;
    for ($i = 0; $i < count($values); $i++) {
        $bind_name = 'bind' . $i;
        $$bind_name = $values[$i];
        $bind_names[] = &$$bind_name;
    }
    call_user_func_array([$stmt, 'bind_param'], $bind_names);

    if ($stmt->execute()) {
        echo json_encode(["status" => "sucesso", "mensagem" => "Bebê cadastrado com sucesso!"]);
    } else {
        echo json_encode(["status" => "erro", "mensagem" => "Erro ao cadastrar: " . $stmt->error]);
    }

    $stmt->close();
    $mysqli->close();
    exit;
}

// UPDATE
elseif (isset($_POST['action']) && $_POST['action'] == 'update') {
    $cpf = mysqli_real_escape_string($mysqli, $_POST['cpf']);
    $nomeCompleto = mysqli_real_escape_string($mysqli, $_POST['nomeCompleto']);
    $nomeSocial = mysqli_real_escape_string($mysqli, $_POST['nomeSocial']);
    $dataNascimento = mysqli_real_escape_string($mysqli, $_POST['dataNascimento']);
    $cartaoSUS = mysqli_real_escape_string($mysqli, $_POST['cartaoSUS']);
    $responsavel = mysqli_real_escape_string($mysqli, $_POST['responsavel']);
    $telefoneResponsavel = mysqli_real_escape_string($mysqli, $_POST['telefoneResponsavel']);
    $enderecoResponsavel = mysqli_real_escape_string($mysqli, $_POST['enderecoResponsavel']);
    
    $sql = "UPDATE bebeHIV SET 
            nomeCompleto = '$nomeCompleto',
            nomeSocial = '$nomeSocial',
            dataNascimento = '$dataNascimento',
            cartaoSUS = '$cartaoSUS',
            responsavel = '$responsavel',
            telefoneResponsavel = '$telefoneResponsavel',
            enderecoResponsavel = '$enderecoResponsavel'
            WHERE cpf = '$cpf'";
    
    if ($mysqli->query($sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Bebê atualizado com sucesso!']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erro ao atualizar: ' . $mysqli->error]);
    }
    exit;
}

// SELECT
elseif ($acao === 'select') {
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');

    if ($cpf === '' && $nome === '') {
        echo json_encode(["status" => "erro", "mensagem" => "Informe nome ou CPF para consulta."]);
        exit;
    }

    if ($cpf !== '') {
        $sql = "SELECT cpf, nomeCompleto, nomeSocial, DATE_FORMAT(dataNascimento,'%Y-%m-%d') as dataNascimento,
                       cartaoSUS, responsavel, telefoneResponsavel, enderecoResponsavel, dataCadastro, statusCadastro
                FROM bebeHIV WHERE cpf = ? AND statusCadastro = 'ativo' ORDER BY dataCadastro DESC";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $cpf);
    } else {
        $sql = "SELECT cpf, nomeCompleto, nomeSocial, DATE_FORMAT(dataNascimento,'%Y-%m-%d') as dataNascimento,
                       cartaoSUS, responsavel, telefoneResponsavel, enderecoResponsavel, dataCadastro, statusCadastro
                FROM bebeHIV WHERE nomeCompleto LIKE ? AND statusCadastro = 'ativo' ORDER BY dataCadastro DESC";
        $stmt = $mysqli->prepare($sql);
        $like = "%{$nome}%";
        $stmt->bind_param("s", $like);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    $dados = [];
    while ($row = $res->fetch_assoc()) {
        $dados[] = $row;
    }

    if (count($dados) === 0) {
        echo json_encode(["status" => "vazio", "mensagem" => "Nenhum registro encontrado."]);
    } else {
        echo json_encode(["status" => "sucesso", "dados" => $dados]);
    }

    $stmt->close();
    $mysqli->close();
    exit;
}

// SELECT OBITO
elseif ($acao === 'selectObito') {
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');

    if ($cpf === '' && $nome === '') {
        echo json_encode(["status" => "erro", "mensagem" => "Informe nome ou CPF para consulta."]);
        exit;
    }

    if ($cpf !== '') {
        $sql = "SELECT cpf, nomeCompleto, nomeSocial, DATE_FORMAT(dataNascimento,'%Y-%m-%d') as dataNascimento,
                       cartaoSUS, responsavel, telefoneResponsavel, enderecoResponsavel, dataCadastro, statusCadastro
                FROM bebeHIV WHERE cpf = ? AND statusCadastro = 'inativo_obito' ORDER BY dataCadastro DESC";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $cpf);
    } else {
        $sql = "SELECT cpf, nomeCompleto, nomeSocial, DATE_FORMAT(dataNascimento,'%Y-%m-%d') as dataNascimento,
                       cartaoSUS, responsavel, telefoneResponsavel, enderecoResponsavel, dataCadastro, statusCadastro
                FROM bebeHIV WHERE nomeCompleto LIKE ? AND statusCadastro = 'inativo_obito' ORDER BY dataCadastro DESC";
        $stmt = $mysqli->prepare($sql);
        $like = "%{$nome}%";
        $stmt->bind_param("s", $like);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    $dados = [];
    while ($row = $res->fetch_assoc()) {
        $dados[] = $row;
    }

    if (count($dados) === 0) {
        echo json_encode(["status" => "vazio", "mensagem" => "Nenhum registro encontrado."]);
    } else {
        echo json_encode(["status" => "sucesso", "dados" => $dados]);
    }

    $stmt->close();
    $mysqli->close();
    exit;
}

// BUSCAR ENTRADAS (PARA entradaChng.php)
elseif ($acao === 'selectEntrada') {
    if (!isset($_SESSION['usuario_udm'])) {
        echo json_encode(["status" => "erro", "mensagem" => "Não autorizado."]);
        exit;
    }
    
    $formulaNumeracao = trim($_POST['formulaNumeracao'] ?? '');
    $dataValidade = trim($_POST['dataValidade'] ?? '');
    $lote_id = trim($_POST['lote_id'] ?? '');
    $udm = $_SESSION['usuario_udm'];
    
    // CONSTRUIR WHERE DINAMICAMENTE
    $where = [];
    $params = [];
    $types = "";
    
    // FILTRAR POR FÓRMULA
    if (!empty($formulaNumeracao) && $formulaNumeracao !== 'Selecione') {
        $where[] = "l.formulaInfantilNumeracao = ?";
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
                l.formulaInfantilNumeracao as formulaNumeracao,
                DATE_FORMAT(l.dataValidade, '%d/%m/%Y') as dataValidade_fmt,
                DATE_FORMAT(l.dataEntrada, '%d/%m/%Y') as dataEntrada_fmt,
                'Entrada' as tipo,
                l.quantidade,
                e.udm
            FROM lote l
            INNER JOIN estoque_lote el ON el.lote_id = l.id
            INNER JOIN estoque e ON e.id = el.estoque_id
            {$whereClause}
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
            "mensagem" => "Nenhuma entrada encontrada para esta UDM."
        ]);
    } else {
        echo json_encode([
            "status" => "sucesso", 
            "dados" => $dados
        ]);
    }
    
    exit;
}

// CADASTRAR ENTRADA LOTE
elseif ($acao === 'insertEntrada') {
    if (!isset($_SESSION['usuario_cpf']) || !isset($_SESSION['usuario_udm'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Não autorizado']);
        exit;
    }
    
    // RECEBER DADOS
    $tipoEntrada = mysqli_real_escape_string($mysqli, $_POST['tipoEntrada'] ?? '');
    $dataEntrada = mysqli_real_escape_string($mysqli, $_POST['dataEntrada'] ?? '');
    $origem = mysqli_real_escape_string($mysqli, $_POST['origem'] ?? '');
    $formulaNumeracao = intval($_POST['formulaNumeracao'] ?? 0);
    $dataValidade = mysqli_real_escape_string($mysqli, $_POST['dataValidade'] ?? '');
    $numLote = mysqli_real_escape_string($mysqli, $_POST['numLote'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);
    
    // VALIDAR
    if ($tipoEntrada === '' || $dataEntrada === '' || $origem === '' || 
        $formulaNumeracao === 0 || $dataValidade === '' || $numLote === '' || $quantidade <= 0) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha todos os campos obrigatórios']);
        exit;
    }
    
    // INICIAR TRANSAÇÃO
    $mysqli->begin_transaction();
    
    try {
        // 1. INSERIR LOTE
        $sql_lote = "INSERT INTO lote (
            id,
            dataValidade,
            dataEntrada,
            quantidade,
            formulaInfantilNumeracao,
            origemEntrada,
            tipoEntrada
        ) VALUES (
            $numLote,
            '$dataValidade', 
            '$dataEntrada', 
            $quantidade,
            $formulaNumeracao,
            '$origem',
            '$tipoEntrada'
        )";
        
        if (!$mysqli->query($sql_lote)) {
            throw new Exception('Erro ao inserir lote: ' . $mysqli->error);
        }
        
        $lote_id = $numLote;
        
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
                           saldoTotal = saldoTotal + $quantidade,
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
                    VALUES ('$cpf', 'INSERT', 'lote', $lote_id, 
                    'Entrada: $tipoEntrada | Origem: $origem | Lote: $numLote | Qtd: $quantidade')";
        
        $mysqli->query($sql_log);
        
        $mysqli->commit();
        
        echo json_encode([
            'status' => 'sucesso', 
            'mensagem' => 'Entrada cadastrada com sucesso!',
            'lote_id' => $lote_id
        ]);
        
    } catch (Exception $e) {
        $mysqli->rollback();
        echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
    }
    
    exit;
}

// CADASTRAR SAÍDA LOTE
elseif ($acao === 'insertSaida') {
    if (!isset($_SESSION['usuario_cpf']) || !isset($_SESSION['usuario_udm'])) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Não autorizado']);
        exit;
    }
    
    // RECEBER DADOS
    $tipoSaida = mysqli_real_escape_string($mysqli, $_POST['tipoSaida'] ?? '');
    $dataSaida = mysqli_real_escape_string($mysqli, $_POST['dataSaida'] ?? '');
    $origemSaida = mysqli_real_escape_string($mysqli, $_POST['origemSaida'] ?? '');
    $lote_id = intval($_POST['lote_id'] ?? 0);
    $quantidade = intval($_POST['quantidade'] ?? 0);
    $justificativaPerda = mysqli_real_escape_string($mysqli, $_POST['justificativaPerda'] ?? '');
    
    // VALIDAR
    if ($tipoSaida === '' || $dataSaida === '' || $origemSaida === '' || $lote_id === 0 || $quantidade <= 0) {
        echo json_encode(['status' => 'erro', 'mensagem' => 'Preencha todos os campos obrigatórios']);
        exit;
    }
    
    // INICIAR TRANSAÇÃO
    $mysqli->begin_transaction();
    
    try {
        // 1. UPDATE LOTE
        $sql_lote = "UPDATE lote SET 
            dataSaida = '$dataSaida',
            origemSaida = '$origemSaida',
            tipoSaida = '$tipoSaida',
            justificativaPerda = '$justificativaPerda',
            quantidade = quantidade - $quantidade
            WHERE id = $lote_id AND quantidade >= $quantidade";
        
        if (!$mysqli->query($sql_lote) || $mysqli->affected_rows === 0) {
            throw new Exception('Quantidade insuficiente ou lote inválido');
        }
        
        // 2. ATUALIZAR ESTOQUE
        $udm = $_SESSION['usuario_udm'];
        $sql_estoque = "UPDATE estoque e
            INNER JOIN estoque_lote el ON el.estoque_id = e.id
            SET e.saldoTotal = e.saldoTotal - $quantidade,
                e.saldoFinal = e.saldoFinal - $quantidade,
                el.quantidade = el.quantidade - $quantidade
            WHERE el.lote_id = $lote_id AND e.udm = $udm AND e.saldoFinal >= $quantidade";
        
        if (!$mysqli->query($sql_estoque) || $mysqli->affected_rows === 0) {
            throw new Exception('Estoque insuficiente');
        }
        
        // 3. LOG
        $cpf = $_SESSION['usuario_cpf'];
        $dados_log = "Saída: $tipoSaida | Destino: $origemSaida | Lote: $lote_id | Qtd: $quantidade";
        if ($tipoSaida === 'Perda' && $justificativaPerda !== '') {
            $dados_log .= " | Justificativa: $justificativaPerda";
        }
        
        $sql_log = "INSERT INTO log_auditoria (usuario_cpf, acao, tabela_afetada, registro_id, dados_novos)
                    VALUES ('$cpf', 'UPDATE_Saida', 'lote', $lote_id, '$dados_log')";
        $mysqli->query($sql_log);
        
        $mysqli->commit();
        echo json_encode(['status' => 'sucesso', 'mensagem' => 'Saída registrada com sucesso!']);
        
    } catch (Exception $e) {
        $mysqli->rollback();
        echo json_encode(['status' => 'erro', 'mensagem' => $e->getMessage()]);
    }
    
    exit;
}

// BUSCAR SAÍDAS
elseif ($acao === 'selectSaida') {
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

    // FILTRAR POR TIPO SAÍDA
    if (!empty($tipoSaida) && $tipoSaida !== 'Selecione') {
        $where[] = "l.tipoSaida = ?";
        $params[] = $tipoSaida;
        $types .= "s";
    }
    
    // FILTRAR POR FÃ“RMULA
    if (!empty($formulaNumeracao) && $formulaNumeracao !== 'Selecione') {
        $where[] = "l.formulaInfantilNumeracao = ?";
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
                l.formulaInfantilNumeracao as formulaNumeracao,
                DATE_FORMAT(l.dataValidade, '%d/%m/%Y') as dataValidade_fmt,
                DATE_FORMAT(l.dataSaida, '%d/%m/%Y') as dataSaida_fmt,
                l.justificativaPerda,
                l.quantidade,
                e.udm
            FROM lote l
            INNER JOIN estoque_lote el ON el.lote_id = l.id
            INNER JOIN estoque e ON e.id = el.estoque_id
            {$whereClause}
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

else {
    echo json_encode(["status" => "erro", "mensagem" => "Ação inválida."]);
    $mysqli->close();
    ob_end_clean();
    exit;
}
