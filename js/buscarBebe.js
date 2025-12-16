// FUNÇÃO PARA BUSCAR BEBÊ E ATUALIZAR TABELA
async function buscarBebeTabela(nome, cpf, tbody) {
    try {
        const formData = new FormData();
        formData.append('acao', 'select');
        formData.append('nome', nome);
        formData.append('cpf', cpf);
        
        const resp = await fetch('../ajax/forms.php', { method: 'POST', body: formData });
        const json = await resp.json();
        
        // LIMPAR TABELA
        tbody.innerHTML = '';
        
        if (json.status === 'sucesso' && json.dados.length > 0) {
            // PREENCHER TABELA COM RESULTADOS
            json.dados.forEach(bebe => {
                const tr = document.createElement('tr');
                
                // FORMATAR DATA
                const dataNasc = bebe.dataNascimento ? 
                    new Date(bebe.dataNascimento + 'T00:00:00').toLocaleDateString('pt-BR') : 
                    'N/A';
                
                tr.innerHTML = `
                    <td class="cpfdata">${bebe.cpf || ''}</td>
                    <td class="namedata">${bebe.nomeCompleto || ''}</td>
                    <td class="responsaveldata">${bebe.responsavel || 'Não informado'}</td>
                    <td class="nascimentodata">${dataNasc}</td>
                    <td class="acao">
                        <button class="btn" id="visualizar" onclick="verMaisBebe('${bebe.cpf}')">Ver mais</button>
                    </td>
                `;
                
                tbody.appendChild(tr);
            });
        } else {
            // NENHUM RESULTADO
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                    Nenhum bebê encontrado
                </td>
            `;
            tbody.appendChild(tr);
        }
        
    } catch (err) {
        console.error('Erro ao buscar bebê:', err);
        
        // ERRO NA REQUISIÇÃO
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #D23737;">
                    Erro ao buscar dados
                </td>
            </tr>
        `;
    }
}

// FUNÇÃO PARA BUSCAR BEBÊ COM STATUS INATIVO_OBITO E ATUALIZAR TABELA
async function buscarBebeObitoTabela(nome, cpf, tbody) {
    try {
        const formData = new FormData();
        formData.append('acao', 'selectObito');
        formData.append('nome', nome);
        formData.append('cpf', cpf);
        
        const resp = await fetch('../ajax/forms.php', { method: 'POST', body: formData });
        const json = await resp.json();
        
        // LIMPAR TABELA
        tbody.innerHTML = '';
        
        if (json.status === 'sucesso' && json.dados.length > 0) {
            // PREENCHER TABELA COM RESULTADOS
            json.dados.forEach(bebe => {
                const tr = document.createElement('tr');
                
                // FORMATAR DATA
                const dataNasc = bebe.dataNascimento ? 
                    new Date(bebe.dataNascimento + 'T00:00:00').toLocaleDateString('pt-BR') : 
                    'N/A';
                
                tr.innerHTML = `
                    <td class="cpfdata">${bebe.cpf || ''}</td>
                    <td class="namedata">${bebe.nomeCompleto || ''}</td>
                    <td class="responsaveldata">${bebe.responsavel || 'Não informado'}</td>
                    <td class="nascimentodata">${dataNasc}</td>
                    <td class="acao">
                        <button class="btn" id="visualizar" onclick="verMaisBebe('${bebe.cpf}')">Ver mais</button>
                    </td>
                `;
                
                tbody.appendChild(tr);
            });
        } else {
            // NENHUM RESULTADO
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                    Nenhum bebê encontrado
                </td>
            `;
            tbody.appendChild(tr);
        }
        
    } catch (err) {
        console.error('Erro ao buscar bebê:', err);
        
        // ERRO NA REQUISIÇÃO
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #D23737;">
                    Erro ao buscar dados
                </td>
            </tr>
        `;
    }
}

// FUNÇÃO PLACEHOLDER PARA VER MAIS
let bebeAtualCPF = '';

async function verMaisBebe(cpf) {
    try {
        bebeAtualCPF = cpf;
        
        const resp = await fetch(`../ajax/buscar_bebe_detalhes.php?cpf=${encodeURIComponent(cpf)}`);
        const json = await resp.json();
        
        if (json.status === 'sucesso') {
            const bebe = json.dados;
            const ultima = json.ultimaDispensacao;
            
            // PREENCHE MODAL
            document.getElementById('modal-nome').value = bebe.nomeCompleto || '';
            document.getElementById('modal-nomeSocial').value = bebe.nomeSocial || '';
            document.getElementById('modal-cpf').value = bebe.cpf || '';
            document.getElementById('modal-cartaoSUS').value = bebe.cartaoSUS || '';
            document.getElementById('modal-dataNascimento').value = bebe.dataNascimento || '';
            document.getElementById('modal-responsavel').value = bebe.responsavel || '';
            document.getElementById('modal-endereco').value = bebe.enderecoResponsavel || '';
            document.getElementById('modal-telefone').value = bebe.telefoneResponsavel || '';
            document.getElementById('modal-dataObito').value = bebe.dataObito || '';
            document.getElementById('modal-formulaNumeracao').value = bebe.formulaInfantilNumeracao || '';
            
            // PREENCHE ULTIMA DISPENSACAO
            if (ultima) {
                document.getElementById('modal-ultimaDispensacao').value = ultima.dataDispensacao_fmt || '';
                document.getElementById('modal-ultimaQuantidade').value = ultima.quantidadeFI || '';
                document.getElementById('modal-proximaConsulta').value = ultima.proximaDispensacao_fmt || '';
            } else {
                document.getElementById('modal-ultimaDispensacao').value = 'Nenhuma dispensação registrada';
                document.getElementById('modal-ultimaQuantidade').value = '';
                document.getElementById('modal-proximaConsulta').value = '';
            }
            
            // Abrir modal
            document.getElementById('modalBebeInfo').classList.add('active');
        } else {
            alert('Erro: ' + json.mensagem);
        }
    } catch (err) {
        console.error('Erro ao buscar detalhes:', err);
        alert('Erro ao buscar informações do bebê');
    }
}

function fecharModal() {
    document.getElementById('modalBebeInfo').classList.remove('active');
    document.getElementById('formDispensacao').style.display = 'none';
}

function mostrarFormDispensacao() {
    document.getElementById('formDispensacao').style.display = 'block';
    
    // CARREGA LOTES
    const formulaNumeracao = document.getElementById('modal-formulaNumeracao').value;
    if (formulaNumeracao) {
        const validade = document.getElementById('modal-validade-disp');
        const lote = document.getElementById('modal-lote-disp');
        carregarLotesPorFormula(formulaNumeracao, validade, lote);
    }
}

async function salvarDispensacao() {
    const lote_id = document.getElementById('modal-lote-disp').value;
    const quantidade = document.getElementById('modal-quantidade-disp').value;
    const proximaConsulta = document.getElementById('modal-proximaConsulta-disp').value;
    
    if (!lote_id || lote_id === 'Selecione') {
        alert('Selecione o lote');
        return;
    }
    
    if (!quantidade || parseInt(quantidade) <= 0) {
        alert('Informe a quantidade');
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('cpf', bebeAtualCPF);
        formData.append('lote_id', lote_id);
        formData.append('quantidade', quantidade);
        formData.append('proximaConsulta', proximaConsulta);
        
        const resp = await fetch('../ajax/registrar_dispensacao.php', {
            method: 'POST',
            body: formData
        });
        const json = await resp.json();
        
        if (json.status === 'sucesso') {
            alert(json.mensagem);
            fecharModal();
        } else {
            alert('Erro: ' + json.mensagem);
        }
    } catch (err) {
        console.error('Erro ao salvar:', err);
        alert('Erro ao registrar dispensação');
    }
}

async function salvarObito() {
    const cpf = document.getElementById('modal-cpf').value;
    const dataObito = document.getElementById('modal-dataObito').value;
    
    if (!dataObito) {
        alert('Preencha a data de óbito para salvar');
        return;
    }
    
    try {
        const formData = new FormData();
        formData.append('cpf', cpf);
        formData.append('dataObito', dataObito);
        
        const resp = await fetch('../ajax/registrar_obito.php', {
            method: 'POST',
            body: formData
        });
        const json = await resp.json();
        
        if (json.status === 'sucesso') {
            alert(json.mensagem);
            fecharModal();
            const tbody = document.querySelector('.tabelaResultado tbody');
            if (tbody) {
                tbody.innerHTML = '';
            }
        } else {
            alert('Erro: ' + json.mensagem);
        }
    } catch (err) {
        console.error('Erro ao salvar:', err);
        alert('Erro ao registrar óbito');
    }
}