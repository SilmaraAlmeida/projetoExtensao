<div class="flex items-center justify-center min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4">
    <div class="w-full max-w-lg">
        <!-- Card Principal -->
        <div class="bg-white shadow-2xl rounded-lg overflow-hidden min-h-[600px]">
            <!-- Header do Card -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-8 py-8">
                <h3 class="text-white text-2xl font-semibold mb-0">Esqueceu sua Senha</h3>
                <p class="text-blue-100 text-sm mt-2">Recupere o acesso à sua conta</p>
            </div>

            <!-- Body do Card -->
            <div class="px-8 py-12 flex-1 flex flex-col justify-center">
                <p class="text-gray-600 text-base mb-10 leading-relaxed">
                    Informe seu e-mail cadastrado. Você irá receber um e-mail com um link para recuperar sua senha.
                </p>

                <!-- Formulário -->
                <form action="<?= baseUrl() ?>login/esqueciASenhaEnvio" method="POST" class="space-y-8">
                    <!-- Campo de Email -->
                    <div class="space-y-4">
                        <label for="login" class="block text-base font-semibold text-gray-700">
                            <i class="fas fa-envelope text-gray-400 mr-2"></i>
                            Informe seu Email
                        </label>
                        <input
                            type="email"
                            class="w-full px-5 py-5 border-2 border-gray-200 rounded-lg text-base text-gray-700 placeholder-gray-400 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                            id="login"
                            name="login"
                            placeholder="seu@email.com"
                            value="<?= setValor("login") ?>"
                            required
                            autofocus>
                    </div>

                    <!-- Área de Alertas -->
                    <div class="space-y-4">
                        <?= exibeAlerta() ?>
                    </div>

                    <!-- Botões -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-8">
                        <button
                            type="submit"
                            class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-5 px-8 rounded-lg text-base font-semibold hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-200 flex items-center justify-center group">
                            <i class="fas fa-paper-plane mr-3 group-hover:translate-x-1 transition-transform duration-200"></i>
                            Enviar
                        </button>

                        <a
                            href="<?= baseUrl() ?>login"
                            class="flex-1 border-2 border-gray-300 text-gray-700 py-5 px-8 rounded-lg text-base font-semibold text-center hover:border-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all duration-200 flex items-center justify-center group">
                            <i class="fas fa-arrow-left mr-3 group-hover:-translate-x-1 transition-transform duration-200"></i>
                            Voltar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informação Adicional -->
        <div class="mt-8 text-center">
            <p class="text-gray-500 text-base">
                <i class="fas fa-info-circle mr-2"></i>
                Não recebeu o e-mail? Verifique sua caixa de spam ou entre em contato com o suporte.
            </p>
        </div>
    </div>
</div>
