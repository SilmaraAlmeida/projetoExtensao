<?php

use Core\Library\Session;

$gestorOptionDisabled = true;
?>

<div class="min-h-screen bg-gray-50">
    <!-- Header do Dashboard -->
    <div class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Painel de Controle</h1>
                    <p class="text-gray-600 mt-1">Bem-vindo, <?= Session::get('userNome') ?>!</p>
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
                                echo 'Anunciante';
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
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <?php $userNivel = Session::get('userNivel'); ?>

            <?php if ($userNivel === 'G'): ?>
                <!-- CARDS DO GESTOR -->

                <!-- Gerenciar Usuários -->
                <a href="<?= baseUrl() ?>usuario" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-200">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gerenciar Usuários</h3>
                    <p class="text-gray-600 text-sm">Cadastrar, editar e gerenciar usuários do sistema</p>
                </a>


                <!-- Gerenciar Empresas -->
                <a href="<?= $gestorOptionDisabled ? 'javascript:void(0)' : baseUrl() . 'empresas' ?>"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 
                    <?= $gestorOptionDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : 'hover:shadow-md transition-shadow duration-200' ?> 
                    group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 rounded-lg 
                    <?= !$gestorOptionDisabled ? 'group-hover:bg-green-200 transition-colors duration-200' : '' ?>">
                            <i class="fas fa-building text-2xl text-green-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gerenciar Empresas</h3>
                    <p class="text-gray-600 text-sm">Aprovar e gerenciar estabelecimentos cadastrados</p>
                </a>


                <!-- Gerenciar Vagas -->
                <a href="<?= $gestorOptionDisabled ? 'javascript:void(0)' : baseUrl() . 'vagas' ?>"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 
                    <?= $gestorOptionDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : 'hover:shadow-md transition-shadow duration-200' ?> group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 rounded-lg 
                    <?= !$gestorOptionDisabled ? 'group-hover:bg-purple-200 transition-colors duration-200' : '' ?>">
                            <i class="fas fa-briefcase text-2xl text-purple-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gerenciar Vagas</h3>
                    <p class="text-gray-600 text-sm">Moderar e aprovar vagas publicadas</p>
                </a>


                <!-- Gerenciar Cargos -->
                <a href="<?= $gestorOptionDisabled ? 'javascript:void(0)' : baseUrl() . 'sistema/cargos' ?>"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 
                    <?= $gestorOptionDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : 'hover:shadow-md transition-shadow duration-200' ?> group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-100 rounded-lg 
                    <?= !$gestorOptionDisabled ? 'group-hover:bg-indigo-200 transition-colors duration-200' : '' ?>">
                            <i class="fas fa-id-badge text-2xl text-indigo-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Gerenciar Cargos</h3>
                    <p class="text-gray-600 text-sm">Cadastrar e editar cargos disponíveis</p>
                </a>


                <!-- Categorias de Estabelecimento -->
                <a href="<?= $gestorOptionDisabled ? 'javascript:void(0)' : baseUrl() . 'sistema/categorias' ?>"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 
                    <?= $gestorOptionDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : 'hover:shadow-md transition-shadow duration-200' ?> group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-yellow-100 rounded-lg 
                    <?= !$gestorOptionDisabled ? 'group-hover:bg-yellow-200 transition-colors duration-200' : '' ?>">
                            <i class="fas fa-tags text-2xl text-yellow-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Categorias</h3>
                    <p class="text-gray-600 text-sm">Gerenciar categorias de estabelecimentos</p>
                </a>


                <!-- Termos de Uso -->
                <a href="<?= $gestorOptionDisabled ? 'javascript:void(0)' : baseUrl() . 'sistema/termos' ?>"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 
                    <?= $gestorOptionDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : 'hover:shadow-md transition-shadow duration-200' ?> group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-100 rounded-lg 
                    <?= !$gestorOptionDisabled ? 'group-hover:bg-orange-200 transition-colors duration-200' : '' ?>">
                            <i class="fas fa-file-contract text-2xl text-orange-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Termos de Uso</h3>
                    <p class="text-gray-600 text-sm">Gerenciar versões dos termos do sistema</p>
                </a>


                <!-- Configurações do Sistema -->
                <a href="<?= $gestorOptionDisabled ? 'javascript:void(0)' : baseUrl() . 'sistema/configuracoes' ?>"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 
                    <?= $gestorOptionDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : 'hover:shadow-md transition-shadow duration-200' ?> group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-red-100 rounded-lg 
                    <?= !$gestorOptionDisabled ? 'group-hover:bg-red-200 transition-colors duration-200' : '' ?>">
                            <i class="fas fa-cogs text-2xl text-red-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Configurações</h3>
                    <p class="text-gray-600 text-sm">Configurar parâmetros do sistema</p>
                </a>


                <!-- Logs do Sistema -->
                <a href="<?= $gestorOptionDisabled ? 'javascript:void(0)' : baseUrl() . 'sistema/logs' ?>"
                    class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 
                    <?= $gestorOptionDisabled ? 'pointer-events-none opacity-50 cursor-not-allowed' : 'hover:shadow-md transition-shadow duration-200' ?> group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-gray-100 rounded-lg 
                    <?= !$gestorOptionDisabled ? 'group-hover:bg-gray-200 transition-colors duration-200' : '' ?>">
                            <i class="fas fa-history text-2xl text-gray-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Logs do Sistema</h3>
                    <p class="text-gray-600 text-sm">Visualizar auditoria e logs de ações</p>
                </a>


            <?php elseif ($userNivel === 'A'): ?>
                <!-- CARDS DO ANUNCIANTE (EMPRESA) -->

                <!-- Minhas Vagas -->
                <a href="<?= baseUrl() ?>VagasEmpresa" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-200">
                            <i class="fas fa-briefcase text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Minhas Vagas</h3>
                    <p class="text-gray-600 text-sm">Gerenciar vagas publicadas pela empresa</p>
                </a>

                <!-- Publicar Nova Vaga -->
                <a href="<?= baseUrl() ?>VagasEmpresa/form/insert/0" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-green-100 rounded-lg group-hover:bg-green-200 transition-colors duration-200">
                            <i class="fas fa-plus-circle text-2xl text-green-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Publicar Vaga</h3>
                    <p class="text-gray-600 text-sm">Criar nova oportunidade de emprego</p>
                </a>

                <!-- Perfil da Empresa -->
                <a href="<?= baseUrl() ?>sistema/perfil" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors duration-200">
                            <i class="fas fa-building text-2xl text-orange-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Perfil da Empresa</h3>
                    <p class="text-gray-600 text-sm">Editar dados do estabelecimento</p>
                </a>

            <?php elseif ($userNivel === 'CN'): ?>
                <!-- CARDS DO CANDIDATO -->

                <!-- Buscar Vagas -->
                <a href="<?= baseUrl() ?>vaga" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-blue-100 rounded-lg group-hover:bg-blue-200 transition-colors duration-200">
                            <i class="fas fa-search text-2xl text-blue-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Buscar Vagas</h3>
                    <p class="text-gray-600 text-sm">Encontrar oportunidades de emprego</p>
                </a>

                <!-- Minhas Candidaturas -->
                <a href="<?= baseUrl() ?>candidato/candidaturas" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-purple-100 rounded-lg group-hover:bg-purple-200 transition-colors duration-200">
                            <i class="fas fa-paper-plane text-2xl text-purple-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Minhas Candidaturas</h3>
                    <p class="text-gray-600 text-sm">Acompanhar candidaturas enviadas</p>
                </a>

                <!-- Meu Currículo -->
                <a href="<?= baseUrl() ?>candidato/curriculo" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-indigo-100 rounded-lg group-hover:bg-indigo-200 transition-colors duration-200">
                            <i class="fas fa-file-alt text-2xl text-indigo-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Meu Currículo</h3>
                    <p class="text-gray-600 text-sm">Gerenciar dados do currículo</p>
                </a>

                <!-- Meu Perfil -->
                <a href="<?= baseUrl() ?>sistema/perfil" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
                    <div class="flex items-center justify-between mb-4">
                        <div class="p-3 bg-orange-100 rounded-lg group-hover:bg-orange-200 transition-colors duration-200">
                            <i class="fas fa-user text-2xl text-orange-600"></i>
                        </div>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Meu Perfil</h3>
                    <p class="text-gray-600 text-sm">Editar informações pessoais</p>
                </a>

            <?php endif; ?>

            <!-- CARDS COMUNS PARA TODOS OS USUÁRIOS -->

            <!-- Sair do Sistema -->
            <a href="<?= baseUrl() ?>login/signOut" class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition-shadow duration-200 group">
                <div class="flex items-center justify-between mb-4">
                    <div class="p-3 bg-red-100 rounded-lg group-hover:bg-red-200 transition-colors duration-200">
                        <i class="fas fa-sign-out-alt text-2xl text-red-600"></i>
                    </div>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Sair</h3>
                <p class="text-gray-600 text-sm">Fazer logout do sistema</p>
            </a>

        </div>
    </div>
</div>