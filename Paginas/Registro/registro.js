        const form = document.getElementById('cadastro-form');
        const btnCandidato = document.getElementById('btn-candidato');
        const btnEmpresa = document.getElementById('btn-empresa');
        const formContent = document.getElementById('form-content');
        let currentRole = 'candidato';

        const fields = {
            nome: document.getElementById('nome'),
            sobrenome: document.getElementById('sobrenome'),
            documento: document.getElementById('documento'),
            email: document.getElementById('email'),
            telefone: document.getElementById('telefone'),
            senha: document.getElementById('senha'),
            confirmarSenha: document.getElementById('confirmar-senha'),
            termos: document.getElementById('aceite-termos')
        };
        const errors = {
            nome: document.getElementById('error-nome'),
            sobrenome: document.getElementById('error-sobrenome'),
            documento: document.getElementById('error-documento'),
            email: document.getElementById('error-email'),
            telefone: document.getElementById('error-telefone'),
            senha: document.getElementById('error-senha'),
            confirmarSenha: document.getElementById('error-confirmar-senha'),
            termos: document.getElementById('error-termos')
        };
        
        const labelNome = document.getElementById('label-nome');
        const labelSobrenome = document.getElementById('label-sobrenome');
        const sobrenomeContainer = fields.sobrenome.closest('div');
        const labelDocumento = document.getElementById('label-documento');
        const labelEmail = document.getElementById('label-email');
        const btnCadastro = document.getElementById('btn-cadastro');

        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        function maskCpf(value) {
            return value.replace(/\D/g, '')
                        .replace(/(\d{3})(\d)/, '$1.$2')
                        .replace(/(\d{3})(\d)/, '$1.$2')
                        .replace(/(\d{3})(\d{1,2})/, '$1-$2')
                        .replace(/(-\d{2})\d+?$/, '$1');
        }

        function maskCnpj(value) {
            return value.replace(/\D/g, '')
                        .replace(/^(\d{2})(\d)/, '$1.$2')
                        .replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3')
                        .replace(/\.(\d{3})(\d)/, '.$1/$2')
                        .replace(/(\d{4})(\d)/, '$1-$2')
                        .replace(/(-\d{2})\d+?$/, '$1');
        }

        function maskTelefone(value) {
            return value.replace(/\D/g, '')
                        .replace(/^(\d{2})(\d)/g, '($1) $2')
                        .replace(/(\d)(\d{4})$/, '$1-$2');
        }

        fields.documento.addEventListener('input', (e) => {
            if (currentRole === 'candidato') {
                e.target.value = maskCpf(e.target.value);
            } else {
                e.target.value = maskCnpj(e.target.value);
            }
        });

        fields.telefone.addEventListener('input', (e) => {
            e.target.value = maskTelefone(e.target.value);
        });

        function hideAllErrors() {
            Object.values(errors).forEach(el => el.classList.add('hidden'));
        }

        function setCandidatoForm() {
            btnCandidato.classList.replace('border-gray-200', 'border-blue-600');
            btnCandidato.classList.replace('text-gray-500', 'text-blue-600');
            btnEmpresa.classList.replace('border-blue-600', 'border-gray-200');
            btnEmpresa.classList.replace('text-blue-600', 'text-gray-500');

            labelNome.textContent = 'Nome:';
            labelSobrenome.textContent = 'Sobrenome:';
            sobrenomeContainer.style.display = 'block';
            labelDocumento.textContent = 'CPF:';
            labelEmail.textContent = 'E-mail:';
            fields.documento.placeholder = '000.000.000-00';
            fields.documento.maxLength = 14;
            btnCadastro.textContent = 'Criar Conta como Candidato';
            form.reset();
            hideAllErrors();
        }

        function setEmpresaForm() {
            btnEmpresa.classList.replace('border-gray-200', 'border-blue-600');
            btnEmpresa.classList.replace('text-gray-500', 'text-blue-600');
            btnCandidato.classList.replace('border-blue-600', 'border-gray-200');
            btnCandidato.classList.replace('text-blue-600', 'text-gray-500');

            labelNome.textContent = 'Razão Social:';
            labelSobrenome.textContent = '';
            sobrenomeContainer.style.display = 'none';
            labelDocumento.textContent = 'CNPJ:';
            labelEmail.textContent = 'E-mail Corporativo:';
            fields.documento.placeholder = '00.000.000/0000-00';
            fields.documento.maxLength = 18;
            btnCadastro.textContent = 'Criar Conta como Empresa';
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

        function validateForm() {
            hideAllErrors();
            let isValid = true;

            // Validação de campos obrigatórios
            if (fields.nome.value.trim() === '') {
                errors.nome.textContent = "Este campo é obrigatório.";
                errors.nome.classList.remove('hidden');
                isValid = false;
            }

            if (currentRole === 'candidato' && fields.sobrenome.value.trim() === '') {
                errors.sobrenome.textContent = "Este campo é obrigatório.";
                errors.sobrenome.classList.remove('hidden');
                isValid = false;
            }

            if (fields.documento.value.trim() === '') {
                errors.documento.textContent = (currentRole === 'candidato') ? "CPF obrigatório." : "CNPJ obrigatório.";
                errors.documento.classList.remove('hidden');
                isValid = false;
            } else if (currentRole === 'candidato' && fields.documento.value.length !== 14) {
                 errors.documento.textContent = "CPF inválido.";
                errors.documento.classList.remove('hidden');
                isValid = false;
            } else if (currentRole === 'empresa' && fields.documento.value.length !== 18) {
                errors.documento.textContent = "CNPJ inválido.";
                errors.documento.classList.remove('hidden');
                isValid = false;
            }

            if (fields.email.value.trim() === '' || !emailPattern.test(fields.email.value)) {
                errors.email.textContent = "E-mail inválido.";
                errors.email.classList.remove('hidden');
                isValid = false;
            }
            
            if (fields.telefone.value.trim() === '' || fields.telefone.value.length < 14) {
                errors.telefone.textContent = "Telefone inválido.";
                errors.telefone.classList.remove('hidden');
                isValid = false;
            }

            // Validação de senhas
            if (fields.senha.value !== fields.confirmarSenha.value) {
                errors.confirmarSenha.textContent = "As senhas não coincidem.";
                errors.confirmarSenha.classList.remove('hidden');
                isValid = false;
            }

            if (!passwordPattern.test(fields.senha.value)) {
                errors.senha.textContent = "A senha deve ter no mínimo 8 caracteres, com letra maiúscula, minúscula e número.";
                errors.senha.classList.remove('hidden');
                isValid = false;
            }

            // Validação de checkbox
            if (!fields.termos.checked) {
                errors.termos.classList.remove('hidden');
                isValid = false;
            }

            return isValid;
        }

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            if (validateForm()) {
                alert("Formulário enviado com sucesso!");
                form.reset();
                // Aqui você pode adicionar o código para redirecionar o usuário
               window.location.href = "../Home/Home.html"; // redirecionar para a página home
            }
        });