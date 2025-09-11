        const form = document.getElementById('login-form');
        const btnCandidato = document.getElementById('btn-candidato');
        const btnEmpresa = document.getElementById('btn-empresa');
        const formContent = document.getElementById('form-content');
        const btnGoogleLogin = document.getElementById('btn-google-login');
        const btnFacebookLogin = document.getElementById('btn-facebook-login');

        let currentRole = 'candidato';
        const fields = {
            email: document.getElementById('email'),
            senha: document.getElementById('senha')
        };
        const errors = {
            email: document.getElementById('error-email'),
            senha: document.getElementById('error-senha')
        };
        const labelEmail = document.getElementById('label-email');
        const btnLogin = document.getElementById('btn-login');
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        // URLs das APIs no seu back-end (exemplo)
        const API_URL = 'http://localhost:3000/api/login'; 
        const GOOGLE_AUTH_URL = 'http://localhost:3000/api/auth/google';
        const FACEBOOK_AUTH_URL = 'http://localhost:3000/api/auth/facebook';

        function setCandidatoForm() {
            btnCandidato.classList.replace('bg-none', 'bg-blue-100');
            btnCandidato.classList.replace('text-gray-500', 'text-blue-600');
            btnEmpresa.classList.replace('bg-blue-100', 'bg-none');
            btnEmpresa.classList.replace('text-blue-600', 'text-gray-500');
            labelEmail.textContent = 'E-mail:';
            fields.email.placeholder = 'seu@email.com';
            btnLogin.textContent = 'Entrar como Candidato';
            form.reset();
            hideAllErrors();
        }

        function setEmpresaForm() {
            btnEmpresa.classList.replace('bg-none', 'bg-blue-100');
            btnEmpresa.classList.replace('text-gray-500', 'text-blue-600');
            btnCandidato.classList.replace('bg-blue-100', 'bg-none');
            btnCandidato.classList.replace('text-blue-600', 'text-gray-500');
            labelEmail.textContent = 'E-mail Corporativo:';
            fields.email.placeholder = 'seu@email.com';
            btnLogin.textContent = 'Entrar como Empresa';
            form.reset();
            hideAllErrors();
        }

        btnCandidato.addEventListener('click', () => {
            if (currentRole === 'candidato') return;
            formContent.classList.add('opacity-0');
            setTimeout(() => {
                setCandidatoForm();
                currentRole = 'candidato';
                formContent.classList.remove('opacity-0');
            }, 300);
        });

        btnEmpresa.addEventListener('click', () => {
            if (currentRole === 'empresa') return;
            formContent.classList.add('opacity-0');
            setTimeout(() => {
                setEmpresaForm();
                currentRole = 'empresa';
                formContent.classList.remove('opacity-0');
            }, 300);
        });

        function hideAllErrors() {
            Object.values(errors).forEach(el => el.classList.add('hidden'));
        }

        function showMessage(element, message) {
            element.textContent = message;
            element.classList.remove('hidden');
        }

        function validateForm() {
            hideAllErrors();
            let isValid = true;
            if (fields.email.value.trim() === '' || !emailPattern.test(fields.email.value)) {
                showMessage(errors.email, "E-mail inválido ou não preenchido.");
                isValid = false;
            }
            if (fields.senha.value.length < 8) {
                showMessage(errors.senha, "Senha deve ter no mínimo 8 caracteres.");
                isValid = false;
            }
            return isValid;
        }

        // Função para lidar com o login social
        function handleSocialLogin(url, provider) {
            // O front-end simplesmente redireciona para a URL do back-end
            // O back-end cuida do resto do processo OAuth e redireciona de volta
            window.location.href = `${url}?role=${currentRole}`;
        }
        
        // Eventos de clique para os botões sociais
        btnGoogleLogin.addEventListener('click', () => {
            handleSocialLogin(GOOGLE_AUTH_URL, 'google');
        });

        btnFacebookLogin.addEventListener('click', () => {
            handleSocialLogin(FACEBOOK_AUTH_URL, 'facebook');
        });
        
        // Evento de envio do formulário padrão
        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            if (!validateForm()) {
                return;
            }
            
            const data = {
                email: fields.email.value,
                password: fields.senha.value,
                role: currentRole
            };
            
            try {
                const response = await fetch(API_URL, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                
                const result = await response.json();
                
                if (response.ok) {
                    alert("Login realizado com sucesso! Redirecionando...");
                    window.location.href = '../Vagas/index.html'; 
                } else {
                    const errorMessage = result.message || "Credenciais inválidas. Tente novamente.";
                    alert("Erro no login: " + errorMessage);
                }
            } catch (error) {
                alert("Erro de conexão com o servidor. Verifique sua rede.");
                console.error('Erro de login:', error);
            }
        });