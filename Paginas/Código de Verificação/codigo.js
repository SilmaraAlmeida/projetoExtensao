const formCodigo = document.getElementById('form-codigo');
        const inputCodigo = document.getElementById('input-codigo');
        const mensagemErro = document.getElementById('mensagem-erro');

        // Adiciona a formatação automática
        inputCodigo.addEventListener('input', function (e) {
            let value = e.target.value.replace(/\D/g, '');

            if (value.length > 3) {
                value = value.slice(0, 3) + '-' + value.slice(3, 6);
            }

            e.target.value = value;
        });

        // Adiciona a validação e o redirecionamento ao enviar o formulário
        formCodigo.addEventListener('submit', function (event) {
            event.preventDefault();

            const codigoValue = inputCodigo.value.trim();

            // Verifica se o campo tem exatamente 7 caracteres (XXX-XXX)
            if (codigoValue.length === 7) {
                mensagemErro.classList.add('hidden');
                // Redireciona o usuário para a página de sucesso
                window.location.href = '../Redefinir Senha/redefinir.html'; // Altere para o caminho da sua página de destino
            } else {
                // Se o formato estiver incorreto, exibe a mensagem de erro
                mensagemErro.classList.remove('hidden');
            }
        });