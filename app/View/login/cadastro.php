
<div class="card col-lg-4 card-background">
    <div class="card-header">
        <div class="justify-content-center">
            <img class="login-img" src="/assets/img/AtomPHP-logo.png" alt="">
        </div>
        <h3>Cadastro</h3>
    </div>
    <div class="card-body">
        <form action="<?= baseUrl() ?>Usuario/registraUsuario" method="post">
            <div class="row">
                <div class="mb-3 col-12">
                    <label for="register-name" class="form-label">Nome</label>
                    <input type="text" class="form-control border-dark" id="register-name" name="register-name" placeholder="Escreva seu Nome">
                </div>
                <div class="mb-3 col-12">
                    <label for="register-email" class="form-label">Email</label>
                    <input type="email" class="form-control border-dark" id="register-email" name="register-email" placeholder="Escreva seu email de registro">
                </div>
                <div class="mb-3 col-12">
                    <label for="register-password" class="form-label">Senha</label>
                    <input type="password" class="form-control border-dark" id="register-password" name="register-password">
                </div>
                <div class="mb-3 col-12">
                    <label for="confirm-register-password" class="form-label">Confirmar Senha</label>
                    <input type="password" class="form-control border-dark" id="confirm-register-password" name="confirm-register-password">
                </div>
                <div class="col-12 d-flex justify-content-between">
                    <h6><a href="login.html" class="text-decoration-none fw-bold">Ja tem uma Conta?</a></h6>
                </div>
                <div class="mb-3 col-4">
                    <button class="btn btn-OrangeBlack">Registrar</button>
                </div>
            </div>
        </form>
    </div>
</div>
