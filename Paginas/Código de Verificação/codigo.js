 document.getElementById('form-codigo').addEventListener('submit', function(event) {
      event.preventDefault(); // Impede o envio padrão do formulário

      const codigoInput = document.getElementById('input-codigo');
      const mensagemErro = document.getElementById('mensagem-erro');
      const codigoValue = codigoInput.value.trim();

      if (codigoValue === '') {
        // Se o campo estiver vazio, exibe a mensagem de erro
        mensagemErro.classList.remove('hidden');
      } else {
        // Se o campo estiver preenchido, oculta a mensagem de erro e redireciona
        mensagemErro.classList.add('hidden');
        window.location.href = '../Redefinir Senha/redefinir.html'; // Redireciona para a nova página
      }
    });
