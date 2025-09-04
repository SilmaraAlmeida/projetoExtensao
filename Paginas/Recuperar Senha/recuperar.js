        const form = document.getElementById('form-recuperar-senha');
        const emailInput = document.getElementById('email-input');
        const mensagemErro = document.getElementById('mensagem-erro');
        const mensagemSucesso = document.getElementById('mensagem-sucesso');
        const btnEnviar = document.getElementById('btn-enviar-email');
        const btnText = document.getElementById('btn-text');
        const btnLoading = document.getElementById('btn-loading');

        // URL do endpoint de recuperação de senha no seu back-end
        const API_URL = 'http://localhost:3000/api/recuperar-senha'; // Exemplo de URL

        // Função para mostrar e esconder o estado de carregamento do botão
        function setLoading(isLoading) {
            if (isLoading) {
                btnText.textContent = 'Enviando...';
                btnLoading.classList.remove('hidden');
                btnEnviar.disabled = true;
            } else {
                btnText.textContent = 'Enviar E-mail';
                btnLoading.classList.add('hidden');
                btnEnviar.disabled = false;
            }
        }

        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            mensagemErro.classList.add('hidden');
            mensagemSucesso.classList.add('hidden');
            const emailValue = emailInput.value.trim();

            if (emailValue === '') {
                mensagemErro.textContent = 'Por favor, insira um e-mail.';
                mensagemErro.classList.remove('hidden');
                return;
            }

            // Expressão regular para validação básica de e-mail
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(emailValue)) {
                mensagemErro.textContent = 'Por favor, insira um e-mail válido.';
                mensagemErro.classList.remove('hidden');
                return;
            }
            
            setLoading(true);

            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ email: emailValue })
                });

                const result = await response.json();

                if (response.ok) {
                    // Se o back-end retornar sucesso
                    mensagemSucesso.classList.remove('hidden');
                    // Redireciona para a página de verificação de código após um breve delay
                    setTimeout(() => {
                         window.location.href = '../Código de Verificação/codigo.html'; 
                    }, 2000); 
                } else {
                    // Se o back-end retornar um erro (ex: e-mail não encontrado)
                    mensagemErro.textContent = result.message || 'Ocorreu um erro. Por favor, tente novamente.';
                    mensagemErro.classList.remove('hidden');
                }
            } catch (error) {
                // Se houver um erro de rede ou de conexão
                mensagemErro.textContent = 'Erro de conexão com o servidor. Verifique sua rede.';
                mensagemErro.classList.remove('hidden');
                console.error('Erro:', error);
            } finally {
                setLoading(false);
            }
        });
