// FUNÃ‡ÃƒO PARA BUSCAR SAIDAS E ATUALIZAR TABELA
async function buscarSaidaTabela(tipoSaida, formulaNumeracao, dataValidade, loteId, tbody) {
    try {
        const formData = new FormData();
        formData.append('acao', 'selectSaida');
        formData.append('tipoSaida', tipoSaida);
        formData.append('formulaNumeracao', formulaNumeracao);
        formData.append('dataValidade', dataValidade);
        formData.append('lote_id', loteId);
        
        const resp = await fetch('../ajax/forms.php', { method: 'POST', body: formData });
        const json = await resp.json();
        
        // LIMPAR TABELA
        tbody.innerHTML = '';
        
        if (json.status === 'sucesso' && json.dados.length > 0) {
            json.dados.forEach(saida => {
                const tr = document.createElement('tr');

                tr.innerHTML = `
                    <td class="tipodata">${saida.tipoSaida || 'N/A'}</td>
                    <td class="numdata">${saida.formulaNumeracao || 'N/A'}</td>
                    <td class="lotedata">#${saida.lote_id || ''}</td>
                    <td class="datavalidadedata">${saida.dataValidade_fmt || ''}</td>
                    <td class="dataentradadata">${saida.dataSaida_fmt || ''}</td>
                    ${saida.justificativaPerda ? `<td class="justificativadata">${saida.justificativaPerda}</td>` : ''}
                    <td class="acao">
                        <button class="btn" id="visualizar" onclick="verMaisEntrada(${saida.lote_id})">Ver mais</button>
                    </td>
                `;
                
                tbody.appendChild(tr);
            });
        } else {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                    Nenhuma saída encontrada
                </td>
            `;
            tbody.appendChild(tr);
        }
        
    } catch (err) {
        console.error('Erro ao buscar saída:', err);
        tbody.innerHTML = `
            <tr>
                <td colspan="5" style="text-align: center; padding: 20px; color: #D23737;">
                    Erro ao buscar dados
                </td>
            </tr>
        `;
    }
}

// FUNÃ‡ÃƒO PLACEHOLDER PARA VER MAIS
function verMaisEntrada(loteId) {
    alert('Função "Ver Mais" será implementada em breve!\nLote ID: ' + loteId);
}