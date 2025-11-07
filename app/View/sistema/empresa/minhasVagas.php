<?php
$vagas = $dados['vagas'] ?? [];
$cargos = $dados['cargos'] ?? [];

$statusLabels = [
    1 => ['Pré-vaga', 'gray'],
    11 => ['Em aberto', 'green'],
    91 => ['Suspensa', 'yellow'],
    99 => ['Finalizada', 'red']
];

$modalidadeLabels = [1 => 'Presencial', 2 => 'Remoto'];
$vinculoLabels = [1 => 'CLT', 2 => 'PJ'];
?>

<div class="min-h-screen bg-gray-50">
    
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Gerenciar Vagas</h1>
                    <p class="text-gray-600 mt-1">Crie e gerencie as vagas disponíveis na sua empresa</p>
                </div>
                <a href="<?= baseUrl() ?>VagasEmpresa/form/insert/0"
                    class="inline-flex items-center px-6 py-3 bg-gray-900 text-white rounded-lg text-base font-semibold hover:bg-black transition-all shadow-md hover:shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Nova Vaga
                </a>
            </div>
        </div>
    </div>

    <!-- Alert Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <?= exibeAlerta() ?>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Filtros -->
        <!-- <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                    <select name="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                        <option value="">Todos</option>
                        <option value="1">Pré-vaga</option>
                        <option value="11">Em aberto</option>
                        <option value="91">Suspensa</option>
                        <option value="99">Finalizada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Modalidade</label>
                    <select name="modalidade"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                        <option value="">Todas</option>
                        <option value="1">Presencial</option>
                        <option value="2">Remoto</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Vínculo</label>
                    <select name="vinculo"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                        <option value="">Todos</option>
                        <option value="1">CLT</option>
                        <option value="2">PJ</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Buscar</label>
                    <input type="text" name="busca" placeholder="Nome da vaga..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                </div>
            </form>
        </div> -->

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Total de Vagas</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1"><?= count($vagas) ?></p>
                    </div>
                    <i class="fas fa-briefcase text-3xl text-gray-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Em Aberto</p>
                        <p class="text-3xl font-bold text-green-600 mt-1"><?= count(array_filter($vagas, fn($v) => $v['statusVaga'] == 11)) ?></p>
                    </div>
                    <i class="fas fa-check-circle text-3xl text-green-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Suspensas</p>
                        <p class="text-3xl font-bold text-yellow-600 mt-1"><?= count(array_filter($vagas, fn($v) => $v['statusVaga'] == 91)) ?></p>
                    </div>
                    <i class="fas fa-pause-circle text-3xl text-yellow-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Finalizadas</p>
                        <p class="text-3xl font-bold text-red-600 mt-1"><?= count(array_filter($vagas, fn($v) => $v['statusVaga'] == 99)) ?></p>
                    </div>
                    <i class="fas fa-times-circle text-3xl text-red-200"></i>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <?php if (empty($vagas)): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-16 text-center">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhuma vaga cadastrada</h3>
                    <p class="text-gray-600 mb-6">Comece a criar vagas clicando no botão acima para atrair os melhores candidatos!</p>
                    <a href="<?= baseUrl() ?>VagasEmpresa/form/insert/0"
                        class="inline-flex items-center px-6 py-3 bg-gray-900 text-white rounded-lg text-base font-semibold hover:bg-black transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Criar Primeira Vaga
                    </a>
                </div>
            </div>
        <?php else: ?>

            <!-- Lista de Vagas -->
            <div class="space-y-6">
                <?php foreach ($vagas as $vaga): ?>
                    <?php
                        $statusInfo = $statusLabels[$vaga['statusVaga']] ?? ['Desconhecido', 'gray'];
                        $cargo = $vaga['cargo'] ?? [];
                        $dataInicio = new DateTime($vaga['dtInicio']);
                        $dataFim = new DateTime($vaga['dtFim']);
                        $hoje = new DateTime();
                        $diasAberto = $hoje->diff($dataFim)->days;
                    ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all">
                        
                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-gray-50 to-white border-b border-gray-200 px-6 py-4 flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-bold text-gray-900"><?= htmlspecialchars($cargo['descricao'] ?? 'Cargo') ?></h3>
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold"
                                        style="background-color: <?= $statusInfo[1] === 'green' ? '#d1fae5' : ($statusInfo[1] === 'yellow' ? '#fef3c7' : ($statusInfo[1] === 'red' ? '#fee2e2' : '#f3f4f6')) ?>;
                                                 color: <?= $statusInfo[1] === 'green' ? '#047857' : ($statusInfo[1] === 'yellow' ? '#92400e' : ($statusInfo[1] === 'red' ? '#991b1b' : '#374151')) ?>;">
                                        <i class="fas fa-<?= $statusInfo[1] === 'green' ? 'check-circle' : ($statusInfo[1] === 'red' ? 'times-circle' : 'clock') ?> mr-1"></i>
                                        <?= $statusInfo[0] ?>
                                    </span>
                                </div>
                                <p class="text-gray-600 line-clamp-2"><?= htmlspecialchars($vaga['descricao'] ?? '') ?></p>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-gray-900">#<?= $vaga['vaga_id'] ?></p>
                                <p class="text-xs text-gray-500">ID da vaga</p>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="px-6 py-6">
                            <!-- Detalhes -->
                            <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6 pb-6 border-b border-gray-200">
                                <!-- Modalidade -->
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 mb-1 uppercase tracking-wide">Modalidade</p>
                                    <div class="flex items-center text-gray-900">
                                        <i class="fas fa-<?= $vaga['modalidade'] == 1 ? 'map-marker-alt' : 'laptop' ?> mr-2 text-gray-500"></i>
                                        <span class="text-sm font-medium"><?= $modalidadeLabels[$vaga['modalidade']] ?? 'N/A' ?></span>
                                    </div>
                                </div>

                                <!-- Vínculo -->
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 mb-1 uppercase tracking-wide">Vínculo</p>
                                    <div class="flex items-center text-gray-900">
                                        <i class="fas fa-briefcase mr-2 text-gray-500"></i>
                                        <span class="text-sm font-medium"><?= $vinculoLabels[$vaga['vinculo']] ?? 'N/A' ?></span>
                                    </div>
                                </div>

                                <!-- Data Início -->
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 mb-1 uppercase tracking-wide">Início</p>
                                    <div class="flex items-center text-gray-900">
                                        <i class="fas fa-calendar-alt mr-2 text-gray-500"></i>
                                        <span class="text-sm font-medium"><?= $dataInicio->format('d/m/Y') ?></span>
                                    </div>
                                </div>

                                <!-- Data Fim -->
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 mb-1 uppercase tracking-wide">Encerramento</p>
                                    <div class="flex items-center text-gray-900">
                                        <i class="fas fa-hourglass-end mr-2 text-gray-500"></i>
                                        <span class="text-sm font-medium"><?= $dataFim->format('d/m/Y') ?></span>
                                    </div>
                                </div>

                                <!-- Dias Aberto -->
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 mb-1 uppercase tracking-wide">Dias</p>
                                    <div class="flex items-center text-gray-900">
                                        <i class="fas fa-clock mr-2 text-<?= $diasAberto > 7 ? 'green' : 'red' ?>-500"></i>
                                        <span class="text-sm font-medium"><?= max(0, $diasAberto) ?> dias</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Descrição Expandida -->
                            <div class="mb-6">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Sobre a Vaga</h4>
                                <p class="text-gray-700 leading-relaxed line-clamp-3"><?= nl2br(htmlspecialchars($vaga['sobreaVaga'] ?? '')) ?></p>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <span class="inline-block px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-semibold">
                                    <i class="fas fa-users mr-1"></i>
                                    <?= $vaga['candidatos'] ?? 0 ?> candidatos
                                </span>
                            </div>
                            <div class="flex gap-3">
                                <a href="<?= baseUrl() ?>VagasEmpresa/form/update/<?= $vaga['vaga_id'] ?>"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                                    <i class="fas fa-edit mr-1"></i>
                                    Editar
                                </a>
                                <a href="<?= baseUrl() ?>VagasEmpresa/form/delete/<?= $vaga['vaga_id'] ?>"
                                    class="inline-flex items-center px-4 py-2 border border-red-300 text-red-700 rounded-lg text-sm font-medium hover:bg-red-50 transition-all"
                                    onclick="return confirm('Tem certeza que deseja deletar esta vaga? Esta ação é irreversível.');">
                                    <i class="fas fa-trash mr-1"></i>
                                    Deletar
                                </a>
                                <a href="<?= baseUrl() ?>empresa/vagas/candidatos/<?= $vaga['vaga_id'] ?>"
                                    class="inline-flex items-center px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-black transition-all">
                                    <i class="fas fa-users mr-1"></i>
                                    Candidatos
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>
</div>

<!-- Estilos -->
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
