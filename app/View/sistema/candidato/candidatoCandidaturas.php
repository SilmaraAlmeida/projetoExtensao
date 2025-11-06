<?php
$candidaturas = $dados['candidaturas'] ?? [];
$statusVagaLabels = [
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
                    <h1 class="text-3xl font-bold text-gray-900">Minhas Candidaturas</h1>
                    <p class="text-gray-600 mt-1">Acompanhe todas as vagas em que você se inscreveu</p>
                </div>
                <a href="<?= baseUrl() ?>Sistema/"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Voltar
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
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Status da Vaga</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                        <option value="">Todos</option>
                        <option value="11">Em aberto</option>
                        <option value="1">Pré-vaga</option>
                        <option value="91">Suspensa</option>
                        <option value="99">Finalizada</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Modalidade</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                        <option value="">Todas</option>
                        <option value="1">Presencial</option>
                        <option value="2">Remoto</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Vínculo</label>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                        <option value="">Todos</option>
                        <option value="1">CLT</option>
                        <option value="2">PJ</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <?php if (empty($candidaturas)): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-16 text-center">
                    <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhuma candidatura encontrada</h3>
                    <p class="text-gray-600 mb-6">Você ainda não se inscreveu em nenhuma vaga. Explore vagas disponíveis e comece a se candidatar!</p>
                    <a href="<?= baseUrl() ?>vaga"
                        class="inline-flex items-center px-6 py-3 bg-gray-900 text-white rounded-lg text-base font-semibold hover:bg-black transition-all">
                        <i class="fas fa-search mr-2"></i>
                        Ver Vagas Disponíveis
                    </a>
                </div>
            </div>
        <?php else: ?>

            <!-- Lista de Candidaturas -->
            <div class="space-y-6">
                <?php foreach ($candidaturas as $candidatura): ?>
                    <?php
                        $vaga = $candidatura['vaga'] ?? [];
                        $cargo = $vaga['cargo'] ?? [];
                        $estabelecimento = $vaga['estabelecimento'] ?? [];
                        $statusVaga = $vaga['statusVaga'] ?? 1;
                        $statusInfo = $statusVagaLabels[$statusVaga] ?? ['Desconhecido', 'gray'];
                        $dateCandidatura = new DateTime($candidatura['dateCandidatura']);
                        $hoje = new DateTime();
                        $intervalo = $hoje->diff($dateCandidatura);
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
                                <p class="text-gray-600 flex items-center">
                                    <i class="fas fa-building mr-2"></i>
                                    <?= htmlspecialchars($estabelecimento['nome'] ?? 'Empresa') ?>
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    <?php
                                        if ($intervalo->days == 0) {
                                            echo 'Hoje';
                                        } elseif ($intervalo->days == 1) {
                                            echo 'Ontem';
                                        } elseif ($intervalo->days < 7) {
                                            echo $intervalo->days . ' dias atrás';
                                        } elseif ($intervalo->days < 30) {
                                            echo (int)($intervalo->days / 7) . ' semana' . ((int)($intervalo->days / 7) > 1 ? 's' : '') . ' atrás';
                                        } else {
                                            echo (int)($intervalo->days / 30) . ' mês' . ((int)($intervalo->days / 30) > 1 ? 'es' : '') . ' atrás';
                                        }
                                    ?>
                                </p>
                                <p class="text-xs text-gray-500 mt-1">
                                    <?= $dateCandidatura->format('d/m/Y H:i') ?>
                                </p>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="px-6 py-6">
                            <!-- Descrição da Vaga -->
                            <div class="mb-6 pb-6 border-b border-gray-200">
                                <h4 class="text-sm font-semibold text-gray-700 mb-2">Sobre a Vaga</h4>
                                <p class="text-gray-700 line-clamp-2"><?= htmlspecialchars($vaga['descricao'] ?? '') ?></p>
                                <?php if (!empty($vaga['sobreaVaga'])): ?>
                                    <p class="text-gray-600 text-sm mt-3 leading-relaxed"><?= nl2br(htmlspecialchars($vaga['sobreaVaga'])) ?></p>
                                <?php endif; ?>
                            </div>

                            <!-- Detalhes -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
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
                                        <i class="fas fa-play-circle mr-2 text-gray-500"></i>
                                        <span class="text-sm font-medium">
                                            <?= (new DateTime($vaga['dtInicio']))->format('d/m/Y') ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Data Fim -->
                                <div>
                                    <p class="text-xs font-semibold text-gray-700 mb-1 uppercase tracking-wide">Encerramento</p>
                                    <div class="flex items-center text-gray-900">
                                        <i class="fas fa-stop-circle mr-2 text-gray-500"></i>
                                        <span class="text-sm font-medium">
                                            <?= (new DateTime($vaga['dtFim']))->format('d/m/Y') ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-info-circle mr-2"></i>
                                <span>ID da candidatura: #<?= $candidatura['vaga_id'] ?>-<?= $candidatura['curriculum_id'] ?></span>
                            </div>
                            <div class="flex gap-3">
                                <a href="<?= baseUrl() ?>vaga/detalhes/view/<?= $candidatura['vaga_id'] ?>"
                                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-all">
                                    <i class="fas fa-eye mr-1"></i>
                                    Ver Vaga
                                </a>
                                <?php if ($statusVaga == 11): ?>
                                    <button class="inline-flex items-center px-4 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-black transition-all">
                                        <i class="fas fa-envelope mr-1"></i>
                                        Contatar
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>
</div>

<!-- Estilos para line-clamp -->
<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
