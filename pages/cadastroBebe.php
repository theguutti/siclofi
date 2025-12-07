<?php
session_start();
require_once '../functions/auth.php';
verificarLogin();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SICLOFI</title>
    <link rel="stylesheet" href="../css/styleInicial.css">
    <link rel="stylesheet" href="../css/cadBeberegObito.css">
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
            
            <!-- FORM PADRAO -->
            <div class="form-box active" id="search-form">

                <div class="titulo">
                    <label id="titulo">Cadastro de Bebê</label>
                </div>

                <div class="conteudo">

                   <div class="field-group">
                        <label>Nome do Bebê</label>
                        <input type="text" name="nomeBebeInput-search" autocomplete="off">
                    </div>

                    <div class="field-group">
                        <label>CPF do Bebê</label>
                        <input type="text" name="cpfBebeInput-search" autocomplete="off" minlength="14" maxlength="14" id="cpf-search">
                    </div>
                        
                    <div class="botoes">
                        <div class="row-buttons">
                            <button class="btn" id="consultar" onclick="consultarBebe()"> <i class="fa-solid fa-magnifying-glass"></i> Consultar </button>
                            <button class="btn" id="adicionar" onclick="showForm('new-form')"> <i class="fa-solid fa-plus"></i> Adicionar </button>
                        </div>
                    </div>

                    <hr style="margin: 2vh 0 1vh 0; border: 1px solid #D23737;">

                    <div class="field-group">
                        <label>Resultados</label>

                        <table class="tabelaResultado">
                            <thead>
                                <tr>
                                    <th>CPF</th>
                                    <th>Nome Completo</th>
                                    <th>Nome do Responsável</th>
                                    <th>Nascimento</th>
                                    <th>Ação<th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="cpfdata"></td>
                                    <td class="namedata"></td>
                                    <td class="responsaveldata"></td>
                                    <td class="nascimentodata"></td>
                                    <td class="acao"><button class="btn" id="visualizar" onclick=""></button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            

            </div>

            <!-- FORM ADICIONAR -->
            <div class="form-box" id="new-form">

                <div class="titulo">
                    <label id="titulo">Cadastro Bebê</label>
                </div>

                <div class="conteudo"> 

                    <div class="row-items">
                        
                        <div class="field-group wide">
                            <label>Nome Completo do Bebê - Civil</label>
                            <input type="text" name="nomeBebeInput-new" autocomplete="off" id="nomeBebe-new" required>
                        </div>

                        <div class="field-group wide">
                            <label>Nome Completo do Responsável</label>
                            <input type="text" name="nomeResponsavelInput-new" autocomplete="off" id="nomeResponsavel-new" required>
                        </div>

                    </div>

                    <div class="row-items">

                        <div class="field-group">
                            <label>CPF</label>
                            <input type="text" name="cpfBebeInput-new" autocomplete="off" minlength="14" maxlength="14" id="cpf-new" required>
                        </div>

                        <div class="field-group">
                            <label>Cartão SUS</label>
                            <input type="text" name="cartaoSUSBebeInput-new" autocomplete="off" minlength="20" maxlength="20" id="cartaoSUSBebe-new" required>
                        </div>

                        <div class="field-group">
                            <label>Data de Nascimento</label>
                            <input type="date" name="dataNascimentoBebeInput-new" autocomplete="off" id="dataNascimentoBebe-new" required>
                        </div>

                        <div class="field-group">
                            <label>Nome Social</label>
                            <input type="text" name="nomeSocialBebeInput-new" autocomplete="off" id="nomeSocialBebe-new">
                        </div>

                    </div>

                    <div class="row-items">
                        
                        <div class="field-group wide">
                            <label>Endereço</label>
                            <input type="text" name="enderecoInput-new" autocomplete="off" id="endereco-new">
                        </div>

                        <div class="field-group wide">
                            <label>Telefone</label>
                            <input type="tel" name="telefoneInput-new" autocomplete="off" id="telefone-new" minlength="13" maxlength="13" pattern="[1-9]{2}-[0-9]{9}">
                        </div>

                    </div>
                    
                    <div class="botoes">
                        <div class="row-buttons">
                            <button class="btn" id="voltar" onclick="showForm('search-form')"> <i class="fa-solid fa-angle-left"></i> Voltar </button>
                            <button class="btn" id="salvar" onclick="cadastrarBebe()"> <i class="fa-solid fa-floppy-disk"></i> Salvar </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-overlay" id="messageModal">
            <div class="modal-box">
                <h3>Atenção</h3>
                <p id="modalMessage"></p>
                <button onclick="closeModal()">OK</button>
            </div>
        </div>
        
</main>

    <script src="../js/cpf.js"></script>
    <script src="../js/tel.js"></script>
    <script src="../js/forms.js"></script>
    <script src="../js/buscarBebe.js"></script>
    <script>
        // EVENTO: BUSCAR AO DIGITAR (ATUALIZAÇÃO AUTOMÁTICA)
        document.addEventListener('DOMContentLoaded', function() {
            const nomeInput = document.querySelector('input[name="nomeBebeInput-search"]');
            const cpfInput = document.querySelector('input[name="cpfBebeInput-search"]');
            const tbody = document.querySelector('.tabelaResultado tbody');
            
            if (nomeInput && cpfInput && tbody) {
                // BUSCAR AO DIGITAR NOME (COM DELAY)
                let timerNome;
                nomeInput.addEventListener('input', function() {
                    clearTimeout(timerNome);
                    const valorNome = this.value.trim();
                    
                    if (valorNome.length >= 3) {
                        timerNome = setTimeout(() => {
                            buscarBebeTabela(valorNome, '', tbody);
                        }, 500); // ESPERA 500ms APÓS PARAR DE DIGITAR
                    } else if (valorNome.length === 0) {
                        // LIMPAR TABELA SE CAMPO FICAR VAZIO
                        tbody.innerHTML = `
                            <tr>
                                <td class="cpfdata">&nbsp;</td>
                                <td class="namedata">&nbsp;</td>
                                <td class="responsaveldata">&nbsp;</td>
                                <td class="nascimentodata">&nbsp;</td>
                                <td class="acao">&nbsp;</td>
                            </tr>
                        `;
                    }
                });
                
                // BUSCAR AO DIGITAR CPF (COM DELAY)
                let timerCPF;
                cpfInput.addEventListener('input', function() {
                    clearTimeout(timerCPF);
                    const valorCPF = this.value.trim();
                    
                    if (valorCPF.length === 14) { // CPF COMPLETO (XXX.XXX.XXX-XX)
                        timerCPF = setTimeout(() => {
                            buscarBebeTabela('', valorCPF, tbody);
                        }, 500);
                    } else if (valorCPF.length === 0) {
                        // LIMPAR TABELA
                        tbody.innerHTML = `
                            <tr>
                                <td class="cpfdata">&nbsp;</td>
                                <td class="namedata">&nbsp;</td>
                                <td class="responsaveldata">&nbsp;</td>
                                <td class="nascimentodata">&nbsp;</td>
                                <td class="acao">&nbsp;</td>
                            </tr>
                        `;
                    }
                });
            }
        });
    </script>

</body>

</html>
