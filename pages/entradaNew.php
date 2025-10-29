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
                    
                    <button class="btn" id="adicionar" onclick=""><i class="fa-solid fa-plus"></i> Adicionar </button>

            </div>
            TODO: AO SELECIONAR "Recebimento", SELECIONA "SES - RJ" AUTOMATICAMENTE
        </div>

    </main>

    <script src="../js/carregarLotes.js"></script>

</body>
</html>
