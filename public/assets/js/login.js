// Aplicação Portal de Empregos Muriaé
class PortalEmpregos {
    constructor() {
        this.currentPage = 'home';
        this.currentTab = 'candidato';
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.setupFormValidation();
        this.setupInputMasks();
        this.showPage('home');
    }

    setupEventListeners() {
        // Navegação entre páginas
        document.addEventListener('click', (e) => {
            if (e.target.hasAttribute('data-page')) {
                e.preventDefault();
                const page = e.target.getAttribute('data-page');
                this.showPage(page);
            }
        });

        // Menu mobile
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        
        if (mobileMenuBtn && mobileMenu) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('active');
            });
        }

        // Tabs do formulário
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.preventDefault();
                const tab = btn.getAttribute('data-tab');
                this.switchTab(tab);
            });
        });

        // Validação em tempo real
        document.querySelectorAll('.form-control').forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });

            input.addEventListener('input', () => {
                this.clearError(input);
            });
        });

        // Submit dos formulários
        document.getElementById('form-candidato').addEventListener('submit', (e) => {
            this.handleFormSubmit(e, 'candidato');
        });

        document.getElementById('form-empresa').addEventListener('submit', (e) => {
            this.handleFormSubmit(e, 'empresa');
        });

        // Upload de arquivo
        const fileInput = document.getElementById('curriculo');
        if (fileInput) {
            fileInput.addEventListener('change', (e) => {
                this.handleFileUpload(e);
            });
        }
    }

    showPage(pageName) {
        // Esconder todas as páginas
        document.querySelectorAll('.page').forEach(page => {
            page.classList.remove('active');
        });

        // Mostrar página selecionada
        const targetPage = document.getElementById(`page-${pageName}`);
        if (targetPage) {
            targetPage.classList.add('active');
            this.currentPage = pageName;
        }

        // Atualizar navegação ativa
        document.querySelectorAll('.nav-link').forEach(link => {
            link.classList.remove('active');
        });

        document.querySelectorAll(`[data-page="${pageName}"]`).forEach(link => {
            if (link.classList.contains('nav-link')) {
                link.classList.add('active');
            }
        });

        // Fechar menu mobile se estiver aberto
        const mobileMenu = document.getElementById('mobileMenu');
        if (mobileMenu) {
            mobileMenu.classList.remove('active');
        }

        // Scroll para o topo
        window.scrollTo(0, 0);
    }

    switchTab(tabName) {
        // Atualizar botões das tabs
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
        });

        document.querySelector(`[data-tab="${tabName}"]`).classList.add('active');

        // Mostrar conteúdo da tab
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });

        document.getElementById(`form-${tabName}`).classList.add('active');
        this.currentTab = tabName;
    }

    setupInputMasks() {
        // Máscara para CPF
        const cpfInput = document.getElementById('cpf');
        if (cpfInput) {
            cpfInput.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            });
        }

        // Máscara para CNPJ
        const cnpjInput = document.getElementById('cnpj');
        if (cnpjInput) {
            cnpjInput.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '');
                value = value.replace(/^(\d{2})(\d)/, '$1.$2');
                value = value.replace(/^(\d{2})\.(\d{3})(\d)/, '$1.$2.$3');
                value = value.replace(/\.(\d{3})(\d)/, '.$1/$2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
                e.target.value = value;
            });
        }

        // Máscara para telefone
        const telefoneInputs = document.querySelectorAll('input[type="tel"]');
        telefoneInputs.forEach(input => {
            input.addEventListener('input', (e) => {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length >= 11) {
                    value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
                } else if (value.length >= 7) {
                    value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
                } else if (value.length >= 3) {
                    value = value.replace(/^(\d{2})(\d{0,5})/, '($1) $2');
                } else {
                    value = value.replace(/^(\d*)/, '($1');
                }
                e.target.value = value;
            });
        });
    }

    setupFormValidation() {
        // Configurar validações personalizadas aqui se necessário
    }

    validateField(input) {
        const value = input.value.trim();
        const name = input.name;
        let isValid = true;
        let errorMessage = '';

        // Validação obrigatória
        if (input.hasAttribute('required') && !value) {
            isValid = false;
            errorMessage = 'Este campo é obrigatório';
        }

        // Validações específicas
        switch (name) {
            case 'email':
                if (value && !this.isValidEmail(value)) {
                    isValid = false;
                    errorMessage = 'Digite um e-mail válido';
                }
                break;

            case 'cpf':
                if (value && !this.isValidCPF(value)) {
                    isValid = false;
                    errorMessage = 'CPF inválido';
                }
                break;

            case 'cnpj':
                if (value && !this.isValidCNPJ(value)) {
                    isValid = false;
                    errorMessage = 'CNPJ inválido';
                }
                break;

            case 'confirmar_senha':
            case 'confirmar_senha_empresa':
                const senhaField = this.currentTab === 'candidato' ? 
                    document.getElementById('senha') : 
                    document.getElementById('senha_empresa');
                if (value && senhaField && value !== senhaField.value) {
                    isValid = false;
                    errorMessage = 'As senhas não coincidem';
                }
                break;

            case 'senha':
            case 'senha_empresa':
                if (value && value.length < 6) {
                    isValid = false;
                    errorMessage = 'A senha deve ter pelo menos 6 caracteres';
                }
                break;

            case 'data_nascimento':
                if (value && !this.isValidAge(value)) {
                    isValid = false;
                    errorMessage = 'Você deve ter pelo menos 16 anos';
                }
                break;
        }

        this.showFieldError(input, isValid, errorMessage);
        return isValid;
    }

    showFieldError(input, isValid, errorMessage) {
        const errorElement = document.getElementById(`error-${input.name}`) || 
                            document.getElementById(`error-${input.id}`);
        
        if (isValid) {
            input.classList.remove('error');
            if (errorElement) {
                errorElement.classList.remove('show');
                errorElement.textContent = '';
            }
        } else {
            input.classList.add('error');
            if (errorElement) {
                errorElement.classList.add('show');
                errorElement.textContent = errorMessage;
            }
        }
    }

    clearError(input) {
        input.classList.remove('error');
        const errorElement = document.getElementById(`error-${input.name}`) || 
                            document.getElementById(`error-${input.id}`);
        if (errorElement) {
            errorElement.classList.remove('show');
            errorElement.textContent = '';
        }
    }

    handleFormSubmit(e, formType) {
        e.preventDefault();
        
        const form = e.target;
        const submitBtn = form.querySelector('button[type="submit"]');
        let isFormValid = true;

        // Validar todos os campos
        const inputs = form.querySelectorAll('.form-control, input[type="checkbox"][required]');
        inputs.forEach(input => {
            if (input.type === 'checkbox') {
                if (!input.checked) {
                    isFormValid = false;
                    const errorElement = document.getElementById(`error-${input.name}`);
                    if (errorElement) {
                        errorElement.classList.add('show');
                        errorElement.textContent = 'Você deve aceitar os termos';
                    }
                }
            } else {
                if (!this.validateField(input)) {
                    isFormValid = false;
                }
            }
        });

        if (!isFormValid) {
            // Scroll para o primeiro erro
            const firstError = form.querySelector('.form-control.error');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }
    }

    // Utilitários de validação
    isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    isValidCPF(cpf) {
        cpf = cpf.replace(/\D/g, '');
        
        if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) {
            return false;
        }

        let sum = 0;
        for (let i = 0; i < 9; i++) {
            sum += parseInt(cpf.charAt(i)) * (10 - i);
        }
        let remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) remainder = 0;
        if (remainder !== parseInt(cpf.charAt(9))) return false;

        sum = 0;
        for (let i = 0; i < 10; i++) {
            sum += parseInt(cpf.charAt(i)) * (11 - i);
        }
        remainder = (sum * 10) % 11;
        if (remainder === 10 || remainder === 11) remainder = 0;
        return remainder === parseInt(cpf.charAt(10));
    }

    isValidCNPJ(cnpj) {
        cnpj = cnpj.replace(/\D/g, '');
        
        if (cnpj.length !== 14 || /^(\d)\1{13}$/.test(cnpj)) {
            return false;
        }

        let size = cnpj.length - 2;
        let numbers = cnpj.substring(0, size);
        let digits = cnpj.substring(size);
        let sum = 0;
        let pos = size - 7;

        for (let i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2) pos = 9;
        }

        let result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        if (result !== parseInt(digits.charAt(0))) return false;

        size = size + 1;
        numbers = cnpj.substring(0, size);
        sum = 0;
        pos = size - 7;

        for (let i = size; i >= 1; i--) {
            sum += numbers.charAt(size - i) * pos--;
            if (pos < 2) pos = 9;
        }

        result = sum % 11 < 2 ? 0 : 11 - sum % 11;
        return result === parseInt(digits.charAt(1));
    }

    isValidAge(birthDate) {
        const today = new Date();
        const birth = new Date(birthDate);
        const age = today.getFullYear() - birth.getFullYear();
        const monthDiff = today.getMonth() - birth.getMonth();
        
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birth.getDate())) {
            return age - 1 >= 16;
        }
        
        return age >= 16;
    }
}

// Inicializar aplicação quando DOM estiver pronto
document.addEventListener('DOMContentLoaded', () => {
    window.portalEmpregos = new PortalEmpregos();
});

// Funções globais para compatibilidade (se necessário para integração PHP)
window.navegarPara = function(pagina) {
    if (window.portalEmpregos) {
        window.portalEmpregos.showPage(pagina);
    }
};

window.alternarTab = function(tab) {
    if (window.portalEmpregos) {
        window.portalEmpregos.switchTab(tab);
    }
};

// Service Worker para cache offline (opcional)
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        // navigator.serviceWorker.register('/sw.js')
        //     .then(registration => console.log('SW registered'))
        //     .catch(error => console.log('SW registration failed'));
    });
}