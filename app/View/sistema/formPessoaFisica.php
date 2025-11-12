<script type="text/javascript" src="<?= baseUrl(); ?>assets/js/pessoaFisica.js"></script>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?= formTitulo('Pessoa Física') ?>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <form method="POST" action="<?= $this->request->formAction() ?>">

                <input type="hidden" name="pessoa_fisica_id" id="pessoa_fisica_id" value="<?= setValor('pessoa_fisica_id') ?>">

                <div class="flex flex-wrap -mx-3">

                    <!-- Nome Completo -->
                    <div class="w-full lg:w-2/3 px-3 mb-6">
                        <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome Completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 hover:border-gray-300" 
                               id="nome" 
                               name="nome"
                               placeholder="Nome completo da pessoa" 
                               maxlength="150"
                               value="<?= setValor('nome') ?>" 
                               required 
                               autofocus>
                        <?= setMsgFilderError('nome') ?>
                    </div>

                    <!-- Visitante ID -->
                    <div class="w-full lg:w-1/3 px-3 mb-6">
                        <label for="visitante_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Visitante ID
                        </label>
                        <input type="number" 
                               class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 hover:border-gray-300" 
                               id="visitante_id" 
                               name="visitante_id"
                               placeholder="ID do visitante" 
                               min="1"
                               value="<?= setValor('visitante_id') ?>">
                        <?= setMsgFilderError('visitante_id') ?>
                        <small class="block mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Campo opcional - Referência a visitante externo
                        </small>
                    </div>

                    <!-- CPF -->
                    <div class="w-full px-3 mb-6">
                        <label for="cpf" class="block text-sm font-semibold text-gray-700 mb-2">
                            CPF
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-id-card text-gray-400"></i>
                            </div>
                            <input type="text" 
                                   class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 hover:border-gray-300" 
                                   id="cpf" 
                                   name="cpf"
                                   placeholder="000.000.000-00" 
                                   maxlength="14"
                                   value="<?= setValor('cpf') ?>" 
                                   onkeyup="mascaraCPF(this)" 
                                   onblur="validaCPF(this)">
                        </div>
                        <div id="cpfFeedback" class="mt-2"></div>
                        <?= setMsgFilderError('cpf') ?>
                        <small class="block mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Campo opcional - Apenas números
                        </small>
                    </div>

                </div>

                <!-- Informações Adicionais -->
                <?php if ($this->request->getAction() == 'update' && !empty(setValor('pessoa_fisica_id'))): ?>
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-blue-600 mt-1 mr-3"></i>
                            <div class="text-sm text-blue-800">
                                <p class="font-semibold mb-1">Informações:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs">
                                    <li>ID da Pessoa: <strong><?= setValor('pessoa_fisica_id') ?></strong></li>
                                    <li>Esta pessoa pode estar vinculada a um ou mais usuários do sistema</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Botões -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <?= formButton() ?>
                </div>

            </form>
        </div>
        
    </div>
</div>

<script>
function mascaraCPF(campo) {
    var cpf = campo.value.replace(/\D/g, '');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    campo.value = cpf;
}

function validaCPF(campo) {
    var cpf = campo.value.replace(/\D/g, '');
    var feedback = document.getElementById('cpfFeedback');
    
    // Se campo vazio, não valida (campo opcional)
    if (cpf === '') {
        campo.classList.remove('border-red-500', 'border-green-500');
        campo.classList.add('border-gray-200');
        feedback.innerHTML = '';
        return;
    }
    
    if (cpf.length !== 11) {
        campo.classList.remove('border-green-500', 'border-gray-200');
        campo.classList.add('border-red-500');
        feedback.innerHTML = '<p class="text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>CPF deve ter 11 dígitos</p>';
        return;
    }
    
    // Verifica se todos os dígitos são iguais
    if (/^(\d)\1{10}$/.test(cpf)) {
        campo.classList.remove('border-green-500', 'border-gray-200');
        campo.classList.add('border-red-500');
        feedback.innerHTML = '<p class="text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>CPF inválido</p>';
        return;
    }
    
    // Validação dos dígitos verificadores
    var soma = 0;
    var resto;
    
    // Primeiro dígito
    for (var i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i-1, i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) {
        campo.classList.remove('border-green-500', 'border-gray-200');
        campo.classList.add('border-red-500');
        feedback.innerHTML = '<p class="text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>CPF inválido</p>';
        return;
    }
    
    soma = 0;
    // Segundo dígito
    for (var i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i-1, i)) * (12 - i);
    }
    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) {
        campo.classList.remove('border-green-500', 'border-gray-200');
        campo.classList.add('border-red-500');
        feedback.innerHTML = '<p class="text-xs text-red-600"><i class="fas fa-exclamation-circle mr-1"></i>CPF inválido</p>';
        return;
    }
    
    // CPF válido
    campo.classList.remove('border-red-500', 'border-gray-200');
    campo.classList.add('border-green-500');
    feedback.innerHTML = '<p class="text-xs text-green-600"><i class="fas fa-check-circle mr-1"></i>CPF válido</p>';
}

// Remove formatação ao submeter o formulário
document.querySelector('form').addEventListener('submit', function() {
    var cpfField = document.getElementById('cpf');
    if (cpfField.value) {
        cpfField.value = cpfField.value.replace(/\D/g, '');
    }
});
</script>
