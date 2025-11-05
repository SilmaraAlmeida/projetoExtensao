<?php

$vaga = $dados['vaga'] ?? null;
$cargo = $dados['cargo'] ?? null;
$estabelecimento = $dados['estabelecimento'] ?? null;
$vagas_relacionadas = $dados['vagas_relacionadas'] ?? [];
$statusAtual = (int)$vaga['statusVaga'];
$modalidadeAtual = (int)$vaga['modalidade'];
$vinculoAtual = (int)$vaga['vinculo'];
$vagaAtiva = $statusAtual === 11;

$statusInfo = obterStatusInfo($statusAtual);
$vinculoInfo = obterVinculoInfo($vinculoAtual);
$modalidadeInfo = obterModalidadeInfo($modalidadeAtual);

// Formatação de datas otimizada
$dataInicio = !empty($vaga['dtInicio']) ? date('d/m/Y', strtotime($vaga['dtInicio'])) : null;
$dataFim = !empty($vaga['dtFim']) ? date('d/m/Y', strtotime($vaga['dtFim'])) : null;
$prazoVencido = $dataFim && strtotime($vaga['dtFim']) < time();

$tituloCompleto = htmlspecialchars($vaga['descricao']);
$estabelecimentoNome = $estabelecimento['nome'] ?? 'Estabelecimento não informado';
$cargoNome = $cargo['descricao'] ?? '';
?>

<!-- Breadcrumb Otimizado com Schema Markup -->
<section class="bg-white border-b border-gray-200 py-4" itemscope itemtype="https://schema.org/BreadcrumbList">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex items-center space-x-2 text-sm text-gray-500" aria-label="Breadcrumb">
            <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="/" class="hover:text-blue-600 transition-colors" itemprop="item">
                    <span itemprop="name">Home</span>
                </a>
                <meta itemprop="position" content="1">
            </span>
            <i class="fas fa-chevron-right text-xs" aria-hidden="true"></i>

            <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <a href="/vaga" class="hover:text-blue-600 transition-colors" itemprop="item">
                    <span itemprop="name">Vagas</span>
                </a>
                <meta itemprop="position" content="2">
            </span>
            <i class="fas fa-chevron-right text-xs" aria-hidden="true"></i>

            <span class="text-gray-900 font-medium" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                <span itemprop="name"><?= $tituloCompleto ?></span>
                <meta itemprop="position" content="3">
            </span>
        </nav>
    </div>
</section>

<!-- Conteúdo Principal -->
<main class="py-8 bg-gray-50" role="main">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            <!-- Seção Principal da Vaga -->
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-lg shadow-sm p-8">
                    <div class="flex flex-col lg:flex-row lg:justify-between lg:items-start gap-4 mb-6">
                        <div class="flex-1 min-w-0">
                            <h1 class="text-3xl font-bold text-gray-900 mb-4 break-words">
                                <?= $tituloCompleto ?>
                            </h1>

                            <!-- Informações Contextuais -->
                            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-6">
                                <span class="flex items-center" title="Estabelecimento">
                                    <i class="fas fa-building mr-2 text-blue-600 flex-shrink-0" aria-hidden="true"></i>
                                    <span class="truncate"><?= htmlspecialchars($estabelecimentoNome) ?></span>
                                </span>

                                <span class="flex items-center" title="Localização">
                                    <i class="fas fa-map-marker-alt mr-2 text-blue-600 flex-shrink-0" aria-hidden="true"></i>
                                    <span>Muriaé, MG</span>
                                </span>

                                <?php if ($dataInicio): ?>
                                    <span class="flex items-center" title="Data de início">
                                        <i class="fas fa-calendar mr-2 text-blue-600 flex-shrink-0" aria-hidden="true"></i>
                                        <span>Início: <?= $dataInicio ?></span>
                                    </span>
                                <?php endif; ?>

                                <?php if ($dataFim): ?>
                                    <span class="flex items-center <?= $prazoVencido ? 'text-red-600' : 'text-gray-600' ?>"
                                        title="<?= $prazoVencido ? 'Prazo vencido' : 'Prazo para candidatura' ?>">
                                        <i class="fas fa-calendar-times mr-2 flex-shrink-0" aria-hidden="true"></i>
                                        <span>Até: <?= $dataFim ?></span>
                                        <?php if ($prazoVencido): ?>
                                            <i class="fas fa-exclamation-triangle ml-1 text-red-500" aria-hidden="true"></i>
                                        <?php endif; ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Status Badge Aprimorado -->
                        <div class="flex-shrink-0">
                            <span class="inline-flex items-center px-4 py-2 <?= $statusInfo['class'] ?> text-sm rounded-full font-medium whitespace-nowrap">
                                <i class="<?= $statusInfo['icon'] ?> mr-2 flex-shrink-0" aria-hidden="true"></i>
                                <?= $statusInfo['texto'] ?>
                            </span>
                        </div>
                    </div>

                    <!-- Tags Otimizadas -->
                    <div class="flex flex-wrap gap-3 mb-6">
                        <?php if ($cargoNome): ?>
                            <span class="inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 text-sm rounded-full font-medium">
                                <i class="fas fa-briefcase mr-2 flex-shrink-0" aria-hidden="true"></i>
                                <span class="truncate"><?= htmlspecialchars($cargoNome) ?></span>
                            </span>
                        <?php endif; ?>

                        <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 text-sm rounded-full font-medium">
                            <i class="<?= $vinculoInfo['icon'] ?> mr-2 flex-shrink-0" aria-hidden="true"></i>
                            <?= $vinculoInfo['texto'] ?>
                        </span>

                        <span class="inline-flex items-center px-4 py-2 bg-<?= $modalidadeInfo['color'] ?>-100 text-<?= $modalidadeInfo['color'] ?>-800 text-sm rounded-full font-medium">
                            <i class="<?= $modalidadeInfo['icon'] ?> mr-2 flex-shrink-0" aria-hidden="true"></i>
                            <?= $modalidadeInfo['texto'] ?>
                        </span>
                    </div>
                </div>

                <!-- Descrição Otimizada -->
                <section class="bg-white rounded-lg shadow-sm p-8">
                    <h2 class="text-2xl font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-600 flex-shrink-0" aria-hidden="true"></i>
                        Sobre a Vaga
                    </h2>

                    <div class="prose max-w-none text-gray-700 leading-relaxed">
                        <?php if (!empty($vaga['sobreaVaga'])): ?>
                            <?= nl2br(htmlspecialchars($vaga['sobreaVaga'])) ?>
                        <?php else: ?>
                            <div class="text-center py-8">
                                <i class="fas fa-file-alt text-4xl text-gray-300 mb-3" aria-hidden="true"></i>
                                <p class="text-gray-500 italic">Descrição não disponível para esta vaga.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <!-- Informações Adicionais Otimizadas -->
                <?php
                $temInformacoesAdicionais = $dataFim || !empty($vaga['salario']) || !empty($vaga['beneficios']);
                if ($temInformacoesAdicionais):
                ?>
                    <section class="bg-white rounded-lg shadow-sm p-8">
                        <h2 class="text-2xl font-semibold text-gray-900 mb-6 flex items-center">
                            <i class="fas fa-list-ul mr-2 text-blue-600 flex-shrink-0" aria-hidden="true"></i>
                            Informações Adicionais
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php if ($dataFim): ?>
                                <div class="flex items-start p-4 rounded-lg <?= $prazoVencido ? 'bg-red-50 border border-red-200' : 'bg-blue-50 border border-blue-200' ?>">
                                    <i class="fas fa-calendar-times mr-3 mt-1 <?= $prazoVencido ? 'text-red-500' : 'text-blue-500' ?> flex-shrink-0" aria-hidden="true"></i>
                                    <div class="min-w-0 flex-1">
                                        <span class="block text-sm font-medium <?= $prazoVencido ? 'text-red-700' : 'text-blue-700' ?>">
                                            Prazo para candidatura:
                                        </span>
                                        <p class="font-semibold <?= $prazoVencido ? 'text-red-900' : 'text-blue-900' ?> break-words">
                                            <?= $dataFim ?>
                                            <?php if ($prazoVencido): ?>
                                                <span class="text-red-600 text-sm ml-2">(Vencido)</span>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($vaga['salario'])): ?>
                                <div class="flex items-start p-4 rounded-lg bg-green-50 border border-green-200">
                                    <i class="fas fa-money-bill-wave mr-3 mt-1 text-green-500 flex-shrink-0" aria-hidden="true"></i>
                                    <div class="min-w-0 flex-1">
                                        <span class="block text-sm font-medium text-green-700">Salário:</span>
                                        <p class="font-semibold text-green-900 break-words">
                                            R$ <?= number_format($vaga['salario'], 2, ',', '.') ?>
                                        </p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </section>
                <?php endif; ?>

            </div>

            <!-- Sidebar Otimizada -->
            <aside class="lg:col-span-1 space-y-6">

                <!-- Card de Ação Aprimorado -->
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user-plus mr-2 text-blue-600 flex-shrink-0" aria-hidden="true"></i>
                        Interessado na vaga?
                    </h3>

                    <?php if ($vagaAtiva && !$prazoVencido): ?>
                        <div class="space-y-3">
                            <button type="button"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                                aria-label="Candidatar-se à vaga">
                                <i class="fas fa-paper-plane mr-2" aria-hidden="true"></i>
                                Candidatar-se
                            </button>

                            <button type="button"
                                class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-medium transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                                aria-label="Salvar vaga para depois">
                                <i class="fas fa-heart mr-2" aria-hidden="true"></i>
                                Salvar Vaga
                            </button>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-6 px-4 bg-gray-50 rounded-lg border">
                            <i class="fas fa-info-circle text-gray-400 text-3xl mb-3" aria-hidden="true"></i>
                            <p class="text-gray-600 font-medium mb-2">
                                <?php if ($prazoVencido): ?>
                                    Prazo para candidatura expirado
                                <?php else: ?>
                                    Vaga não disponível
                                <?php endif; ?>
                            </p>
                            <p class="text-sm text-gray-500">
                                Esta vaga está <strong><?= strtolower($statusInfo['texto']) ?></strong>
                                <?= $prazoVencido ? ' e o prazo expirou' : ' e não aceita candidaturas' ?>.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Informações do Estabelecimento -->
                <?php if ($estabelecimento): ?>
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-building mr-2 text-blue-600 flex-shrink-0" aria-hidden="true"></i>
                            Sobre o Estabelecimento
                        </h3>

                        <div class="space-y-3">
                            <h4 class="font-medium text-gray-900 break-words">
                                <?= htmlspecialchars($estabelecimento['nome']) ?>
                            </h4>

                            <?php if (!empty($estabelecimento['endereco'])): ?>
                                <p class="text-sm text-gray-600 flex items-start">
                                    <i class="fas fa-map-marker-alt mr-2 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                    <span class="break-words"><?= htmlspecialchars($estabelecimento['endereco']) ?></span>
                                </p>
                            <?php endif; ?>

                            <a href="/vaga?estabelecimento_id=<?= $estabelecimento['estabelecimento_id'] ?>"
                                class="inline-flex items-center text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors focus:outline-none focus:underline">
                                <i class="fas fa-search mr-1" aria-hidden="true"></i>
                                Ver outras vagas deste estabelecimento
                                <i class="fas fa-arrow-right ml-1" aria-hidden="true"></i>
                            </a>
                        </div>
                    </section>
                <?php endif; ?>

                <!-- Vagas Relacionadas Otimizadas -->
                <?php if (!empty($vagas_relacionadas)): ?>
                    <section class="bg-white rounded-lg shadow-sm p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                            <i class="fas fa-lightbulb mr-2 text-blue-600 flex-shrink-0" aria-hidden="true"></i>
                            Vagas Relacionadas
                        </h3>

                        <div class="space-y-4">
                            <?php foreach ($vagas_relacionadas as $rel): ?>
                                <article class="border-l-4 border-blue-500 pl-4 py-2 hover:bg-blue-50 rounded-r transition-colors">
                                    <h4 class="font-medium text-gray-900 mb-1">
                                        <a href="/vaga/detalhes/<?= $rel['vaga_id'] ?>"
                                            class="hover:text-blue-600 transition-colors focus:outline-none focus:underline line-clamp-2"
                                            title="<?= htmlspecialchars($rel['descricao']) ?>">
                                            <?= htmlspecialchars($rel['descricao']) ?>
                                        </a>
                                    </h4>
                                    <p class="text-sm text-gray-500 flex items-center">
                                        <i class="fas fa-calendar mr-1 flex-shrink-0" aria-hidden="true"></i>
                                        <?= date('d/m/Y', strtotime($rel['dtInicio'])) ?>
                                    </p>
                                </article>
                            <?php endforeach; ?>
                        </div>

                        <div class="mt-4 pt-4 border-t border-gray-200">
                            <a href="/vaga"
                                class="inline-flex items-center justify-center w-full text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors focus:outline-none focus:underline">
                                <i class="fas fa-search mr-2" aria-hidden="true"></i>
                                Ver todas as vagas
                                <i class="fas fa-arrow-right ml-2" aria-hidden="true"></i>
                            </a>
                        </div>
                    </section>
                <?php endif; ?>

            </aside>

        </div>
    </div>
</main>