-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS siclofi;
USE siclofi;

-- Tabela UDM (Unidade de Dispensação de Medicamento)
CREATE TABLE udm (
    codigo INT PRIMARY KEY,
    uf VARCHAR(2) NOT NULL,
    nome VARCHAR(100) NOT NULL,
    endereco VARCHAR(255),
    farmaceuticoResponsavel VARCHAR(11),
    ativo BOOLEAN DEFAULT TRUE,
    estoqueMinimo INT DEFAULT 100
);

-- Tabela Administrador
CREATE TABLE administrador (
    cpf VARCHAR(11) PRIMARY KEY,
    senha VARCHAR(255) NOT NULL
);

-- Tabela Farmacêutico
CREATE TABLE farmaceutico (
    cpf VARCHAR(14) PRIMARY KEY,
    nomeCompleto VARCHAR(255) NOT NULL,
    crf VARCHAR(20) NOT NULL,
    senha VARCHAR(100) NOT NULL,
    udm INT NOT NULL,
    uf VARCHAR(2) NOT NULL,
    especialidade VARCHAR(100),
    cargo_funcao VARCHAR(100),
    dataCadastro DATETIME,
    status ENUM('ativo','inativo') DEFAULT 'ativo',
    FOREIGN KEY (udm) REFERENCES udm(codigo)
);

ALTER TABLE udm 
ADD CONSTRAINT fk_udm_farmaceutico 
FOREIGN KEY (farmaceuticoResponsavel) REFERENCES farmaceutico(cpf);

-- Tabela FormulaInfantil
CREATE TABLE formulaInfantil (
    numeracao INT PRIMARY KEY,
    faixaEtaria INT NOT NULL,
    composicaoNutricional TEXT,
    pesoEmbalagem DECIMAL(6,2),
    quantidadeRecomendadaDia INT, -- por faixa etária
    marca VARCHAR(100),
    nome VARCHAR(255) NOT NULL
);

-- Tabela Bebê HIV
CREATE TABLE bebeHIV (
    cpf VARCHAR(14) PRIMARY KEY,
    nomeCompleto VARCHAR(255) NOT NULL,
    nomeSocial VARCHAR(225),
    dataNascimento DATE NOT NULL,
    dataObito DATE,
    cartaoSUS VARCHAR(20) NOT NULL,
    responsavel VARCHAR(255) NOT NULL,
    formulaInfantilNumeracao INT,
    enderecoResponsavel VARCHAR(255),
    telefoneResponsavel VARCHAR(255),
    cadastradoPor VARCHAR(11),
    dataCadastro DATE,
    horaCadastro TIME,
    statusCadastro ENUM('ativo','inativo_obito','inativo_transferencia') DEFAULT 'ativo',
    FOREIGN KEY (formulaInfantilNumeracao) REFERENCES formulaInfantil(numeracao)
); 

-- Tabela Estoque
CREATE TABLE estoque (
    id INT PRIMARY KEY AUTO_INCREMENT,
    udm INT NOT NULL,
    saldoAnterior INT NOT NULL DEFAULT 0,
    saldoTotal INT NOT NULL DEFAULT 0,
    saldoFinal INT NOT NULL DEFAULT 0,
    FOREIGN KEY (udm) REFERENCES udm(codigo)
);

-- Tabela Lote
CREATE TABLE lote (
    id INT PRIMARY KEY,
    dataValidade DATE NOT NULL,
    dataEntrada DATE NOT NULL,
    dataSaida DATE,
    quantidade INT NOT NULL,
    tipoEntrada VARCHAR(50) NOT NULL,
    tipoSaida VARCHAR(50),
    origemEntrada VARCHAR(50) NOT NULL,
    origemSaida VARCHAR(50),
    formulaInfantilNumeracao INT NOT NULL,
    FOREIGN KEY (formulaInfantilNumeracao) REFERENCES formulaInfantil(numeracao)
);

-- Tabela Estoque-Lote
CREATE TABLE estoque_lote (
    id INT PRIMARY KEY AUTO_INCREMENT,
    estoque_id INT NOT NULL,
    lote_id INT NOT NULL,
    quantidade INT NOT NULL,
    FOREIGN KEY (estoque_id) REFERENCES estoque(id),
    FOREIGN KEY (lote_id) REFERENCES lote(id)
);

-- Tabela Relatório
CREATE TABLE relatorio (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50) NOT NULL,
    dataGeracao DATE NOT NULL,
    geradoPor VARCHAR(255),
    geradoPorCRF VARCHAR(20),
    formato ENUM('PDF','XLSX','CSV'),
    parametrosUtilizados TEXT, -- JSON c/ filtros aplicados
    caminhoArquivo TEXT,
    status ENUM('processando','concluído','erro'),
    udmCodigo INT,
    FOREIGN KEY (udmCodigo) REFERENCES udm(codigo)
);

-- Tabela ConsultaDispensacao
CREATE TABLE consultaDispensacao (
    id INT PRIMARY KEY AUTO_INCREMENT,
    bebeCPF VARCHAR(11) NOT NULL,
    dataDispensacao DATE NOT NULL,
    proximaDispensacao DATE,
    farmaceuticoResponsavel VARCHAR(11) NOT NULL,
    estoque_id INT NOT NULL,
    numeracaoFI INT,
    quantidadeFI INT,
    FOREIGN KEY (bebeCPF) REFERENCES bebeHIV(cpf),
    FOREIGN KEY (farmaceuticoResponsavel) REFERENCES farmaceutico(cpf),
    FOREIGN KEY (estoque_id) REFERENCES estoque(id)
);

-- Tabela Log de Auditoria
CREATE TABLE log_auditoria (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_cpf VARCHAR(11) NOT NULL,
    acao ENUM('INSERT', 'UPDATE', 'DELETE', 'SELECT') NOT NULL,
    tabela_afetada VARCHAR(50) NOT NULL,
    registro_id INT,
    dados_anteriores TEXT,          -- JSON
    dados_novos TEXT,                -- JSON
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    ip_origem VARCHAR(45),
    FOREIGN KEY (usuario_cpf) REFERENCES farmaceutico(cpf)
);

-- Tabela Alertas
CREATE TABLE alertas (
    id INT PRIMARY KEY AUTO_INCREMENT,
    tipo ENUM('VALIDADE_PROXIMA', 'ESTOQUE_BAIXO', 'ESTOQUE_CRITICO') NOT NULL,
    mensagem TEXT NOT NULL,
    lote_id INT,
    udm_codigo INT,
    data_alerta DATETIME DEFAULT CURRENT_TIMESTAMP,
    visualizado BOOLEAN DEFAULT FALSE,
    FOREIGN KEY (lote_id) REFERENCES lote(id),
    FOREIGN KEY (udm_codigo) REFERENCES udm(codigo)
);

CREATE TABLE login_attempts (
    cpf VARCHAR(11) PRIMARY KEY,
    failed_attempts INT DEFAULT 0,
    last_attempt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Adicionar índices para melhor performance
CREATE INDEX idx_bebe_nome ON bebeHIV(nomeCompleto);
CREATE INDEX idx_consulta_data ON consultaDispensacao(dataDispensacao);
CREATE INDEX idx_consulta_bebe ON consultaDispensacao(bebeCPF);
CREATE INDEX idx_estoque_udm ON estoque(udm);

-- Inserir dados iniciais de exemplo
INSERT INTO udm (codigo, nome, endereco, ativo) VALUES
(1, 'UDM Central', 'Rua das Flores, 123', TRUE),
(2, 'UDM Norte', 'Avenida Norte, 456', TRUE);

INSERT INTO farmaceutico (cpf, nomeCompleto, crf, senha, udm, uf) VALUES
('98765432100', 'João', '12345-RJ', '$2y$10$brpU/cS9bA8H2woWLMPFROba/AeIUxRsDEFSYRpXS9ZkyvfJwHFWa', 1, 'RJ'),
('11122233344', 'Maria', '67890-RJ', '$2y$10$brpU/cS9bA8H2woWLMPFROba/AeIUxRsDEFSYRpXS9ZkyvfJwHFWa', 2, 'RJ');

UPDATE udm SET farmaceuticoResponsavel = '98765432100' WHERE codigo = 1;
UPDATE udm SET farmaceuticoResponsavel = '11122233344' WHERE codigo = 2;

INSERT INTO administrador (cpf, senha) VALUES
('12345678901', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO formulaInfantil (numeracao, nome, faixaEtaria, marca) VALUES
(1, 'Fórmula Infantil 0-6 meses', 1, 'Nestlé'), -- 0-6 meses
(2, 'Fórmula Infantil 6-12 meses', 2, 'Nestlé'); -- 6-12 meses

-- Procedimento para verificar disponibilidade de estoque
DELIMITER //
CREATE PROCEDURE VerificarDisponibilidadeEstoque(IN udm_codigo INT, OUT quantidade_disponivel INT)
BEGIN
    SELECT saldoFinal INTO quantidade_disponivel
    FROM estoque 
    WHERE udm = udm_codigo;
END //
DELIMITER ;

-- Procedimento para adicionar quantidade ao estoque (recebimento)
DELIMITER //
CREATE PROCEDURE AdicionarQuantidadeEstoque(
    IN p_udm INT,
    IN p_quantidade_nova INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Atualizar estoque: saldoTotal = saldoAnterior + nova quantidade
    -- saldoFinal também aumenta
    UPDATE estoque 
    SET saldoTotal = saldoAnterior + p_quantidade_nova,
        saldoFinal = saldoFinal + p_quantidade_nova
    WHERE udm = p_udm;
    
    COMMIT;
END //
DELIMITER ;

-- Procedimento para registrar dispensação
DELIMITER //
CREATE PROCEDURE RegistrarDispensacao(
    IN p_bebeCPF VARCHAR(11),
    IN p_dataDispensacao DATE,
    IN p_proximaDispensacao DATE,
    IN p_farmaceutico_cpf VARCHAR(11),
    IN p_estoque_id INT,
    IN p_lote_id INT,
    IN p_quantidade INT
)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- Inserir consulta de dispensação
    INSERT INTO consultaDispensacao (bebeCPF, dataDispensacao, proximaDispensacao, farmaceuticoResponsavel, estoque_id, quantidadeFI)
    VALUES (p_bebeCPF, p_dataDispensacao, p_proximaDispensacao, p_farmaceutico_cpf, p_estoque_id, p_quantidade);
    
    -- Diminuir do saldo final (dispensação)
    UPDATE estoque 
    SET saldoFinal = saldoFinal - p_quantidade
    WHERE id = p_estoque_id AND saldoFinal >= p_quantidade;
    
    UPDATE lote
    SET quantidade = quantidade - p_quantidade
    WHERE id = p_lote_id AND quantidade >= p_quantidade;
    
    IF ROW_COUNT() = 0 THEN
		SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = "Quantidade insuficiente no lote";
	END IF;
    
    COMMIT;
END //
DELIMITER ;

-- Procedimento para virada de mês (saldoFinal vira saldoAnterior)
DELIMITER //
CREATE PROCEDURE ViradaMes()
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        RESIGNAL;
    END;
    
    START TRANSACTION;
    
    -- saldoAnterior = saldoFinal atual
    -- saldoTotal = saldoFinal atual (reset para o novo mês)
    UPDATE estoque 
    SET saldoAnterior = saldoFinal,
        saldoTotal = saldoFinal;
    
    COMMIT;
END //
DELIMITER ;

-- Trigger para alertar produtos com validade < 60 dias
DELIMITER //
CREATE TRIGGER alerta_validade_lote
AFTER INSERT ON lote
FOR EACH ROW
BEGIN
    IF DATEDIFF(NEW.dataValidade, NOW()) < 60 THEN
        -- Inserir em tabela de alertas ou enviar notificação
        INSERT INTO alertas (tipo, mensagem, lote_id, data_alerta)
        VALUES ('VALIDADE_PROXIMA', 
                CONCAT('Lote ', NEW.id, ' vence em menos de 60 dias'), 
                NEW.id, 
                NOW());
    END IF;
END //
DELIMITER ;

-- Trigger para alertar quando estoque atinge nível mínimo
DELIMITER //
CREATE TRIGGER alerta_estoque_minimo
AFTER UPDATE ON estoque
FOR EACH ROW
BEGIN
    DECLARE nivel_minimo INT;
    SELECT estoqueMinimo INTO nivel_minimo FROM udm WHERE codigo = NEW.udm;
    
    IF NEW.saldoFinal < nivel_minimo THEN
        INSERT INTO alertas (tipo, mensagem, udm_codigo, data_alerta)
        VALUES ('ESTOQUE_BAIXO', 
                CONCAT('Estoque da UDM ', NEW.udm, ' abaixo do mínimo'), 
                NEW.udm, 
                NOW());
    END IF;
END //
DELIMITER ;

-- Função de cálculo automático de idade
DELIMITER //
CREATE FUNCTION calcular_idade_completa(data_nasc DATE)
RETURNS VARCHAR(50)
DETERMINISTIC
BEGIN
    DECLARE anos INT;
    DECLARE meses INT;
    DECLARE dias INT;
    
    SET anos = TIMESTAMPDIFF(YEAR, data_nasc, CURDATE());
    SET meses = TIMESTAMPDIFF(MONTH, data_nasc, CURDATE()) % 12;
    SET dias = DATEDIFF(CURDATE(), 
                        DATE_ADD(DATE_ADD(data_nasc, INTERVAL anos YEAR), 
                        INTERVAL meses MONTH));
    
    RETURN CONCAT(anos, ' anos, ', meses, ' meses, ', dias, ' dias');
END //
DELIMITER ;

-- Criar view para relatório de dispensações
CREATE VIEW vw_relatorio_dispensacoes AS
SELECT 
    cd.id,
    cd.dataDispensacao,
    cd.proximaDispensacao,
    p.nomeCompleto as bebe_nome,
    p.cartaoSUS,
    u.nome as udm_nome,
    cd.quantidadeFI as quantidade_dispensada
FROM consultaDispensacao cd
JOIN bebeHIV p ON cd.bebeCPF = p.cpf
JOIN farmaceutico f ON cd.farmaceuticoResponsavel = f.cpf
JOIN estoque e ON cd.estoque_id = e.id
JOIN udm u ON e.udm = u.codigo
ORDER BY cd.dataDispensacao DESC;

-- Criar view para controle de estoque
CREATE VIEW vw_controle_estoque AS
SELECT 
    e.id,
    u.nome as udm_nome,
    e.saldoAnterior,
    e.saldoTotal,
    e.saldoFinal,
    (e.saldoTotal - e.saldoAnterior) as quantidade_recebida_mes,
    (e.saldoAnterior - e.saldoFinal) as quantidade_dispensada_mes
FROM estoque e
JOIN udm u ON e.udm = u.codigo;

COMMIT;

SELECT cpf, LENGTH(cpf) as tamanho, CHAR_LENGTH(cpf) as chars 
FROM bebeHIV 
LIMIT 1;