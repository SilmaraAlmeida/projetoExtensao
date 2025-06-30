<script type="text/javascript" src="<?= baseUrl(); ?>assets/js/pessoaFisica.js"></script>

<?= formTitulo('Pessoa Física') ?>

<form method="POST" action="<?= $this->request->formAction() ?>">

    <input type="hidden" name="pessoa_fisica_id" id="pessoa_fisica_id" value="<?= setValor('pessoa_fisica_id') ?>">

    <div class="row m-2">

        <div class="mb-3 col-8">
            <label for="nome" class="form-label">Nome Completo</label>
            <input type="text" class="form-control" id="nome" name="nome"
                placeholder="Nome completo da pessoa" maxlength="150"
                value="<?= setValor('nome') ?>" required autofocus>
            <?= setMsgFilderError('nome') ?>
        </div>

        <div class="mb-3 col-4">
            <label for="visitante_id" class="form-label">Visitante ID</label>
            <input type="number" class="form-control" id="visitante_id" name="visitante_id"
                placeholder="ID do visitante" min="1"
                value="<?= setValor('visitante_id') ?>">
            <?= setMsgFilderError('visitante_id') ?>
            <small class="form-text text-muted">Campo opcional</small>
        </div>

        <div class="mb-3 col-6">
            <label for="cpf" class="form-label">CPF</label>
            <input type="text" class="form-control" id="cpf" name="cpf"
                placeholder="000.000.000-00" maxlength="14"
                value="<?= setValor('cpf') ?>" 
                onkeyup="mascaraCPF(this)" onblur="validaCPF(this)">
            <?= setMsgFilderError('cpf') ?>
            <small class="form-text text-muted">Campo opcional</small>
        </div>

    </div>

    <div class="m-3">
        <?= formButton() ?>
    </div>

</form>

<script>
function mascaraCPF(campo) {
    var cpf = campo.value.replace(/\D/g, '');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    campo.value = cpf;
}

function validaCPF(campo) {
    var cpf = campo.value.replace(/\D/g, '');
    
    // Se campo vazio, não valida (campo opcional)
    if (cpf === '') {
        campo.classList.remove('is-invalid', 'is-valid');
        return;
    }
    
    if (cpf.length !== 11) {
        campo.classList.add('is-invalid');
        campo.classList.remove('is-valid');
        return;
    }
    
    // Verifica se todos os dígitos são iguais
    if (/^(\d)\1{10}$/.test(cpf)) {
        campo.classList.add('is-invalid');
        campo.classList.remove('is-valid');
        return;
    }
    
    // Validação dos dígitos verificadores
    var soma = 0;
    var resto;
    
    // Primeiro dígito
    for (var i = 1; i <= 9; i++) {
        soma += parseInt(cpf.substring(i-1, i)) * (11 - i);
    }
    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;
    if (resto !== parseInt(cpf.substring(9, 10))) {
        campo.classList.add('is-invalid');
        campo.classList.remove('is-valid');
        return;
    }
    
    soma = 0;
    // Segundo dígito
    for (var i = 1; i <= 10; i++) {
        soma += parseInt(cpf.substring(i-1, i)) * (12 - i);
    }
    resto = (soma * 10) % 11;
    if ((resto === 10) || (resto === 11)) resto = 0;
    if (resto !== parseInt(cpf.substring(10, 11))) {
        campo.classList.add('is-invalid');
        campo.classList.remove('is-valid');
        return;
    }
    
    // CPF válido
    campo.classList.remove('is-invalid');
    campo.classList.add('is-valid');
}

// Remove formatação ao submeter o formulário
document.querySelector('form').addEventListener('submit', function() {
    var cpfField = document.getElementById('cpf');
    if (cpfField.value) {
        cpfField.value = cpfField.value.replace(/\D/g, '');
    }
});
</script>
