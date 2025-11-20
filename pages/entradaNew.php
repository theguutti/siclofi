<?php
session_start();
require_once '../functions/auth.php';
verificarLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICLOFI</title>
    <link rel="stylesheet" href="../css/styleInicial.css">
    <link rel="stylesheet" href="../css/entradaNew.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    <nav id="sidebar">
        <div id="sidebar_content">
            <div id="sidebar_title">
                <a href="inicial.php"><p class="title">SICLOFI Operacional</p></a>
            </div>
            <ul id="side_items">

                <li class="side-item">
                    <a href="cadastroBebe.php">
                        <i class="fa-solid fa-user-plus"></i>
                        <span class="item-description">Cadastro de Bebê</span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="registroObito.php">
                        <i class="fa-solid fa-user-xmark"></i>
                        <span class="item-description">Registro de Óbito</span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="ressupMen.php">
                        <i class="fa-solid fa-chart-simple"></i>
                        <span class="item-description">Ressuprimento Mensal</span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="entradaNew.php">
                        <i class="fa-solid fa-plus"></i>
                        <span class="item-description">Entrada - Nova</span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="entradaChng.php">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span class="item-description">Entrada - Consultar/Alterar</span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="saidaReman.php">
                        <i class="fa-solid fa-shuffle"></i>
                        <span class="item-description">Saída - Remanejamento</span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="saidaMaternidade.php">
                        <i class="fa-solid fa-hospital"></i>
                        <span class="item-description">Saída - Maternidade</span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="saidaReturn.php">
                        <i class="fa-solid fa-rotate-left"></i>
                        <span class="item-description">Saída - Devolução</span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="saidaPerda.php">
                        <i class="fa-solid fa-xmark"></i>
                        <span class="item-description">Saída - Perda</span>
                    </a>
                </li>

                <li class="side-item">
                    <a href="gerenRelat.php">
                        <i class="fa-solid fa-book"></i>
                        <span class="item-description">Gerenciador de relatórios</span>
                    </a>
                </li>
            </ul>
        </div>
        <form action="../logout.php" method="post">
            <div id="logout">
                <button type="submit" id="logoutBtn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Sair</span>
                </button>
            </div>
        </form>
    </nav>

    <main>
        <div class="container">
            
            <div class="form-box">

                <div class="titulo">
                    <label id="titulo">Estoque - Entrada Nova</label>
                    <label id="UDM"><?php echo htmlspecialchars($_SESSION['usuario_udm_nome'] ?? 'UDM'); ?></label>
                </div>

                <div class="conteudo">

                    <div class="row-items">

                        <div class="field-group">
                            <label>Tipo de Entrada</label>
                            <select id="tipoEntrada" required>
                                <option value="Selecione"></option>
                                <option value="Recebimento">Recebimento</option>
                                <option value="Remanejamento">Remanejamento</option>
                                <option value="Maternidade">Maternidade</option>
                            </select>
                        </div>

                    </div>

                    <div class="row-items">

                        <div class="field-group">
                            <label>Data de Entrada</label>
                            <input type="date" name="dataEntradaInput" autocomplete="off" id="dataEntrada" required>
                        </div>

                    </div>

                    <div class="row-items">

                        <div class="field-group wide">
                            <label>Origem</label>
                            <select id="origemEntrada" required>
                                <option value="Selecione"></option>
                                <option value="SMSniteroi">SMS - Niterói</option>
                                <option value="SMSrj">SMS - Rio de Janeiro</option>
                                <option value="SMSduquedecaxias">SMS - Duque de Caxias</option>
                                <option value="SMSsaogoncalo">SMS - São Gonçalo</option>
                                <option value="SMSvoltaredonda">SMS - Volta Redonda</option>
                                <option value="SMSpetropolis">SMS - Petrópolis</option>
                                <option value="SMSmangaratiba">SMS - Mangaratiba</option>
                                <option value="SMSangradosreis">SMS - Angra dos Reis</option>
                                <option value="SESrj">SES - Rio de Janeiro</option>
                                <option value="CErj">CE de Atenção Básica do Rio de Janeiro</option>
                                <option value="CMrj">CM de Atenção Básica do Rio de Janeiro</option>
                                <option value="Outro">Outro</option>
                            </select>
                        </div>

                        <div class="field-group wide">
                            <label>Fórmula Infantil</label>
                            <select id="formulaNumeracao" required>
                                <option value="Selecione"></option>
                                <?php
                                $stmt = $pdo->query("SELECT numeracao, nome, faixaEtaria FROM formulaInfantil ORDER BY faixaEtaria");
                                while($formula = $stmt->fetch()) {
                                    echo "<option value='{$formula['numeracao']}'>{$formula['nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                    </div>

                    <div class="row-items">

                        <div class="field-group wide">
                            <label>Data de Validade</label>
                            <input type="date" name="dataValidadeInput" autocomplete="off" id="dataValidade" required></input>
                        </div>

                        <div class="field-group wide">
                            <label>Número do Lote</label>
                            <input type="text" name="numLoteInput" autocomplete="off" id="numLote" required></input>
                        </div>

                    </div>

                    <div class="row-items">

                        <div class="field-group">
                            <label>Quantidade</label>
                            <input type="text" name="qtdeEntradaInput" autocomplete="off" id="qtdeEntrada" required></input>
                        </div>

                    </div>
                    
                    <button class="btn" id="adicionar"><i class="fa-solid fa-plus"></i> Adicionar </button>

            </div>
        </div>

    </main>

    <script src="../js/forms.js"></script>
    <script src="../js/carregarLotes.js"></script>
    <script>
        // GARANTIR QUE O DOM ESTÁ CARREGADO
        document.addEventListener('DOMContentLoaded', function() {
            console.log('JavaScript carregado');
            
            const btnAdicionar = document.getElementById('adicionar');
            const tipoEntrada = document.getElementById('tipoEntrada');
            const origem = document.getElementById('origemEntrada');
            
            // AUTO-SELECIONAR "SES - RJ" QUANDO TIPO FOR "Recebimento"
            if (tipoEntrada && origem) {
                tipoEntrada.addEventListener('change', function() {
                    if (this.value === 'Recebimento') {
                        origem.value = 'SESrj';
                        console.log('Origem auto-selecionada: SES - RJ');
                    }
                });
            }
            
            // CONECTAR BOTÃO ADICIONAR
            if (btnAdicionar) {
                console.log('Botão "Adicionar" encontrado');
                
                btnAdicionar.addEventListener('click', async function(e) {
                    e.preventDefault();
                    console.log('Botão clicado!');
                    
                    try {
                        // COLETAR DADOS
                        const tipoEntrada = document.getElementById('tipoEntrada').value;
                        const dataEntrada = document.getElementById('dataEntrada').value;
                        const origem = document.getElementById('origemEntrada').value;
                        const formulaNumeracao = document.getElementById('formulaNumeracao').value;
                        const dataValidade = document.getElementById('dataValidade').value;
                        const numLote = document.getElementById('numLote').value;
                        const quantidade = document.getElementById('qtdeEntrada').value;
                        
                        console.log('Dados:', {
                            tipoEntrada,
                            dataEntrada,
                            origem,
                            formulaNumeracao,
                            dataValidade,
                            numLote,
                            quantidade
                        });
                        
                        // VALIDAR CAMPOS OBRIGATÓRIOS
                        if (!tipoEntrada || tipoEntrada === 'Selecione') {
                            alert('Selecione o tipo de entrada');
                            return;
                        }
                        
                        if (!dataEntrada) {
                            alert('Informe a data de entrada');
                            return;
                        }
                        
                        if (!origem || origem === 'Selecione') {
                            alert('Selecione a origem');
                            return;
                        }
                        
                        if (!formulaNumeracao || formulaNumeracao === 'Selecione') {
                            alert('Selecione a fórmula infantil');
                            return;
                        }
                        
                        if (!dataValidade) {
                            alert('Informe a data de validade');
                            return;
                        }
                        
                        if (!numLote || numLote.trim() === '') {
                            alert('Informe o número do lote');
                            return;
                        }
                        
                        if (!quantidade || parseInt(quantidade) <= 0) {
                            alert('Informe a quantidade (deve ser maior que zero)');
                            return;
                        }
                        
                        console.log('Validação OK');
                        
                        // PREPARAR DADOS
                        const formData = new FormData();
                        formData.append('acao', 'insertEntrada');
                        formData.append('tipoEntrada', tipoEntrada);
                        formData.append('dataEntrada', dataEntrada);
                        formData.append('origem', origem);
                        formData.append('formulaNumeracao', formulaNumeracao);
                        formData.append('dataValidade', dataValidade);
                        formData.append('numLote', numLote);
                        formData.append('quantidade', quantidade);
                        
                        console.log('Enviando para servidor...');
                        
                        // ENVIAR PARA O SERVIDOR
                        const resp = await fetch('../ajax/forms.php', {
                            method: 'POST',
                            body: formData
                        });
                        
                        console.log('Resposta recebida, status:', resp.status);
                        
                        const json = await resp.json();
                        console.log('JSON:', json);
                        
                        if (json.status === 'sucesso') {
                            alert('Entrada cadastrada com sucesso!');
                            
                            // LIMPAR FORMULÁRIO
                            document.getElementById('tipoEntrada').value = 'Selecione';
                            document.getElementById('dataEntrada').value = '';
                            document.getElementById('origemEntrada').value = 'Selecione';
                            document.getElementById('formulaNumeracao').value = 'Selecione';
                            document.getElementById('dataValidade').value = '';
                            document.getElementById('numLote').value = '';
                            document.getElementById('qtdeEntrada').value = '';
                            
                            console.log('Formulário limpo');
                        } else {
                            alert('Erro: ' + (json.mensagem || 'Erro desconhecido'));
                            console.error('Erro do servidor:', json);
                        }
                        
                    } catch (err) {
                        console.error('Erro ao cadastrar:', err);
                        alert('Erro ao cadastrar entrada. Verifique o console (F12).');
                    }
                });
            } else {
                console.error('Botão "Adicionar" não encontrado!');
            }
        });
    </script>

</body>
</html>
