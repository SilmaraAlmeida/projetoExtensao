<?php

$dados = $dados['dados'] ?? [];
$cidades = $dados['cidades'] ?? [];
$escolaridades = $dados['escolaridades'] ?? [];
$cargos = $dados['cargos'] ?? [];
$curriculum = $dados['curriculum'] ?? [];
$educacoes = $dados['educacoes'] ?? [];
$qualificacoes = $dados['qualificacoes'] ?? [];
$experiencias = $dados['experiencias'] ?? [];
$possuiCurriculum = !empty($curriculum['curriculum_id']);

?>
<div class="min-h-screen bg-gray-50" x-data="curriculoData()">
    <!-- Header -->
    <div class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Currículo</h1>
                    <p class="text-gray-600 mt-1">
                        <?= $possuiCurriculum ? 'Visualize e edite seu currículo profissional' : 'Crie seu currículo profissional' ?>
                    </p>
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
        <form action="<?= baseUrl() ?>candidato/salvarCurriculo" method="POST" enctype="multipart/form-data" class="space-y-8">
            
            <input type="hidden" name="curriculum_id" value="<?= $curriculum['curriculum_id'] ?? '' ?>">
            <input type="hidden" name="pessoa_fisica_id" value="<?= $dados['pessoa_fisica_id'] ?? '' ?>">

            <!-- ========== DADOS PESSOAIS ========== -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 text-sm font-bold mr-3">1</span>
                        Dados Pessoais
                    </h3>
                    <p class="text-xs text-gray-500 mt-1 ml-11">Informações básicas do currículo</p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Email -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">E-mail</label>
                            <input type="email" name="email" value="<?= $curriculum['email'] ?? '' ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                placeholder="seu@email.com" required>
                        </div>

                        <!-- Celular -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Celular</label>
                            <input type="text" name="celular" x-model="celular" @input="formatarCelular()"
                                value="<?= $curriculum['celular'] ?? '' ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                placeholder="(32) 99999-9999" maxlength="15" required>
                        </div>

                        <!-- Data de Nascimento -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Data de Nascimento</label>
                            <input type="date" name="dataNascimento" value="<?= $curriculum['dataNascimento'] ?? '' ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" required>
                        </div>

                        <!-- Sexo -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Sexo</label>
                            <select name="sexo" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" required>
                                <option value="">Selecione uma opção</option>
                                <option value="M" <?= ($curriculum['sexo'] ?? '') === 'M' ? 'selected' : '' ?>>Masculino</option>
                                <option value="F" <?= ($curriculum['sexo'] ?? '') === 'F' ? 'selected' : '' ?>>Feminino</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ========== ENDEREÇO ========== -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 text-sm font-bold mr-3">2</span>
                        Endereço
                    </h3>
                    <p class="text-xs text-gray-500 mt-1 ml-11">Onde você mora</p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">CEP</label>
                            <input type="text" name="cep" x-model="cep" @input="formatarCEP()"
                                value="<?= $curriculum['cep'] ?? '' ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                placeholder="00000-000" maxlength="9" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Cidade</label>
                            <select name="cidade_id" class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" required>
                                <option value="">Selecione uma cidade</option>
                                <?php foreach ($cidades as $cidade): ?>
                                    <option value="<?= $cidade['cidade_id'] ?>" <?= ($curriculum['cidade_id'] ?? '') == $cidade['cidade_id'] ? 'selected' : '' ?>>
                                        <?= $cidade['cidade'] ?> - <?= $cidade['uf'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Logradouro</label>
                            <input type="text" name="logradouro" value="<?= $curriculum['logradouro'] ?? '' ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                placeholder="Rua, Avenida, etc" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Número</label>
                            <input type="text" name="numero" value="<?= $curriculum['numero'] ?? '' ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                placeholder="123" required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Complemento</label>
                            <input type="text" name="complemento" value="<?= $curriculum['complemento'] ?? '' ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                placeholder="Apto, Bloco, etc">
                        </div>

                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Bairro</label>
                            <input type="text" name="bairro" value="<?= $curriculum['bairro'] ?? '' ?>"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                placeholder="Centro" required>
                        </div>

                    </div>
                </div>
            </div>

            <!-- ========== APRESENTAÇÃO PESSOAL ========== -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white">
                    <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                        <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 text-sm font-bold mr-3">3</span>
                        Apresentação Pessoal
                    </h3>
                    <p class="text-xs text-gray-500 mt-1 ml-11">Fale sobre você (opcional)</p>
                </div>

                <div class="p-6">
                    <textarea name="apresentacaoPessoal" rows="5"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all resize-none"
                        placeholder="Conte um pouco sobre você, suas experiências e objetivos profissionais. Ex: Profissional dedicado com 5 anos de experiência em..."><?= $curriculum['apresentacaoPessoal'] ?? '' ?></textarea>
                    <p class="text-xs text-gray-500 mt-2">Máximo 500 caracteres</p>
                </div>
            </div>

            <!-- ========== EDUCAÇÃO ========== -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 text-sm font-bold mr-3">4</span>
                            Educação
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 ml-11">Ensino fundamental, médio, superior, etc</p>
                    </div>
                    <button type="button" @click="adicionarEducacao()" 
                        class="inline-flex items-center px-4 py-2 border-2 border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Adicionar
                    </button>
                </div>

                <div class="p-6">
                    <div x-show="educacoes.length === 0" class="text-center py-12 text-gray-400">
                        <i class="fas fa-book text-4xl mb-3"></i>
                        <p>Nenhuma educação cadastrada</p>
                        <p class="text-sm mt-1">Adicione suas formações clicando no botão acima</p>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(edu, index) in educacoes" :key="index">
                            <div class="border border-gray-200 rounded-lg p-5 hover:shadow-sm hover:border-gray-300 transition-all bg-gradient-to-br from-gray-50 to-white">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded">
                                        <i class="fas fa-graduation-cap mr-1"></i>
                                        Educação <span x-text="index + 1"></span>
                                    </span>
                                    <button type="button" @click="removerEducacao(index)"
                                        class="text-gray-400 hover:text-red-600 transition-colors">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Escolaridade</label>
                                        <select :name="'educacoes[' + index + '][escolaridade_id]'" 
                                            x-model="educacoes[index].escolaridade_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                                            <option value="">Selecione</option>
                                            <?php foreach ($escolaridades as $e): ?>
                                                <option value="<?= $e['escolaridade_id'] ?>"><?= $e['descricao'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Instituição</label>
                                        <input type="text" :name="'educacoes[' + index + '][instituicao]'" 
                                            x-model="educacoes[index].instituicao"
                                            class="w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                            placeholder="USP, UFMG, FIAP...">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Descrição</label>
                                        <input type="text" :name="'educacoes[' + index + '][descricao]'" 
                                            x-model="educacoes[index].descricao"
                                            class="w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                            placeholder="Ex: Análise e Desenvolvimento de Sistemas">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Cidade</label>
                                        <select :name="'educacoes[' + index + '][cidade_id]'" 
                                            x-model="educacoes[index].cidade_id"
                                            class="w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                                            <option value="">Selecione</option>
                                            <?php foreach ($cidades as $c): ?>
                                                <option value="<?= $c['cidade_id'] ?>"><?= $c['cidade'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Início</label>
                                        <div class="flex gap-2">
                                            <select :name="'educacoes[' + index + '][inicioMes]'" x-model="educacoes[index].inicioMes"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                                                <option value="">Mês</option>
                                                <option value="1">Jan</option><option value="2">Fev</option><option value="3">Mar</option><option value="4">Abr</option>
                                                <option value="5">Mai</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Ago</option>
                                                <option value="9">Set</option><option value="10">Out</option><option value="11">Nov</option><option value="12">Dez</option>
                                            </select>
                                            <input type="number" :name="'educacoes[' + index + '][inicioAno]'" x-model="educacoes[index].inicioAno"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                                placeholder="Ano" min="1950" :max="new Date().getFullYear()">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Fim</label>
                                        <div class="flex gap-2">
                                            <select :name="'educacoes[' + index + '][fimMes]'" x-model="educacoes[index].fimMes"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                                                <option value="">Mês</option>
                                                <option value="1">Jan</option><option value="2">Fev</option><option value="3">Mar</option><option value="4">Abr</option>
                                                <option value="5">Mai</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Ago</option>
                                                <option value="9">Set</option><option value="10">Out</option><option value="11">Nov</option><option value="12">Dez</option>
                                            </select>
                                            <input type="number" :name="'educacoes[' + index + '][fimAno]'" x-model="educacoes[index].fimAno"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                                placeholder="Ano" min="1950" :max="new Date().getFullYear()">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- ========== QUALIFICAÇÕES ========== -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 text-sm font-bold mr-3">5</span>
                            Qualificações
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 ml-11">Cursos, certificados, treinamentos</p>
                    </div>
                    <button type="button" @click="adicionarQualificacao()" 
                        class="inline-flex items-center px-4 py-2 border-2 border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Adicionar
                    </button>
                </div>

                <div class="p-6">
                    <div x-show="qualificacoes.length === 0" class="text-center py-12 text-gray-400">
                        <i class="fas fa-certificate text-4xl mb-3"></i>
                        <p>Nenhuma qualificação cadastrada</p>
                        <p class="text-sm mt-1">Adicione seus cursos clicando no botão acima</p>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(qual, index) in qualificacoes" :key="index">
                            <div class="border border-gray-200 rounded-lg p-5 hover:shadow-sm hover:border-gray-300 transition-all bg-gradient-to-br from-gray-50 to-white">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded">
                                        <i class="fas fa-certificate mr-1"></i>
                                        Qualificação <span x-text="index + 1"></span>
                                    </span>
                                    <button type="button" @click="removerQualificacao(index)"
                                        class="text-gray-400 hover:text-red-600 transition-colors">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Nome do Curso</label>
                                        <input type="text" :name="'qualificacoes[' + index + '][descricao]'" 
                                            x-model="qualificacoes[index].descricao"
                                            class="w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                            placeholder="Ex: Excel Avançado, Python, Marketing Digital">
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Instituição</label>
                                        <input type="text" :name="'qualificacoes[' + index + '][estabelecimento]'" 
                                            x-model="qualificacoes[index].estabelecimento"
                                            class="w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                            placeholder="SENAI, SENAC, Udemy, Coursera...">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Conclusão</label>
                                        <div class="flex gap-2">
                                            <select :name="'qualificacoes[' + index + '][mes]'" x-model="qualificacoes[index].mes"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                                                <option value="">Mês</option>
                                                <option value="1">Jan</option><option value="2">Fev</option><option value="3">Mar</option><option value="4">Abr</option>
                                                <option value="5">Mai</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Ago</option>
                                                <option value="9">Set</option><option value="10">Out</option><option value="11">Nov</option><option value="12">Dez</option>
                                            </select>
                                            <input type="number" :name="'qualificacoes[' + index + '][ano]'" x-model="qualificacoes[index].ano"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                                placeholder="Ano" min="1950" :max="new Date().getFullYear()">
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Carga Horária</label>
                                        <div class="flex items-center">
                                            <input type="number" :name="'qualificacoes[' + index + '][cargaHoraria]'" x-model="qualificacoes[index].cargaHoraria"
                                                class="flex-1 px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                                placeholder="Horas" min="1">
                                            <span class="text-sm text-gray-500 ml-2">h</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- ========== EXPERIÊNCIA ========== -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center">
                            <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gray-200 text-gray-700 text-sm font-bold mr-3">6</span>
                            Experiência Profissional
                        </h3>
                        <p class="text-xs text-gray-500 mt-1 ml-11">Empregos e trabalhos anteriores</p>
                    </div>
                    <button type="button" @click="adicionarExperiencia()" 
                        class="inline-flex items-center px-4 py-2 border-2 border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all">
                        <i class="fas fa-plus mr-2"></i>
                        Adicionar
                    </button>
                </div>

                <div class="p-6">
                    <div x-show="experiencias.length === 0" class="text-center py-12 text-gray-400">
                        <i class="fas fa-briefcase text-4xl mb-3"></i>
                        <p>Nenhuma experiência cadastrada</p>
                        <p class="text-sm mt-1">Adicione seus empregos clicando no botão acima</p>
                    </div>

                    <div class="space-y-4">
                        <template x-for="(exp, index) in experiencias" :key="index">
                            <div class="border border-gray-200 rounded-lg p-5 hover:shadow-sm hover:border-gray-300 transition-all bg-gradient-to-br from-gray-50 to-white">
                                <div class="flex justify-between items-start mb-4">
                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-700 text-xs font-semibold rounded">
                                        <i class="fas fa-briefcase mr-1"></i>
                                        Experiência <span x-text="index + 1"></span>
                                    </span>
                                    <button type="button" @click="removerExperiencia(index)"
                                        class="text-gray-400 hover:text-red-600 transition-colors">
                                        <i class="fas fa-trash text-lg"></i>
                                    </button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Empresa</label>
                                        <input type="text" :name="'experiencias[' + index + '][estabelecimento]'" 
                                            x-model="experiencias[index].estabelecimento"
                                            class="w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                            placeholder="Nome da empresa">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Cargo</label>
                                        <input type="text" :name="'experiencias[' + index + '][cargoDescricao]'" 
                                            x-model="experiencias[index].cargoDescricao"
                                            class="w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                            placeholder="Ex: Desenvolvedor Junior">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Período</label>
                                        <div class="flex gap-1 items-center text-xs text-gray-600">
                                            <select :name="'experiencias[' + index + '][inicioMes]'" x-model="experiencias[index].inicioMes"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                                                <option value="">Mês</option>
                                                <option value="1">Jan</option><option value="2">Fev</option><option value="3">Mar</option><option value="4">Abr</option>
                                                <option value="5">Mai</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Ago</option>
                                                <option value="9">Set</option><option value="10">Out</option><option value="11">Nov</option><option value="12">Dez</option>
                                            </select>
                                            <input type="number" :name="'experiencias[' + index + '][inicioAno]'" x-model="experiencias[index].inicioAno"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                                placeholder="Ano" min="1950" :max="new Date().getFullYear()">
                                            <span class="text-gray-500">até</span>
                                            <select :name="'experiencias[' + index + '][fimMes]'" x-model="experiencias[index].fimMes"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all">
                                                <option value="">Atual</option>
                                                <option value="1">Jan</option><option value="2">Fev</option><option value="3">Mar</option><option value="4">Abr</option>
                                                <option value="5">Mai</option><option value="6">Jun</option><option value="7">Jul</option><option value="8">Ago</option>
                                                <option value="9">Set</option><option value="10">Out</option><option value="11">Nov</option><option value="12">Dez</option>
                                            </select>
                                            <input type="number" :name="'experiencias[' + index + '][fimAno]'" x-model="experiencias[index].fimAno"
                                                class="flex-1 px-2 py-2 border border-gray-300 rounded text-sm text-gray-700 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all" 
                                                placeholder="Ano" min="1950" :max="new Date().getFullYear()">
                                        </div>
                                    </div>
                                    <div class="md:col-span-2">
                                        <label class="block text-xs font-semibold text-gray-700 mb-1">Atividades e Responsabilidades</label>
                                        <textarea :name="'experiencias[' + index + '][atividadesExercidas]'" 
                                            x-model="experiencias[index].atividadesExercidas"
                                            class="w-full px-3 py-2 border border-gray-300 rounded text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:border-gray-500 focus:ring-2 focus:ring-gray-200 transition-all resize-none" 
                                            rows="3" placeholder="Descreva suas principais responsabilidades..."></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- ========== BOTÕES ========== -->
            <div class="sticky bottom-0 bg-white border-t border-gray-200 shadow-lg -mx-4 sm:-mx-6 lg:-mx-8 px-4 sm:px-6 lg:px-8 py-4">
                <div class="max-w-7xl mx-auto flex justify-end gap-4">
                    <a href="<?= baseUrl() ?>Sistema/"
                        class="inline-flex items-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg text-base font-semibold hover:border-gray-400 hover:bg-gray-50 transition-all">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Cancelar
                    </a>
                    <button type="submit"
                        class="inline-flex items-center px-8 py-3 bg-gray-900 text-white rounded-lg text-base font-semibold hover:bg-black active:scale-95 transition-all shadow-md hover:shadow-lg">
                        <i class="fas fa-save mr-2"></i>
                        Salvar Currículo
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

<script>
function curriculoData() {
    return {
        celular: '<?= $curriculum['celular'] ?? '' ?>',
        cep: '<?= $curriculum['cep'] ?? '' ?>',
        fotoPreview: null,
        educacoes: <?= json_encode($educacoes) ?>,
        qualificacoes: <?= json_encode($qualificacoes) ?>,
        experiencias: <?= json_encode($experiencias) ?>,

        formatarCelular() {
            let value = this.celular.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
                value = value.replace(/(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            this.celular = value;
        },

        formatarCEP() {
            let value = this.cep.replace(/\D/g, '');
            value = value.replace(/(\d{5})(\d)/, '$1-$2');
            this.cep = value;
        },

        previewFoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    this.fotoPreview = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        adicionarEducacao() {
            this.educacoes.push({
                curriculum_escolaridade_id: null,
                escolaridade_id: '',
                instituicao: '',
                descricao: '',
                cidade_id: '',
                inicioMes: '',
                inicioAno: new Date().getFullYear(),
                fimMes: '',
                fimAno: new Date().getFullYear()
            });
        },

        removerEducacao(index) {
            if (confirm('Tem certeza que deseja remover esta educação?')) {
                this.educacoes.splice(index, 1);
            }
        },

        adicionarQualificacao() {
            this.qualificacoes.push({
                curriculum_qualificacao_id: null,
                descricao: '',
                estabelecimento: '',
                mes: '',
                ano: new Date().getFullYear(),
                cargaHoraria: ''
            });
        },

        removerQualificacao(index) {
            if (confirm('Tem certeza que deseja remover esta qualificação?')) {
                this.qualificacoes.splice(index, 1);
            }
        },

        adicionarExperiencia() {
            this.experiencias.push({
                curriculum_experiencia_id: null,
                estabelecimento: '',
                cargoDescricao: '',
                inicioMes: '',
                inicioAno: new Date().getFullYear(),
                fimMes: '',
                fimAno: '',
                atividadesExercidas: ''
            });
        },

        removerExperiencia(index) {
            if (confirm('Tem certeza que deseja remover esta experiência?')) {
                this.experiencias.splice(index, 1);
            }
        }
    }
}
</script>
