<?php
// Verificar se a variável existe, senão definir
use Core\Library\Session; 
?>

<div class="sidebar-wrapper d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" id="sidebar">
    <a href="<?= baseUrl() ?>Sistema" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <i class="fas fa-crown me-2 fs-4"></i>
        <span class="fs-5 fw-bold">Painel Gestor</span>
    </a>
    <hr>

    <ul class="list-unstyled ps-0">
        <!-- Dashboard -->
        <li class="nav-item mb-2">
            <a href="<?= baseUrl() ?>Sistema" class="nav-link <?= ($currentController == 'Sistema') ? 'active' : 'link-body-emphasis' ?>">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </a>
        </li>

        <!-- Gestão de Usuários -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#usuarios-collapse" aria-expanded="false">
                <i class="fas fa-users me-2"></i>Gestão de Usuários
            </button>
            <div class="collapse" id="usuarios-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>Usuario" class="list-group-item list-group-item-action <?= ($currentController == 'Usuario') ? 'active' : '' ?>">
                        <i class="fas fa-users me-2"></i>Usuários
                    </a>
                    <a href="<?= baseUrl() ?>PessoaFisica" class="list-group-item list-group-item-action <?= ($currentController == 'PessoaFisica') ? 'active' : '' ?>">
                        <i class="fas fa-user me-2"></i>Pessoas Físicas
                    </a>
                    <a href="<?= baseUrl() ?>Telefone" class="list-group-item list-group-item-action <?= ($currentController == 'Telefone') ? 'active' : '' ?>">
                        <i class="fas fa-user me-2"></i>Telefone
                    </a>
                    <a href="<?= baseUrl() ?>TermoDeUsoAceite" class="list-group-item list-group-item-action <?= ($currentController == 'TermoDeUsoAceite') ? 'active' : '' ?>">
                        <i class="fas fa-user me-2"></i>Termo De Uso Aceite
                    </a>
                </div>
            </div>
        </li>

        <!-- Estabelecimentos -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#estabelecimentos-collapse" aria-expanded="false">
                <i class="fas fa-building me-2"></i>Estabelecimentos
            </button>
            <div class="collapse" id="estabelecimentos-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>Estabelecimento" class="list-group-item list-group-item-action <?= ($currentController == 'Estabelecimento') ? 'active' : '' ?>">
                        <i class="fas fa-building me-2"></i>Estabelecimentos
                    </a>
                    <a href="<?= baseUrl() ?>Telefone" class="list-group-item list-group-item-action <?= ($currentController == 'Telefone') ? 'active' : '' ?>">
                        <i class="fas fa-phone me-2"></i>Telefones
                    </a>
                </div>
            </div>
        </li>

        <!-- RH & Vagas -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#rh-collapse" aria-expanded="false">
                <i class="fas fa-briefcase me-2"></i>RH & Vagas
            </button>
            <div class="collapse" id="rh-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>Vaga" class="list-group-item list-group-item-action <?= ($currentController == 'Vaga') ? 'active' : '' ?>">
                        <i class="fas fa-briefcase me-2"></i>Vagas
                    </a>
                    <a href="<?= baseUrl() ?>Curriculum" class="list-group-item list-group-item-action <?= ($currentController == 'Curriculum') ? 'active' : '' ?>">
                        <i class="fas fa-file-alt me-2"></i>Currículos
                    </a>
                    <a href="<?= baseUrl() ?>Cargo" class="list-group-item list-group-item-action <?= ($currentController == 'Cargo') ? 'active' : '' ?>">
                        <i class="fas fa-user-tie me-2"></i>Cargos
                    </a>
                    <a href="<?= baseUrl() ?>Escolaridade" class="list-group-item list-group-item-action <?= ($currentController == 'Escolaridade') ? 'active' : '' ?>">
                        <i class="fas fa-graduation-cap me-2"></i>Escolaridade
                    </a>
                    <a href="<?= baseUrl() ?>CurriculumEscolaridade" class="list-group-item list-group-item-action <?= ($currentController == 'CurriculumEscolaridade') ? 'active' : '' ?>">
                        <i class="fas fa-school me-2"></i>Curriculum Escolaridade
                    </a>
                    <a href="<?= baseUrl() ?>CurriculumExperiencia" class="list-group-item list-group-item-action <?= ($currentController == 'CurriculumExperiencia') ? 'active' : '' ?>">
                        <i class="fas fa-business-time me-2"></i>Curriculum Experiência
                    </a>
                    <a href="<?= baseUrl() ?>CurriculumQualificacao" class="list-group-item list-group-item-action <?= ($currentController == 'CurriculumQualificacao') ? 'active' : '' ?>">
                        <i class="fas fa-certificate me-2"></i>Curriculum Qualificação
                    </a>
                    <a href="<?= baseUrl() ?>VagaCurriculum" class="list-group-item list-group-item-action <?= ($currentController == 'VagaCurriculum') ? 'active' : '' ?>">
                        <i class="fas fa-handshake me-2"></i>Vaga Curriculum
                    </a>
                </div>
            </div>
        </li>

        <!-- Localização -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#localizacao-collapse" aria-expanded="false">
                <i class="fas fa-map-marker-alt me-2"></i>Localização
            </button>
            <div class="collapse" id="localizacao-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>Cidade" class="list-group-item list-group-item-action <?= ($currentController == 'Cidade') ? 'active' : '' ?>">
                        <i class="fas fa-city me-2"></i>Cidades
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
                </div>
            </div>
        </li>

        <li class="border-top my-3"></li>

        <!-- Sistema -->
        <li class="mb-1">
            <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#sistema-collapse" aria-expanded="false">
                <i class="fas fa-cog me-2"></i>Sistema
            </button>
            <div class="collapse" id="sistema-collapse">
                <div class="list-group list-group-flush">
                    <a href="<?= baseUrl() ?>TermoDeUso" class="list-group-item list-group-item-action <?= ($currentController == 'TermoDeUso') ? 'active' : '' ?>">
                        <i class="fas fa-file-contract me-2"></i>Termos de Uso
                    </a>
                    <a href="<?= baseUrl() ?>TermoDeUsoAceite" class="list-group-item list-group-item-action <?= ($currentController == 'TermoDeUsoAceite') ? 'active' : '' ?>">
                        <i class="fas fa-check-circle me-2"></i>Aceite Termos
                    </a>
                    <a href="<?= baseUrl() ?>UsuarioRecuperaSenha" class="list-group-item list-group-item-action <?= ($currentController == 'UsuarioRecuperaSenha') ? 'active' : '' ?>">
                        <i class="fas fa-key me-2"></i>Recuperação Senha
                    </a>
                    <a href="<?= baseUrl() ?>Relatorio" class="list-group-item list-group-item-action <?= ($currentController == 'Relatorio') ? 'active' : '' ?>">
                        <i class="fas fa-chart-bar me-2"></i>Relatórios
                    </a>
                    <a href="<?= baseUrl() ?>Log" class="list-group-item list-group-item-action <?= ($currentController == 'Log') ? 'active' : '' ?>">
                        <i class="fas fa-list-alt me-2"></i>Logs do Sistema
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
