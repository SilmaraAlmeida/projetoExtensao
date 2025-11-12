<?= formTitulo('Gestão de Acessos ao Sistema', true) ?>

<?= exibeAlerta() ?>

<!-- Estatísticas -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

        <!-- Total -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium">Total de Acessos</p>
                    <p class="text-3xl font-bold mt-1"><?= $aDados['estatisticas']['total'] ?></p>
                    <p class="text-blue-100 text-xs mt-1">Usuários com login ativo</p>
                </div>
                <div class="bg-white/20 rounded-full p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>

        <!-- Anunciantes -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Anunciantes</p>
                    <p class="text-3xl font-bold text-blue-600 mt-1"><?= $aDados['estatisticas']['anunciantes'] ?></p>
                    <p class="text-gray-500 text-xs mt-1">Empresas publicando vagas</p>
                </div>
                <div class="bg-blue-100 rounded-full p-3">
                    <i class="fas fa-building text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Gestores -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Gestores</p>
                    <p class="text-3xl font-bold text-purple-600 mt-1"><?= $aDados['estatisticas']['gestores'] ?></p>
                    <p class="text-gray-500 text-xs mt-1">Administradores do sistema</p>
                </div>
                <div class="bg-purple-100 rounded-full p-3">
                    <i class="fas fa-user-shield text-purple-600 text-xl"></i>
                </div>
            </div>
        </div>

        <!-- Candidatos -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-medium">Candidatos</p>
                    <p class="text-3xl font-bold text-green-600 mt-1"><?= $aDados['estatisticas']['candidatos'] ?></p>
                    <p class="text-gray-500 text-xs mt-1">Buscando oportunidades</p>
                </div>
                <div class="bg-green-100 rounded-full p-3">
                    <i class="fas fa-user-tie text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Tabela -->
<?php if (count($aDados['usuarios']) > 0): ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">

        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <div>
                <h2 class="text-lg font-semibold text-gray-900">Usuários com Acesso ao Sistema</h2>
                <p class="text-sm text-gray-600">Pessoas e empresas que podem fazer login</p>
            </div>
            <a href="<?= baseUrl() ?>usuario/form/insert/0"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                <i class="fas fa-user-plus mr-2"></i>
                Criar Novo Acesso
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table id="tblUsuarios" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                ID
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Usuário
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Email/Login
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tipo de Acesso
                            </th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Vínculo
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Ações
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php foreach ($aDados['usuarios'] as $usuario): ?>
                            <tr class="hover:bg-gray-50 transition-colors duration-150">
                                <!-- ID -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    #<?= str_pad($usuario['usuario_id'], 4, '0', STR_PAD_LEFT) ?>
                                </td>

                                <!-- Usuário (Nome + Avatar) -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10 rounded-full flex items-center justify-center
                                            <?= $usuario['tipo'] === 'A' ? 'bg-blue-100' : ($usuario['tipo'] === 'G' ? 'bg-purple-100' : 'bg-green-100') ?>">
                                            <i class="fas fa-<?= $usuario['tipo'] === 'A' ? 'building' : ($usuario['tipo'] === 'G' ? 'user-shield' : 'user-tie') ?> 
                                               text-<?= $usuario['tipo'] === 'A' ? 'blue' : ($usuario['tipo'] === 'G' ? 'purple' : 'green') ?>-600"></i>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">
                                                <?= htmlspecialchars($usuario['nome'] ?? 'Sem vínculo') ?>
                                            </p>
                                            <?php if ($usuario['cpf']): ?>
                                                <p class="text-xs text-gray-500">
                                                    CPF: <?= substr($usuario['cpf'], 0, 3) ?>.***.***-<?= substr($usuario['cpf'], -2) ?>
                                                </p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <!-- Email/Login -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <div class="flex items-center">
                                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                                        <?= htmlspecialchars($usuario['login']) ?>
                                    </div>
                                </td>

                                <!-- Tipo (Badge) -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php
                                    $badges = [
                                        'G' => ['class' => 'bg-purple-100 text-purple-800', 'icon' => 'user-shield', 'label' => 'Gestor'],
                                        'A' => ['class' => 'bg-blue-100 text-blue-800', 'icon' => 'building', 'label' => 'Anunciante'],
                                        'CN' => ['class' => 'bg-green-100 text-green-800', 'icon' => 'user-tie', 'label' => 'Candidato']
                                    ];
                                    $badge = $badges[$usuario['tipo']] ?? ['class' => 'bg-gray-100 text-gray-800', 'icon' => 'user', 'label' => 'Indefinido'];
                                    ?>
                                    <span class="inline-flex items-center px-3 py-1 text-xs font-semibold rounded-full <?= $badge['class'] ?>">
                                        <i class="fas fa-<?= $badge['icon'] ?> mr-1"></i>
                                        <?= $badge['label'] ?>
                                    </span>
                                </td>

                                <!-- Vínculo -->
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    <?php if ($usuario['tipo'] === 'A'): ?>
                                        <a href="<?= baseUrl() ?>estabelecimento/form/view/<?= $usuario['estabelecimento_id'] ?>"
                                            class="text-blue-600 hover:underline flex items-center">
                                            <i class="fas fa-external-link-alt text-xs mr-1"></i>
                                            Ver Estabelecimento
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= baseUrl() ?>PessoaFisica/form/view/<?= $usuario['pessoa_fisica_id'] ?>"
                                            class="text-blue-600 hover:underline flex items-center">
                                            <i class="fas fa-external-link-alt text-xs mr-1"></i>
                                            Ver Pessoa Física
                                        </a>
                                    <?php endif; ?>
                                </td>

                                <!-- Ações -->
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex items-center justify-center space-x-2">
                                        <?= buttons('view', $usuario['usuario_id']) ?>
                                        <?= buttons('update', $usuario['usuario_id']) ?>
                                        <?= buttons('delete', $usuario['usuario_id']) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Legenda e Informações -->
        <div class="mt-4 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <!-- Legenda -->
            <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600">
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-blue-600 mr-2"></div>
                    <span>Anunciante - Publica vagas</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-purple-600 mr-2"></div>
                    <span>Gestor - Administrador</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 rounded-full bg-green-600 mr-2"></div>
                    <span>Candidato - Busca emprego</span>
                </div>
            </div>

            <!-- Info Adicional -->
            <div class="text-xs text-gray-500 flex items-center">
                <i class="fas fa-info-circle mr-1"></i>
                <span>Exibindo usuários com acesso ativo ao sistema</span>
            </div>
        </div>
    </div>

    <?= datatables('tblUsuarios') ?>

<?php else: ?>

    <!-- Estado Vazio -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="max-w-sm mx-auto">
                <div class="bg-blue-50 rounded-full w-24 h-24 flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-user-lock text-5xl text-blue-600"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum acesso cadastrado</h3>
                <p class="text-gray-600 mb-2">O sistema ainda não possui usuários com permissão de login</p>
                <p class="text-gray-500 text-sm mb-6">
                    Crie o primeiro acesso para gerenciar o sistema
                </p>
                <a href="<?= baseUrl() ?>usuario/form/insert/0"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                    <i class="fas fa-user-plus mr-2"></i>
                    Criar Primeiro Acesso
                </a>
            </div>
        </div>
    </div>

<?php endif; ?>