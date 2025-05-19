<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<link rel="stylesheet" href="<?= baseUrl() ?>/assets/css/login/login.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

		<title>Logop Ipsum</title>
	</head>
	<body>
		<div class="container" id="container">
			<div class="form-container sign-up-container">
				<form action="/LoginCadastro/registrar" method="POST">
					<h1>Crie sua conta</h1>
					<div class="social-container">
						<a href="#" class="social"><i class="fab fa-facebook-f"></i></a>
						<a href="#" class="social"><i class="fab fa-google-plus-g"></i></a>
						<a href="#" class="social"><i class="fab fa-linkedin-in"></i></a>
					</div>
					<span>ou use seus dados para se registrar</span>
					<br>
					<!-- <select id="tipoRegistro" required> -->
					<select id="tipoRegistro" name="tipoRegistro" required style="background-color: #eee; border: none; padding: 12px 15px; width: 100%; margin-bottom: 7px;">
						<option value="" selected disabled>Eu sou...</option>
						<option value="empresa">Empresa</option>
						<option value="candidato">Candidato</option>
					</select>
                    <input type="text" id="cpf" placeholder=" CPF 000.000.000-00" name="cpf" maxlength="14" required />
		            <input type="text" class="form-control" id="cnpj" maxlength="18" placeholder=" CNPJ 00.000.000/0000-00" required />
					<input type="text" placeholder=" Nome" name="nome" required />
					<input type="email" placeholder=" Email" name="email" required />
					<input type="password" placeholder=" Senha" name="senha" required />
					<button>Cadastrar</button>
				</form>
			</div>
			<div class="form-container sign-in-container">
				<form action="/LoginCadastro/login" method="POST">
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
					<button type="submit">Entrar</button>
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
		<!-- Bootstrap Icons -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
		<!-- jQuery e máscara -->
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?= baseUrl() ?>/assets/js/login/login.js"></script>
		<script>
			$(document).ready(function() {
				$('#cnpj').mask('00.000.000/0000-00');
				$('#cpf').mask('000.000.000-00');
			});

			document.addEventListener('DOMContentLoaded', function () {
				const select = document.getElementById('tipoRegistro');
				const cpf = document.getElementById('cpf');
				const cnpj = document.getElementById('cnpj');
				cpf.style.display = 'none';
				cnpj.style.display = 'none';

				select.addEventListener('change', function () {
					if (select.value === 'empresa') {
						cnpj.style.display = 'block';

						cpf.required = false;
						cnpj.required = true;
					} else {
						cnpj.style.display = 'none';
					}

					if (select.value === 'candidato') {
						cpf.style.display = 'block';
						
						cpf.required = true;
						cnpj.required = false;
					} else {
						cpf.style.display = 'none';
					}
				});
			});
		</script>
	</body>
</html>