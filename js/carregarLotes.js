// VARIÁVEL GLOBAL PARA ARMAZENAR DADOS DOS LOTES
let dadosLotes = {};

// FUNÇÃO PARA CARREGAR VALIDADES E LOTES AO SELECIONAR FÓRMULA
function carregarLotesPorFormula(formulaNumeracao, selectValidade, selectLote) {
    if (!formulaNumeracao || formulaNumeracao === 'Selecione') {
        selectValidade.innerHTML = '<option value="">Selecione uma fórmula primeiro</option>';
        selectValidade.disabled = true;
        selectLote.innerHTML = '<option value="">Selecione uma validade primeiro</option>';
        selectLote.disabled = true;
        return;
    }
    
    // LOADING
    selectValidade.innerHTML = '<option value="">Carregando...</option>';
    selectValidade.disabled = true;
    selectLote.innerHTML = '<option value="">Aguarde...</option>';
    selectLote.disabled = true;
    
    // REQUISIÇÃO AJAX
    fetch('../ajax/carregar_lotes.php?formulaNumeracao=' + encodeURIComponent(formulaNumeracao))
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                // ARMAZENAR DADOS GLOBALMENTE
                dadosLotes = data.lotesPorValidade;
                
                // PREENCHER SELECT DE VALIDADES
                selectValidade.innerHTML = '<option value="">Selecione a validade</option>';
                data.validades.forEach(val => {
                    const option = document.createElement('option');
                    option.value = val.data;
                    option.textContent = val.data_fmt;
                    selectValidade.appendChild(option);
                });
                selectValidade.disabled = false;
                
                // LIMPAR LOTES
                selectLote.innerHTML = '<option value="">Selecione uma validade primeiro</option>';
                selectLote.disabled = true;
            } else {
                selectValidade.innerHTML = '<option value="">Nenhum lote disponível</option>';
                selectLote.innerHTML = '<option value="">-</option>';
            }
        })
        .catch(error => {
            console.error('Erro ao carregar lotes:', error);
            selectValidade.innerHTML = '<option value="">Erro ao carregar</option>';
            selectLote.innerHTML = '<option value="">Erro ao carregar</option>';
        });
}

// FUNÇÃO PARA CARREGAR LOTES AO SELECIONAR VALIDADE
function carregarLotesPorValidade(dataValidade, selectLote) {
    if (!dataValidade || dataValidade === '') {
        selectLote.innerHTML = '<option value="">Selecione uma validade primeiro</option>';
        selectLote.disabled = true;
        return;
    }
    
    // BUSCAR LOTES DA VALIDADE SELECIONADA
    const lotes = dadosLotes[dataValidade];
    
    if (!lotes || lotes.length === 0) {
        selectLote.innerHTML = '<option value="">Nenhum lote disponível</option>';
        selectLote.disabled = true;
        return;
    }
    
    // PREENCHER SELECT DE LOTES
    selectLote.innerHTML = '<option value="">Selecione o lote</option>';
    lotes.forEach(lote => {
        const option = document.createElement('option');
        option.value = lote.lote_id;
        option.textContent = `Lote #${lote.lote_id} (${lote.quantidade} unid.)`;
        selectLote.appendChild(option);
    });
    selectLote.disabled = false;
}

// FUNÇÃO PARA BUSCAR QUANTIDADE EM ESTOQUE
function buscarQuantidadeEstoque(loteId, inputQuantidade) {
    if (!loteId || loteId === '') {
        inputQuantidade.value = '';
        return;
    }
    
    // REQUISIÇÃO AJAX
    fetch('../ajax/buscar_quantidade_estoque.php?lote_id=' + encodeURIComponent(loteId))
        .then(response => response.json())
        .then(data => {
            if (data.sucesso) {
                inputQuantidade.value = data.quantidade;
            } else {
                inputQuantidade.value = '0';
                console.error('Erro:', data.mensagem);
            }
        })
        .catch(error => {
            console.error('Erro ao buscar quantidade:', error);
            inputQuantidade.value = 'Erro';
        });
}