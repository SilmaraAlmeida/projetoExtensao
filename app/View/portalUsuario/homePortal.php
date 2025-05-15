<?php 
var_dump($_SESSION)
?>
<p>
    Bem vindo ao portal do usuário, <?= $_SESSION['nomeUsuario'] ?>!
</p>
<a href="/LoginCadastro/deslogar">Deslogar</a>