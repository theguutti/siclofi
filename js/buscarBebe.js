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
async function verMaisBebe(cpf) {
    try {
        const resp = await fetch(`../ajax/buscar_bebe_detalhes.php?cpf=${encodeURIComponent(cpf)}`);
        const json = await resp.json();
        
        if (json.status === 'sucesso') {
            const bebe = json.dados;
            
            // PREENCHER MODAL
            document.getElementById('modal-nome').value = bebe.nomeCompleto || '';
            document.getElementById('modal-nomeSocial').value = bebe.nomeSocial || '';
            document.getElementById('modal-cpf').value = bebe.cpf || '';
            document.getElementById('modal-cartaoSUS').value = bebe.cartaoSUS || '';
            document.getElementById('modal-dataNascimento').value = bebe.dataNascimento || '';
            document.getElementById('modal-responsavel').value = bebe.responsavel || '';
            document.getElementById('modal-endereco').value = bebe.enderecoResponsavel || '';
            document.getElementById('modal-telefone').value = bebe.telefoneResponsavel || '';
            document.getElementById('modal-dataObito').value = bebe.dataObito || '';
            
            // ABRIR MODAL
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
            // RECARREGAR TABELA
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
