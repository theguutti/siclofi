<!--
o que é mostrado ao Ver Mais de um bebê é:
nome completo, 👍
cpf, 👍
nome completo do responsavel, 👍
endereco, 👍
telefone, 👍
data de nascimento, 👍
data de obito (se for na pagina de Registro de Obito),
cartao sus, 👍
numeracao da formula infantil,
status do cadastro
    (ativo ou inativo para pagina de Cadastro de Bebe, e inativo (obito) para Registro de Obito),
dados da ultima consulta
    (consultaDispensacao WHERE bebeCPF = bebeHIV(cpf) mais recente),
botao para registrar consulta de dispensacao
    (abre campos de quantidade de formula infantil, lote da formula infantil, tipo de
    saida (consulta de dispensacao na pagina e consultaDispensacao no banco de dados), alem de preencher
    automaticamente a dataDispensacao (banco de dados) com a data e hora atual, farmaceuticoResponsavel
    (banco de dados) com farmaceutico(cpf) logado, bebeCPF com bebeHIV(cpf) com o bebe que estiver
    selecionado e subtrair a quantidade de formula infantil do estoque),
campo para preencher data de obito,
botao para salvar alteracoes e 👍
botao para cancelar. 👍
-->
<?php
?>

<div class="form-box">
    <div class="titulo">
        <label id="titulo">Informações</label>
    </div>

    <div class="conteudo">

        <div class="row-items">
            <div class="field-group wide">
                <label>Nome Completo do Bebê - Civil</label>
                <input type="text" name="nomeBebeInput-info" autocomplete="off" id="nomeBebe-info" disabled>
            </div>

            <div class="field-group wide">
                <label>Nome Completo do Responsável</label>
                <input type="text" name="nomeResponsavelInput-info" autocomplete="off" id="nomeResponsavel-info" disabled>
            </div>
        </div>

        <div class="row-items">
            <div class="field-group">
                <label>CPF</label>
                <input type="text" name="cpfBebeInput-info" autocomplete="off" minlength="14" maxlength="14" id="cpf-info" disabled>
            </div>

            <div class="field-group">
                <label>Cartão SUS</label>
                <input type="text" name="cartaoSUSBebeInput-info" autocomplete="off" minlength="20" maxlength="20" id="cartaoSUSBebe-info" disabled>
            </div>

            <div class="field-group">
                <label>Data de Nascimento</label>
                <input type="date" name="dataNascimentoBebeInput-info" autocomplete="off" id="dataNascimentoBebe-info" disabled>
            </div>

            <div class="field-group">
                <label>Nome Social</label>
                <input type="text" name="nomeSocialBebeInput-info" autocomplete="off" id="nomeSocialBebe-info" disabled>
            </div>
        </div>

        <div class="row-items">
            <div class="field-group wide">
                <label>Endereço</label>
                <input type="text" name="enderecoInput-info" autocomplete="off" id="endereco-info" disabled>
            </div>

            <div class="field-group wide">
                <label>Telefone</label>
                <input type="tel" name="telefoneInput-info" autocomplete="off" id="telefone-info" minlength="13" maxlength="13" pattern="[1-9]{2}-[0-9]{9}" disabled>
            </div>
        </div>

        <div class="botoes">
            <div class="row-buttons">
                <button class="btn" id="voltar" onclick=""> <i class="fa-solid fa-angle-left"></i> Cancelar </button>
                <button class="btn" id="salvar" onclick=""> <i class="fa-solid fa-floppy-disk"></i> Salvar alterações</button>
            </div>
        </div>

    </div>
</div>
