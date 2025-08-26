  <style>
    body {
      background: #003399;
      font-family: sans-serif;
    }

    .card-login {
      border-radius: 15px;
      max-width: 400px;
      width: 100%;
    }

    .toggle-container {
        background-color: #f1f5fb; /* fundo do container */
        border-radius: 10px;
        padding: 4px;
        display: flex;
        gap: 4px;
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

    .divider-text {
      position: relative;
      text-align: center;
      margin: 1rem 0;
      color: #aaa;
      font-size: 0.875rem;
    }

    .divider-text::before,
    .divider-text::after {
      content: "";
      position: absolute;
      top: 50%;
      width: 40%;
      height: 1px;
      background: #ccc;
    }

    .divider-text::before {
      left: 0;
    }

    .divider-text::after {
      right: 0;
    }
  </style>
<div class="d-flex justify-content-center align-items-center vh-100">
  <div class="card card-login shadow p-4">
    <div class="text-center mb-3">
      <a href="/home/">
        <img src="<?= baseUrl() ?>/assets/img/logo.png" alt="Logo" style="max-width: 100px;">
      </a>
      <p class="text-muted mt-2 mb-0">Entre na sua conta</p>
    </div>

    <h5 class="text-center fw-bold mb-3">Fazer Login</h5>

    <!-- Botões de alternância -->
    <div class="toggle-container mb-3">
    <button id="btnCandidato" class="toggle-btn active">👤 Candidato</button>
    <button id="btnEmpresa" class="toggle-btn">🏢 Empresa</button>
    </div>

    <!-- Formulário Candidato -->
    <form id="formCandidato" class="form-box active" action="/login/candidato" method="POST">
      <div class="mb-3">
        <label for="emailCandidato" class="form-label">E-mail:</label>
        <input type="email" class="form-control" id="emailCandidato" name="email" placeholder="seu@email.com" required>
      </div>
      <div class="mb-3">
        <label for="senhaCandidato" class="form-label">Senha:</label>
        <input type="password" class="form-control" id="senhaCandidato" name="senha" placeholder="Sua senha" required>
      </div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="lembrarCandidato">
          <label class="form-check-label" for="lembrarCandidato">Lembrar-me</label>
        </div>
        <a href="#" class="small text-decoration-none">Esqueci minha senha</a>
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar como Candidato</button>
    </form>

    <!-- Formulário Empresa -->
    <form id="formEmpresa" class="form-box" action="/login/empresa" method="POST">
      <div class="mb-3">
        <label for="emailEmpresa" class="form-label">E-mail Corporativo:</label>
        <input type="email" class="form-control" id="emailEmpresa" name="email" placeholder="contato@empresa.com" required>
      </div>
      <div class="mb-3">
        <label for="senhaEmpresa" class="form-label">Senha:</label>
        <input type="password" class="form-control" id="senhaEmpresa" name="senha" placeholder="Sua senha" required>
      </div>
      <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="lembrarEmpresa">
          <label class="form-check-label" for="lembrarEmpresa">Lembrar-me</label>
        </div>
        <a href="#" class="small text-decoration-none">Esqueci minha senha</a>
      </div>
      <button type="submit" class="btn btn-primary w-100">Entrar como Empresa</button>
    </form>

    <p class="text-center mt-3 small">
      Não tem uma conta? <a href="#" class="fw-bold text-decoration-none">Cadastre-se aqui</a>
    </p>

    <div class="divider-text">Ou continue com</div>

    <div class="d-flex gap-2">
      <button class="btn btn-outline-dark w-50">Google</button>
      <button class="btn btn-outline-dark w-50">Facebook</button>
    </div>
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
</script>