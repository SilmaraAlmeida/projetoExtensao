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
        <nav class="navbar bg-body-tertiary px-3 mb-3 p-4 header">
            <!-- menu só será exibido após o login -->
            <!-- <div class="menuHamburger">
                <img src="<?= baseUrl() ?>/assets/img/menu.png" alt="Ícone menu" onclick="toggleMenu()">
            </div> -->

            <div class="logo">
                <img src="<?= baseUrl() ?>/assets/img/logo.png" alt="Logo">
            </div>
            <div class="pesquisa">
                <input type="text" placeholder="Pesquisar">
            </div>

            <ul class="nav nav-pills rightMenu">
                <li class="nav-item">
                    <a class="nav-link home" href="#">Home</a>
                </li>
                <li>
                    <select name="vagas" class="dropdown-item vagas" id="">
                        <option value="vagas"><a href="">Vagas</a></option>
                        <option value="estagio"><a href="">Estágio</a></option>
                        <option value="remoto"><a href="#">Remoto</a></option>
                        <option value="redes"><a href="#">Redes</a></option>
                    </select>
                </li>
                <li>
                    <a class="dropdown-item entrar" href="LoginCadastro/">Entrar</a>

                </li>
                <li>
                    <!-- perfil só será exibido após o login -->
                    <!-- <div class="perfil">
                        <img src="<?= baseUrl() ?>/assets/img/perfil.png" alt="Ícone perfil">
                    </div> -->
                </li>
            </ul>
        </nav>
        
        <main class="container">