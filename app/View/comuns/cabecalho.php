<?php

use Core\Library\Session; ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO Meta Tags -->
    <meta name="description" content="Via Muriaé - A plataforma que conecta talentos e empresas de Muriaé. Encontre vagas de emprego ou divulgue oportunidades de forma simples, rápida e centralizada.">
    <meta name="keywords" content="vagas Muriaé, empregos Muriaé, recrutamento Muriaé, oportunidades de trabalho, talentos locais, plataforma de empregos, buscar emprego Muriaé, contratar profissionais Muriaé">
    <meta name="author" content="Via Muriaé">
    <meta name="robots" content="index, follow">
    <meta name="language" content="pt-BR">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= baseUrl() ?>">
    <meta property="og:title" content="Via Muriaé - Conectando talentos às oportunidades">
    <meta property="og:description" content="A plataforma que une empresas e profissionais de Muriaé. Cadastre-se gratuitamente e transforme sua carreira ou encontre os melhores talentos para sua empresa.">
    <meta property="og:image" content="<?= baseUrl() ?>assets/img/AtomPHP-icone.jpg">
    <meta property="og:locale" content="pt_BR">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="<?= baseUrl() ?>">
    <meta name="twitter:title" content="Via Muriaé - Conectando talentos às oportunidades">
    <meta name="twitter:description" content="A plataforma que une empresas e profissionais de Muriaé.">
    <meta name="twitter:image" content="<?= baseUrl() ?>assets/img/AtomPHP-icone.jpg">

    <title>Via Muriaé - Conectando talentos às oportunidades em Muriaé</title>

    <!-- Favicon -->
    <link href="<?= baseUrl() ?>assets/img/AtomPHP-icone.png" rel="icon" type="image/png">

    <!-- Tailwind CSS -->
    <link href="<?= baseUrl() ?>assets/css/tailwind-output.css" rel="stylesheet">

    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Canonical URL -->
    <link rel="canonical" href="<?= baseUrl() ?>">
</head>


<body class="bg-gray-50 font-sans antialiased">

    <!-- Header Navigation -->
    <header class="bg-blue-900 shadow-lg sticky top-0 z-50" x-data="{ mobileMenuOpen: false }">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20 lg:h-24">

                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="/" class="flex items-center">
                        <img src="<?= baseUrl() ?>/assets/img/logo-horizontal.png" alt="Via Muriaé Logo" class="h-12 lg:h-16 w-auto">
                    </a>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-white hover:text-blue-200 px-4 py-3 rounded-md text-base lg:text-lg font-medium transition-colors duration-200">
                        Home
                    </a>
                    <a href="/vaga" class="text-white hover:text-blue-200 px-4 py-3 rounded-md text-base lg:text-lg font-medium transition-colors duration-200">
                        Vagas
                    </a>
                </div>

                <?php if (!in_array($this->request->getController(), CONTROLLER_NO_SEARCH)): ?>
                    <!-- Search Bar - Desktop -->
                    <div class="hidden md:flex flex-1 max-w-lg mx-8">
                        <div class="relative w-full">
                            <form action="/vaga" method="GET">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400 text-base"></i>
                                </div>
                                <input
                                    type="text" name="busca"
                                    placeholder="Pesquisar vagas, empresas..."
                                    class="block w-full pl-12 pr-4 py-3 text-base border border-gray-300 rounded-lg bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition-all duration-200">
                                <button class="hidden" type="submit"></button>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>


                <!-- User Actions -->
                <div class="hidden md:flex items-center space-x-6">
                    <?php if (Session::get("userLogin")): ?>
                        <!-- Logged User Menu -->
                        <div class="relative" x-data="{ open: false }">
                            <button
                                @click="open = !open"
                                @click.away="open = false"
                                class="text-white hover:text-blue-200 px-4 py-3 rounded-md text-base lg:text-lg font-medium flex items-center space-x-2 transition-colors duration-200">
                                <i class="fas fa-user-circle text-lg"></i>
                                <span>Minha Área</span>
                                <i class="fas fa-chevron-down text-sm transition-transform duration-200" :class="open ? 'rotate-180' : ''"></i>
                            </button>

                            <!-- Dropdown -->
                            <div
                                x-show="open"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-150"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                class="absolute right-0 mt-2 w-52 bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 z-50"
                                x-cloak>
                                <div class="py-2">
                                    <?php if (Session::get("userNivel") == "G"): ?>
                                        <a href="<?= baseUrl() ?>Sistema/" class="block px-4 py-3 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors duration-200">
                                            <i class="fas fa-cogs mr-3"></i>Área do Gestor
                                        </a>
                                    <?php elseif (Session::get("userNivel") == "A"): ?>
                                        <a href="<?= baseUrl() ?>Sistema/" class="block px-4 py-3 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors duration-200">
                                            <i class="fas fa-building mr-3"></i>Área da Empresa
                                        </a>
                                    <?php else: ?>
                                        <a href="<?= baseUrl() ?>Sistema/" class="block px-4 py-3 text-base text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors duration-200">
                                            <i class="fas fa-user mr-3"></i>Área do Usuário
                                        </a>
                                    <?php endif; ?>

                                    <div class="border-t border-gray-100"></div>
                                    <a href="<?= baseUrl() ?>Login/signout/" class="block px-4 py-3 text-base text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt mr-3"></i>Sair
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Guest Actions -->
                        <a href="<?= baseUrl() ?>Login/" class="text-white hover:text-blue-200 px-4 py-3 rounded-md text-base lg:text-lg font-medium transition-colors duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>Entrar
                        </a>
                        <a href="<?= baseUrl() ?>Cadastro/" class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-md text-base lg:text-lg font-medium transition-all duration-200 transform hover:scale-105">
                            Cadastre-se
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="md:hidden ml-4 text-white hover:text-blue-200 focus:outline-none focus:text-blue-200 transition-colors duration-200">
                    <i class="fas fa-bars text-2xl" x-show="!mobileMenuOpen"></i>
                    <i class="fas fa-times text-2xl" x-show="mobileMenuOpen" x-cloak></i>
                </button>
            </div>

            <!-- Mobile Menu -->
            <div
                x-show="mobileMenuOpen"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-2"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 -translate-y-2"
                class="md:hidden border-t border-blue-800 bg-blue-800"
                x-cloak>
                <div class="px-4 pt-4 pb-6 space-y-3 sm:px-6">

                    <!-- Mobile Search -->
                    <div class="py-2">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400 text-base"></i>
                            </div>
                            <input
                                type="text"
                                placeholder="Pesquisar..."
                                class="block w-full pl-12 pr-4 py-3 text-base border border-gray-300 rounded-lg bg-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                        </div>
                    </div>

                    <!-- Mobile Navigation -->
                    <a href="/" class="text-white hover:text-blue-200 hover:bg-blue-700 block px-4 py-3 rounded-md text-lg font-medium transition-colors duration-200">
                        Home
                    </a>
                    <a href="/vaga" class="text-white hover:text-blue-200 hover:bg-blue-700 block px-4 py-3 rounded-md text-lg font-medium transition-colors duration-200">
                        Vagas
                    </a>

                    <?php if (Session::get("userLogin")): ?>
                        <div class="border-t border-blue-700 pt-4">
                            <?php if (Session::get("userNivel") == "G"): ?>
                                <a href="<?= baseUrl() ?>Sistema/" class="text-white hover:text-blue-200 hover:bg-blue-700 block px-4 py-3 rounded-md text-lg font-medium transition-colors duration-200">
                                    <i class="fas fa-cogs mr-3"></i>Área do Gestor
                                </a>
                            <?php elseif (Session::get("userNivel") == "A"): ?>
                                <a href="<?= baseUrl() ?>Sistema/" class="text-white hover:text-blue-200 hover:bg-blue-700 block px-4 py-3 rounded-md text-lg font-medium transition-colors duration-200">
                                    <i class="fas fa-building mr-3"></i>Área da Empresa
                                </a>
                            <?php else: ?>
                                <a href="<?= baseUrl() ?>Sistema/" class="text-white hover:text-blue-200 hover:bg-blue-700 block px-4 py-3 rounded-md text-lg font-medium transition-colors duration-200">
                                    <i class="fas fa-user mr-3"></i>Área do Usuário
                                </a>
                            <?php endif; ?>

                            <a href="<?= baseUrl() ?>Logout/" class="text-red-300 hover:text-red-100 hover:bg-red-600 block px-4 py-3 rounded-md text-lg font-medium transition-colors duration-200">
                                <i class="fas fa-sign-out-alt mr-3"></i>Sair
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="border-t border-blue-700 pt-4 space-y-3">
                            <a href="<?= baseUrl() ?>Login/" class="text-white hover:text-blue-200 hover:bg-blue-700 block px-4 py-3 rounded-md text-lg font-medium transition-colors duration-200">
                                <i class="fas fa-sign-in-alt mr-3"></i>Entrar
                            </a>
                            <a href="<?= baseUrl() ?>Cadastro/" class="bg-orange-500 hover:bg-orange-600 text-white block mx-3 px-4 py-3 rounded-md text-lg font-medium text-center transition-colors duration-200">
                                Cadastre-se
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="min-h-screen">