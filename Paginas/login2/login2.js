const form = document.getElementById('login-form');
        const btnCandidato = document.getElementById('btn-candidato');
        const btnEmpresa = document.getElementById('btn-empresa');
        const formContent = document.getElementById('form-content');
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

        function setCandidatoForm() {
            btnCandidato.classList.replace('border-gray-200', 'border-blue-600');
            btnCandidato.classList.replace('text-gray-500', 'text-blue-600');
            btnEmpresa.classList.replace('border-blue-600', 'border-gray-200');
            btnEmpresa.classList.replace('text-blue-600', 'text-gray-500');

            labelEmail.textContent = 'E-mail:';
            fields.email.placeholder = 'seu@email.com';
            btnLogin.textContent = 'Entrar como Candidato';
            form.reset();
            hideAllErrors();
        }

        function setEmpresaForm() {
            btnEmpresa.classList.replace('border-gray-200', 'border-blue-600');
            btnEmpresa.classList.replace('text-gray-500', 'text-blue-600');
            btnCandidato.classList.replace('border-blue-600', 'border-gray-200');
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
            }, 500);
        });

        btnEmpresa.addEventListener('click', () => {
            if (currentRole === 'empresa') return;
            formContent.classList.add('opacity-0');
            setTimeout(() => {
                setEmpresaForm();
                currentRole = 'empresa';
                formContent.classList.remove('opacity-0');
            }, 500);
        });

        function hideAllErrors() {
            Object.values(errors).forEach(el => el.classList.add('hidden'));
        }

        function validateForm() {
            hideAllErrors();
            let isValid = true;

            if (fields.email.value.trim() === '' || !emailPattern.test(fields.email.value)) {
                errors.email.textContent = "E-mail inválido ou não preenchido.";
                errors.email.classList.remove('hidden');
                isValid = false;
            }

            if (fields.senha.value.length < 8) {
                errors.senha.textContent = "Senha deve ter no mínimo 8 caracteres.";
                errors.senha.classList.remove('hidden');
                isValid = false;
            }

            return isValid;
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (validateForm()) {
                alert("Login realizado com sucesso!");
                form.reset();
                 window.location.href = '../Vagas/index.html';
            }
        });