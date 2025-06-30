<?php
use Core\Library\Session;

// Obter dados do usuário
$userNivel = Session::get("userNivel");
$currentController = $this->controller ?? '';

// Incluir sidebar específica baseada no tipo de usuário
switch ($userNivel) {
    case 'G':
        require_once 'sidebar-gestor.php';
        break;
    case 'A':
        require_once 'sidebar-anunciante.php';
        break;
    case 'CN':
        require_once 'sidebar-contribuinte.php';
        break;
    default:
        echo '<div class="alert alert-warning">Tipo de usuário não reconhecido.</div>';
        break;
}
?>
