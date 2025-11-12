    </main>

    <!-- Footer -->
    <footer class="bg-blue-900 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">

                <!-- Empresa Info -->
                <div>
                    <h3 class="text-lg font-bold mb-3">Via Muriaé – Conectando talentos às oportunidades em Muriaé</h3>
                    <p class="text-blue-100 text-sm mb-3 leading-relaxed">
                        Somos o hub que conecta talentos e empresas de Muriaé.
                    </p>
                    <div class="text-blue-100 text-sm space-y-1">
                        <p>Rua Almeida João, 123 – Centro, Muriaé/MG</p>
                        <p>(32) 3721-0000</p>
                        <p>contato@viamuriae.com.br</p>
                    </div>
                </div>

                <!-- Menu Principal -->
                <div>
                    <h4 class="text-base font-semibold mb-3">Menu Principal</h4>
                    <ul class="space-y-1 text-sm">
                        <li>
                            <a href="<?= baseUrl() ?>" class="text-blue-100 hover:text-white transition-colors duration-200">
                                Início
                            </a>
                        </li>
                        <li>
                            <a href="<?= baseUrl() ?>vaga" class="text-blue-100 hover:text-white transition-colors duration-200">
                                Vagas
                            </a>
                        </li>
                        <!-- <li>
                            <a href="#" class="text-blue-100 hover:text-white transition-colors duration-200">
                                Sobre nós
                            </a>
                        </li> -->
                        <li>
                            <a href="<?= baseUrl() ?>Login/" class="text-blue-100 hover:text-white transition-colors duration-200">
                                Entrar
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Divisor -->
            <hr class="border-blue-800 my-6">

            <!-- Copyright e Redes Sociais -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <p class="text-blue-100 text-sm mb-4 md:mb-0">
                    © 2025 ViaMuriae. Todos os direitos reservados
                </p>

                <div class="flex flex-col md:flex-row md:items-center space-y-4 md:space-y-0 md:space-x-6">
                    <!-- Links legais -->
                    <div class="flex space-x-4 text-sm">
                        <a href="<?= baseUrl() ?>home/termodeuso" class="text-blue-100 hover:text-white transition-colors duration-200">
                            Termos de uso
                        </a>
                        <a href="<?= baseUrl() ?>home/termodeuso" class="text-blue-100 hover:text-white transition-colors duration-200">
                            Política de privacidade
                        </a>
                    </div>

                    <!-- Redes Sociais -->
                    <div class="flex space-x-3">
                        <a href="#" class="text-blue-100 hover:text-white transition-colors duration-200">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                        <a href="#" class="text-blue-100 hover:text-white transition-colors duration-200">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-blue-100 hover:text-white transition-colors duration-200">
                            <i class="fab fa-whatsapp text-xl"></i>
                        </a>
                        <a href="#" class="text-blue-100 hover:text-white transition-colors duration-200">
                            <i class="fab fa-linkedin text-xl"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    </body>

    </html>