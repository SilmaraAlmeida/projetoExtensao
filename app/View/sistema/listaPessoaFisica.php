<?= formTitulo('Gestão de Pessoas Físicas', true) ?>

<?= exibeAlerta() ?>

<!-- Estatísticas -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        
        <!-- Total -->
        <div class="bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-indigo-100 text-sm font-medium">Total de Pessoas</p>
                    <p class="text-3xl font-bold mt-1"><?= $aDados['estatisticas']['total'] ?></p>
                    <p class="text-indigo-100 text-xs mt-1">Cadastradas no sistema</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Com Usuário -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Com Usuário</p>
                    <p class="text-3xl font-bold text-green-600 mt-1"><?= $aDados['estatisticas']['com_usuario'] ?></p>
                    <p class="text-gray-500 text-xs mt-1">Possuem acesso ao sistema</p>
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

        <!-- Com CPF -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Com CPF</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1"><?= $aDados['estatisticas']['com_cpf'] ?></p>
                    <p class="text-gray-500 text-xs mt-1">Documentos cadastrados</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-id-card text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Tabela -->
<?php if (count($aDados['pessoas']) > 0): ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Lista de Pessoas Físicas</h2>
                <p class="text-sm text-gray-600">Gerenciamento de pessoas cadastradas</p>
            </div>
            <a href="<?= baseUrl() ?>PessoaFisica/form/insert/0" 
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                <i class="fas fa-user-plus mr-2"></i>
                Nova Pessoa
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table id="tblPessoasFisicas" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Nome
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                CPF
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
                        <?php foreach ($aDados['pessoas'] as $pessoa): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- ID -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #<?= str_pad($pessoa['pessoa_fisica_id'], 4, '0', STR_PAD_LEFT) ?>
                                </td>
                                
                                <!-- Nome -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                            <i class="fas fa-user text-indigo-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($pessoa['nome'] ?? 'Sem nome') ?>
                                            </p>
                                            <?php if (!empty($pessoa['visitante_id'])): ?>
                                                <p class="text-xs text-gray-500">
                                                    <i class="fas fa-globe text-gray-400 mr-1"></i>
                                                    Visitante: <?= $pessoa['visitante_id'] ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- CPF -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php if (!empty($pessoa['cpf'])): ?>
                                        <?php
                                        $cpf = $pessoa['cpf'];
                                        $cpfFormatado = strlen($cpf) == 11 
                                            ? substr($cpf, 0, 3) . '.' . substr($cpf, 3, 3) . '.' . substr($cpf, 6, 3) . '-' . substr($cpf, 9, 2)
                                            : $cpf;
                                        ?>
                                        <span class="font-mono"><?= $cpfFormatado ?></span>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic text-xs">Não informado</span>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- Status Usuário -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if (!empty($pessoa['usuario_id'])): ?>
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            Com acesso
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">
                                            <?php
                                            $tipoLabels = ['G' => 'Gestor', 'CN' => 'Candidato', 'A' => 'Anunciante'];
                                            echo $tipoLabels[$pessoa['tipo']] ?? $pessoa['tipo'];
                                            ?>
                                        </p>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            Sem acesso
                                        </span>
                                        <a href="<?= baseUrl() ?>usuario/form/insert/0?pessoa_fisica_id=<?= $pessoa['pessoa_fisica_id'] ?>" 
                                           class="text-xs text-blue-600 hover:underline block mt-1">
                                            <i class="fas fa-plus-circle mr-1"></i>Criar usuário
                                        </a>
                                    <?php endif; ?>
                                </td>
                                
                                <!-- Ações -->
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <?= buttons('view', $pessoa['pessoa_fisica_id']) ?>
                                        <?= buttons('update', $pessoa['pessoa_fisica_id']) ?>
                                        <?= buttons('delete', $pessoa['pessoa_fisica_id']) ?>
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
            </div>

            <div class="text-xs text-gray-500 flex items-center">
                <i class="fas fa-info-circle mr-1"></i>
                <span>Exibindo todas as pessoas físicas cadastradas</span>
            </div>
        </div>
    </div>

    <?= datatables('tblPessoasFisicas') ?>

<?php else: ?>

    <!-- Estado Vazio -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="max-w-sm mx-auto">
                <div class="bg-indigo-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-users text-5xl text-indigo-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhuma pessoa cadastrada</h3>
                <p class="text-gray-600 mb-6">
                    Comece cadastrando a primeira pessoa física no sistema
                </p>
                <a href="<?= baseUrl() ?>PessoaFisica/form/insert/0" 
                   class="inline-flex items-center px-6 py-3 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                    <i class="fas fa-user-plus mr-2"></i>
                    Cadastrar Primeira Pessoa
                </a>
            </div>
        </div>
    </div>

<?php endif; ?>
