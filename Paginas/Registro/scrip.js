document.addEventListener('DOMContentLoaded', function () {
  const tipoRegistro = document.getElementById('tipoRegistro');
  const formEmpresa = document.getElementById('formEmpresa');
  const formCandidato = document.getElementById('formCandidato');
  const registroForm = document.getElementById('registroForm');

  tipoRegistro.addEventListener('change', function () {
    if (this.value === 'empresa') {
      formEmpresa.style.display = 'block';
      formCandidato.style.display = 'none';
    } else if (this.value === 'candidato') {
      formEmpresa.style.display = 'none';
      formCandidato.style.display = 'block';
    } else {
      formEmpresa.style.display = 'none';
      formCandidato.style.display = 'none';
    }
  });

  registroForm.addEventListener('submit', function (e) {
    e.preventDefault();

    let isValid = true;

    // Limpar classes de erro
    registroForm.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

    if (!tipoRegistro.value) {
      // Se não escolheu empresa nem candidato
      alert('Por favor, selecione o tipo de registro.');
      isValid = false;
      return;
    }

    if (tipoRegistro.value === 'empresa') {
      // Campos empresa
      const campos = [
        'nomeEmpresa',
        'cnpj',
        'emailEmpresa',
        'senhaEmpresa',
        'confSenhaEmpresa',
      ];

      campos.forEach(id => {
        const campo = document.getElementById(id);
        if (!campo.value.trim()) {
          campo.classList.add('is-invalid');
          isValid = false;
        }
      });

      const senha = document.getElementById('senhaEmpresa');
      const confSenha = document.getElementById('confSenhaEmpresa');

      if (senha.value !== confSenha.value) {
        confSenha.classList.add('is-invalid');
        isValid = false;
      }
    } else if (tipoRegistro.value === 'candidato') {
      // Campos candidato
      const campos = [
        'nomeCandidato',
        'sobrenomeCandidato',
        'emailCandidato',
        'cpf',
        'senhaCandidato',
        'confSenhaCandidato',
      ];

      campos.forEach(id => {
        const campo = document.getElementById(id);
        if (!campo.value.trim()) {
          campo.classList.add('is-invalid');
          isValid = false;
        }
      });

      const senha = document.getElementById('senhaCandidato');
      const confSenha = document.getElementById('confSenhaCandidato');

      if (senha.value !== confSenha.value) {
        confSenha.classList.add('is-invalid');
        isValid = false;
      }
    }

    if (isValid) {
      alert('Formulário válido! Pronto para enviar.');
      registroForm.reset();
      formEmpresa.style.display = 'none';
      formCandidato.style.display = 'none';
    }
  });
   $(document).ready(function() {
    $('#cnpj').mask('00.000.000/0000-00');
  });
});
