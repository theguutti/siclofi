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
    <link rel="icon" href="favicon.ico" type="../images/siclofi">
    <link rel="stylesheet" href="../css/styleInicial.css">
    <link rel="stylesheet" href="../css/saidas.css">
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
            
            <!-- FORM NEW -->
            <div class="form-box active" id="new-saidaReturn-form">

                <div class="titulo">
                    <label id="titulo">Saída - Devolução</label>
                </div>

                <div class="conteudo"> 

                    <div class="row-items">

                        <div class="field-group">
                            <label class="label">Data</label>
                            <input type="date" name="dataInput" id="data-new" autocomplete="off" placeholder="DD/MM/AA">
                        </div>

                    </div>
                    
                    <div class="row-items">
                        
                        <div class="field-group wide">
                            <label class="label">Fórmula Infantil</label>
                            <select id="fi-new">
                                <option value="Selecione"></option>
                                <?php
                                $stmt = $pdo->query("SELECT numeracao, nome, faixaEtaria FROM formulaInfantil ORDER BY faixaEtaria");
                                while($formula = $stmt->fetch()) {
                                    echo "<option value='{$formula['numeracao']}'>{$formula['nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="field-group wide">
                            <label class="label">Validade</label>
                            <select id="validade-new">
                                <option value="Selecione"></option>
                                <option value=""></option>
                            </select>
                        </div>

                    </div>

                    <div class="row-items">
                        
                        <div class="field-group wide">
                            <label class="label">Lote</label>
                            <select id="lote-new">
                                <option value="Selecione"></option>
                                <option value=""></option>
                            </select>
                        </div>

                        <div class="field-group wide">
                            <label class="label">Quantidade</label>
                            <input type="number" name="qtdeInput" id="qtde-new" autocapitalize="off">
                        </div>

                    </div>

                    <div class="row-items">
                        <div class="field-group">
                            <label class="label">Quantidade em Estoque</label>
                            <input type="number" name="qtdeInput" id="qtdeEstqInput-new" autocapitalize="off" readonly="readonly">
                        </div>
                    </div>

                    <div class="botoes">
                        <div class="row-buttons">
                            <button class="btn" id="voltar" onclick="showForm('search-saidaReturn-form')"> <i class="fa-solid fa-right-left"></i> Consultar </button>
                            <button class="btn" id="adicionar"> <i class="fa-solid fa-floppy-disk"></i> Adicionar </button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- FORM CONSULTAR -->
            <div class="form-box" id="search-saidaReturn-form">

                <div class="titulo">
                    <label id="titulo">Saída - Consultar Devolução</label>
                </div>

                <div class="conteudo">

                    <div class="row-items">

                        <div class="field-group">
                            <label class="label">Fórmula Infantil</label>
                            <select id="fi-search" required>
                                <option value="Selecione"></option>
                                <?php
                                $stmt = $pdo->query("SELECT numeracao, nome, faixaEtaria FROM formulaInfantil ORDER BY faixaEtaria");
                                while($formula = $stmt->fetch()) {
                                    echo "<option value='{$formula['numeracao']}'>{$formula['nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="field-group">
                            <label class="label">Validade</label>
                            <select id="validade-search" required>
                                <option value="Selecione"></option>
                            </select>
                        </div>

                        <div class="field-group">
                            <label class="label">Lote</label>
                            <select id="lote-search" required>
                                <option value="Selecione"></option>
                            </select>
                        </div>

                    </div>
                    
                    <div class="botoes">
                        <div class="row-buttons">
                            <button class="btn" id="voltar" onclick="showForm('new-saidaReturn-form')"> <i class="fa-solid fa-right-left"></i> Adicionar </button>
                            <button class="btn" id="consultar" onclick=""> <i class="fa-solid fa-magnifying-glass"></i> Consultar </button>
                        </div>
                    </div>

                    <hr style="margin: 2vh 0 1vh 0; border: 1px solid #D23737;">

                    <div class="field-group">
                        <label class="label">Resultados</label>

                        <table class="tabelaResultado">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Numeração</th>
                                    <th>Lote</th>
                                    <th>Data de Validade</th>
                                    <th>Data de Entrada</th>
                                    <th>Ação<th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="tipodata"></td>
                                    <td class="numdata"></td>
                                    <td class="lotedata"></td>
                                    <td class="datavalidadedata"></td>
                                    <td class="dataentradadata"></td>
                                    <td class="acao"><button class="btn" id="visualizar" onclick=""></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </main>

    <script src="../js/forms.js"></script>
    <script src="../js/carregarLotes.js"></script>
    <script src="../js/buscarSaidas.js"></script>
    <script>
        // CONFIGURAR EVENTOS PARA O FORM NEW
        document.addEventListener('DOMContentLoaded', function() {
            const fiNew = document.getElementById('fi-new');
            const validadeNew = document.getElementById('validade-new');
            const loteNew = document.getElementById('lote-new');
            
            if (fiNew && validadeNew && loteNew) {
                // EVENTO: SELECIONAR FÓRMULA
                fiNew.addEventListener('change', function() {
                    carregarLotesPorFormula(this.value, validadeNew, loteNew);
                });
                
                // EVENTO: SELECIONAR VALIDADE
                validadeNew.addEventListener('change', function() {
                    carregarLotesPorValidade(this.value, loteNew);
                });
            }
            
            // CONFIGURAR EVENTOS PARA O FORM SEARCH
            const fiSearch = document.getElementById('fi-search');
            const validadeSearch = document.getElementById('validade-search');
            const loteSearch = document.getElementById('lote-search');
            
            if (fiSearch && validadeSearch && loteSearch) {
                fiSearch.addEventListener('change', function() {
                    carregarLotesPorFormula(this.value, validadeSearch, loteSearch);
                });
                
                validadeSearch.addEventListener('change', function() {
                    carregarLotesPorValidade(this.value, loteSearch);
                });
            }
        });
    </script>
        <script>
        document.getElementById('adicionar').addEventListener('click', async function(e) {
            e.preventDefault();
            
            const formData = new FormData();
            formData.append('acao', 'insertSaida');
            formData.append('tipoSaida', 'Devolução'); // Muda para cada página
            formData.append('dataSaida', document.getElementById('data-new').value);
            formData.append('origemSaida', 'Devolução');
            formData.append('lote_id', document.getElementById('lote-new').value);
            formData.append('quantidade', document.getElementById('qtde-new').value);
            
            const resp = await fetch('../ajax/forms.php', { method: 'POST', body: formData });
            const json = await resp.json();
            
            if (json.status === 'sucesso') {
                alert(json.mensagem);
            } else {
                alert('Erro: ' + json.mensagem);
            }
        });
    </script>
    <script>
        document.getElementById('consultar').addEventListener('click', function(e) {
            e.preventDefault();
            const tbody = document.querySelector('.tabelaResultado tbody');
            const tipoSaida = 'Devolução';
            buscarSaidaTabela(
                tipoSaida,
                document.getElementById('fi-search').value,
                document.getElementById('validade-search').value,
                document.getElementById('lote-search').value,
                tbody
            );
        });
    </script>

</body>
</html>
