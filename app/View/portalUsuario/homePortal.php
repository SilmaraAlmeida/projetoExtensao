<?php 
var_dump($_SESSION)
?>
<p>
    Bem vindo ao portal do usuário, <?= $_SESSION['nomeUsuario'] ?>! <br>
    Você é um(a) <?= $_SESSION['tipoRegistro'] ?>
</p>
<a href="/LoginCadastro/deslogar">Deslogar</a>