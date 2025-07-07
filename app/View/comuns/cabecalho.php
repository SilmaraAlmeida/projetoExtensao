<?php

use Core\Library\Session;
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistema de Gestão Via Muriaé - Plataforma para gerenciamento de vagas e oportunidades">
    <meta name="author" content="Via Muriaé">

    <title>Via Muriaé - Sistema de Gestão</title>

    <link href="<?= baseUrl() ?>assets/img/AtomPHP-icone.png" rel="icon" type="image/png">
    <link href="<?= baseUrl() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= baseUrl() ?>assets/css/style.css" rel="stylesheet">
    <link href="<?= baseUrl() ?>assets/css/home.css" rel="stylesheet">
    <link href="<?= baseUrl() ?>assets/css/footer.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="<?= baseUrl() ?>assets/js/script.js"></script>
    <script src="<?= baseUrl() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        /* PRESERVAR ESTILOS ORIGINAIS DA NAVBAR - NÃO MODIFICAR */
        .header {
            /* position: fixed; */
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
            background: #003399;
            /* Mantém todos os estilos originais do seu CSS */
        }

        /* Ajustes específicos para o sistema */
        body.sistema-layout {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Layout container para sistema */
        .sistema-container {
            display: flex;
            flex-direction: row;
            margin-top: 87px;
            min-height: calc(100vh - 87px);
            width: 100%;
        }

        /* Sidebar Bootstrap seguindo o exemplo fornecido */
        .sidebar-wrapper {
            width: 280px;
            min-height: calc(100vh - 87px);
            background: #f8f9fa;
            border-right: 1px solid #dee2e6;
            flex-shrink: 0;
            padding: 1rem;
            position: relative;
        }

        .sidebar-wrapper .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            border-radius: 0.375rem;
            margin: 0.125rem 0;
            transition: all 0.15s ease-in-out;
            display: flex;
            align-items: center;
        }

        .sidebar-wrapper .nav-link:hover {
            background-color: #e9ecef;
            color: #0d6efd;
        }

        .sidebar-wrapper .nav-link.active {
            background-color: #0d6efd;
            color: #fff;
        }

        .sidebar-wrapper .nav-link i {
            width: 1.25rem;
            margin-right: 0.5rem;
            text-align: center;
        }

        /* Conteúdo principal */
        .main-content {
            flex: 1;
            padding: 2rem;
            background: #fff;
            overflow-y: auto;
            min-height: calc(100vh - 87px);
            width: calc(100% - 280px);
        }

        /* Botão toggle mobile */
        .sidebar-toggle {
            display: none;
            position: fixed;
            top: 100px;
            left: 10px;
            z-index: 1025;
            background: #0d6efd;
            border: none;
            color: #fff;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        /* Responsivo */
        @media (max-width: 991.98px) {
            .sidebar-wrapper {
                position: fixed;
                left: -280px;
                top: 87px;
                height: calc(100vh - 87px);
                z-index: 1020;
                transition: left 0.3s ease;
            }

            .sidebar-wrapper.show {
                left: 0;
            }

            .main-content {
                width: 100%;
            }

            .sidebar-toggle {
                display: block !important;
            }
        }

        /* Preservar container original para páginas não-sistema */
        body:not(.sistema-layout) .container {
            margin-top: 87px;
        }

        /* Garantir que o footer não apareça no meio da página */
        body.sistema-layout footer {
            display: none;
        }
    </style>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('show');
        }

        // Fecha sidebar ao clicar fora (mobile)
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.querySelector('.sidebar-toggle');

            if (window.innerWidth <= 991.98 &&
                !sidebar.contains(e.target) &&
                !toggle.contains(e.target) &&
                sidebar.classList.contains('show')) {
                sidebar.classList.remove('show');
            }
        });
    </script>
</head>

<body <?= (Session::get("userLogin") && in_array(Session::get("userNivel"), USER_TYPES) && in_array($this->controller ?? '', SISTEMA_CONTROLLERS)) ? 'class="sistema-layout"' : '' ?>>

    <!-- Header - MANTIDO EXATAMENTE COMO ESTAVA NO ORIGINAL -->
    <nav class="navbar bg-body-tertiary px-3 p-4 header">
        <div class="logo">
            <a href="/home/"><img src="<?= baseUrl() ?>/assets/img/logo.png" alt="Logo"></a>
        </div>
        <div class="pesquisa">
            <input type="text" placeholder="Pesquisar">
        </div>
        <ul class="nav nav-pills rightMenu">
            <li class="nav-item">
                <a class="nav-link text-decoration-none text-light" href="#">Home</a>
            </li>
            <li>
                <a class="nav-link text-decoration-none text-light" href="#">Vagas</a>
            </li>
            <?php if (Session::get("userLogin")): ?>
                <?php if (Session::get("userNivel") == "G"): ?>
                    <li>
                        <a class="dropdown-item entrar" href="<?= baseUrl() ?>Sistema/">Área do Gestor</a>
                    </li>
                <?php elseif (Session::get("userNivel") == "A"): ?>
                    <li>
                        <a class="dropdown-item entrar" href="<?= baseUrl() ?>Sistema/">Área da Empresa</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a class="dropdown-item entrar" href="<?= baseUrl() ?>Sistema/">Área do Usuário</a>
                    </li>
                <?php endif; ?>
            <?php else: ?>
                <li>
                    <a class="dropdown-item entrar" href="<?= baseUrl() ?>Login/">Entrar</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>

    <?php if (Session::get("userLogin") && in_array(Session::get("userNivel"), USER_TYPES) && in_array($this->controller ?? '', SISTEMA_CONTROLLERS)): ?>

        <!-- Botão toggle mobile -->
        <button class="sidebar-toggle" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Container do sistema -->
        <div class="sistema-container">
            <!-- Sidebar modularizada -->
            <?php
            $currentController = $this->controller ?? '';
            $userNivel = Session::get("userNivel");
            $pathComuns = ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "View" . DIRECTORY_SEPARATOR . "Comuns" . DIRECTORY_SEPARATOR;

            switch ($userNivel) {
                case 'G':
                    if (file_exists($pathComuns . "sidebar-gestor.php")) {
                        require_once $pathComuns . "sidebar-gestor.php";
                    }
                    break;
                case 'A':
                    if (file_exists($pathComuns . "sidebar-anunciante.php")) {
                        require_once $pathComuns . "sidebar-anunciante.php";
                    }
                    break;
                case 'CN':
                    if (file_exists($pathComuns . "sidebar-contribuinte.php")) {
                        require_once $pathComuns . "sidebar-contribuinte.php";
                    }
                    break;
            }
            ?>



            <!-- Conteúdo principal -->
            <main class="main-content">

            <?php else: ?>
                <!-- Container para páginas não-sistema -->
                <main>
                <?php endif; ?>