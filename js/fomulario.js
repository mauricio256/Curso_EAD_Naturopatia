// Máscara de CPF
function mascaraCPF(cpf) {
  cpf.value = cpf.value
    .replace(/\D/g, "")
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d)/, "$1.$2")
    .replace(/(\d{3})(\d{1,2})$/, "$1-$2");
}

// Máscara de CEP
function mascaraCEP(cep) {
  cep.value = cep.value
    .replace(/\D/g, "")
    .replace(/(\d{5})(\d)/, "$1-$2");
}

// Máscara de WhatsApp
function mascaraWhatsapp(whatsapp) {
  whatsapp.value = whatsapp.value
    .replace(/\D/g, "")
    .replace(/^(\d{2})(\d)/g, "($1) $2")
    .replace(/(\d{5})(\d{4})$/, "$1-$2");
}

// Buscar endereço no ViaCEP
async function buscarCEP(cep) {
  cep = cep.replace(/\D/g, "");

  if (cep.length !== 8) return;

  try {
    const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
    const data = await response.json();

    if (data.erro) {
      alert("CEP não encontrado!");
      return;
    }

    document.getElementById("endereco").value = data.logradouro || "";
    document.getElementById("cidade").value = data.localidade || "";
    document.getElementById("uf").value = data.uf || "";
  } catch (error) {
    alert("Erro ao buscar CEP. Tente novamente.");
    return;
  }
}

// Validação do formulário
function validarFormulario(e) {
  const nome = document.getElementById("nome");
  const cpf = document.getElementById("cpf");
  const email = document.getElementById("email");
  const password = document.getElementById("password");

  if (nome.value.trim() === "") {
    alert("Por favor, preencha seu nome completo.");
    nome.focus();
    e.preventDefault();
    return false;
  }

  const cpfRegex = /^\d{3}\.\d{3}\.\d{3}-\d{2}$/;
  if (!cpfRegex.test(cpf.value)) {
    alert("CPF inválido! Digite no formato 000.000.000-00");
    cpf.focus();
    e.preventDefault();
    return false;
  }

  const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  if (!emailRegex.test(email.value)) {
    alert("Digite um e-mail válido.");
    email.focus();
    e.preventDefault();
    return false;
  }

  if (password.value.length < 6) {
    alert("A senha deve ter no mínimo 6 caracteres.");
    password.focus();
    e.preventDefault();
    return false;
  }

  return true;
}

// Eventos
document.addEventListener("DOMContentLoaded", () => {
  const form = document.querySelector("form");
  const cpf = document.getElementById("cpf");
  const cep = document.getElementById("cep");
  const whatsapp = document.getElementById("whatsapp");

  cpf.addEventListener("input", () => mascaraCPF(cpf));
  cep.addEventListener("input", () => mascaraCEP(cep));
  cep.addEventListener("blur", () => buscarCEP(cep.value));
  whatsapp.addEventListener("input", () => mascaraWhatsapp(whatsapp));

  form.addEventListener("submit", validarFormulario);
});
