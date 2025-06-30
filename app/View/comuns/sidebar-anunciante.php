<?php use Core\Library\Session; ?>
<div class="sidebar-wrapper d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" id="sidebar">
    <a href="<?= baseUrl() ?>Sistema    " class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <i class="fas fa-store me-2 fs-4"></i>
        <span class="fs-5 fw-bold">Painel Empresa</span>
    </a>
    <hr>

    <ul class="list-unstyled ps-0">
        <!-- Dashboard -->
        <li class="nav-item mb-2">
            <a href="<?= baseUrl() ?>Sistema" class="nav-link <?= ($currentController == 'Sistema') ? 'active' : 'link-body-emphasis' ?>">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>

        <!-- Meu Estabelecimento -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#estabelecimento-collapse" aria-expanded="false">
                <i class="fas fa-building me-2"></i>Meu Estabelecimento
            </button>
            <div class="collapse" id="estabelecimento-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>Estabelecimento" class="list-group-item list-group-item-action <?= ($currentController == 'Estabelecimento') ? 'active' : '' ?>">
                        <i class="fas fa-building me-2"></i>Dados da Empresa
                    </a>
                    <a href="<?= baseUrl() ?>Telefone" class="list-group-item list-group-item-action <?= ($currentController == 'Telefone') ? 'active' : '' ?>">
                        <i class="fas fa-phone me-2"></i>Telefones
                    </a>
                    <a href="<?= baseUrl() ?>CategoriaEstabelecimento" class="list-group-item list-group-item-action <?= ($currentController == 'CategoriaEstabelecimento') ? 'active' : '' ?>">
                        <i class="fas fa-tags me-2"></i>Categorias
                    </a>
                </div>
            </div>
        </li>

        <!-- Vagas de Emprego -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#vagas-collapse" aria-expanded="false">
                <i class="fas fa-briefcase me-2"></i>Vagas de Emprego
            </button>
            <div class="collapse" id="vagas-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>Vaga" class="list-group-item list-group-item-action <?= ($currentController == 'Vaga') ? 'active' : '' ?>">
                        <i class="fas fa-briefcase me-2"></i>Minhas Vagas
                    </a>
                    <a href="<?= baseUrl() ?>VagaCurriculum" class="list-group-item list-group-item-action <?= ($currentController == 'VagaCurriculum') ? 'active' : '' ?>">
                        <i class="fas fa-users me-2"></i>Candidatos
                    </a>
                    <a href="<?= baseUrl() ?>Cargo" class="list-group-item list-group-item-action <?= ($currentController == 'Cargo') ? 'active' : '' ?>">
                        <i class="fas fa-user-tie me-2"></i>Cargos
                    </a>
                </div>
            </div>
        </li>

        <!-- Analytics -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#analytics-collapse" aria-expanded="false">
                <i class="fas fa-chart-line me-2"></i>Analytics
            </button>
            <div class="collapse" id="analytics-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>CliqueTelefone" class="list-group-item list-group-item-action <?= ($currentController == 'CliqueTelefone') ? 'active' : '' ?>">
                        <i class="fas fa-phone-square me-2"></i>Cliques Telefone
                    </a>
                    <a href="<?= baseUrl() ?>CliqueCelular" class="list-group-item list-group-item-action <?= ($currentController == 'CliqueCelular') ? 'active' : '' ?>">
                        <i class="fas fa-mobile-alt me-2"></i>Cliques Celular
                    </a>
                    <a href="<?= baseUrl() ?>Relatorio" class="list-group-item list-group-item-action <?= ($currentController == 'Relatorio') ? 'active' : '' ?>">
                        <i class="fas fa-chart-bar me-2"></i>Relatórios
                    </a>
                </div>
            </div>
        </li>

        <li class="border-top my-3"></li>

        <!-- Configurações -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#configuracoes-collapse" aria-expanded="false">
                <i class="fas fa-cog me-2"></i>Configurações
            </button>
            <div class="collapse" id="configuracoes-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>TermoDeUso" class="list-group-item list-group-item-action <?= ($currentController == 'TermoDeUso') ? 'active' : '' ?>">
                        <i class="fas fa-file-contract me-2"></i>Termos de Uso
                    </a>
                    <a href="<?= baseUrl() ?>TermoDeUsoAceite" class="list-group-item list-group-item-action <?= ($currentController == 'TermoDeUsoAceite') ? 'active' : '' ?>">
                        <i class="fas fa-check-circle me-2"></i>Aceite Termos
                    </a>
                </div>
            </div>
        </li>
    </ul>

    <hr>
    <!-- Dropdown do Usuário -->
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-user-circle fs-4 me-2"></i>
            <strong><?= Session::get('userNome') ?? 'Usuário' ?></strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li><a class="dropdown-item" href="<?= baseUrl() ?>Perfil">
                <i class="fas fa-user me-2"></i>Perfil
            </a></li>
            <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario/formTrocarSenha">
                <i class="fas fa-key me-2"></i>Trocar Senha
            </a></li>
            <li><a class="dropdown-item" href="#">
                <i class="fas fa-cog me-2"></i>Configurações
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="<?= baseUrl() ?>Login/signout">
                <i class="fas fa-sign-out-alt me-2"></i>Sair
            </a></li>
        </ul>
    </div>

</div>
