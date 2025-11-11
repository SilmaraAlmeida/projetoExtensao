<?php
$vaga = $dados['vaga'] ?? [];
$candidatos = $dados['candidatos'] ?? [];
?>

<div class="min-h-screen bg-gray-50">

    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <a href="<?= baseUrl() ?>VagasEmpresa"
                        class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors mb-2">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Voltar para Vagas
                    </a>
                    <h1 class="text-3xl font-bold text-gray-900">Candidatos</h1>
                    <p class="text-gray-600 mt-1"><?= htmlspecialchars($vaga['cargoDescricao'] ?? 'Vaga') ?> - Vaga #<?= $vaga['vaga_id'] ?? '' ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Area -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <?= exibeAlerta() ?>
    </div>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Total de Candidatos</p>
                        <p class="text-3xl font-bold text-gray-900 mt-1"><?= count($candidatos) ?></p>
                    </div>
                    <i class="fas fa-users text-3xl text-blue-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Status da Vaga</p>
                        <p class="text-lg font-bold text-gray-900 mt-1">
                            <?php
                            $status = match ($vaga['statusVaga'] ?? 1) {
                                1 => '⚪ Pré-vaga',
                                11 => '🟢 Em Aberto',
                                91 => '🟡 Suspensa',
                                99 => '🔴 Finalizada',
                                default => 'Desconhecido'
                            };
                            echo $status;
                            ?>
                        </p>
                    </div>
                    <i class="fas fa-info-circle text-3xl text-gray-200"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="flex items-center">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold">Período</p>
                        <p class="text-sm font-medium text-gray-900 mt-1">
                            <?= date('d/m/Y', strtotime($vaga['dtInicio'] ?? 'now')) ?> até <?= date('d/m/Y', strtotime($vaga['dtFim'] ?? 'now')) ?>
                        </p>
                    </div>
                    <i class="fas fa-calendar text-3xl text-gray-200"></i>
                </div>
            </div>
        </div>

        <!-- Empty State -->
        <?php if (empty($candidatos)): ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-8 py-16 text-center">
                    <i class="fas fa-user-slash text-6xl text-gray-300 mb-4"></i>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Nenhum candidato ainda</h3>
                    <p class="text-gray-600">Aguarde candidaturas para esta vaga ou divulgue mais!</p>
                </div>
            </div>
        <?php else: ?>

            <!-- Lista de Candidatos -->
            <div class="space-y-6">
                <?php foreach ($candidatos as $candidato): ?>
                    <?php
                    $pessoa = $candidato['pessoa'] ?? [];
                    $curriculum = $candidato['curriculum'] ?? [];
                    $educacoes = $candidato['educacoes'] ?? [];
                    $qualificacoes = $candidato['qualificacoes'] ?? [];
                    $experiencias = $candidato['experiencias'] ?? [];
                    $dateCandidatura = new DateTime($candidato['dateCandidatura']);
                    ?>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all">

                        <!-- Card Header -->
                        <div class="bg-gradient-to-r from-blue-50 to-white border-b border-gray-200 px-6 py-4">
                            <div class="flex items-start justify-between">
                                <div class="flex items-center gap-4">
                                    <!-- Foto -->
                                    <div class="flex-shrink-0">
                                        <img src="<?= !empty($curriculum['foto']) ? baseUrl() . 'uploads/fotos/' . $curriculum['foto'] : 'https://ui-avatars.com/api/?name=' . urlencode($pessoa['nome']) . '&size=80&background=3b82f6&color=fff' ?>"
                                            class="w-16 h-16 rounded-full object-cover border-2 border-blue-200"
                                            alt="<?= htmlspecialchars($pessoa['nome']) ?>">
                                    </div>

                                    <!-- Info -->
                                    <div>
                                        <h3 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($pessoa['nome']) ?></h3>
                                        <p class="text-gray-600 text-sm mt-1">
                                            <i class="fas fa-envelope mr-2"></i>
                                            <?= htmlspecialchars($curriculum['email'] ?? 'N/A') ?>
                                        </p>
                                        <p class="text-gray-600 text-sm">
                                            <i class="fas fa-phone mr-2"></i>
                                            <?= htmlspecialchars($curriculum['celular'] ?? 'N/A') ?>
                                        </p>
                                    </div>
                                </div>

                                <!-- Data Candidatura -->
                                <div class="text-right">
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                        <i class="fas fa-calendar-check mr-1"></i>
                                        Candidatura em <?= $dateCandidatura->format('d/m/Y') ?>
                                    </span>
                                    <p class="text-xs text-gray-500 mt-2">às <?= $dateCandidatura->format('H:i') ?></p>
                                </div>
                            </div>
                        </div>

                        <!-- Card Body -->
                        <div class="p-6">

                            <!-- Apresentação Pessoal -->
                            <?php if (!empty($curriculum['apresentacaoPessoal'])): ?>
                                <div class="mb-6 pb-6 border-b border-gray-200">
                                    <h4 class="text-sm font-bold text-gray-900 mb-2 uppercase tracking-wide">Apresentação</h4>
                                    <p class="text-gray-700 leading-relaxed"><?= nl2br(htmlspecialchars($curriculum['apresentacaoPessoal'])) ?></p>
                                </div>
                            <?php endif; ?>

                            <!-- Grid de Informações -->
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                                <!-- EDUCAÇÃO -->
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center">
                                        <i class="fas fa-graduation-cap mr-2 text-blue-600"></i>
                                        Educação
                                    </h4>
                                    <?php if (empty($educacoes)): ?>
                                        <p class="text-sm text-gray-500">Não informado</p>
                                    <?php else: ?>
                                        <div class="space-y-3">
                                            <?php foreach ($educacoes as $edu): ?>
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <p class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($edu['escolaridadeDescricao'] ?? 'N/A') ?></p>
                                                    <p class="text-xs text-gray-600 mt-1"><?= htmlspecialchars($edu['instituicao'] ?? 'N/A') ?></p>
                                                    <?php if (!empty($edu['descricao'])): ?>
                                                        <p class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($edu['descricao']) ?></p>
                                                    <?php endif; ?>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        <?= $edu['inicioAno'] ?? '' ?> - <?= $edu['fimAno'] ?? '' ?>
                                                    </p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- QUALIFICAÇÕES -->
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center">
                                        <i class="fas fa-certificate mr-2 text-yellow-600"></i>
                                        Qualificações
                                    </h4>
                                    <?php if (empty($qualificacoes)): ?>
                                        <p class="text-sm text-gray-500">Não informado</p>
                                    <?php else: ?>
                                        <div class="space-y-3">
                                            <?php foreach ($qualificacoes as $qual): ?>
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <p class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($qual['descricao'] ?? 'N/A') ?></p>
                                                    <p class="text-xs text-gray-600 mt-1"><?= htmlspecialchars($qual['estabelecimento'] ?? 'N/A') ?></p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        <?= $qual['ano'] ?? '' ?> • <?= $qual['cargaHoraria'] ?? '' ?>h
                                                    </p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <!-- EXPERIÊNCIAS -->
                                <div>
                                    <h4 class="text-sm font-bold text-gray-900 mb-3 flex items-center">
                                        <i class="fas fa-briefcase mr-2 text-green-600"></i>
                                        Experiências
                                    </h4>
                                    <?php if (empty($experiencias)): ?>
                                        <p class="text-sm text-gray-500">Não informado</p>
                                    <?php else: ?>
                                        <div class="space-y-3">
                                            <?php foreach ($experiencias as $exp): ?>
                                                <div class="bg-gray-50 rounded-lg p-3">
                                                    <p class="text-sm font-semibold text-gray-900"><?= htmlspecialchars($exp['cargoDescricao'] ?? 'N/A') ?></p>
                                                    <p class="text-xs text-gray-600 mt-1"><?= htmlspecialchars($exp['estabelecimento'] ?? 'N/A') ?></p>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        <?= $exp['inicioAno'] ?? '' ?> - <?= $exp['fimAno'] ?? 'Atual' ?>
                                                    </p>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        </div>

                        <!-- Card Footer -->
                        <div class="bg-gray-50 border-t border-gray-200 px-6 py-4 flex items-center justify-between">
                            <div class="text-sm text-gray-600">
                                <i class="fas fa-id-card mr-2"></i>
                                Curriculum ID: #<?= $curriculum['curriculum_id'] ?? 'N/A' ?>
                            </div>
                            <div class="flex gap-3">
                                <a href="mailto:<?= htmlspecialchars($curriculum['email'] ?? '') ?>"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-all">
                                    <i class="fas fa-envelope mr-2"></i>
                                    Contatar
                                </a>
                                <a href="https://wa.me/55<?= preg_replace('/\D/', '', $curriculum['celular'] ?? '') ?>"
                                    target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg text-sm font-medium hover:bg-green-700 transition-all">
                                    <i class="fab fa-whatsapp mr-2"></i>
                                    WhatsApp
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </div>
</div>