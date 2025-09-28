<!-- Seção de Busca Principal -->
<section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-8">
         <h1 class="text-3xl md:text-4xl font-bold mb-4">
            <?php if (isset($_GET['busca']) && !empty($_GET['busca'])): ?>
               Resultados para "<?= htmlspecialchars($_GET['busca']) ?>"
            <?php else: ?>
               Encontre sua Vaga Ideal
            <?php endif; ?>
         </h1>
         <p class="text-xl text-blue-100">Explore as melhores oportunidades em Muriaé e região</p>
      </div>

      <!-- Formulário de Busca Avançada -->
      <div class="max-w-6xl mx-auto">
         <form action="/vaga/busca" method="GET" class="bg-white rounded-lg shadow-xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
               <!-- Campo Principal de Busca -->
               <div class="lg:col-span-2">
                  <label for="busca" class="block text-sm font-medium text-gray-700 mb-2">
                     <i class="fas fa-search mr-2 text-blue-600"></i>Cargo ou Palavra-chave
                  </label>
                  <input type="text"
                     id="busca"
                     name="busca"
                     value="<?= isset($_GET['busca']) ? htmlspecialchars($_GET['busca']) : '' ?>"
                     placeholder="Ex: Desenvolvedor, Vendedor, Analista..."
                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 placeholder-gray-500">
               </div>

               <!-- Localização -->
               <div>
                  <label for="localizacao" class="block text-sm font-medium text-gray-700 mb-2">
                     <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Localização
                  </label>
                  <select id="localizacao"
                     name="localizacao"
                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                     <option value="">Todas as cidades</option>
                     <option value="muriae" <?= (isset($_GET['localizacao']) && $_GET['localizacao'] == 'muriae') ? 'selected' : '' ?>>Muriaé</option>
                     <option value="carangola" <?= (isset($_GET['localizacao']) && $_GET['localizacao'] == 'carangola') ? 'selected' : '' ?>>Carangola</option>
                     <option value="miradouro" <?= (isset($_GET['localizacao']) && $_GET['localizacao'] == 'miradouro') ? 'selected' : '' ?>>Miradouro</option>
                     <option value="patrocinio" <?= (isset($_GET['localizacao']) && $_GET['localizacao'] == 'patrocinio') ? 'selected' : '' ?>>Patrocínio do Muriaé</option>
                  </select>
               </div>

               <!-- Categoria -->
               <div>
                  <label for="categoria" class="block text-sm font-medium text-gray-700 mb-2">
                     <i class="fas fa-briefcase mr-2 text-blue-600"></i>Categoria
                  </label>
                  <select id="categoria"
                     name="categoria"
                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                     <option value="">Todas as áreas</option>
                     <option value="tecnologia" <?= (isset($_GET['categoria']) && $_GET['categoria'] == 'tecnologia') ? 'selected' : '' ?>>Tecnologia</option>
                     <option value="vendas" <?= (isset($_GET['categoria']) && $_GET['categoria'] == 'vendas') ? 'selected' : '' ?>>Vendas</option>
                     <option value="administracao" <?= (isset($_GET['categoria']) && $_GET['categoria'] == 'administracao') ? 'selected' : '' ?>>Administração</option>
                     <option value="educacao" <?= (isset($_GET['categoria']) && $_GET['categoria'] == 'educacao') ? 'selected' : '' ?>>Educação</option>
                     <option value="saude" <?= (isset($_GET['categoria']) && $_GET['categoria'] == 'saude') ? 'selected' : '' ?>>Saúde</option>
                  </select>
               </div>

               <!-- Botão de Busca -->
               <div class="flex items-end">
                  <button type="submit"
                     class="w-full bg-orange-500 hover:bg-orange-600 text-white px-6 py-3 rounded-lg font-medium transition-all duration-200 transform hover:scale-105 shadow-lg">
                     <i class="fas fa-search mr-2"></i>Buscar Vagas
                  </button>
               </div>
            </div>

            <!-- Filtros Adicionais (Expansível) -->
            <?php
            $hasAdvancedFilters = (
               (isset($_GET['contrato']) && !empty($_GET['contrato'])) ||
               (isset($_GET['regime']) && !empty($_GET['regime'])) ||
               (isset($_GET['salario']) && !empty($_GET['salario'])) ||
               (isset($_GET['experiencia']) && !empty($_GET['experiencia']))
            );
            ?>
            <div x-data="{ showAdvanced: <?= $hasAdvancedFilters ? 'true' : 'false' ?> }" class="mt-4">
               <button type="button"
                  @click="showAdvanced = !showAdvanced"
                  class="flex items-center text-blue-600 hover:text-blue-700 text-sm font-medium transition-colors duration-200">
                  <i class="fas fa-sliders-h mr-2"></i>
                  <span x-text="showAdvanced ? 'Ocultar Filtros Avançados' : 'Mostrar Filtros Avançados'"></span>
                  <i class="fas fa-chevron-down ml-2 text-xs transition-transform duration-200" :class="showAdvanced ? 'rotate-180' : ''"></i>
               </button>

               <div x-show="showAdvanced"
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0 -translate-y-2"
                  x-transition:enter-end="opacity-100 translate-y-0"
                  x-transition:leave="transition ease-in duration-200"
                  x-transition:leave-start="opacity-100 translate-y-0"
                  x-transition:leave-end="opacity-0 -translate-y-2"
                  class="mt-4 pt-4 border-t border-gray-200"
                  x-cloak>
                  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                     <!-- Tipo de Contrato -->
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Contrato</label>
                        <div class="space-y-2">
                           <label class="flex items-center">
                              <input type="checkbox" name="contrato[]" value="clt"
                                 <?= (isset($_GET['contrato']) && in_array('clt', $_GET['contrato'])) ? 'checked' : '' ?>
                                 class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              <span class="ml-2 text-sm text-gray-700">CLT</span>
                           </label>
                           <label class="flex items-center">
                              <input type="checkbox" name="contrato[]" value="pj"
                                 <?= (isset($_GET['contrato']) && in_array('pj', $_GET['contrato'])) ? 'checked' : '' ?>
                                 class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              <span class="ml-2 text-sm text-gray-700">Pessoa Jurídica</span>
                           </label>
                           <label class="flex items-center">
                              <input type="checkbox" name="contrato[]" value="estagio"
                                 <?= (isset($_GET['contrato']) && in_array('estagio', $_GET['contrato'])) ? 'checked' : '' ?>
                                 class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              <span class="ml-2 text-sm text-gray-700">Estágio</span>
                           </label>
                        </div>
                     </div>

                     <!-- Regime de Trabalho -->
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Regime</label>
                        <div class="space-y-2">
                           <label class="flex items-center">
                              <input type="checkbox" name="regime[]" value="presencial"
                                 <?= (isset($_GET['regime']) && in_array('presencial', $_GET['regime'])) ? 'checked' : '' ?>
                                 class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              <span class="ml-2 text-sm text-gray-700">Presencial</span>
                           </label>
                           <label class="flex items-center">
                              <input type="checkbox" name="regime[]" value="remoto"
                                 <?= (isset($_GET['regime']) && in_array('remoto', $_GET['regime'])) ? 'checked' : '' ?>
                                 class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              <span class="ml-2 text-sm text-gray-700">Remoto</span>
                           </label>
                           <label class="flex items-center">
                              <input type="checkbox" name="regime[]" value="hibrido"
                                 <?= (isset($_GET['regime']) && in_array('hibrido', $_GET['regime'])) ? 'checked' : '' ?>
                                 class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                              <span class="ml-2 text-sm text-gray-700">Híbrido</span>
                           </label>
                        </div>
                     </div>


                     <!-- Faixa Salarial -->
                     <div>
                        <label for="salario" class="block text-sm font-medium text-gray-700 mb-2">Faixa Salarial</label>
                        <select id="salario" name="salario" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-900">
                           <option value="">Qualquer faixa</option>
                           <option value="1" <?= (isset($_GET['salario']) && $_GET['salario'] == '1') ? 'selected' : '' ?>>Até R$ 2.000</option>
                           <option value="2" <?= (isset($_GET['salario']) && $_GET['salario'] == '2') ? 'selected' : '' ?>>R$ 2.000 - R$ 4.000</option>
                           <option value="3" <?= (isset($_GET['salario']) && $_GET['salario'] == '3') ? 'selected' : '' ?>>R$ 4.000 - R$ 6.000</option>
                           <option value="4" <?= (isset($_GET['salario']) && $_GET['salario'] == '4') ? 'selected' : '' ?>>R$ 6.000 - R$ 8.000</option>
                           <option value="5" <?= (isset($_GET['salario']) && $_GET['salario'] == '5') ? 'selected' : '' ?>>Acima de R$ 8.000</option>
                        </select>
                     </div>


                     <!-- Nível de Experiência -->
                     <div>
                        <label for="experiencia" class="block text-sm font-medium text-gray-700 mb-2">Experiência</label>
                        <select id="experiencia" name="experiencia" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 text-gray-900">
                           <option value="">Qualquer nível</option>
                           <option value="junior" <?= (isset($_GET['experiencia']) && $_GET['experiencia'] == 'junior') ? 'selected' : '' ?>>Júnior (até 2 anos)</option>
                           <option value="pleno" <?= (isset($_GET['experiencia']) && $_GET['experiencia'] == 'pleno') ? 'selected' : '' ?>>Pleno (2-5 anos)</option>
                           <option value="senior" <?= (isset($_GET['experiencia']) && $_GET['experiencia'] == 'senior') ? 'selected' : '' ?>>Sênior (5+ anos)</option>
                           <option value="especialista" <?= (isset($_GET['experiencia']) && $_GET['experiencia'] == 'especialista') ? 'selected' : '' ?>>Especialista (8+ anos)</option>
                        </select>
                     </div>

                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</section>

<!-- Breadcrumb e Informações da Página -->
<section class="bg-white border-b border-gray-200 py-6">
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row md:items-center md:justify-between">
         <div>
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4 md:mb-0">
               <a href="/" class="hover:text-blue-600">Home</a>
               <i class="fas fa-chevron-right text-xs"></i>
               <span class="text-gray-900 font-medium">Vagas</span>
            </nav>

            <div class="flex items-center justify-between">
               <p class="text-gray-600">
                  <?php if (isset($_GET['busca']) && !empty($_GET['busca'])): ?>
                     Encontramos <span class="font-semibold text-blue-600">23 vagas</span> relacionadas à sua busca
                  <?php else: ?>
                     Mostrando <span class="font-semibold text-blue-600">245 vagas</span> disponíveis
                  <?php endif; ?>
               </p>
            </div>
         </div>

         <!-- Ordenação -->
         <div class="flex items-center space-x-4">
            <span class="text-gray-600 text-sm">Ordenar:</span>
            <select class="px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent">
               <option>Mais recentes</option>
               <option>Relevância</option>
               <option>Maior salário</option>
               <option>Menor salário</option>
            </select>
         </div>
      </div>
   </div>
</section>

<!-- Tags de Filtros Ativos -->
<?php if ((isset($_GET['busca']) && !empty($_GET['busca'])) || isset($_GET['localizacao']) || isset($_GET['categoria'])): ?>
   <section class="bg-gray-50 border-b border-gray-200 py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         <div class="flex items-center justify-between">
            <div class="flex flex-wrap items-center gap-3">
               <span class="text-sm text-gray-600">Filtros ativos:</span>

               <?php if (isset($_GET['busca']) && !empty($_GET['busca'])): ?>
                  <div class="flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                     <span>Busca: "<?= htmlspecialchars($_GET['busca']) ?>"</span>
                     <button onclick="removeFilter('busca')" class="ml-2 hover:text-blue-900">
                        <i class="fas fa-times text-xs"></i>
                     </button>
                  </div>
               <?php endif; ?>

               <?php if (isset($_GET['localizacao']) && !empty($_GET['localizacao'])): ?>
                  <div class="flex items-center bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                     <span>Local: <?= htmlspecialchars($_GET['localizacao']) ?></span>
                     <button onclick="removeFilter('localizacao')" class="ml-2 hover:text-green-900">
                        <i class="fas fa-times text-xs"></i>
                     </button>
                  </div>
               <?php endif; ?>

               <?php if (isset($_GET['categoria']) && !empty($_GET['categoria'])): ?>
                  <div class="flex items-center bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">
                     <span>Área: <?= htmlspecialchars($_GET['categoria']) ?></span>
                     <button onclick="removeFilter('categoria')" class="ml-2 hover:text-purple-900">
                        <i class="fas fa-times text-xs"></i>
                     </button>
                  </div>
               <?php endif; ?>
            </div>

            <a href="/vaga" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
               <i class="fas fa-times-circle mr-1"></i>Limpar todos
            </a>
         </div>
      </div>
   </section>
<?php endif; ?>

<!-- Lista de Vagas -->
<section class="py-8 bg-gray-50 min-h-screen">
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

         <!-- Sidebar com Estatísticas -->
         <div class="lg:col-span-1 space-y-6">
            <div class="bg-white rounded-lg shadow-sm p-6">
               <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                  <i class="fas fa-chart-bar mr-2 text-blue-600"></i>Estatísticas
               </h3>
               <div class="space-y-3">
                  <div class="flex justify-between items-center">
                     <span class="text-gray-600">Total de vagas</span>
                     <span class="font-semibold text-blue-600">245</span>
                  </div>
                  <div class="flex justify-between items-center">
                     <span class="text-gray-600">Novas hoje</span>
                     <span class="font-semibold text-green-600">12</span>
                  </div>
                  <div class="flex justify-between items-center">
                     <span class="text-gray-600">Empresas ativas</span>
                     <span class="font-semibold text-orange-600">48</span>
                  </div>
               </div>
            </div>

            <div class="bg-white rounded-lg shadow-sm p-6">
               <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                  <i class="fas fa-tags mr-2 text-blue-600"></i>Categorias
               </h3>
               <div class="space-y-2">
                  <a href="#" class="block text-blue-600 hover:text-blue-800 text-sm transition-colors duration-200">
                     Tecnologia (45)
                  </a>
                  <a href="#" class="block text-blue-600 hover:text-blue-800 text-sm transition-colors duration-200">
                     Vendas (32)
                  </a>
                  <a href="#" class="block text-blue-600 hover:text-blue-800 text-sm transition-colors duration-200">
                     Administração (28)
                  </a>
                  <a href="#" class="block text-blue-600 hover:text-blue-800 text-sm transition-colors duration-200">
                     Educação (19)
                  </a>
                  <a href="#" class="block text-blue-600 hover:text-blue-800 text-sm transition-colors duration-200">
                     Saúde (15)
                  </a>
               </div>
            </div>
         </div>

         <!-- Cards de Vagas -->
         <div class="lg:col-span-3">
            <div class="space-y-6">

               <!-- Card de Vaga 1 -->
               <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-200 p-6">
                  <div class="flex justify-between items-start mb-4">
                     <div class="flex-1">
                        <div class="flex items-start justify-between mb-2">
                           <h3 class="text-xl font-semibold text-gray-900">
                              <a href="#" class="hover:text-blue-600 transition-colors duration-200">
                                 Desenvolvedor PHP Pleno
                              </a>
                           </h3>
                           <span class="ml-4 px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                              Nova
                           </span>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-3">
                           <span class="flex items-center">
                              <i class="fas fa-building mr-2"></i>TechSolution Muriaé
                           </span>
                           <span class="flex items-center">
                              <i class="fas fa-map-marker-alt mr-2"></i>Muriaé, MG
                           </span>
                           <span class="flex items-center">
                              <i class="fas fa-clock mr-2"></i>2 dias atrás
                           </span>
                        </div>

                        <p class="text-gray-700 leading-relaxed">
                           Buscamos desenvolvedor PHP com experiência em Laravel, MySQL e desenvolvimento de APIs REST.
                           Conhecimento em Docker e Git será um diferencial para projetos modernos.
                        </p>
                     </div>

                     <div class="ml-6 text-right">
                        <div class="text-2xl font-bold text-green-600 mb-1">
                           R$ 4.500
                        </div>
                        <span class="text-sm text-gray-500">por mês</span>
                     </div>
                  </div>

                  <div class="flex flex-wrap gap-2 mb-4">
                     <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">PHP</span>
                     <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">Laravel</span>
                     <span class="px-3 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">MySQL</span>
                     <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">CLT</span>
                     <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">Presencial</span>
                  </div>

                  <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                     <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center">
                           <i class="fas fa-users mr-1"></i>5 candidatos
                        </span>
                        <span class="flex items-center">
                           <i class="fas fa-eye mr-1"></i>127 views
                        </span>
                     </div>
                     <div class="flex space-x-3">
                        <button class="flex items-center px-3 py-2 text-gray-600 hover:text-blue-600 transition-colors duration-200">
                           <i class="fas fa-bookmark mr-2"></i>Salvar
                        </button>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200">
                           <i class="fas fa-paper-plane mr-2"></i>Candidatar
                        </button>
                     </div>
                  </div>
               </div>

               <!-- Card de Vaga 2 -->
               <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-200 p-6">
                  <div class="flex justify-between items-start mb-4">
                     <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                           <a href="#" class="hover:text-blue-600 transition-colors duration-200">
                              Analista de Vendas
                           </a>
                        </h3>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600 mb-3">
                           <span class="flex items-center">
                              <i class="fas fa-building mr-2"></i>ComercialMax Ltda
                           </span>
                           <span class="flex items-center">
                              <i class="fas fa-map-marker-alt mr-2"></i>Muriaé, MG
                           </span>
                           <span class="flex items-center">
                              <i class="fas fa-clock mr-2"></i>5 dias atrás
                           </span>
                        </div>

                        <p class="text-gray-700 leading-relaxed">
                           Oportunidade para analista de vendas com foco em relacionamento com clientes B2B e
                           desenvolvimento de estratégias comerciais. Experiência com CRM é desejável.
                        </p>
                     </div>

                     <div class="ml-6 text-right">
                        <div class="text-2xl font-bold text-green-600 mb-1">
                           R$ 3.200
                        </div>
                        <span class="text-sm text-gray-500">+ comissões</span>
                     </div>
                  </div>

                  <div class="flex flex-wrap gap-2 mb-4">
                     <span class="px-3 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">Vendas</span>
                     <span class="px-3 py-1 bg-orange-100 text-orange-800 text-xs rounded-full">B2B</span>
                     <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full">CLT</span>
                     <span class="px-3 py-1 bg-purple-100 text-purple-800 text-xs rounded-full">Híbrido</span>
                  </div>

                  <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                     <div class="flex items-center space-x-4 text-sm text-gray-500">
                        <span class="flex items-center">
                           <i class="fas fa-users mr-1"></i>12 candidatos
                        </span>
                        <span class="flex items-center">
                           <i class="fas fa-eye mr-1"></i>89 views
                        </span>
                     </div>
                     <div class="flex space-x-3">
                        <button class="flex items-center px-3 py-2 text-gray-600 hover:text-blue-600 transition-colors duration-200">
                           <i class="fas fa-bookmark mr-2"></i>Salvar
                        </button>
                        <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-medium transition-all duration-200">
                           <i class="fas fa-paper-plane mr-2"></i>Candidatar
                        </button>
                     </div>
                  </div>
               </div>

            </div>

            <!-- Paginação -->
            <div class="mt-12 flex justify-center">
               <nav class="flex items-center space-x-2">
                  <button class="px-3 py-2 text-gray-500 hover:text-blue-600 border border-gray-300 rounded-lg hover:border-blue-300 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                     <i class="fas fa-chevron-left"></i>
                  </button>

                  <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium">1</button>
                  <button class="px-4 py-2 text-gray-600 hover:text-blue-600 border border-gray-300 rounded-lg hover:border-blue-300 transition-colors duration-200">2</button>
                  <button class="px-4 py-2 text-gray-600 hover:text-blue-600 border border-gray-300 rounded-lg hover:border-blue-300 transition-colors duration-200">3</button>
                  <span class="px-2 text-gray-500">...</span>
                  <button class="px-4 py-2 text-gray-600 hover:text-blue-600 border border-gray-300 rounded-lg hover:border-blue-300 transition-colors duration-200">8</button>

                  <button class="px-3 py-2 text-gray-500 hover:text-blue-600 border border-gray-300 rounded-lg hover:border-blue-300 transition-colors duration-200">
                     <i class="fas fa-chevron-right"></i>
                  </button>
               </nav>
            </div>
         </div>
      </div>
   </div>
</section>

<script>
   function removeFilter(filterName) {
      const url = new URL(window.location);
      url.searchParams.delete(filterName);
      window.location.href = url.toString();
   }
</script>