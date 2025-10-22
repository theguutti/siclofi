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
    <title>Página Inicial</title>
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
                    <a href="configuracoes.php">
                        <i class="fa-solid fa-gear"></i>
                        <span class="item-description">Configurações</span>
                    </a>
                </li>

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
                    <a href="formulaInfantil.php">
                        <i class="fa-solid fa-folder"></i>
                        <span class="item-description">Fórmula Infantil</span>
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
                    <label id="titulo">Registro de Óbito de Bebês</label>
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
                                    <td class="cpfdata">155.631.827-89</td>
                                    <td class="namedata">Íkaro Nogueira Rossotti</td>
                                    <td class="responsaveldata">Aldenísia Helena Nogueira</td>
                                    <td class="nascimentodata">16/04/2007</td>
                                    <td class="acao"><button class="btn" id="visualizar" onclick="">Ver mais</button></td>
                                </tr>
                                <tr>
                                    <td class="cpfdata">999.999.999-99</td>
                                    <td class="namedata">Nome completo muito longo caralho merda ainda pode ser maior essa</td>
                                    <td class="responsaveldata">Nome completo muito longo caralho merda nao é possivel como eu vou</td>
                                    <td class="nascimentodata">99/99/9999</td>
                                    <td class="acao"><button class="btn" id="visualizar" onclick="">Ver mais</button></td>
                                </tr>
                                <tr>
                                    <td class="cpfdata">&nbsp;</td>
                                    <td class="namedata">&nbsp;</td>
                                    <td class="responsaveldata">&nbsp;</td>
                                    <td class="nascimentodata">&nbsp;</td>
                                    <td class="acao"><button class="btn" id="visualizar" onclick="">Ver mais</button></td>
                                </tr>
                                <tr>
                                    <td class="cpfdata">&nbsp;</td>
                                    <td class="namedata">&nbsp;</td>
                                    <td class="responsaveldata">&nbsp;</td>
                                    <td class="nascimentodata">&nbsp;</td>
                                    <td class="acao"><button class="btn" id="visualizar" onclick="">Ver mais</button></td>
                                </tr>
                            </tbody>
                        </table>
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

</body>
</html>
