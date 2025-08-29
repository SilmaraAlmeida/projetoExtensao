 const form = document.getElementById('form-nova-senha');
        const senhaInput = document.getElementById('senha');
        const confirmarSenhaInput = document.getElementById('confirmar-senha');
        const mensagemErro = document.getElementById('mensagem-erro');

        form.addEventListener('submit', function(event) {
            event.preventDefault();

            const senha = senhaInput.value;
            const confirmarSenha = confirmarSenhaInput.value;

            // Define o padrão de segurança da senha
            // Mínimo 8 caracteres, pelo menos uma letra maiúscula, uma minúscula e um número
            const padraoSenha = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

            if (senha !== confirmarSenha) {
                mensagemErro.textContent = "As senhas não coincidem.";
                mensagemErro.classList.remove('hidden');
            } else if (!padraoSenha.test(senha)) {
                mensagemErro.textContent = "A senha deve ter no mínimo 8 caracteres, incluindo uma letra maiúscula, uma minúscula e um número.";
                mensagemErro.classList.remove('hidden');
            } else {
                // As senhas são iguais e seguras, então redireciona
                mensagemErro.classList.add('hidden');
                // Altere 'pagina-de-sucesso.html' para a URL da sua página de destino
                window.location.href = '../Login/index.html'; 
            }
        });