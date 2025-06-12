<?php

/**
 * emailRecuperacaoSenha
 *
 * @param strting $cLink 
 * @return array
 */
function emailRecuperacaoSenha($cLink)
{
    return [
        "assunto" => 'AtomPHP - Solicitação de recuperação de senha.',
        "corpo" => '
                Você solicitou a recuperação de sua senha? <br><br>
                Caso tenha solicitação clique no link a seguir para prosseguir <a href="'. $cLink . '" title="Recuperar a senha"> com a recuperação da sua senha.</a> <br><br>
                Att: <br><br>
                Equipe AtomPHP
            '
    ];
}