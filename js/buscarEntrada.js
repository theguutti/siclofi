// FUNÇÃO PARA BUSCAR ENTRADAS E ATUALIZAR TABELA
async function buscarEntradaTabela(formulaNumeracao, dataValidade, loteId, tbody) {
    try {
        const formData = new FormData();
        formData.append('acao', 'selectEntrada');
        formData.append('formulaNumeracao', formulaNumeracao);
        formData.append('dataValidade', dataValidade);
        formData.append('lote_id', loteId);
        
        const resp = await fetch('../ajax/forms.php', { method: 'POST', body: formData });
        const json = await resp.json();
        
        // LIMPAR TABELA
        tbody.innerHTML = '';
        
        if (json.status === 'sucesso' && json.dados.length > 0) {
            json.dados.forEach(entrada => {
                const tr = document.createElement('tr');
                
                tr.innerHTML = `
                    <td class="tipodata">${entrada.tipo || 'N/A'}</td>
                    <td class="lotedata">#${entrada.lote_id || ''}</td>
                    <td class="datavalidadedata">${entrada.dataValidade_fmt || ''}</td>
                    <td class="dataentradadata">${entrada.dataEntrada_fmt || ''}</td>
                    <td class="acao">
                        <button class="btn" id="visualizar" onclick="verMaisEntrada(${entrada.lote_id})">Ver mais</button>
                    </td>
                `;
                
                tbody.appendChild(tr);
            });
        } else {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                    Nenhuma entrada encontrada
                </td>
            `;
            tbody.appendChild(tr);
        }
        
    } catch (err) {
        console.error('Erro ao buscar entrada:', err);
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
function verMaisEntrada(loteId) {
    alert('Função "Ver Mais" será implementada em breve!\nLote ID: ' + loteId);
}