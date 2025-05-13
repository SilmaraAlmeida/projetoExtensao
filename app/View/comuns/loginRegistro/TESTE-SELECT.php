<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" href="<?= baseUrl() ?>/assets/css/login/login.css">
        <link href="<?= baseUrl() ?>assets/img/AtomPHP-icone.png" rel="icon" type="image/png">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

		<title>Logop Ipsum</title>
	</head>
	<body>
		<div class="container" id="container">
			<div class="form-container sign-up-container">
				<form action="/cadastrar" method="POST">
					<h1>Crie sua conta</h1>
					<div class="social-container">
						<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
						<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
						<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
					</div>
					<span>ou use seus dados para se registrar</span>

					<select name="tipo" id="tipo">
						<option value="selecione">Você é ...</option>
						<option value="empresa">Empresa</option>
						<option value="candidato">Candidato</option>
					</select>
                    <input type="text" id="cpf" placeholder="CPF" name="cpf" maxlength="14"required />

					<input type="text" placeholder="Nome" name="nome" required />
					<input type="email" placeholder="Email" name="email" required />
					<input type="password" placeholder="Senha" name="senha" required />
					<button>Entrar</button>
				</form>
			</div>
			<div class="form-container sign-in-container">
				<form action="/login" method="POST">
					<h1>Conecte-se</h1>
					<div class="social-container">
						<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
						<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
						<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
					</div>
					<span>ou use sua conta</span>
					<input type="email" placeholder="Email" name="email" required />
					<input type="password" placeholder="Senha" name="senha" required />
					<a href="#">Esqueceu sua senha?</a>
					<button>Entrar</button>
				</form>
			</div>
			<div class="overlay-container">
				<div class="overlay">
					<div class="overlay-panel overlay-left">
						<h1>Bem-vindo novamente</h1>
						<p>Para se manter conectado conosco, faça login com seus dados</p>
						<button class="ghost" id="signIn">Entrar</button>
					</div>
					<div class="overlay-panel overlay-right">
						<h1>Seja bem-vindo!</h1>
						<p>Insira seus dados e comece sua jornada conosco.</p>
						<button class="ghost" id="signUp">Crie sua conta</button>
					</div>
				</div>
			</div>
		</div>
        <a href="/">Voltar</a>
        <script src="<?= baseUrl() ?>/assets/js/login/login.js"></script>
		<script>
			document.addEventListener('DOMContentLoaded', function () {
				const select = document.getElementById('tipo');
				const cnpj = document.getElementById('cpf');
				cnpj.style.display = 'none';

				select.addEventListener('change', function () {
					if (select.value === 'empresa') {
						cnpj.style.display = 'block';
					} else {
						cnpj.style.display = 'none';
					}
				});
			});
		</script>
	</body>
</html>