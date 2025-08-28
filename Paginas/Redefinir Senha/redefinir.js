const form = document.getElementById('form-senha');
    const senhaInput = document.getElementById('senha');
    const confirmarSenhaInput = document.getElementById('confirmar-senha');
    const mensagemErro = document.getElementById('mensagem-erro');

    form.addEventListener('submit', function(event) {
        // Previne o envio padrão do formulário
        event.preventDefault();

        // Obtém os valores dos campos
        const senha = senhaInput.value;
        const confirmarSenha = confirmarSenhaInput.value;

        // Verifica se as senhas são iguais
        if (senha === confirmarSenha) {
            // Se forem iguais, oculta a mensagem de erro e envia o formulário (aqui você faria a lógica de envio real)
            mensagemErro.classList.add('hidden');
            alert('Senhas conferem! Formulário foi enviado.'); // Substitua por sua lógica de envio
            // form.submit(); // Use esta linha para enviar o formulário
        } else {
            // Se forem diferentes, mostra a mensagem de erro
            mensagemErro.classList.remove('hidden');
        }
    });