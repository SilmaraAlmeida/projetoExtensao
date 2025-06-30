<?php use Core\Library\Session; ?>
<hr>
<div class="dropdown">
    <a href="#" class="d-flex align-items-center link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user-circle fs-4 me-2"></i>
        <strong><?= Session::get('userNome') ?? 'Usuário' ?></strong>
    </a>
    <ul class="dropdown-menu text-small shadow">
        <li><a class="dropdown-item" href="<?= baseUrl() ?>Perfil"><i class="fas fa-user me-2"></i>Meu Perfil</a></li>
        <?php if (Session::get("userNivel") == 'G'): ?>
            <li><a class="dropdown-item" href="<?= baseUrl() ?>Usuario/configuracoes"><i class="fas fa-cog me-2"></i>Configurações</a></li>
        <?php endif; ?>
        <li><hr class="dropdown-divider"></li>
        <li><a class="dropdown-item" href="<?= baseUrl() ?>Auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Sair</a></li>
    </ul>
</div>
