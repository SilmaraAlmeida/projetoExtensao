<script type="text/javascript" src="<?= baseUrl(); ?>assets/js/usuario.js"></script>

<div class="card col-lg-4 card-background">
    <div class="card-header">
        <h3 class="mt-1">Recuperação de Senha</h3>
    </div>
    <div class="card-body">

        <form action="<?= baseUrl() ?>login/atualizaRecuperaSenha" method="POST" id="recuperaSenhaform" class="form-horizontal" role="form" >

            <input type="hidden" name="id" id="id" value="<?= $dados['id'] ?>">
            <input type="hidden" name="usuariorecuperasenha_id" id="usuariorecuperasenha_id" value="<?= $dados['usuariorecuperasenha_id'] ?>">
            <input type="hidden" name="nome" id="nome" value="<?= $dados['nome'] ?>">

            <div class="input-group mt-3">
                <label class="ml-1">Olá <b><?= $dados['nome'] ?></b>!</label>
                <p>Para prosseguir com a recuperação da senha basta digitar a senha nos campos abaixo e clicar em atualizar.</p>
            </div>

            <div class="control-group mt-3">
                <span class="input-group-addon"><i class="fa fa-key"></i> Nova Senha</span>
                <div class="controls mt-2">
                    <input type="password" class="form-control" 
                            id="NovaSenha" 
                            name="NovaSenha" 
                            required
                            placeholder="Nova senha" 
                            onkeyup="checa_segur_senha( 'NovaSenha', 'msgSenhaNova', 'btEnviar' );"
                            autofocus>
                    <div id="msgSenhaNova" class="mt-2 mb-3"></div>
                </div>
            </div>

            <div class="control-group mb-3">
                <span class="input-group-addon"><i class="fa fa-key"></i> Confirme a nova senha</span>
                <div class="controls mt-2">
                    <input type="password" class="form-control" 
                            name="NovaSenha2" 
                            id="NovaSenha2"     
                            placeholder="Confirma nova senha" 
                            required
                            onkeyup="checa_segur_senha( 'NovaSenha2', 'msgSenhaNova2', 'btEnviar' );">
                    <div id="msgSenhaNova2" class="mt-2 mb-3"></div>
                </div>
            </div>

            <div class="form-group mt-3">
                <div class="col-xs-2 controls">
                    <button class="btn btn-primary" id="btEnviar" disabled>Atualizar</button>
                </div>

                <div class="col-xs-10 controls">
                    <?= exibeAlerta() ?>
                </div>

            </div>

        </form>     
    </div>        
</div>