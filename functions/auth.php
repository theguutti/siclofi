<?php
require_once __DIR__ . '/../config/conecta.php';

function fazerLogin($cpf, $senha, $udm_codigo) {
    global $pdo;
    
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    try {
        // SEARCH FARMACEUTICO (COF, UDM, STATUS)
        $stmt = $pdo->prepare("
            SELECT f.*, u.nome as udm_nome, u.codigo as udm_codigo, f.uf
            FROM farmaceutico f
            INNER JOIN udm u ON f.udm = u.codigo
            WHERE f.cpf = ? 
            AND f.udm = ? 
            AND f.status = 'ativo'
            AND u.ativo = TRUE
        ");
        $stmt->execute([$cpf, $udm_codigo]);
        $usuario = $stmt->fetch();
        
        if (!$usuario) {
            return ['sucesso' => false, 'mensagem' => 'CPF não autorizado para esta UDM ou usuário inativo!'];
        }
        
        if (password_verify($senha, $usuario['senha'])) {
            // LOGIN SUCESSO
            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_cpf'] = $usuario['cpf'];
            $_SESSION['usuario_nome'] = $usuario['nomeCompleto'];
            $_SESSION['usuario_crf'] = $usuario['crf'];
            $_SESSION['usuario_udm'] = $usuario['udm_codigo'];
            $_SESSION['usuario_udm_nome'] = $usuario['udm_nome'];
            $_SESSION['usuario_uf'] = $usuario['uf'];
            
            // LOG SUCESSO
            registrarLog($usuario['cpf'], 'LOGIN', 'Sistema', null, 'Login realizado na UDM ' . $usuario['udm_nome']);
            
            return ['sucesso' => true, 'mensagem' => 'Login realizado com sucesso!'];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Senha incorreta!'];
        }
        
    } catch(PDOException $e) {
        return ['sucesso' => false, 'mensagem' => 'Erro no sistema: ' . $e->getMessage()];
    }
}

function verificarLogin() {
    if (!isset($_SESSION['usuario_logado']) || $_SESSION['usuario_logado'] !== true) {
        header('Location: ../index.php');
        exit();
    }
}

function fazerLogout() {
    if (isset($_SESSION['usuario_cpf'])) {
        registrarLog($_SESSION['usuario_cpf'], 'LOGOUT', 'Sistema', null, 'Logout realizado');
    }
    session_destroy();
    header('Location: index.php');
    exit();
}

function registrarLog($usuario_cpf, $acao, $tabela, $registro_id, $descricao) {
    global $pdo;
    
    try {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'Desconhecido';
        
        $stmt = $pdo->prepare("
            INSERT INTO log_auditoria 
            (usuario_cpf, acao, tabela_afetada, registro_id, dados_novos, ip_origem) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([$usuario_cpf, $acao, $tabela, $registro_id, $descricao, $ip]);
        
    } catch(PDOException $e) {
        error_log("Erro ao registrar log: " . $e->getMessage());
    }
}
?>
