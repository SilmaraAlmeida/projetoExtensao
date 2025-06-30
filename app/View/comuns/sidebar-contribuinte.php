<?php use Core\Library\Session; ?>
<div class="sidebar-wrapper d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" id="sidebar">
    <a href="<?= baseUrl() ?>Sistema" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <i class="fas fa-user me-2 fs-4"></i>
        <span class="fs-5 fw-bold">Minha Área</span>
    </a>
    <hr>

    <ul class="list-unstyled ps-0">
        <!-- Dashboard -->
        <li class="nav-item mb-2">
            <a href="<?= baseUrl() ?>Sistema" class="nav-link <?= ($currentController == 'Sistema') ? 'active' : 'link-body-emphasis' ?>">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>

        <!-- Meu Currículo -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#curriculum-collapse" aria-expanded="false">
                <i class="fas fa-file-alt me-2"></i>Meu Currículo
            </button>
            <div class="collapse" id="curriculum-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>Curriculum" class="list-group-item list-group-item-action <?= ($currentController == 'Curriculum') ? 'active' : '' ?>">
                        <i class="fas fa-file-alt me-2"></i>Dados Pessoais
                    </a>
                    <a href="<?= baseUrl() ?>CurriculumEscolaridade" class="list-group-item list-group-item-action <?= ($currentController == 'CurriculumEscolaridade') ? 'active' : '' ?>">
                        <i class="fas fa-graduation-cap me-2"></i>Formação
                    </a>
                    <a href="<?= baseUrl() ?>CurriculumExperiencia" class="list-group-item list-group-item-action <?= ($currentController == 'CurriculumExperiencia') ? 'active' : '' ?>">
                        <i class="fas fa-briefcase me-2"></i>Experiências
                    </a>
                    <a href="<?= baseUrl() ?>CurriculumQualificacao" class="list-group-item list-group-item-action <?= ($currentController == 'CurriculumQualificacao') ? 'active' : '' ?>">
                        <i class="fas fa-certificate me-2"></i>Qualificações
                    </a>
                </div>
            </div>
        </li>

        <!-- Oportunidades -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#oportunidades-collapse" aria-expanded="false">
                <i class="fas fa-search me-2"></i>Oportunidades
            </button>
            <div class="collapse" id="oportunidades-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>Vaga" class="list-group-item list-group-item-action <?= ($currentController == 'Vaga') ? 'active' : '' ?>">
                        <i class="fas fa-briefcase me-2"></i>Vagas Disponíveis
                    </a>
                    <a href="<?= baseUrl() ?>VagaCurriculum" class="list-group-item list-group-item-action <?= ($currentController == 'VagaCurriculum') ? 'active' : '' ?>">
                        <i class="fas fa-paper-plane me-2"></i>Minhas Candidaturas
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
