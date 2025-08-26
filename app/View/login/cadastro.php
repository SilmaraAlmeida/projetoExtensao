<?php use Core\Library\Session; ?>

<style>
  body {
    background-color: #003399;
    font-family: sans-serif;
  }

  .card-register {
    background: white;
    border-radius: 10px;
    max-width: 600px;
    width: 100%;
    padding: 2rem 2.5rem;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
  }

  .toggle-container {
    background-color: #f1f5fb;
    border-radius: 10px;
    padding: 4px;
    display: flex;
    gap: 4px;
    margin-bottom: 1.5rem;
  }

  .toggle-btn {
    flex: 1;
    border: none;
    border-radius: 8px;
    background-color: transparent;
    font-weight: 500;
    color: #333;
    padding: 8px 0;
    transition: all 0.2s ease;
  }

  .toggle-btn.active {
    background-color: #ffffff;
    border: 1px solid #cdd6f3;
    font-weight: bold;
    color: #000;
  }

  .form-box {
    display: none;
  }

  .form-box.active {
    display: block;
  }
</style>

<?php
$msgError = Session::getDestroy('msgError');
$errors = Session::get('errors');
$inputs = Session::get('inputs');
?>

<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="card-register">
    <div class="text-center mb-3">
      <a href="/home/"><img src="<?= baseUrl() ?>/assets/img/logo.png" alt="Logo" style="max-width: 100px;"></a>
      <p class="text-muted mt-2 mb-0">Crie sua conta gratuitamente</p>
    </div>

    <h4 class="text-center fw-bold mb-4">Criar Conta</h4>

    <?php if ($msgError): ?>
      <div class="alert alert-danger" role="alert">
        <?= $msgError ?>
      </div>
    <?php endif; ?>

    <div class="toggle-container">
      <button id="btnCandidato" class="toggle-btn active">👤 Sou Candidato</button>
      <button id="btnEmpresa" class="toggle-btn">🏢 Sou Empresa</button>
    </div>

    <!-- Formulário Candidato -->
    <form id="formCandidato" class="form-box active" action="<?= baseUrl() ?>cadastro/cadastroUsuario" method="post">
      <div class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nome:</label>
          <input type="text" name="nome" class="form-control <?= isset($errors['nome']) ? 'is-invalid' : '' ?>" placeholder="Seu nome" value="<?= $inputs['nome'] ?? '' ?>" required>
          <?php if (isset($errors['nome'])): ?>
            <div class="invalid-feedback"><?= $errors['nome'] ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label">Sobrenome:</label>
          <input type="text" name="sobrenome" class="form-control" placeholder="Seu sobrenome" value="<?= $inputs['sobrenome'] ?? '' ?>" required>
        </div>
        <div class="col-12">
          <label class="form-label">CPF:</label>
          <input type="text" name="cpf" id="cpf" class="form-control <?= isset($errors['cpf']) ? 'is-invalid' : '' ?>" placeholder="000.000.000-00" value="<?= $inputs['cpf'] ?? '' ?>">
          <?php if (isset($errors['cpf'])): ?>
            <div class="invalid-feedback"><?= $errors['cpf'] ?></div>
          <?php endif; ?>
        </div>
        <div class="col-12">
          <label class="form-label">E-mail:</label>
          <input type="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" placeholder="seu@email.com" value="<?= $inputs['email'] ?? '' ?>" required>
          <?php if (isset($errors['email'])): ?>
            <div class="invalid-feedback"><?= $errors['email'] ?></div>
          <?php endif; ?>
        </div>
        <div class="col-12">
          <label class="form-label">Telefone:</label>
          <input type="text" name="telefone" id="telefone" class="form-control <?= isset($errors['telefone']) ? 'is-invalid' : '' ?>" placeholder="(11) 99999-9999" value="<?= $inputs['telefone'] ?? '' ?>">
          <?php if (isset($errors['telefone'])): ?>
            <div class="invalid-feedback"><?= $errors['telefone'] ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label">Senha:</label>
          <input type="password" name="senha" class="form-control <?= isset($errors['senha']) ? 'is-invalid' : '' ?>" placeholder="Mínimo 8 caracteres" required>
          <?php if (isset($errors['senha'])): ?>
            <div class="invalid-feedback"><?= $errors['senha'] ?></div>
          <?php endif; ?>
        </div>
        <div class="col-md-6">
          <label class="form-label">Confirmar Senha:</label>
          <input type="password" name="confSenha" class="form-control <?= isset($errors['confSenha']) ? 'is-invalid' : '' ?>" placeholder="Confirme sua senha" required>
          <?php if (isset($errors['confSenha'])): ?>
            <div class="invalid-feedback"><?= $errors['confSenha'] ?></div>
          <?php endif; ?>
        </div>
        <div class="col-12 mt-2">
          <div class="form-check">
            <input type="checkbox" class="form-check-input <?= isset($errors['termos']) ? 'is-invalid' : '' ?>" name="termos" value="1" <?= isset($inputs['termos']) ? 'checked' : '' ?> required>
            <label class="form-check-label">Aceito os <a href="#">Termos de Uso</a> e <a href="#">Política de Privacidade</a></label>
            <?php if (isset($errors['termos'])): ?>
              <div class="invalid-feedback"><?= $errors['termos'] ?></div>
            <?php endif; ?>
          </div>
        </div>
        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-primary w-100">Criar Conta como Candidato</button>
        </div>
      </div>
    </form>

    <!-- Formulário Empresa -->
    <form id="formEmpresa" class="form-box" action="<?= baseUrl() ?>cadastro/cadastroEmpresa" method="post">
      <div class="row g-3">
        <div class="col-12">
          <label class="form-label">Razão Social:</label>
          <input type="text" name="razaoSocial" class="form-control" placeholder="Nome da empresa" required>
        </div>
        <div class="col-12">
          <label class="form-label">CNPJ:</label>
          <input type="text" name="cnpj" class="form-control" placeholder="00.000.000/0000-00" required>
        </div>
        <div class="col-12">
          <label class="form-label">E-mail Corporativo:</label>
          <input type="email" name="emailEmpresa" class="form-control" placeholder="contato@empresa.com" required>
        </div>
        <div class="col-12">
          <label class="form-label">Telefone:</label>
          <input type="text" name="telefoneEmpresa" class="form-control" placeholder="(11) 99999-9999">
        </div>
        <div class="col-md-6">
          <label class="form-label">Senha:</label>
          <input type="password" name="senhaEmpresa" class="form-control" placeholder="Mínimo 8 caracteres" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Confirmar Senha:</label>
          <input type="password" name="confSenhaEmpresa" class="form-control" placeholder="Confirme sua senha" required>
        </div>
        <div class="col-12 mt-2">
          <div class="form-check">
            <input type="checkbox" class="form-check-input" name="termosEmpresa" required>
            <label class="form-check-label">Aceito os <a href="#">Termos de Uso</a> e <a href="#">Política de Privacidade</a></label>
          </div>
        </div>
        <div class="col-12 mt-3">
          <button type="submit" class="btn btn-primary w-100">Criar Conta como Empresa</button>
        </div>
      </div>
    </form>

    <p class="text-center mt-3 small">Já tem uma conta? <a href="<?= baseUrl() ?>login">Faça login aqui</a></p>
  </div>
</div>

<script>
  const btnCandidato = document.getElementById('btnCandidato');
  const btnEmpresa = document.getElementById('btnEmpresa');
  const formCandidato = document.getElementById('formCandidato');
  const formEmpresa = document.getElementById('formEmpresa');

  btnCandidato.addEventListener('click', () => {
    btnCandidato.classList.add('active');
    btnEmpresa.classList.remove('active');
    formCandidato.classList.add('active');
    formEmpresa.classList.remove('active');
  });

  btnEmpresa.addEventListener('click', () => {
    btnEmpresa.classList.add('active');
    btnCandidato.classList.remove('active');
    formEmpresa.classList.add('active');
    formCandidato.classList.remove('active');
  });

  // Máscara para telefone
  document.getElementById('telefone')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, function(match, p1, p2, p3) {
      return p3 ? `(${p1}) ${p2}-${p3}` : `(${p1}) ${p2}`;
    });
    e.target.value = value;
  });

  // Máscara para CPF
  document.getElementById('cpf')?.addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, '');
    value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, function(match, p1, p2, p3, p4) {
      return p4 ? `${p1}.${p2}.${p3}-${p4}` : `${p1}.${p2}.${p3}`;
    });
    e.target.value = value;
  });
</script>

<?php
// Limpar as sessions após exibir
Session::destroy('errors');
Session::destroy('inputs');
?>
