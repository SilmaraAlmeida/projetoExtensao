<?php
use Core\Library\Session;
$inputs = Session::get('inputs');
?>

<div class="min-h-screen bg-blue-900 flex items-center justify-center p-4">
  <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-md">

    <!-- Logo e Título -->
    <div class="text-center mb-6">
      <a href="/home/" class="inline-block">
        <img src="<?= baseUrl() ?>/assets/img/logo.png" alt="Logo Via Muriaé" class="mx-auto h-16 w-auto">
      </a>
      <p class="text-gray-500 mt-3 mb-0">Entre na sua conta</p>
    </div>

    <h2 class="text-center text-xl font-bold text-gray-800 mb-6">Fazer Login</h2>

    <?= exibeAlerta(); ?>
    <!-- Formulário de Login -->
    <form action="<?= baseUrl() ?>login/signIn" method="POST" class="space-y-4">
      <div>
        <label for="login" class="block text-sm font-medium text-gray-700 mb-2">
          Login:
        </label>
        <input
          type="email"
          id="login"
          name="login"
          placeholder="seu@email.com"
          value="<?= $inputs['login'] ?? '' ?>"
          required
          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
        >
      </div>

      <div>
        <label for="senha" class="block text-sm font-medium text-gray-700 mb-2">
          Senha:
        </label>
        <div class="relative" x-data="{ show: false }">
          <input
            :type="show ? 'text' : 'password'"
            id="senha"
            name="senha"
            placeholder="Sua senha"
            required
            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm pr-10"
          >
          <button
            type="submit"
            @click="show = !show"
            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
          >
            <i class="fas fa-eye" x-show="!show"></i>
            <i class="fas fa-eye-slash" x-show="show" x-cloak></i>
          </button>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <label class="flex items-center">
          <input type="checkbox" id="lembrar" name="lembrar" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
          <span class="ml-2 text-sm text-gray-600">Lembrar-me</span>
        </label>
        <a href="<?= baseUrl() ?>login/esqueciASenha" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
          Esqueci minha senha
        </a>
      </div>

      <button
        type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 transform hover:scale-[1.02]"
      >
        Entrar
      </button>
    </form>

    <!-- Link de Cadastro -->
    <p class="text-center mt-6 text-sm text-gray-600">
      Não tem uma conta?
      <a href="<?= baseUrl() ?>Cadastro/" class="font-bold text-blue-600 hover:text-blue-800 transition-colors duration-200">
        Cadastre-se aqui
      </a>
    </p>

    <!-- Divider -->
    <div class="relative my-6">
      <div class="absolute inset-0 flex items-center">
        <div class="w-full border-t border-gray-300"></div>
      </div>
      <div class="relative flex justify-center text-sm">
        <span class="px-4 bg-white text-gray-500">Ou continue com</span>
      </div>
    </div>

    <!-- Social Login -->
    <div class="grid grid-cols-2 gap-3">
      <button
        type="button"
        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-sm font-medium text-gray-700"
      >
        <i class="fab fa-google mr-2 text-red-500"></i>
        Google
      </button>
      <button
        type="button"
        class="flex items-center justify-center px-4 py-3 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors duration-200 text-sm font-medium text-gray-700"
      >
        <i class="fab fa-facebook mr-2 text-blue-600"></i>
        Facebook
      </button>
    </div>
  </div>
</div>
