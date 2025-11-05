<?php

// var_dump($_POST);
// Set das variáveis vindas do controller
$vagas = isset($dados['vagas']) ? $dados['vagas'] : [];
$total_vagas = isset($dados['total_vagas']) ? $dados['total_vagas'] : 0;
$cargos = isset($dados['cargos']) ? $dados['cargos'] : [];
$estabelecimentos = isset($dados['estabelecimentos']) ? $dados['estabelecimentos'] : [];
$filtros_ativos = isset($dados['filtros_ativos']) ? $dados['filtros_ativos'] : [];
$paginacao = isset($dados['paginacao']) ? $dados['paginacao'] : [];
$termo_busca = isset($dados['termo_busca']) ? $dados['termo_busca'] : '';
?>

<!-- Seção de Busca Principal -->
<section class="bg-gradient-to-r from-blue-900 to-blue-800 text-white py-12">
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-8">
         <h1 class="text-3xl md:text-4xl font-bold mb-4">
            <?php if (isset($termo_busca) && !empty($termo_busca)): ?>
               Resultados para "<?= htmlspecialchars($termo_busca) ?>"
            <?php else: ?>
               Encontre sua Vaga Ideal
            <?php endif; ?>
         </h1>
         <p class="text-xl text-blue-100">Explore as melhores oportunidades em Muriaé e região</p>
      </div>

      <!-- Formulário de Busca Avançada -->
      <div class="max-w-6xl mx-auto">
         <form action="/vaga" method="GET" class="bg-white rounded-lg shadow-xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
               <!-- Campo Principal de Busca -->
               <div class="lg:col-span-2">
                  <label for="busca" class="block text-sm font-medium text-gray-700 mb-2">
                     <i class="fas fa-search mr-2 text-blue-600"></i>Cargo ou Palavra-chave
                  </label>
                  <input type="text"
                     id="busca"
                     name="busca"
                     value="<?= isset($termo_busca) ? htmlspecialchars($termo_busca) : '' ?>"
                     placeholder="Ex: Desenvolvedor, Vendedor, Analista..."
                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900 placeholder-gray-500">
               </div>

               <!-- Cargo -->
               <div>
                  <label for="cargo_id" class="block text-sm font-medium text-gray-700 mb-2">
                     <i class="fas fa-briefcase mr-2 text-blue-600"></i>Cargo
                  </label>
                  <select id="cargo_id"
                     name="cargo_id"
                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                     <option value="">Todos os cargos</option>
                     <?php if (isset($cargos) && !empty($cargos)): ?>
                        <?php foreach ($cargos as $cargo): ?>
                           <option value="<?= $cargo['cargo_id'] ?>" 
                              <?= (isset($_GET['cargo_id']) && $_GET['cargo_id'] == $cargo['cargo_id']) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($cargo['descricao']) ?>
                           </option>
                        <?php endforeach; ?>
                     <?php endif; ?>
                  </select>
               </div>

               <!-- Estabelecimento -->
               <div>
                  <label for="estabelecimento_id" class="block text-sm font-medium text-gray-700 mb-2">
                     <i class="fas fa-map-marker-alt mr-2 text-blue-600"></i>Estabelecimento
                  </label>
                  <select id="estabelecimento_id"
                     name="estabelecimento_id"
                     class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-gray-900">
                     <option value="">Todos os estabelecimentos</option>
                     <?php if (isset($estabelecimentos) && !empty($estabelecimentos)): ?>
                        <?php foreach ($estabelecimentos as $estabelecimento): ?>
                           <option value="<?= $estabelecimento['estabelecimento_id'] ?>" 
                              <?= (isset($_GET['estabelecimento_id']) && $_GET['estabelecimento_id'] == $estabelecimento['estabelecimento_id']) ? 'selected' : '' ?>>
                              <?= htmlspecialchars($estabelecimento['nome']) ?>
                           </option>
                        <?php endforeach; ?>
                     <?php endif; ?>
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
               (isset($_GET['regime']) && !empty($_GET['regime']))
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
                  <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                     <!-- Tipo de Contrato -->
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tipo de Vínculo</label>
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
                        </div>
                     </div>

                     <!-- Regime de Trabalho -->
                     <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Modalidade</label>
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
                        </div>
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
      <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
         <a href="/" class="hover:text-blue-600">Home</a>
         <i class="fas fa-chevron-right text-xs"></i>
         <span class="text-gray-900 font-medium">Vagas</span>
      </nav>

      <p class="text-gray-600">
         <?php if (isset($termo_busca) && !empty($termo_busca)): ?>
            Encontramos <span class="font-semibold text-blue-600"><?= $total_vagas ?> vagas</span> relacionadas à sua busca
         <?php else: ?>
            Mostrando <span class="font-semibold text-blue-600"><?= $total_vagas ?> vagas</span> disponíveis
         <?php endif; ?>
      </p>
   </div>
</section>

<!-- Tags de Filtros Ativos -->
<?php if (!empty($filtros_ativos)): ?>
   <section class="bg-gray-50 border-b border-gray-200 py-4">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
         <div class="flex items-center justify-between">
            <div class="flex flex-wrap items-center gap-3">
               <span class="text-sm text-gray-600">Filtros ativos:</span>

               <?php foreach ($filtros_ativos as $key => $filtro): ?>
                  <div class="flex items-center bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm">
                     <span><?= $filtro['label'] ?>: "<?= htmlspecialchars($filtro['valor']) ?>"</span>
                     <button onclick="removeFilter('<?= $key ?>')" class="ml-2 hover:text-blue-900">
                        <i class="fas fa-times text-xs"></i>
                     </button>
                  </div>
               <?php endforeach; ?>
            </div>

            <a href="/vaga" class="text-blue-600 hover:text-blue-700 text-sm font-medium">
               <i class="fas fa-times-circle mr-1"></i>Limpar todos
            </a>
         </div>
      </div>
   </section>
<?php endif; ?>

<!-- Lista de Vagas com Sidebar -->
<section class="py-8 bg-gray-50 min-h-screen">
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
         
         <!-- Sidebar de Filtros -->
         <div class="lg:col-span-1 space-y-6">
            <!-- Filtros Rápidos -->
            <div class="bg-white rounded-lg shadow-sm p-6">
               <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                  <i class="fas fa-filter mr-2 text-blue-600"></i>Filtros Rápidos
               </h3>
               
               <form action="/vaga" method="GET" class="space-y-4">
                  <!-- Preservar busca atual -->
                  <?php if (!empty($termo_busca)): ?>
                     <input type="hidden" name="busca" value="<?= htmlspecialchars($termo_busca) ?>">
                  <?php endif; ?>
                  
                  <!-- Status da Vaga -->
                  <div>
                     <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                     <div class="space-y-2">
                        <label class="flex items-center">
                           <input type="radio" name="statusVaga" value="" 
                              <?= !isset($_GET['statusVaga']) ? 'checked' : '' ?>
                              class="text-blue-600 focus:ring-blue-500">
                           <span class="ml-2 text-sm text-gray-700">Todas</span>
                        </label>
                        <label class="flex items-center">
                           <input type="radio" name="statusVaga" value="11"
                              <?= (isset($_GET['statusVaga']) && $_GET['statusVaga'] == '11') ? 'checked' : '' ?>
                              class="text-blue-600 focus:ring-blue-500">
                           <span class="ml-2 text-sm text-gray-700">Em Aberto</span>
                        </label>
                        <label class="flex items-center">
                           <input type="radio" name="statusVaga" value="1"
                              <?= (isset($_GET['statusVaga']) && $_GET['statusVaga'] == '1') ? 'checked' : '' ?>
                              class="text-blue-600 focus:ring-blue-500">
                           <span class="ml-2 text-sm text-gray-700">Pré Vaga</span>
                        </label>
                        <label class="flex items-center">
                           <input type="radio" name="statusVaga" value="91"
                              <?= (isset($_GET['statusVaga']) && $_GET['statusVaga'] == '91') ? 'checked' : '' ?>
                              class="text-blue-600 focus:ring-blue-500">
                           <span class="ml-2 text-sm text-gray-700">Suspensa</span>
                        </label>
                     </div>
                  </div>

                  <!-- Tipo de Vínculo -->
                  <div>
                     <label class="block text-sm font-medium text-gray-700 mb-2">Vínculo</label>
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
                     </div>
                  </div>

                  <!-- Modalidade -->
                  <div>
                     <label class="block text-sm font-medium text-gray-700 mb-2">Modalidade</label>
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
                     </div>
                  </div>

                  <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-medium transition-colors duration-200">
                     Aplicar Filtros
                  </button>
               </form>
            </div>

            <!-- Cargos Populares -->
            <?php if (isset($cargos) && !empty($cargos)): ?>
               <div class="bg-white rounded-lg shadow-sm p-6">
                  <h3 class="font-semibold text-gray-900 mb-4 flex items-center">
                     <i class="fas fa-briefcase mr-2 text-blue-600"></i>Cargos Populares
                  </h3>
                  <div class="space-y-2">
                     <?php foreach (array_slice($cargos, 0, 6) as $cargo): ?>
                        <a href="/vaga?cargo_id=<?= $cargo['cargo_id'] ?>" 
                           class="block text-blue-600 hover:text-blue-800 text-sm transition-colors duration-200 py-1">
                           <?= htmlspecialchars($cargo['descricao']) ?>
                        </a>
                     <?php endforeach; ?>
                  </div>
               </div>
            <?php endif; ?>
         </div>

         <!-- Lista de Vagas -->
         <div class="lg:col-span-3">
            <?php if (isset($vagas) && !empty($vagas)): ?>
               <div class="space-y-6">
                  <?php foreach ($vagas as $vaga): ?>
                     <div class="bg-white rounded-lg shadow-sm border border-gray-200 hover:shadow-lg transition-all duration-200 p-8">
                        <div class="flex justify-between items-start mb-6">
                           <div class="flex-1">
                              <div class="flex items-start justify-between mb-3">
                                 <h3 class="text-xl font-semibold text-gray-900 pr-4">
                                    <a href="/vaga/detalhes/view/<?= $vaga['vaga_id'] ?>" class="hover:text-blue-600 transition-colors duration-200">
                                       <?= htmlspecialchars($vaga['descricao']) ?>
                                    </a>
                                 </h3>
                                 <?php if (isset($vaga['statusVaga'])): ?>
                                    <?php if ($vaga['statusVaga'] == 1): ?>
                                       <span class="px-3 py-1 bg-yellow-100 text-yellow-800 text-xs rounded-full whitespace-nowrap">
                                          Pré Vaga
                                       </span>
                                    <?php elseif ($vaga['statusVaga'] == 11 ): ?>
                                       <span class="px-3 py-1 bg-green-100 text-green-800 text-xs rounded-full whitespace-nowrap">
                                          Em Aberto
                                       </span>
                                    <?php elseif ($vaga['statusVaga'] == 91 ): ?>
                                       <span class="px-3 py-1 bg-red-100 text-red-800 text-xs rounded-full whitespace-nowrap">
                                          Suspensa
                                       </span>
                                    <?php endif; ?>
                                 <?php endif; ?>
                              </div>

                              <div class="flex flex-wrap items-center gap-6 text-sm text-gray-600 mb-4">
                                 <?php
                                 // Buscar estabelecimento da vaga
                                 $estabelecimentoVaga = null;
                                 if (isset($estabelecimentos) && isset($vaga['estabelecimento_id'])) {
                                    foreach ($estabelecimentos as $est) {
                                       if ($est['estabelecimento_id'] == $vaga['estabelecimento_id']) {
                                          $estabelecimentoVaga = $est;
                                          break;
                                       }
                                    }
                                 }
                                 ?>
                                 <span class="flex items-center">
                                    <i class="fas fa-building mr-2"></i>
                                    <?= $estabelecimentoVaga ? htmlspecialchars($estabelecimentoVaga['nome']) : 'Estabelecimento não encontrado' ?>
                                 </span>
                                 
                                 <span class="flex items-center">
                                    <i class="fas fa-map-marker-alt mr-2"></i>Muriaé, MG
                                 </span>
                                 
                                 <?php if (isset($vaga['dtInicio'])): ?>
                                    <span class="flex items-center">
                                       <i class="fas fa-clock mr-2"></i>Início: <?= date('d/m/Y', strtotime($vaga['dtInicio'])) ?>
                                    </span>
                                 <?php endif; ?>
                              </div>

                              <p class="text-gray-700 leading-relaxed mb-5">
                                 <?= isset($vaga['sobreaVaga']) ? htmlspecialchars(substr($vaga['sobreaVaga'], 0, 200)) . (strlen($vaga['sobreaVaga']) > 200 ? '...' : '') : 'Descrição não disponível' ?>
                              </p>
                           </div>
                        </div>

                        <div class="flex flex-wrap gap-3 mb-6">
                           <?php
                           // Buscar cargo da vaga
                           $cargoVaga = null;
                           if (isset($cargos) && isset($vaga['cargo_id'])) {
                              foreach ($cargos as $cargo) {
                                 if ($cargo['cargo_id'] == $vaga['cargo_id']) {
                                    $cargoVaga = $cargo;
                                    break;
                                 }
                              }
                           }
                           ?>
                           <?php if ($cargoVaga): ?>
                              <span class="px-4 py-2 bg-blue-100 text-blue-800 text-sm rounded-full">
                                 <?= htmlspecialchars($cargoVaga['descricao']) ?>
                              </span>
                           <?php endif; ?>
                           
                           <span class="px-4 py-2 bg-green-100 text-green-800 text-sm rounded-full">
                              <?= (isset($vaga['vinculo']) && $vaga['vinculo'] == 1) ? 'CLT' : 'Pessoa Jurídica' ?>
                           </span>
                           
                           <span class="px-4 py-2 bg-purple-100 text-purple-800 text-sm rounded-full">
                              <?= (isset($vaga['modalidade']) && $vaga['modalidade'] == 1) ? 'Presencial' : 'Remoto' ?>
                           </span>
                        </div>

                        <div class="flex justify-between items-center pt-5 border-t border-gray-100">
                           <div class="text-sm text-gray-500">
                              <?php if (isset($vaga['dtFim'])): ?>
                                 <span class="flex items-center">
                                    <i class="fas fa-calendar mr-2"></i>Até: <?= date('d/m/Y', strtotime($vaga['dtFim'])) ?>
                                 </span>
                              <?php endif; ?>
                           </div>
                           <a href="/vaga/detalhes/view/<?= $vaga['vaga_id'] ?>" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-medium transition-all duration-200">
                              <i class="fas fa-eye mr-2"></i>Ver Detalhes
                           </a>
                        </div>
                     </div>
                  <?php endforeach; ?>
               </div>
            <?php else: ?>
               <div class="text-center py-12">
                  <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                  <h3 class="text-xl font-semibold text-gray-600 mb-2">Nenhuma vaga encontrada</h3>
                  <p class="text-gray-500">Tente ajustar os filtros de busca ou 
                     <a href="/vaga" class="text-blue-600 hover:text-blue-700">visualizar todas as vagas</a>.
                  </p>
               </div>
            <?php endif; ?>

            <!-- Paginação -->
            <?php if (isset($paginacao) && $paginacao['total_paginas'] > 1): ?>
               <div class="mt-12 flex justify-center">
                  <nav class="flex items-center space-x-2">
                     <?php if ($paginacao['pagina_atual'] > 1): ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $paginacao['pagina_atual'] - 1])) ?>" 
                           class="px-3 py-2 text-gray-500 hover:text-blue-600 border border-gray-300 rounded-lg hover:border-blue-300 transition-colors duration-200">
                           <i class="fas fa-chevron-left"></i>
                        </a>
                     <?php endif; ?>

                     <?php for ($i = 1; $i <= $paginacao['total_paginas']; $i++): ?>
                        <?php if ($i == $paginacao['pagina_atual']): ?>
                           <button class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium"><?= $i ?></button>
                        <?php else: ?>
                           <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                              class="px-4 py-2 text-gray-600 hover:text-blue-600 border border-gray-300 rounded-lg hover:border-blue-300 transition-colors duration-200"><?= $i ?></a>
                        <?php endif; ?>
                     <?php endfor; ?>

                     <?php if ($paginacao['pagina_atual'] < $paginacao['total_paginas']): ?>
                        <a href="?<?= http_build_query(array_merge($_GET, ['page' => $paginacao['pagina_atual'] + 1])) ?>" 
                           class="px-3 py-2 text-gray-500 hover:text-blue-600 border border-gray-300 rounded-lg hover:border-blue-300 transition-colors duration-200">
                           <i class="fas fa-chevron-right"></i>
                        </a>
                     <?php endif; ?>
                  </nav>
               </div>
            <?php endif; ?>
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
