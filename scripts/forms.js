/* TROCAR O FORM QUE ESTÁ VISÍVEL */
function showForm(formId) {
    document.querySelectorAll('.form-box').forEach(form => form.classList.remove('active'));
    document.getElementById(formId).classList.add('active');
}

/* PREENCHER NO MINIMO UM CAMPO */
function showModal(message) {
    document.getElementById('modalMessage').textContent = message;
    document.getElementById('messageModal').classList.add('active');
}

function closeModal() {
    document.getElementById('messageModal').classList.remove('active');
}

function validarConsultaCADASTRO() {    
    const nomeBebe = document.querySelector('input[name="nomeBebeInput-search"]');
    const cpfBebe = document.querySelector('input[name="cpfBebeInput-search"]');
    
    if (!nomeBebe || !cpfBebe) {
        console.error('Elementos não encontrados!');
        return false;
    }
    
    const nomeValue = nomeBebe.value.trim();
    const cpfValue = cpfBebe.value.trim();
    
    if (nomeValue === '' && cpfValue === '') {
        showModal('Preencha pelo menos um dos campos (Nome do Bebê ou CPF do Bebê) para realizar a consulta.');
        return false;
    }
    
    return true;
}