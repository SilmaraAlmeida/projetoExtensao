<?php use Core\Library\Session; ?>

<?php
$msgError = Session::getDestroy('msgError');
$msgSucesso = Session::getDestroy('msgSucesso');
$errors = Session::get('errors');
$inputs = Session::get('inputs');
?>

<div class="min-h-screen bg-blue-900 flex items-center justify-center p-4">
  <div 
    class="bg-white rounded-xl shadow-xl p-8 w-full max-w-2xl"
    x-data="{ 
      activeTab: 'candidato',
      setTab(tab) { this.activeTab = tab },
      formatPhone(event) {
        let value = event.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{2})(\d{5})(\d{0,4})/, function(match, p1, p2, p3) {
          return p3 ? `(${p1}) ${p2}-${p3}` : `(${p1}) ${p2}`;
        });
        event.target.value = value;
      },
      formatCPF(event) {
        let value = event.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{3})(\d{3})(\d{3})(\d{0,2})/, function(match, p1, p2, p3, p4) {
          return p4 ? `${p1}.${p2}.${p3}-${p4}` : `${p1}.${p2}.${p3}`;
        });
        event.target.value = value;
      },
      formatCNPJ(event) {
        let value = event.target.value.replace(/\D/g, '');
        value = value.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{0,2})/, function(match, p1, p2, p3, p4, p5) {
          return p5 ? `${p1}.${p2}.${p3}/${p4}-${p5}` : `${p1}.${p2}.${p3}/${p4}`;
        });
        event.target.value = value;
      },
      // Verificar disponibilidade via AJAX
      checkAvailability(field, value) {
        if (value.length < 3) return;
        
        fetch('<?= baseUrl() ?>cadastro/verificarDisponibilidade', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: field + '=' + encodeURIComponent(value)
        })
        .then(response => response.json())
        .then(data => {
          if (!data.disponivel) {
            // Mostrar feedback visual se não disponível
            console.log(data.mensagem);
          }
        });
      }
    }"
  >
    
    <!-- Logo e Título -->
    <div class="text-center mb-6">
      <a href="/home/" class="inline-block">
        <img src="<?= baseUrl() ?>/assets/img/logo.png" alt="Logo Via Muriaé" class="mx-auto h-16 w-auto">
      </a>
      <p class="text-gray-500 mt-3 mb-0">Crie sua conta gratuitamente</p>
    </div>

    <h2 class="text-center text-xl font-bold text-gray-800 mb-6">Criar Conta</h2>

    <!-- Mensagem de Erro -->
    <?php if ($msgError): ?>
      <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6 flex items-center">
        <i class="fas fa-exclamation-circle mr-2"></i>
        <?= $msgError ?>
      </div>
    <?php endif; ?>

    <!-- Mensagem de Sucesso -->
    <?php if ($msgSucesso): ?>
      <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6 flex items-center">
        <i class="fas fa-check-circle mr-2"></i>
        <?= $msgSucesso ?>
      </div>
    <?php endif; ?>

    <!-- Toggle Buttons -->
    <div class="bg-blue-50 rounded-xl p-1 flex gap-1 mb-6">
      <button 
        @click="setTab('candidato')"
        :class="activeTab === 'candidato' ? 'bg-white border border-blue-200 shadow-sm font-bold text-gray-900' : 'bg-transparent font-medium text-gray-600 hover:text-gray-800'"
        class="flex-1 py-3 px-4 rounded-lg transition-all duration-200 text-sm"
      >
        <i class="fas fa-user mr-2"></i>Sou Candidato
      </button>
      <button 
        @click="setTab('empresa')"
        :class="activeTab === 'empresa' ? 'bg-white border border-blue-200 shadow-sm font-bold text-gray-900' : 'bg-transparent font-medium text-gray-600 hover:text-gray-800'"
        class="flex-1 py-3 px-4 rounded-lg transition-all duration-200 text-sm"
      >
        <i class="fas fa-building mr-2"></i>Sou Empresa
      </button>
    </div>

    <!-- Form Candidato -->
    <form 
      x-show="activeTab === 'candidato'"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 transform translate-x-4"
      x-transition:enter-end="opacity-100 transform translate-x-0"
      action="<?= baseUrl() ?>cadastro/signUp" 
      method="post"
      class="space-y-4"
    >
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Nome:</label>
          <input 
            type="text" 
            name="nome" 
            placeholder="Seu nome" 
            value="<?= $inputs['nome'] ?? '' ?>" 
            required
            class="w-full px-4 py-3 border <?= isset($errors['nome']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
          >
          <?php if (isset($errors['nome'])): ?>
            <p class="text-red-600 text-xs mt-1"><?= $errors['nome'] ?></p>
          <?php endif; ?>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Sobrenome:</label>
          <input 
            type="text" 
            name="sobrenome" 
            placeholder="Seu sobrenome" 
            value="<?= $inputs['sobrenome'] ?? '' ?>" 
            required
            class="w-full px-4 py-3 border <?= isset($errors['sobrenome']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
          >
          <?php if (isset($errors['sobrenome'])): ?>
            <p class="text-red-600 text-xs mt-1"><?= $errors['sobrenome'] ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">CPF:</label>
        <input 
          type="text" 
          name="cpf" 
          placeholder="000.000.000-00" 
          value="<?= $inputs['cpf'] ?? '' ?>"
          @input="formatCPF($event)"
          @blur="checkAvailability('cpf', $event.target.value)"
          maxlength="14"
          class="w-full px-4 py-3 border <?= isset($errors['cpf']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
        >
        <?php if (isset($errors['cpf'])): ?>
          <p class="text-red-600 text-xs mt-1"><?= $errors['cpf'] ?></p>
        <?php endif; ?>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail:</label>
        <input 
          type="email" 
          name="email" 
          placeholder="seu@email.com" 
          value="<?= $inputs['email'] ?? '' ?>" 
          @blur="checkAvailability('email', $event.target.value)"
          required
          class="w-full px-4 py-3 border <?= isset($errors['email']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
        >
        <?php if (isset($errors['email'])): ?>
          <p class="text-red-600 text-xs mt-1"><?= $errors['email'] ?></p>
        <?php endif; ?>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Senha:</label>
          <div class="relative" x-data="{ show: false }">
            <input 
              :type="show ? 'text' : 'password'"
              name="senha" 
              placeholder="Mínimo 8 caracteres" 
              required
              class="w-full px-4 py-3 border <?= isset($errors['senha']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm pr-10"
            >
            <button 
              type="button"
              @click="show = !show"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
            >
              <i class="fas fa-eye" x-show="!show"></i>
              <i class="fas fa-eye-slash" x-show="show" x-cloak></i>
            </button>
          </div>
          <?php if (isset($errors['senha'])): ?>
            <p class="text-red-600 text-xs mt-1"><?= $errors['senha'] ?></p>
          <?php endif; ?>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Senha:</label>
          <div class="relative" x-data="{ show: false }">
            <input 
              :type="show ? 'text' : 'password'"
              name="confSenha" 
              placeholder="Confirme sua senha" 
              required
              class="w-full px-4 py-3 border <?= isset($errors['confSenha']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm pr-10"
            >
            <button 
              type="button"
              @click="show = !show"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
            >
              <i class="fas fa-eye" x-show="!show"></i>
              <i class="fas fa-eye-slash" x-show="show" x-cloak></i>
            </button>
          </div>
          <?php if (isset($errors['confSenha'])): ?>
            <p class="text-red-600 text-xs mt-1"><?= $errors['confSenha'] ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div class="flex items-start">
        <input 
          type="checkbox" 
          name="termos" 
          value="1" 
          <?= isset($inputs['termos']) ? 'checked' : '' ?>
          required
          class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mt-1 <?= isset($errors['termos']) ? 'border-red-300' : '' ?>"
        >
        <label class="ml-3 text-sm text-gray-600">
          Aceito os <a href="<?= baseUrl() ?>cadastro/termos" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">Termos de Uso</a> e 
          <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Política de Privacidade</a>
        </label>
      </div>
      <?php if (isset($errors['termos'])): ?>
        <p class="text-red-600 text-xs mt-1 ml-6"><?= $errors['termos'] ?></p>
      <?php endif; ?>

      <button 
        type="submit" 
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 transform hover:scale-[1.02]"
      >
        Criar Conta como Candidato
      </button>
    </form>

    <!-- Form Empresa -->
    <form 
      x-show="activeTab === 'empresa'"
      x-transition:enter="transition ease-out duration-200"
      x-transition:enter-start="opacity-0 transform translate-x-4"
      x-transition:enter-end="opacity-100 transform translate-x-0"
      action="<?= baseUrl() ?>cadastro/cadastroEmpresa" 
      method="post"
      class="space-y-4"
      x-cloak
    >
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Razão Social:</label>
        <input 
          type="text" 
          name="razaoSocial" 
          placeholder="Nome da empresa" 
          value="<?= $inputs['razaoSocial'] ?? '' ?>"
          required
          class="w-full px-4 py-3 border <?= isset($errors['razaoSocial']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
        >
        <?php if (isset($errors['razaoSocial'])): ?>
          <p class="text-red-600 text-xs mt-1"><?= $errors['razaoSocial'] ?></p>
        <?php endif; ?>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">CNPJ:</label>
        <input 
          type="text" 
          name="cnpj" 
          placeholder="00.000.000/0000-00" 
          value="<?= $inputs['cnpj'] ?? '' ?>"
          @input="formatCNPJ($event)"
          @blur="checkAvailability('cnpj', $event.target.value)"
          maxlength="18"
          required
          class="w-full px-4 py-3 border <?= isset($errors['cnpj']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
        >
        <?php if (isset($errors['cnpj'])): ?>
          <p class="text-red-600 text-xs mt-1"><?= $errors['cnpj'] ?></p>
        <?php endif; ?>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">E-mail Corporativo:</label>
        <input 
          type="email" 
          name="emailEmpresa" 
          placeholder="contato@empresa.com" 
          value="<?= $inputs['emailEmpresa'] ?? '' ?>"
          @blur="checkAvailability('email', $event.target.value)"
          required
          class="w-full px-4 py-3 border <?= isset($errors['emailEmpresa']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
        >
        <?php if (isset($errors['emailEmpresa'])): ?>
          <p class="text-red-600 text-xs mt-1"><?= $errors['emailEmpresa'] ?></p>
        <?php endif; ?>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">Telefone (Opcional):</label>
        <input 
          type="text" 
          name="telefoneEmpresa" 
          placeholder="(11) 99999-9999"
          value="<?= $inputs['telefoneEmpresa'] ?? '' ?>"
          @input="formatPhone($event)"
          maxlength="15"
          class="w-full px-4 py-3 border <?= isset($errors['telefoneEmpresa']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm"
        >
        <?php if (isset($errors['telefoneEmpresa'])): ?>
          <p class="text-red-600 text-xs mt-1"><?= $errors['telefoneEmpresa'] ?></p>
        <?php endif; ?>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Senha:</label>
          <div class="relative" x-data="{ show: false }">
            <input 
              :type="show ? 'text' : 'password'"
              name="senhaEmpresa" 
              placeholder="Mínimo 8 caracteres" 
              required
              class="w-full px-4 py-3 border <?= isset($errors['senhaEmpresa']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm pr-10"
            >
            <button 
              type="button"
              @click="show = !show"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
            >
              <i class="fas fa-eye" x-show="!show"></i>
              <i class="fas fa-eye-slash" x-show="show" x-cloak></i>
            </button>
          </div>
          <?php if (isset($errors['senhaEmpresa'])): ?>
            <p class="text-red-600 text-xs mt-1"><?= $errors['senhaEmpresa'] ?></p>
          <?php endif; ?>
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700 mb-2">Confirmar Senha:</label>
          <div class="relative" x-data="{ show: false }">
            <input 
              :type="show ? 'text' : 'password'"
              name="confSenhaEmpresa" 
              placeholder="Confirme sua senha" 
              required
              class="w-full px-4 py-3 border <?= isset($errors['confSenhaEmpresa']) ? 'border-red-300 bg-red-50' : 'border-gray-300' ?> rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-200 text-sm pr-10"
            >
            <button 
              type="button"
              @click="show = !show"
              class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
            >
              <i class="fas fa-eye" x-show="!show"></i>
              <i class="fas fa-eye-slash" x-show="show" x-cloak></i>
            </button>
          </div>
          <?php if (isset($errors['confSenhaEmpresa'])): ?>
            <p class="text-red-600 text-xs mt-1"><?= $errors['confSenhaEmpresa'] ?></p>
          <?php endif; ?>
        </div>
      </div>

      <div class="flex items-start">
        <input 
          type="checkbox" 
          name="termosEmpresa" 
          value="1"
          required
          class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 mt-1 <?= isset($errors['termosEmpresa']) ? 'border-red-300' : '' ?>"
        >
        <label class="ml-3 text-sm text-gray-600">
          Aceito os <a href="<?= baseUrl() ?>cadastro/termos" target="_blank" class="text-blue-600 hover:text-blue-800 font-medium">Termos de Uso</a> e 
          <a href="#" class="text-blue-600 hover:text-blue-800 font-medium">Política de Privacidade</a>
        </label>
      </div>
      <?php if (isset($errors['termosEmpresa'])): ?>
        <p class="text-red-600 text-xs mt-1 ml-6"><?= $errors['termosEmpresa'] ?></p>
      <?php endif; ?>

      <button 
        type="submit" 
        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-3 px-4 rounded-lg transition-colors duration-200 transform hover:scale-[1.02]"
      >
        Criar Conta como Empresa
      </button>
    </form>

    <!-- Link de Login -->
    <p class="text-center mt-6 text-sm text-gray-600">
      Já tem uma conta? 
      <a href="<?= baseUrl() ?>login" class="font-bold text-blue-600 hover:text-blue-800 transition-colors duration-200">
        Faça login aqui
      </a>
    </p>
  </div>
</div>

<?php
// Limpar as sessions após exibir
Session::destroy('errors');
Session::destroy('inputs');
?>
