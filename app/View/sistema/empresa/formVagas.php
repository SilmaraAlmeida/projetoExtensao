<?php
$metodo = $this->request->getAction();
$vaga = $dados['vaga'] ?? [];
$cargos = $dados['cargos'] ?? [];

$isInsert = $metodo === 'insert';
$isUpdate = $metodo === 'update';
$isDelete = $metodo === 'delete';
?>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-2xl mx-auto px-4">
        
        <!-- Header -->
        <div class="mb-8">
            <a href="<?= baseUrl() ?>empresa/vagas"
                class="inline-flex items-center text-gray-600 hover:text-gray-900 transition-colors mb-4">
                <i class="fas fa-arrow-left mr-2"></i>
                Voltar para Vagas
            </a>
            
            <?php if ($isDelete): ?>
                <h1 class="text-2xl font-bold text-red-600">Deletar Vaga</h1>
            <?php elseif ($isUpdate): ?>
                <h1 class="text-2xl font-bold text-gray-900">Editar Vaga</h1>
            <?php else: ?>
                <h1 class="text-2xl font-bold text-gray-900">Criar Nova Vaga</h1>
            <?php endif; ?>
        </div>

        <!-- Alert Area -->
        <?= exibeAlerta() ?>

        <!-- ========== DELETE CONFIRMATION ========== -->
        <?php if ($isDelete): ?>
            <div class="bg-red-50 border border-red-200 rounded-xl p-6">
                <div class="flex items-start gap-4 mb-6">
                    <i class="fas fa-exclamation-triangle text-2xl text-red-600 mt-1"></i>
                    <div>
                        <h2 class="text-lg font-bold text-red-900">Deletar Vaga Permanentemente</h2>
                        <p class="text-red-800 text-sm mt-1">Esta ação é <strong>irreversível</strong>!</p>
                    </div>
                </div>

                <!-- Detalhes da Vaga -->
                <div class="bg-white rounded-lg p-4 mb-6 border border-red-200 text-sm">
                    <p><strong>Cargo:</strong> <?= htmlspecialchars($vaga['cargo']['descricao'] ?? 'N/A') ?></p>
                    <p class="mt-2"><strong>ID:</strong> #<?= $vaga['vaga_id'] ?></p>
                    <p class="mt-2"><strong>Candidatos:</strong> <?= $vaga['candidatos'] ?? 0 ?></p>
                </div>

                <!-- Botões -->
                <form method="POST" action="<?= $this->request->formAction() ?>">
                    <input type="hidden" name="vaga_id" value="<?= setValor('vaga_id', $vaga['vaga_id'] ?? '') ?>">
                    <div class="flex gap-3 justif   y-end">
                        <a href="<?= baseUrl() ?>empresa/vagas"
                            class="px-4 py-2 border border-red-300 text-red-700 rounded-lg text-sm font-medium hover:bg-red-50 transition-all">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-4 py-2 bg-red-600 text-white rounded-lg text-sm font-medium hover:bg-red-700 transition-all"
                            onclick="return confirm('Tem certeza? Esta ação não pode ser desfeita.');">
                            Deletar Vaga
                        </button>
                    </div>
                </form>
            </div>

        <!-- ========== FORM INSERT/UPDATE ========== -->
        <?php else: ?>
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <form method="POST" action="<?= $this->request->formAction() ?>">

                    <input type="hidden" name="vaga_id" value="<?= setValor('vaga_id', $vaga['vaga_id'] ?? '') ?>">
                    <input type="hidden" name="estabelecimento_id" value="<?= setValor('estabelecimento_id', $vaga['estabelecimento_id'] ?? '') ?>">

                    <div class="space-y-6">

                        <!-- SEÇÃO 1: INFORMAÇÕES BÁSICAS -->
                        <div>
                            <h2 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wide">Informações Básicas</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                <!-- Cargo -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        Cargo <span class="text-red-500">*</span>
                                    </label>
                                    <select name="cargo_id"
                                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-gray-300"
                                        required>
                                        <option value="">Selecione</option>
                                        <?php foreach ($cargos as $cargo): ?>
                                            <option value="<?= $cargo['cargo_id'] ?>" 
                                                <?= (setValor('cargo_id', $vaga['cargo_id'] ?? '') == $cargo['cargo_id'] ? 'selected' : '') ?>>
                                                <?= htmlspecialchars($cargo['descricao']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= setMsgFilderError('cargo_id') ?>
                                </div>

                                <!-- Status -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        Status <span class="text-red-500">*</span>
                                    </label>
                                    <select name="statusVaga"
                                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-gray-300"
                                        required>
                                        <option value="1" <?= (setValor('statusVaga', $vaga['statusVaga'] ?? 1) == 1 ? 'selected' : '') ?>>Pré-vaga</option>
                                        <option value="11" <?= (setValor('statusVaga', $vaga['statusVaga'] ?? 1) == 11 ? 'selected' : '') ?>>Em aberto</option>
                                        <option value="91" <?= (setValor('statusVaga', $vaga['statusVaga'] ?? 1) == 91 ? 'selected' : '') ?>>Suspensa</option>
                                        <option value="99" <?= (setValor('statusVaga', $vaga['statusVaga'] ?? 1) == 99 ? 'selected' : '') ?>>Finalizada</option>
                                    </select>
                                    <?= setMsgFilderError('statusVaga') ?>
                                </div>

                                <!-- Modalidade -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        Modalidade <span class="text-red-500">*</span>
                                    </label>
                                    <select name="modalidade"
                                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-gray-300"
                                        required>
                                        <option value="">Selecione</option>
                                        <option value="1" <?= (setValor('modalidade', $vaga['modalidade'] ?? '') == 1 ? 'selected' : '') ?>>Presencial</option>
                                        <option value="2" <?= (setValor('modalidade', $vaga['modalidade'] ?? '') == 2 ? 'selected' : '') ?>>Remoto</option>
                                    </select>
                                    <?= setMsgFilderError('modalidade') ?>
                                </div>

                                <!-- Vínculo -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        Vínculo <span class="text-red-500">*</span>
                                    </label>
                                    <select name="vinculo"
                                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-gray-300"
                                        required>
                                        <option value="">Selecione</option>
                                        <option value="1" <?= (setValor('vinculo', $vaga['vinculo'] ?? '') == 1 ? 'selected' : '') ?>>CLT</option>
                                        <option value="2" <?= (setValor('vinculo', $vaga['vinculo'] ?? '') == 2 ? 'selected' : '') ?>>PJ</option>
                                    </select>
                                    <?= setMsgFilderError('vinculo') ?>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- SEÇÃO 2: DATAS -->
                        <div>
                            <h2 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wide">Período de Inscrição</h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                
                                <!-- Data Início -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        Data Início <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="dtInicio"
                                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-gray-300"
                                        value="<?= setValor('dtInicio', $vaga['dtInicio'] ?? '') ?>"
                                        required>
                                    <?= setMsgFilderError('dtInicio') ?>
                                </div>

                                <!-- Data Fim -->
                                <div>
                                    <label class="block text-xs font-semibold text-gray-700 mb-1">
                                        Data Fim <span class="text-red-500">*</span>
                                    </label>
                                    <input type="date" name="dtFim"
                                        class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-gray-300"
                                        value="<?= setValor('dtFim', $vaga['dtFim'] ?? '') ?>"
                                        required>
                                    <?= setMsgFilderError('dtFim') ?>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- SEÇÃO 3: DESCRIÇÕES -->
                        <div>
                            <h2 class="text-sm font-bold text-gray-900 mb-4 uppercase tracking-wide">Descrições</h2>
                            
                            <!-- Descrição Breve -->
                            <div class="mb-4">
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    Descrição Breve <span class="text-red-500">*</span>
                                </label>
                                <textarea name="descricao" rows="2"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-gray-300 resize-none"
                                    placeholder="Ex: Desenvolvedor Full Stack React e Node.js"
                                    required><?= setValor('descricao', $vaga['descricao'] ?? '') ?></textarea>
                                <?= setMsgFilderError('descricao') ?>
                            </div>

                            <!-- Informações Detalhadas -->
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1">
                                    Informações Detalhadas <span class="text-red-500">*</span>
                                </label>
                                <textarea name="sobreaVaga" rows="5"
                                    class="w-full px-3 py-2 border-2 border-gray-200 rounded-lg text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all hover:border-gray-300 resize-none"
                                    placeholder="Responsabilidades, requisitos, benefícios, horário, local..."
                                    required><?= setValor('sobreaVaga', $vaga['sobreaVaga'] ?? '') ?></textarea>
                                <?= setMsgFilderError('sobreaVaga') ?>
                            </div>
                        </div>
                    </div>

                    <!-- Botões -->
                    <div class="mt-8 pt-6 border-t border-gray-200 flex gap-3 justify-end">
                        <a href="<?= baseUrl() ?>empresa/vagas"
                            class="px-6 py-2 border-2 border-gray-200 text-gray-700 rounded-lg text-sm font-medium hover:border-gray-300 hover:bg-gray-50 transition-all">
                            Cancelar
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-all">
                            <i class="fas fa-save mr-2"></i>
                            <?= $isInsert ? 'Criar Vaga' : 'Atualizar Vaga' ?>
                        </button>
                    </div>

                </form>
            </div>
        <?php endif; ?>

    </div>
</div>
