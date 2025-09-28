<?php

use Core\Library\Session; ?>

<div class="min-h-screen bg-gray-50">
    <!-- Header do Dashboard -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        Painel de Controle
                    </h1>
                    <p class="text-gray-600 mt-1">
                        Bem-vindo, <?= Session::get('userNome') ?>!
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <span class="px-3 py-1 bg-blue-100 text-blue-800 text-sm font-medium rounded-full">
                        <?php
                        $nivel = Session::get('userNivel');
                        switch ($nivel) {
                            case 'G':
                                echo 'Gestor';
                                break;
                            case 'A':
                                echo 'Empresa';
                                break;
                            case 'CN':
                                echo 'Candidato';
                                break;
                            default:
                                echo 'Usuário';
                                break;
                        }
                        ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Cards do Dashboard -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

            <?php $userNivel = Session::get('userNivel'); ?>

            <?php if ($userNivel === 'G'): ?>
                <!-- Cards do Gestor -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-200">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gerenciar Usuários</h3>
                    <p class="text-gray-600 text-sm mb-4">Cadastrar, editar e gerenciar usuários do sistema</p>
                    <a href="<?= baseUrl() ?>sistema/usuarios" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors duration-200">
                            <i class="fas fa-building text-2xl text-green-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gerenciar Empresas</h3>
                    <p class="text-gray-600 text-sm mb-4">Cadastrar e aprovar empresas no sistema</p>
                    <a href="<?= baseUrl() ?>sistema/empresas" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors duration-200">
                            <i class="fas fa-briefcase text-2xl text-purple-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gerenciar Vagas</h3>
                    <p class="text-gray-600 text-sm mb-4">Moderar e aprovar vagas publicadas</p>
                    <a href="<?= baseUrl() ?>sistema/vagas" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors duration-200">
                            <i class="fas fa-chart-bar text-2xl text-orange-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Relatórios</h3>
                    <p class="text-gray-600 text-sm mb-4">Visualizar estatísticas e relatórios do sistema</p>
                    <a href="<?= baseUrl() ?>sistema/relatorios" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-100 rounded-lg group-hover:bg-red-200 transition-colors duration-200">
                            <i class="fas fa-cogs text-2xl text-red-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Configurações</h3>
                    <p class="text-gray-600 text-sm mb-4">Configurar parâmetros do sistema</p>
                    <a href="<?= baseUrl() ?>sistema/configuracoes" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gray-100 rounded-lg group-hover:bg-gray-200 transition-colors duration-200">
                            <i class="fas fa-history text-2xl text-gray-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Logs do Sistema</h3>
                    <p class="text-gray-600 text-sm mb-4">Visualizar logs e auditoria do sistema</p>
                    <a href="<?= baseUrl() ?>sistema/logs" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

            <?php elseif ($userNivel === 'A'): ?>
                <!-- Cards da Empresa -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-200">
                            <i class="fas fa-briefcase text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Minhas Vagas</h3>
                    <p class="text-gray-600 text-sm mb-4">Gerenciar vagas publicadas pela empresa</p>
                    <a href="<?= baseUrl() ?>empresa/vagas" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors duration-200">
                            <i class="fas fa-plus-circle text-2xl text-green-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Publicar Vaga</h3>
                    <p class="text-gray-600 text-sm mb-4">Criar nova vaga de emprego</p>
                    <a href="<?= baseUrl() ?>empresa/vagas/nova" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors duration-200">
                            <i class="fas fa-user-tie text-2xl text-purple-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Candidatos</h3>
                    <p class="text-gray-600 text-sm mb-4">Visualizar candidatos das vagas</p>
                    <a href="<?= baseUrl() ?>empresa/candidatos" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors duration-200">
                            <i class="fas fa-building text-2xl text-orange-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Perfil da Empresa</h3>
                    <p class="text-gray-600 text-sm mb-4">Editar informações da empresa</p>
                    <a href="<?= baseUrl() ?>empresa/perfil" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

            <?php elseif ($userNivel === 'CN'): ?>
                <!-- Cards do Candidato -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-200">
                            <i class="fas fa-search text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Buscar Vagas</h3>
                    <p class="text-gray-600 text-sm mb-4">Encontrar oportunidades de emprego</p>
                    <a href="<?= baseUrl() ?>vaga" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors duration-200">
                            <i class="fas fa-paper-plane text-2xl text-purple-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Candidaturas</h3>
                    <p class="text-gray-600 text-sm mb-4">Acompanhar candidaturas enviadas</p>
                    <a href="<?= baseUrl() ?>candidato/candidaturas" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors duration-200">
                            <i class="fas fa-user text-2xl text-orange-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Meu Perfil</h3>
                    <p class="text-gray-600 text-sm mb-4">Editar informações pessoais</p>
                    <a href="<?= baseUrl() ?>candidato/perfil" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-100 rounded-lg group-hover:bg-indigo-200 transition-colors duration-200">
                            <i class="fas fa-file-alt text-2xl text-indigo-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Meu Currículo</h3>
                    <p class="text-gray-600 text-sm mb-4">Gerenciar currículo e experiências</p>
                    <a href="<?= baseUrl() ?>candidato/curriculo" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                        Acessar →
                    </a>
                </div>

            <?php endif; ?>

            <!-- Card Comum para Todos os Usuários -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-gray-100 rounded-lg group-hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-user-cog text-2xl text-gray-600"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Configurações</h3>
                <p class="text-gray-600 text-sm mb-4">Alterar senha e preferências</p>
                <a href="<?= baseUrl() ?>usuario/configuracoes" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    Acessar →
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 cursor-pointer group">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-red-100 rounded-lg group-hover:bg-red-200 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt text-2xl text-red-600"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Sair</h3>
                <p class="text-gray-600 text-sm mb-4">Fazer logout do sistema</p>
                <a href="<?= baseUrl() ?>login/signOut" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                    Acessar →
                </a>
            </div>

        </div>

        <!-- Estatísticas Rápidas (opcional) -->
        <?php if ($userNivel === 'G' || $userNivel === 'A'): ?>
            <div class="mt-12">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Estatísticas Rápidas</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total de Vagas</p>
                                <p class="text-3xl font-bold text-gray-900">248</p>
                            </div>
                            <div class="p-3 bg-blue-100 rounded-lg">
                                <i class="fas fa-briefcase text-xl text-blue-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Candidatos Ativos</p>
                                <p class="text-3xl font-bold text-gray-900">1,429</p>
                            </div>
                            <div class="p-3 bg-green-100 rounded-lg">
                                <i class="fas fa-users text-xl text-green-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Empresas</p>
                                <p class="text-3xl font-bold text-gray-900">89</p>
                            </div>
                            <div class="p-3 bg-purple-100 rounded-lg">
                                <i class="fas fa-building text-xl text-purple-600"></i>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Candidaturas</p>
                                <p class="text-3xl font-bold text-gray-900">3,247</p>
                            </div>
                            <div class="p-3 bg-orange-100 rounded-lg">
                                <i class="fas fa-paper-plane text-xl text-orange-600"></i>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        <?php endif; ?>
    </div>
</div>