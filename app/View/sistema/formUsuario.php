<script type="text/javascript" src="<?= baseUrl(); ?>assets/js/usuario.js"></script>

<?= formTitulo('Usuário') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">

    <input type="hidden" name="usuario_id" id="usuario_id" value="<?= setValor('usuario_id') ?>">

    <div class="row m-2">

        <div class="mb-3 col-8">
            <label for="pessoa_fisica_id" class="form-label">Nome</label>
            <select class="form-select" name="pessoa_fisica_id" id="pessoa_fisica_id" aria-label="Selecione a pessoa" required>
                <option value="">Selecione uma pessoa...</option>
                <?php if (isset($dados['usuarios']) && is_array($dados['usuarios'])): ?>
                    <?php foreach ($dados['usuarios'] as $value): ?>
                        <option value="<?= $value['pessoa_fisica_id'] ?>"
                            <?= (setValor('pessoa_fisica_id') == $value['pessoa_fisica_id'] ? 'selected' : '') ?>>
                            <?= htmlspecialchars($value['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?= setMsgFilderError('pessoa_fisica_id') ?>
        </div>

        <div class="mb-3 col-4">
            <label for="tipo" class="form-label">Tipo de Usuário</label>
            <select class="form-select" name="tipo" id="tipo" aria-label="Tipo de usuário" required>
                <option value="" <?= (setValor('tipo') == "" ? 'selected' : "") ?>>Selecione...</option>
                <option value="CN" <?= (setValor('tipo') == "CN" ? 'selected' : "") ?>>Contribuinte Normativo</option>
                <option value="A" <?= (setValor('tipo') == "A" ? 'selected' : "") ?>>Anunciante</option>
                <option value="G" <?= (setValor('tipo') == "G" ? 'selected' : "") ?>>Gestor</option>
            </select>
            <?= setMsgFilderError('tipo') ?>
        </div>

        <div class="mb-3 col-8">
            <label for="login" class="form-label">Login/Email</label>
            <input type="email" class="form-control" id="login" name="login"
                placeholder="Email do usuário" maxlength="50"
                value="<?= setValor('login') ?>" required>
            <?= setMsgFilderError('login') ?>
        </div>

        <?php if (in_array($this->request->getAction(), ['insert', 'update'])): ?>

            <div class="mb-3 col-6">
                <label for="senha" class="form-label">Senha</label>
                <input type="password" class="form-control" id="senha" name="senha"
                    placeholder="Informe uma senha" maxlength="60"
                    onkeyup="checa_segur_senha('senha', 'msgSenha', 'btEnviar');"
                    <?= ($this->request->getAction() == "insert" ? 'required' : '') ?>>
                <div id="msgSenha" class="mt-3"></div>
                <?= setMsgFilderError('senha') ?>
                <?php if ($this->request->getAction() == "update"): ?>
                    <small class="form-text text-muted">Deixe em branco para manter a senha atual</small>
                <?php endif; ?>
            </div>

            <div class="mb-3 col-6">
                <label for="confSenha" class="form-label">Confirma a Senha</label>
                <input type="password" class="form-control" id="confSenha" name="confSenha"
                    placeholder="Digite a senha para conferência" maxlength="60"
                    onkeyup="checa_segur_senha('confSenha', 'msgConfSenha', 'btEnviar');"
                    <?= ($this->request->getAction() == "insert" ? 'required' : '') ?>>
                <div id="msgConfSenha" class="mt-3"></div>
                <?= setMsgFilderError('confSenha') ?>
            </div>

        <?php endif; ?>

    </div>

    <div class="m-3">
        <?= formButton() ?>
    </div>

</form>