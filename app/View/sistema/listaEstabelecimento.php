<?= formTitulo('Gestão de Estabelecimentos', true) ?>

<?= exibeAlerta() ?>

<!-- Estatísticas -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

        <!-- Total -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total</p>
                    <p class="text-3xl font-bold mt-1"><?= $aDados['estatisticas']['total'] ?></p>
                    <p class="text-blue-100 text-xs mt-1">Estabelecimentos</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-building text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Com Usuário -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Com Usuário</p>
                    <p class="text-3xl font-bold text-green-600 mt-1"><?= $aDados['estatisticas']['com_usuario'] ?></p>
                    <p class="text-gray-500 text-xs mt-1">Possuem acesso</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-user-check text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Sem Usuário -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Sem Usuário</p>
                    <p class="text-3xl font-bold text-orange-600 mt-1"><?= $aDados['estatisticas']['sem_usuario'] ?></p>
                    <p class="text-gray-500 text-xs mt-1">Não possuem acesso</p>
                </div>
                <div class="bg-orange-100 rounded-full p-3">
                    <i class="fas fa-user-times text-orange-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Com Email -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Com Email</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1"><?= $aDados['estatisticas']['com_email'] ?></p>
                    <p class="text-gray-500 text-xs mt-1">Email cadastrado</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-envelope text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Com Localização -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Localização</p>
                    <p class="text-3xl font-bold text-indigo-600 mt-1"><?= $aDados['estatisticas']['com_localizacao'] ?></p>
                    <p class="text-gray-500 text-xs mt-1">Com GPS</p>
                </div>
                <div class="bg-indigo-100 rounded-full p-3">
                    <i class="fas fa-map-marker-alt text-indigo-600 text-xl"></i>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Tabela -->
<?php if (count($aDados['estabelecimentos']) > 0): ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Lista de Estabelecimentos</h2>
                <p class="text-sm text-gray-600">Empresas e organizações cadastradas</p>
            </div>
            <a href="<?= baseUrl() ?>estabelecimento/form/insert/0"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                <i class="fas fa-plus mr-2"></i>
                Novo Estabelecimento
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table id="tblEstabelecimentos" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Estabelecimento
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contato
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status Usuário
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($aDados['estabelecimentos'] as $estabelecimento): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- ID -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #<?= str_pad($estabelecimento['estabelecimento_id'], 4, '0', STR_PAD_LEFT) ?>
                                </td>

                                <!-- Nome + Endereço -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-building text-blue-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($estabelecimento['nome'] ?? 'Sem nome') ?>
                                            </p>
                                            <?php if (!empty($estabelecimento['endereco'])): ?>
                                                <p class="text-xs text-gray-500 flex items-center">
                                                    <i class="fas fa-map-marker-alt text-gray-400 mr-1"></i>
                                                    <?= htmlspecialchars(substr($estabelecimento['endereco'], 0, 40)) ?>
                                                    <?= strlen($estabelecimento['endereco']) > 40 ? '...' : '' ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email + Localização -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                    <?php if (!empty($estabelecimento['email'])): ?>
                                        <div class="flex items-center text-gray-600 mb-1">
                                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                            <span class="text-xs"><?= htmlspecialchars($estabelecimento['email']) ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!empty($estabelecimento['latitude']) && !empty($estabelecimento['longitude'])): ?>
                                        <div class="flex items-center text-gray-600">
                                            <i class="fas fa-map-marker-alt text-green-500 mr-2"></i>
                                            <span class="text-xs">GPS: <?= $estabelecimento['latitude'] ?>, <?= $estabelecimento['longitude'] ?></span>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (empty($estabelecimento['email']) && (empty($estabelecimento['latitude']) || empty($estabelecimento['longitude']))): ?>
                                        <span class="text-gray-400 italic text-xs">Sem contato</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Status Usuário -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if (!empty($estabelecimento['usuario_id'])): ?>
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Com acesso
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <?php
                                            $tipoLabels = ['G' => 'Gestor', 'CN' => 'Candidato', 'A' => 'Anunciante'];
                                            echo $tipoLabels[$estabelecimento['tipo']] ?? $estabelecimento['tipo'];
                                            ?>
                                        </p>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Sem acesso
                                        </span>
                                        <a href="<?= baseUrl() ?>usuario/form/insert/0?estabelecimento_id=<?= $estabelecimento['estabelecimento_id'] ?>"
                                            class="text-xs text-blue-600 hover:underline block mt-1">
                                            <i class="fas fa-plus-circle mr-1"></i>Criar usuário
                                        </a>
                                    <?php endif; ?>
                                </td>

                                <!-- Ações -->
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <?= buttons('view', $estabelecimento['estabelecimento_id']) ?>
                                        <?= buttons('update', $estabelecimento['estabelecimento_id']) ?>
                                        <?= buttons('delete', $estabelecimento['estabelecimento_id']) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Legenda -->
        <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-600 mr-2"></div>
                    <span>Com acesso ao sistema</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-gray-400 mr-2"></div>
                    <span>Sem acesso ao sistema</span>
                </div>
                <div class="flex items-center">
                    <i class="fas fa-map-marker-alt text-green-500 mr-1"></i>
                    <span>Com localização GPS</span>
                </div>
            </div>

            <div class="text-xs text-gray-500 flex items-center">
                <i class="fas fa-info-circle mr-1"></i>
                <span>Exibindo todos os estabelecimentos cadastrados</span>
            </div>
        </div>
    </div>

    <?= datatables('tblEstabelecimentos') ?>

<?php else: ?>

    <!-- Estado Vazio -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="max-w-sm mx-auto">
                <div class="bg-blue-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-building text-5xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum estabelecimento cadastrado</h3>
                <p class="text-gray-600 mb-6">
                    Comece cadastrando o primeiro estabelecimento no sistema
                </p>
                <a href="<?= baseUrl() ?>estabelecimento/form/insert/0"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    <i class="fas fa-plus mr-2"></i>
                    Cadastrar Primeiro Estabelecimento
                </a>
            </div>
        </div>
    </div>

<?php endif; ?>