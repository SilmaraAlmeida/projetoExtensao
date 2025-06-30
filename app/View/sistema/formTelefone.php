<script type="text/javascript" src="<?= baseUrl(); ?>assets/js/telefone.js"></script>

<?= formTitulo('Telefone') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">

    <input type="hidden" name="telefone_id" id="telefone_id" value="<?= setValor('telefone_id') ?>">

    <div class="row m-2">

        <div class="mb-3 col-6">
            <label for="numero" class="form-label">Número do Telefone</label>
            <input type="text" class="form-control" id="numero" name="numero"
                placeholder="(32) 99999-9999" maxlength="15"
                value="<?= setValor('numero') ?>" required autofocus
                onkeyup="mascaraTelefone(this)" onblur="validaTelefone(this)">
            <?= setMsgFilderError('numero') ?>
        </div>

        <div class="mb-3 col-6">
            <label for="tipo" class="form-label">Tipo</label>
            <select class="form-select" name="tipo" id="tipo" aria-label="Tipo de telefone" required>
                <option value="">Selecione...</option>
                <option value="m" <?= (setValor('tipo') == "m" ? 'selected' : "") ?>>Móvel/Celular</option>
                <option value="f" <?= (setValor('tipo') == "f" ? 'selected' : "") ?>>Fixo</option>
            </select>
            <?= setMsgFilderError('tipo') ?>
        </div>

        <div class="mb-3 col-6">
            <label for="estabelecimento_id" class="form-label">Estabelecimento</label>
            <select class="form-select" name="estabelecimento_id" id="estabelecimento_id" aria-label="Selecione o estabelecimento">
                <option value="">Selecione um estabelecimento...</option>
                <?php if (isset($dados['estabelecimentos']) && is_array($dados['estabelecimentos'])): ?>
                    <?php foreach ($dados['estabelecimentos'] as $value): ?>
                        <option value="<?= $value['estabelecimento_id'] ?>"
                            <?= (setValor('estabelecimento_id') == $value['estabelecimento_id'] ? 'selected' : '') ?>>
                            <?= htmlspecialchars($value['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?= setMsgFilderError('estabelecimento_id') ?>
            <small class="form-text text-muted">Vincular ao estabelecimento (opcional)</small>
        </div>

        <div class="mb-3 col-6">
            <label for="usuario_id" class="form-label">Usuário</label>
            <select class="form-select" name="usuario_id" id="usuario_id" aria-label="Selecione o usuário">
                <option value="">Selecione um usuário...</option>
                <?php if (isset($dados['usuarios']) && is_array($dados['usuarios'])): ?>
                    <?php foreach ($dados['usuarios'] as $value): ?>
                        <option value="<?= $value['usuario_id'] ?>"
                            <?= (setValor('usuario_id') == $value['usuario_id'] ? 'selected' : '') ?>>
                            <?= htmlspecialchars($value['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
            <?= setMsgFilderError('usuario_id') ?>
            <small class="form-text text-muted">Vincular ao usuário (opcional)</small>
        </div>

        <div class="col-12">
            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Atenção:</strong> É necessário vincular o telefone a pelo menos um <strong>Estabelecimento</strong> ou <strong>Usuário</strong>.
            </div>
            <?= setMsgFilderError('vinculo') ?>
        </div>

    </div>

    <div class="m-3">
        <?= formButton() ?>
    </div>

</form>

<script>
    function mascaraTelefone(campo) {
        var telefone = campo.value.replace(/\D/g, '');

        if (telefone.length <= 10) {
            // Formato fixo: (32) 3333-3333
            telefone = telefone.replace(/(\d{2})(\d)/, '($1) $2');
            telefone = telefone.replace(/(\d{4})(\d)/, '$1-$2');
        } else {
            // Formato celular: (32) 99999-9999
            telefone = telefone.replace(/(\d{2})(\d)/, '($1) $2');
            telefone = telefone.replace(/(\d{5})(\d)/, '$1-$2');
        }

        campo.value = telefone;
    }

    function validaTelefone(campo) {
        var telefone = campo.value.replace(/\D/g, '');

        if (telefone === '') {
            campo.classList.add('is-invalid');
            campo.classList.remove('is-valid');
            return;
        }

        if (telefone.length < 10 || telefone.length > 11) {
            campo.classList.add('is-invalid');
            campo.classList.remove('is-valid');
            return;
        }

        campo.classList.remove('is-invalid');
        campo.classList.add('is-valid');

        // Auto-seleção do tipo baseado no número de dígitos
        var tipoSelect = document.getElementById('tipo');
        if (telefone.length === 11) {
            tipoSelect.value = 'm'; // Celular
        } else if (telefone.length === 10) {
            tipoSelect.value = 'f'; // Fixo
        }
    }

    // Validação de vínculo obrigatório
    function validarVinculo() {
        var estabelecimento = document.getElementById('estabelecimento_id').value;
        var usuario = document.getElementById('usuario_id').value;
        var alertDiv = document.querySelector('.alert');

        if (!estabelecimento && !usuario) {
            alertDiv.classList.remove('alert-info');
            alertDiv.classList.add('alert-danger');
            return false;
        } else {
            alertDiv.classList.remove('alert-danger');
            alertDiv.classList.add('alert-info');
            return true;
        }
    }

    // Remove formatação ao submeter o formulário
    document.querySelector('form').addEventListener('submit', function(e) {
        var numeroField = document.getElementById('numero');

        // Valida vínculo antes de submeter
        if (!validarVinculo()) {
            e.preventDefault();
            alert('É necessário vincular o telefone a pelo menos um Estabelecimento ou Usuário.');
            return false;
        }

        // Remove formatação do número
        if (numeroField.value) {
            numeroField.value = numeroField.value.replace(/\D/g, '');
        }
    });

    // Validação em tempo real dos selects
    document.getElementById('estabelecimento_id').addEventListener('change', validarVinculo);
    document.getElementById('usuario_id').addEventListener('change', validarVinculo);
</script>