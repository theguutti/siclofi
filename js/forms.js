// TROCAR O FORM QUE ESTÁ VISÍVEL
function showForm(formId) {
  document.querySelectorAll('.form-box').forEach(f => f.classList.remove('active'));
  const el = document.getElementById(formId);
  if (el) el.classList.add('active');
}

// ALERTA
function showModal(message) {
  const modalMsg = document.getElementById('modalMessage');
  if (modalMsg) modalMsg.textContent = message;
  const modal = document.getElementById('messageModal');
  if (modal) modal.classList.add('active');
}

function closeModal() {
  const modal = document.getElementById('messageModal');
  if (modal) modal.classList.remove('active');
}

// VALIDAÇÃO CONSULTA
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

// AJAX

// CADASTRAR BEBÊ
async function cadastrarBebe() {
  try {
    const cpf = document.getElementById("cpf-new")?.value.trim() ?? "";
    const nomeCompleto = document.getElementById("nomeBebe-new")?.value.trim() ?? "";
    const nomeSocial = document.getElementById("nomeSocialBebe-new")?.value.trim() ?? "";
    const dataNascimento = document.getElementById("dataNascimentoBebe-new")?.value ?? "";
    const cartaoSUS = document.getElementById("cartaoSUSBebe-new")?.value.trim() ?? "";
    const responsavel = document.getElementById("nomeResponsavel-new")?.value.trim() ?? "";
    const enderecoResponsavel = document.getElementById("endereco-new")?.value.trim() ?? "";
    const telefoneResponsavel = document.getElementById("telefone-new")?.value.trim() ?? "";

    if (!cpf || !nomeCompleto  || !responsavel || !dataNascimento) {
      showModal("Preencha CPF, Nome do Bebê, Nome do Responsável e Data de Nascimento antes de salvar.");
      return;
    }

    const formData = new FormData();
    formData.append("acao", "insert");
    formData.append("cpf", cpf);
    formData.append("nomeCompleto", nomeCompleto);
    formData.append("nomeSocial", nomeSocial);
    formData.append("dataNascimento", dataNascimento);
    formData.append("cartaoSUS", cartaoSUS);
    formData.append("responsavel", responsavel);
    formData.append("enderecoResponsavel", enderecoResponsavel);
    formData.append("telefoneResponsavel", telefoneResponsavel);

    const resp = await fetch("../ajax/forms.php", { method: "POST", body: formData });
    const json = await resp.json();

    if (json.status === "sucesso") {
      showModal(json.mensagem);
    } else {
      showModal(json.mensagem || "Erro desconhecido ao cadastrar.");
      console.error("Resposta do servidor:", json);
    }
  } catch (err) {
    console.error(err);
    showModal("Erro na requisição ao cadastrar.");
  }
}

// CONSULTAR BEBÊ
async function consultarBebe() {
    try {
        const nomeInput = document.querySelector('input[name="nomeBebeInput-search"]');
        const cpfInput = document.querySelector('input[name="cpfBebeInput-search"]');
        const tbody = document.querySelector('.tabelaResultado tbody');
        
        if (!nomeInput || !cpfInput || !tbody) {
            console.error('Elementos não encontrados!');
            showModal('Erro ao localizar campos do formulário');
            return;
        }
        
        const nome = nomeInput.value.trim();
        const cpf = cpfInput.value.trim();
        
        // VALIDAÇÃO: PELO MENOS UM CAMPO PREENCHIDO
        if (nome === '' && cpf === '') {
            showModal('Preencha pelo menos um campo (Nome ou CPF) para consultar');
            return;
        }
        
        // BUSCAR E ATUALIZAR TABELA
        await buscarBebeTabela(nome, cpf, tbody);
        
    } catch (err) {
        console.error('Erro:', err);
        showModal('Erro ao realizar consulta');
    }
}
