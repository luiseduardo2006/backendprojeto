// Função para validação do CPF (dígito verificador)
function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, '');
    if (cpf.length !== 11) return false;
    let soma = 0, resto;
    for (let i = 1; i <= 9; i++) soma += parseInt(cpf.substring(i - 1, i)) * (11 - i);
    resto = (soma * 10) % 11;
    if (resto == 10 || resto == 11) resto = 0;
    if (resto != parseInt(cpf.substring(9, 10))) return false;
    soma = 0;
    for (let i = 1; i <= 10; i++) soma += parseInt(cpf.substring(i - 1, i)) * (12 - i);
    resto = (soma * 10) % 11;
    if (resto == 10 || resto == 11) resto = 0;
    return resto == parseInt(cpf.substring(10, 11));
  }
  
  // Função para buscar o endereço pelo CEP via API
  function buscarCEP() {
    const cep = document.getElementById("cep").value.replace(/\D/g, '');
    if (cep.length !== 8) return;
  
    fetch(`https://viacep.com.br/ws/${cep}/json/`)
      .then(response => response.json())
      .then(data => {
        if (!data.erro) {
          document.getElementById("endereco").value = `${data.logradouro}, ${data.bairro}, ${data.localidade} - ${data.uf}`;
        } else {
          alert("CEP não encontrado.");
        }
      });
  }
  
  // Validação completa do formulário antes de enviar
  function validarFormulario() {
    const nome = document.getElementById("nome").value;
    const cpf = document.getElementById("cpf").value;
    const login = document.getElementById("login").value;
    const senha = document.getElementById("senha").value;
    const confirmar_senha = document.getElementById("confirmar_senha").value;
  
    if (nome.length < 15 || nome.length > 80) {
      alert("O nome deve ter entre 15 e 80 caracteres.");
      return false;
    }
  
    if (!validarCPF(cpf)) {
      alert("CPF inválido.");
      return false;
    }
  
    if (login.length !== 6) {
      alert("O login deve ter exatamente 6 caracteres.");
      return false;
    }
  
    if (senha.length !== 8) {
      alert("A senha deve ter 8 caracteres.");
      return false;
    }
  
    if (senha !== confirmar_senha) {
      alert("As senhas não coincidem.");
      return false;
    }
  
    return true;
  }
  