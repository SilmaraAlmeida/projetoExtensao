<?php use Core\Library\Session; ?>
<div class="card col-lg-4 card-background">
    <div class="card-header">
        <div class="justify-content-center">
        </div>
        <h3>Cadastro</h3>
    </div>
    <div class="card-body">
        <?php
        $msgError = Session::getDestroy('msgError');
        if ($msgError): ?>
            <div class="alert alert-danger" role="alert">
                <?= $msgError ?>
            </div>
        <?php endif; ?>

        <?php
        $errors = Session::get('errors');
        $inputs = Session::get('inputs');
        ?>

        <form action="<?= baseUrl() ?>cadastro/cadastroUsuario" method="post">
            <div class="row">
                <!-- Nome -->
                <div class="mb-3 col-12">
                    <label for="nome" class="form-label">Nome *</label>
                    <input type="text" class="form-control border-dark <?= ($errors && isset($errors['nome'])) ? 'is-invalid' : '' ?>"
                        id="nome" name="nome" placeholder="Escreva seu nome completo"
                        value="<?= $inputs && isset($inputs['nome']) ? $inputs['nome'] : '' ?>" required>
                    <?php if ($errors && isset($errors['nome'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['nome'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Email -->
                <div class="mb-3 col-12">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" class="form-control border-dark <?= ($errors && isset($errors['email'])) ? 'is-invalid' : '' ?>"
                        id="email" name="email" placeholder="Escreva seu email de registro"
                        value="<?= $inputs && isset($inputs['email']) ? $inputs['email'] : '' ?>" required>
                    <?php if ($errors && isset($errors['email'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['email'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Telefone -->
                <div class="mb-3 col-8">
                    <label for="telefone" class="form-label">Telefone *</label>
                    <input type="tel" class="form-control border-dark <?= ($errors && isset($errors['telefone'])) ? 'is-invalid' : '' ?>"
                        id="telefone" name="telefone" placeholder="(XX) XXXXX-XXXX"
                        value="<?= $inputs && isset($inputs['telefone']) ? $inputs['telefone'] : '' ?>" required>
                    <?php if ($errors && isset($errors['telefone'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['telefone'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Tipo de Telefone -->
                <div class="mb-3 col-4">
                    <label for="tipoTelefone" class="form-label">Tipo</label>
                    <select class="form-select border-dark" id="tipoTelefone" name="tipoTelefone">
                        <option value="m" <?= ($inputs && isset($inputs['tipoTelefone']) && $inputs['tipoTelefone'] == 'm') || !($inputs && isset($inputs['tipoTelefone'])) ? 'selected' : '' ?>>Móvel</option>
                        <option value="f" <?= ($inputs && isset($inputs['tipoTelefone']) && $inputs['tipoTelefone'] == 'f') ? 'selected' : '' ?>>Fixo</option>
                    </select>
                </div>

                <!-- CPF -->
                <div class="mb-3 col-12">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control border-dark <?= ($errors && isset($errors['cpf'])) ? 'is-invalid' : '' ?>"
                        id="cpf" name="cpf" placeholder="XXX.XXX.XXX-XX"
                        value="<?= $inputs && isset($inputs['cpf']) ? $inputs['cpf'] : '' ?>">
                    <?php if ($errors && isset($errors['cpf'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['cpf'] ?>
                        </div>
                    <?php endif; ?>
                    <div class="form-text">Campo opcional</div>
                </div>

                <!-- Senha -->
                <div class="mb-3 col-12">
                    <label for="senha" class="form-label">Senha *</label>
                    <input type="password" class="form-control border-dark <?= ($errors && isset($errors['senha'])) ? 'is-invalid' : '' ?>"
                        id="senha" name="senha" placeholder="Mínimo 7 caracteres" required>
                    <?php if ($errors && isset($errors['senha'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['senha'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Confirmar Senha -->
                <div class="mb-3 col-12">
                    <label for="confSenha" class="form-label">Confirmar Senha *</label>
                    <input type="password" class="form-control border-dark <?= ($errors && isset($errors['confSenha'])) ? 'is-invalid' : '' ?>"
                        id="confSenha" name="confSenha" placeholder="Repita a senha" required>
                    <?php if ($errors && isset($errors['confSenha'])): ?>
                        <div class="invalid-feedback">
                            <?= $errors['confSenha'] ?>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Termos de Uso -->
                <div class="mb-3 col-12">
                    <div class="form-check">
                        <input class="form-check-input <?= ($errors && isset($errors['termos'])) ? 'is-invalid' : '' ?>"
                            type="checkbox" value="1" id="termos" name="termos"
                            <?= ($inputs && isset($inputs['termos'])) ? 'checked' : '' ?> required>
                        <label class="form-check-label" for="termos">
                            Eu aceito os <a href="#" target="_blank">termos de uso</a> *
                        </label>
                        <?php if ($errors && isset($errors['termos'])): ?>
                            <div class="invalid-feedback">
                                <?= $errors['termos'] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Links e Botão -->
                <div class="col-12 d-flex justify-content-between">
                    <h6><a href="<?= baseUrl() ?>Login" class="text-decoration-none fw-bold">Já tem uma conta?</a></h6>
                </div>
                <div class="mb-3 col-4">
                    <button type="submit" class="btn btn-OrangeBlack">Registrar</button>
                </div>
            </div>
        </form>

        <?php
        // Limpar sessions após uso
        Session::destroy('errors');
        Session::destroy('inputs');
        ?>
    </div>
</div>

<script>
    // Máscara para telefone
    document.getElementById('telefone').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            if (value.length <= 10) {
                value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, function(match, p1, p2, p3) {
                    return p3 ? `(${p1}) ${p2}-${p3}` : p2 ? `(${p1}) ${p2}` : p1 ? `(${p1}` : '';
                });
            } else {
                value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, function(match, p1, p2, p3) {
                    return p3 ? `(${p1}) ${p2}-${p3}` : `(${p1}) ${p2}`;
                });
            }
        }
        e.target.value = value;
    });

    // Máscara para CPF
    document.getElementById('cpf').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, function(match, p1, p2, p3, p4) {
            return p4 ? `${p1}.${p2}.${p3}-${p4}` : p3 ? `${p1}.${p2}.${p3}` : p2 ? `${p1}.${p2}` : p1;
        });
        e.target.value = value;
    });
</script>