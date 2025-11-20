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
function verMaisBebe(cpf) {
    alert('Função "Ver Mais" será implementada em breve!\nCPF: ' + cpf);
}
