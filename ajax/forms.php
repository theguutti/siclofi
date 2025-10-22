<?php
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
    session_start();
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
            enderecoResponsavel = '$enderecoResponsavel',
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
                FROM bebeHIV WHERE cpf = ? ORDER BY dataCadastro DESC";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("s", $cpf);
    } else {
        $sql = "SELECT cpf, nomeCompleto, nomeSocial, DATE_FORMAT(dataNascimento,'%Y-%m-%d') as dataNascimento,
                       cartaoSUS, responsavel, telefoneResponsavel, enderecoResponsavel, dataCadastro, statusCadastro
                FROM bebeHIV WHERE nomeCompleto LIKE ? ORDER BY dataCadastro DESC";
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


else {
    echo json_encode(["status" => "erro", "mensagem" => "Ação inválida."]);
    $mysqli->close();
    ob_end_clean();
    exit;
}
