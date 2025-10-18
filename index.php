<?php
require_once 'config/config.php';
require_once 'functions/auth.php';

echo "<!-- DEBUG: Arquivos carregados com sucesso -->";
if (function_exists('fazerLogin')) {
    echo "<!-- DEBUG: Função fazerLogin() existe -->";
} else {
    echo "<!-- DEBUG: ERRO - Função fazerLogin() NÃO existe! -->";
}

// SE LOGADO, REDIRECT
if (isset($_SESSION['usuario_logado']) && $_SESSION['usuario_logado'] === true) {
    header('Location: pages/inicial.php');
    exit();
}

$erro = '';
$sucesso = '';

// PROCESSAR LOGIN
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $uf = $_POST['uf'] ?? '';
    $udm = $_POST['udm'] ?? '';
    $cpf = $_POST['cpf'] ?? '';
    $senha = $_POST['senha'] ?? '';
    
    if (empty($uf) || empty($udm) || empty($cpf) || empty($senha)) {
        $erro = 'Preencha todos os campos!';
    } else {
        $resultado = fazerLogin($cpf, $senha, $udm);
        
        if ($resultado['sucesso']) {
            header('Location: pages/inicial.php');
            exit();
        } else {
            $erro = $resultado['mensagem'];
        }
    }
}

// PROCESSAR REDEFINIÇÃO DE SENHA
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['redefinir'])) {
    $cpf_redef = $_POST['cpf_redef'] ?? '';
    $senha_nova = $_POST['senha_nova'] ?? '';
    $senha_confirma = $_POST['senha_confirma'] ?? '';
    
    if (empty($cpf_redef) || empty($senha_nova) || empty($senha_confirma)) {
        $erro = 'Preencha todos os campos!';
    } elseif ($senha_nova !== $senha_confirma) {
        $erro = 'As senhas não coincidem!';
    } else {
        $sucesso = 'Solicitação de redefinição enviada! Aguarde aprovação do administrador.';
    }
}

// BUSCAR UFs DO BANCO
require_once 'config/conecta.php';
try {
    $stmt = $pdo->query("
        SELECT DISTINCT uf 
        FROM farmaceutico 
        WHERE status = 'ativo'
        ORDER BY uf
    ");
    $ufs = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch(PDOException $e) {
    $ufs = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICLOFI Operacional - Sistema de controle logístico de fórmula infantil</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    
    <div class="container">
        
        <!-- FORMULÁRIO LOGIN -->
        <div class="form-box active" id="login-form">
            <form action="" method="post">
                <img src="images/siclofi.png" alt="SICLOFI Logo">

                <?php if (!empty($erro)): ?>
                    <div class="alert alert-error">
                        <?php echo htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($sucesso)): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($sucesso); ?>
                    </div>
                <?php endif; ?>

                <select class="form-control" name="uf" id="uf" required>
                    <option value="">Selecione a UF</option>
                    <?php foreach($ufs as $uf): ?>
                        <option value="<?php echo htmlspecialchars($uf); ?>" 
                                <?php echo (isset($_POST['uf']) && $_POST['uf'] === $uf) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($uf); ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <select class="form-control" name="udm" id="udm" required disabled>
                    <option value="">Primeiro selecione a UF</option>
                </select><br>
                
                <input type="text" name="cpf" autocomplete="off" minlength="14" maxlength="14" id="cpf" class="form-control" placeholder="CPF" required value="<?php echo htmlspecialchars($_POST['cpf'] ?? ''); ?>"><br> 
                <input type="password" name="senha" autocomplete="off" minlength="6" id="senha" class="form-control" placeholder="Senha" required><br>
                
                <button type="submit" name="login">Entrar</button>

                <a href="#" class="link" onclick="showForm('forgotPassw-form'); return false;">Redefinir senha</a>
            </form>
        </div>
        
        <!-- FORMULÁRIO REDEFINIÇÃO DE SENHA -->
        <div class="form-box" id="forgotPassw-form">
            <form action="" method="post">  
                <img src="images/siclofi.png" alt="SICLOFI Logo">

                <?php if (!empty($erro)): ?>
                    <div class="alert alert-error">
                        <?php echo htmlspecialchars($erro); ?>
                    </div>
                <?php endif; ?>

                <?php if (!empty($sucesso)): ?>
                    <div class="alert alert-success">
                        <?php echo htmlspecialchars($sucesso); ?>
                    </div>
                <?php endif; ?>
                
                <input type="text" name="cpf_redef" autocomplete="off" minlength="14" maxlength="14" id="cpf_redef" class="form-control" placeholder="CPF" required><br>
                <input type="password" name="senha_nova" autocomplete="off" minlength="6" id="senha_nova" class="form-control" placeholder="Nova Senha" required><br>
                <input type="password" name="senha_confirma" autocomplete="off" minlength="6" id="senha_confirma" class="form-control" placeholder="Confirmar Nova Senha" required>
                <br>

                <div class="btn-container">
                    <button type="submit" name="redefinir">Redefinir</button>
                    <button type="button" onclick="showForm('login-form')">Voltar</button>
                </div>

                <p>A solicitação de redefinição de senha pode demorar até 20 dias úteis para ser aceita.</p>
            </form>
        </div>
        
    </div>

    <script src="js/cpf.js"></script>
    <script src="js/forms.js"></script>
    <script>
        document.getElementById('uf').addEventListener('change', function() {
            const uf = this.value;
            const udmSelect = document.getElementById('udm');
            
            if (!uf) {
                udmSelect.innerHTML = '<option value="">Primeiro selecione a UF</option>';
                udmSelect.disabled = true;
                return;
            }
            
            // Mostrar loading
            udmSelect.innerHTML = '<option value="">Carregando...</option>';
            udmSelect.disabled = true;
            
            // REQUISICAO AJAX
            fetch('ajax/carregar_udms.php?uf=' + encodeURIComponent(uf))
                .then(response => response.json())
                .then(data => {
                    if (data.sucesso && data.udms.length > 0) {
                        udmSelect.innerHTML = '<option value="">Selecione a UDM</option>';
                        data.udms.forEach(udm => {
                            const option = document.createElement('option');
                            option.value = udm.codigo;
                            option.textContent = udm.nome;
                            udmSelect.appendChild(option);
                        });
                        udmSelect.disabled = false;
                    } else {
                        udmSelect.innerHTML = '<option value="">Nenhuma UDM encontrada para esta UF</option>';
                    }
                })
                .catch(error => {
                    console.error('Erro ao carregar UDMs:', error);
                    udmSelect.innerHTML = '<option value="">Erro ao carregar UDMs</option>';
                });
        });
    </script>

</body>
</html>
