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
    <link rel="stylesheet" href="../css/entradaNewChng.css">
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
            
            <div class="form-box">

                <div class="titulo">
                    <label id="titulo">Estoque - Consultar Entrada</label>
                    <label id="UDM"><?php echo htmlspecialchars($_SESSION['usuario_udm_nome'] ?? 'UDM'); ?></label>
                </div>

                <div class="conteudo">

                    <div class="row-items"> <!-- TODO: ao selecionar alguma fi, mudar as opcoes de validade e lote -->

                        <div class="field-group">
                            <label class="label">Fórmula Infantil</label>
                            <select id="medicamento" required>
                                <option value="Selecione"></option><?php
                                $stmt = $pdo->query("SELECT numeracao, nome, faixaEtaria FROM formulaInfantil ORDER BY faixaEtaria");
                                while($formula = $stmt->fetch()) {
                                    echo "<option value='{$formula['numeracao']}'>{$formula['nome']}</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="field-group">
                            <label class="label">Validade</label>
                            <select id="validade" required>
                                <option value="Selecione"></option>
                            </select>
                        </div>

                        <div class="field-group">
                            <label class="label">Lote</label>
                            <select id="lote" required>
                                <option value="Selecione"></option>
                            </select>
                        </div>

                    </div>
                
                    <div class="botoes">
                        <button class="btn" id="consultar" onclick=""> <i class="fa-solid fa-magnifying-glass"></i> Consultar </button>
                    </div>
                    
                    <hr style="margin: 2vh 0 1vh 0; border: 1px solid #D23737;">

                    <div class="field-group">
                        <label class="label">Fórmula Infantil</label>

                        <table class="tabelaResultado">
                            <thead>
                                <tr>
                                    <th>Tipo</th>
                                    <th>Lote</th>
                                    <th>Data de Validade</th>
                                    <th>Data de Entrada</th>
                                    <th>Ação<th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="tipodata">Remanejamento</td>
                                    <td class="lotedata">84J3</td>
                                    <td class="datavalidadedata">31/03/2026</td>
                                    <td class="dataentradadata">23/09/2025</td>
                                    <td class="acao"><button class="btn" id="visualizar" onclick="">Ver mais</button></td>
                                </tr>
                                <tr>
                                    <td class="cpfdata">Maternidade</td>
                                    <td class="namedata">90F1</td>
                                    <td class="responsaveldata">09/09/2026</td>
                                    <td class="nascimentodata">16/04/2025</td>
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
    </main>
</body>
</html>
