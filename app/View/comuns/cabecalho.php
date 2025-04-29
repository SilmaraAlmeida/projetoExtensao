<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="AtomPHP, microframework">
        <meta name="autho" content="Aldecir fonseca">

        <title>Logop Ipsum</title>

        <link href="<?= baseUrl() ?>assets/img/AtomPHP-icone.png" rel="icon" type="image/png">

        <link href="<?= baseUrl() ?>assets/css/style.css" rel="stylesheet">

        <link href="<?= baseUrl() ?>assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <script src="<?= baseUrl() ?>assets/js/script.js"></script>

        <script src="<?= baseUrl() ?>assets/bootstrap/js/bootstrap.bundle.min.js"></script>
    </head>
    <body>
        <header class="header">
            <div class="leftMenu">
                <div class="menuHamburger">
                    <img src="<?= baseUrl() ?>/assets/img/menu.png" alt="Ícone menu" onclick="toggleMenu()">
                </div>

                <div class="logo">
                    <img src="<?= baseUrl() ?>/assets/img/logo.png" alt="Logo">
                </div>
                <div class="pesquisa">
                    <input type="text" placeholder="Pesquisar">
                </div>
            </div>

            <div class="rightMenu">
                <p class="home">Home</p>
                <div class="dropdown w-25">
                    <button class="btn btn-light dropdown-toggle w-100 d-flex justify-content-between align-items-center" type="button" data-bs-toggle="dropdown">
                        Vagas
                        <i class="bi bi-caret-down-fill ms-2"></i>
                    </button>
                        <ul class="dropdown-menu w-100">
                            <li><a class="dropdown-item" href="#">Vagas de estágio</a></li>
                            <li><a class="dropdown-item" href="#">Vagas de analistas de sistemas</a></li>
                            <li><a class="dropdown-item" href="#">Técnico de redes</a></li>
                        </ul>
                </div>
                <p class="entrar">Entrar</p>
                <div class="perfil">
                    <img src="<?= baseUrl() ?>/assets/img/perfil.png" alt="Ícone perfil">
                </div>
            </div>
        </header>
        
        <main class="container">