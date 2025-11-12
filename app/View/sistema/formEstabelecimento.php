<script type="text/javascript" src="<?= baseUrl(); ?>assets/js/estabelecimento.js"></script>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

        <?= formTitulo('Estabelecimento') ?>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <form method="POST" action="<?= $this->request->formAction() ?>">

                <input type="hidden" name="estabelecimento_id" id="estabelecimento_id" value="<?= setValor('estabelecimento_id') ?>">

                <div class="flex flex-wrap -mx-3">
        <?= exibeAlerta() ?>
                    <!-- Nome do Estabelecimento -->
                    <div class="w-full px-3 mb-6">
                        <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome do Estabelecimento <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                            class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                            id="nome"
                            name="nome"
                            placeholder="Nome da empresa ou organização"
                            maxlength="50"
                            value="<?= setValor('nome') ?>"
                            required
                            autofocus>
                        <?= setMsgFilderError('nome') ?>
                    </div>

                    <!-- Email -->
                    <div class="w-full lg:w-1/2 px-3 mb-6">
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-envelope text-gray-400"></i>
                            </div>
                            <input type="email"
                                class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                id="email"
                                name="email"
                                placeholder="contato@empresa.com"
                                maxlength="150"
                                value="<?= setValor('email') ?>">
                        </div>
                        <?= setMsgFilderError('email') ?>
                        <small class="block mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Campo opcional - Email de contato
                        </small>
                    </div>

                    <!-- Endereço -->
                    <div class="w-full lg:w-1/2 px-3 mb-6">
                        <label for="endereco" class="block text-sm font-semibold text-gray-700 mb-2">
                            Endereço
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-map-marker-alt text-gray-400"></i>
                            </div>
                            <input type="text"
                                class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                id="endereco"
                                name="endereco"
                                placeholder="Rua, número, bairro, cidade"
                                maxlength="200"
                                value="<?= setValor('endereco') ?>">
                        </div>
                        <?= setMsgFilderError('endereco') ?>
                        <small class="block mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Campo opcional - Endereço físico
                        </small>
                    </div>

                    <!-- Latitude -->
                    <div class="w-full lg:w-1/2 px-3 mb-6">
                        <label for="latitude" class="block text-sm font-semibold text-gray-700 mb-2">
                            Latitude (GPS)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-globe text-gray-400"></i>
                            </div>
                            <input type="text"
                                class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                id="latitude"
                                name="latitude"
                                placeholder="-23.5505199"
                                maxlength="12"
                                value="<?= setValor('latitude') ?>"
                                pattern="^-?[0-9]{1,3}\.?[0-9]*$">
                        </div>
                        <?= setMsgFilderError('latitude') ?>
                        <small class="block mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Exemplo: -23.5505199
                        </small>
                    </div>

                    <!-- Longitude -->
                    <div class="w-full lg:w-1/2 px-3 mb-6">
                        <label for="longitude" class="block text-sm font-semibold text-gray-700 mb-2">
                            Longitude (GPS)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-globe text-gray-400"></i>
                            </div>
                            <input type="text"
                                class="w-full pl-10 pr-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                id="longitude"
                                name="longitude"
                                placeholder="-46.6333094"
                                maxlength="12"
                                value="<?= setValor('longitude') ?>"
                                pattern="^-?[0-9]{1,3}\.?[0-9]*$">
                        </div>
                        <?= setMsgFilderError('longitude') ?>
                        <small class="block mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            Exemplo: -46.6333094
                        </small>
                    </div>

                </div>

                <!-- Card de Ajuda - Localização GPS -->
                <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-map-marked-alt text-blue-600 text-xl mt-0.5"></i>
                        </div>
                        <div class="ml-3 flex-1">
                            <p class="text-sm font-semibold text-blue-800 mb-1">Como obter as coordenadas GPS?</p>
                            <ul class="text-xs text-blue-700 space-y-1">
                                <li>• Acesse <a href="https://www.google.com/maps" target="_blank" class="underline hover:text-blue-900">Google Maps</a></li>
                                <li>• Clique com o botão direito no local desejado</li>
                                <li>• Selecione as coordenadas que aparecem (formato: -23.5505199, -46.6333094)</li>
                                <li>• Cole a latitude e longitude nos campos acima</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Informações Adicionais (Update) -->
                <?php if ($this->request->getAction() == 'update' && !empty(setValor('estabelecimento_id'))): ?>
                    <div class="mb-6 p-4 bg-gray-50 border border-gray-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-info-circle text-gray-600 mt-1 mr-3"></i>
                            <div class="text-sm text-gray-700">
                                <p class="font-semibold mb-1">Informações:</p>
                                <ul class="list-disc list-inside space-y-1 text-xs">
                                    <li>ID do Estabelecimento: <strong><?= setValor('estabelecimento_id') ?></strong></li>
                                    <li>Este estabelecimento pode estar vinculado a um usuário (anunciante)</li>
                                    <li>Pode ter vagas, telefones e categorias associadas</li>
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
    // Validação de coordenadas GPS em tempo real
    document.getElementById('latitude').addEventListener('input', function(e) {
        validarCoordenada(e.target, 'latitude');
    });

    document.getElementById('longitude').addEventListener('input', function(e) {
        validarCoordenada(e.target, 'longitude');
    });

    function validarCoordenada(campo, tipo) {
        const valor = campo.value.trim();

        // Se vazio, remove validação
        if (valor === '') {
            campo.classList.remove('border-red-500', 'border-green-500');
            campo.classList.add('border-gray-200');
            return;
        }

        // Regex para coordenadas
        const regex = /^-?[0-9]{1,3}\.?[0-9]*$/;

        if (!regex.test(valor)) {
            campo.classList.remove('border-green-500', 'border-gray-200');
            campo.classList.add('border-red-500');
            return;
        }

        const num = parseFloat(valor);

        // Validação de range
        if (tipo === 'latitude' && (num < -90 || num > 90)) {
            campo.classList.remove('border-green-500', 'border-gray-200');
            campo.classList.add('border-red-500');
            return;
        }

        if (tipo === 'longitude' && (num < -180 || num > 180)) {
            campo.classList.remove('border-green-500', 'border-gray-200');
            campo.classList.add('border-red-500');
            return;
        }

        // Válido
        campo.classList.remove('border-red-500', 'border-gray-200');
        campo.classList.add('border-green-500');
    }

    // Validação de email em tempo real
    document.getElementById('email').addEventListener('blur', function(e) {
        const email = e.target.value.trim();

        if (email === '') {
            e.target.classList.remove('border-red-500', 'border-green-500');
            e.target.classList.add('border-gray-200');
            return;
        }

        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (regex.test(email)) {
            e.target.classList.remove('border-red-500', 'border-gray-200');
            e.target.classList.add('border-green-500');
        } else {
            e.target.classList.remove('border-green-500', 'border-gray-200');
            e.target.classList.add('border-red-500');
        }
    });
</script>