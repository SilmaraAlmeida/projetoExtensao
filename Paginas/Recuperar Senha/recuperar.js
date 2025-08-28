 document.getElementById('form-recuperar-senha').addEventListener('submit', function(event) {
      event.preventDefault(); // Impede o envio padrão do formulário

      const emailInput = document.getElementById('email-input');
      const mensagemErro = document.getElementById('mensagem-erro');
      const emailValue = emailInput.value.trim();

      if (emailValue === '') {
        // Se o campo estiver vazio, exibe a mensagem de erro
        mensagemErro.classList.remove('hidden');
      } else {
        // Se o campo estiver preenchido, oculta a mensagem de erro e redireciona
        mensagemErro.classList.add('hidden');
        window.location.href = '../Código de Verificação/codigo.html'; // Redireciona para a nova página
      }
    });