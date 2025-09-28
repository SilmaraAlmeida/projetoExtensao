<div class="min-h-screen bg-gray-50" x-data="perfilCandidato()">
   <!-- Header do Dashboard -->
   <div class="bg-white shadow-sm border-b border-gray-200">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
         <div class="flex items-center justify-between">
            <div>
               <h1 class="text-3xl font-bold text-gray-900">
                  Meu Perfil
               </h1>
               <p class="text-gray-600 mt-1">
                  Gerencie suas informações pessoais e contatos
               </p>
            </div>
            <div class="flex items-center space-x-4">
               <a href="<?= baseUrl() ?>Sistema/"
                  class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                  <i class="fas fa-arrow-left mr-2"></i>
                  Voltar ao Sistema
               </a>
            </div>
         </div>
      </div>
   </div>

   <!-- Alert Area -->
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
      <?= exibeAlerta() ?>
   </div>

   <!-- Main Content -->
   <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
      <form action="<?= baseUrl() ?>candidato/atualizarPerfil" method="POST" class="space-y-8">

         <!-- Card de Dados Pessoais -->
         <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-blue-50">
               <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                  <div class="p-2 bg-blue-100 rounded-lg mr-3">
                     <i class="fas fa-user text-blue-600"></i>
                  </div>
                  Dados Pessoais
               </h3>
            </div>

            <div class="p-6 space-y-6">
               <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                  <!-- Nome -->
                  <div>
                     <label for="nome" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user-circle text-gray-400 mr-2"></i>
                        Nome Completo
                     </label>
                     <input
                        type="text"
                        id="nome"
                        name="nome"
                        value="<?= setValor("nome") ?>"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-base text-gray-700 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                        placeholder="Seu nome completo"
                        required>
                  </div>

                  <!-- CPF -->
                  <div>
                     <label for="cpf" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-id-card text-gray-400 mr-2"></i>
                        CPF
                     </label>
                     <input
                        type="text"
                        id="cpf"
                        name="cpf"
                        x-model="cpf"
                        @input="formatarCPF()"
                        value="<?= setValor("cpf") ?>"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-base text-gray-700 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                        placeholder="000.000.000-00"
                        maxlength="14"
                        required>
                  </div>

                  <!-- Email -->
                  <div class="md:col-span-2">
                     <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope text-gray-400 mr-2"></i>
                        E-mail
                     </label>
                     <input
                        type="email"
                        id="email"
                        name="email"
                        value="<?= setValor("email") ?>"
                        class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg text-base text-gray-700 focus:outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
                        placeholder="seu@email.com"
                        required>
                  </div>
               </div>
            </div>
         </div>

         <!-- Card de Telefones -->
         <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-blue-50 flex items-center justify-between">
               <h3 class="text-xl font-semibold text-gray-900 flex items-center">
                  <div class="p-2 bg-blue-100 rounded-lg mr-3">
                     <i class="fas fa-phone text-blue-600"></i>
                  </div>
                  Telefones de Contato
               </h3>
               <button
                  type="button"
                  @click="adicionarTelefone()"
                  class="bg-orange-500 hover:bg-orange-600 text-white px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center">
                  <i class="fas fa-plus mr-2"></i>
                  Adicionar Telefone
               </button>
            </div>

            <div class="p-6">
               <!-- Sem telefones -->
               <div x-show="telefones.length === 0"
                  x-transition:enter="transition ease-out duration-300"
                  x-transition:enter-start="opacity-0"
                  x-transition:enter-end="opacity-100">
                  <div class="text-center py-8 text-gray-500">
                     <div class="p-4 bg-gray-100 rounded-full inline-block mb-4">
                        <i class="fas fa-phone-slash text-4xl text-gray-400"></i>
                     </div>
                     <p class="text-lg font-medium">Nenhum telefone cadastrado</p>
                     <p class="text-sm">Clique em "Adicionar Telefone" para incluir seus contatos.</p>
                  </div>
               </div>

               <!-- Lista de telefones -->
               <div class="space-y-4" x-show="telefones.length > 0">
                  <template x-for="(telefone, index) in telefones" :key="telefone.id || 'novo-' + index">
                     <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:shadow-sm transition-shadow duration-200"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0">

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">

                           <!-- Número -->
                           <div class="md:col-span-5">
                              <label class="block text-sm font-medium text-gray-700 mb-1">
                                 <i class="fas fa-phone text-gray-400 mr-1"></i>
                                 Número
                              </label>
                              <input
                                 type="text"
                                 x-model="telefone.numero"
                                 @input="formatarTelefone(index)"
                                 :name="'telefones[' + index + '][numero]'"
                                 class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 transition-all duration-200"
                                 placeholder="(32) 99999-9999"
                                 maxlength="15">
                              <input type="hidden" :name="'telefones[' + index + '][id]'" x-model="telefone.id">
                           </div>

                           <!-- Tipo -->
                           <div class="md:col-span-3">
                              <label class="block text-sm font-medium text-gray-700 mb-1">
                                 <i class="fas fa-mobile-alt text-gray-400 mr-1"></i>
                                 Tipo
                              </label>
                              <select
                                 x-model="telefone.tipo"
                                 :name="'telefones[' + index + '][tipo]'"
                                 class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-200 transition-all duration-200">
                                 <option value="m">📱 Móvel</option>
                                 <option value="f">📞 Fixo</option>
                              </select>
                           </div>

                           <!-- Principal -->
                           <div class="md:col-span-2">
                              <div class="flex items-center h-full">
                                 <label class="flex items-center space-x-2 cursor-pointer">
                                    <input
                                       type="checkbox"
                                       x-model="telefone.principal"
                                       @change="definirPrincipal(index)"
                                       :name="'telefones[' + index + '][principal]'"
                                       value="1"
                                       class="rounded border-gray-300 text-blue-500 focus:ring-blue-400">
                                    <span class="text-sm text-gray-700"
                                       :class="telefone.principal ? 'font-semibold text-blue-600' : ''">
                                       <i class="fas fa-star mr-1" x-show="telefone.principal"></i>
                                       Principal
                                    </span>
                                 </label>
                              </div>
                           </div>

                           <!-- Remover -->
                           <div class="md:col-span-2">
                              <button
                                 type="button"
                                 @click="removerTelefone(index)"
                                 class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-md text-sm font-medium transition-all duration-200 flex items-center justify-center">
                                 <i class="fas fa-trash mr-1"></i>
                                 Remover
                              </button>
                           </div>
                        </div>
                     </div>
                  </template>
               </div>
            </div>
         </div>

         <!-- Botões de Ação -->
         <div class="flex flex-col sm:flex-row gap-4 justify-end">
            <a
               href="<?= baseUrl() ?>Sistema/"
               class="inline-flex items-center justify-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg text-base font-semibold hover:border-gray-400 hover:bg-gray-50 focus:outline-none focus:ring-4 focus:ring-gray-200 transition-all duration-200">
               <i class="fas fa-times mr-2"></i>
               Cancelar
            </a>
            <button
               type="submit"
               class="inline-flex items-center justify-center px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg text-base font-semibold hover:from-blue-600 hover:to-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-200 transition-all duration-200">
               <i class="fas fa-save mr-2"></i>
               Salvar Alterações
            </button>
         </div>

      </form>
   </div>
</div>

<script>
   function perfilCandidato() {
      return {
         cpf: '<?= setValor("cpf") ?>',
         telefones: <?= json_encode($telefones ?? []) ?>,

         adicionarTelefone() {
            this.telefones.push({
               id: null,
               numero: '',
               tipo: 'm',
               principal: false
            });
         },

         removerTelefone(index) {
            if (confirm('Tem certeza que deseja remover este telefone?')) {
               if (this.telefones[index].principal) {
                  this.telefones[index].principal = false;
               }
               this.telefones.splice(index, 1);
            }
         },

         definirPrincipal(index) {
            if (this.telefones[index].principal) {
               this.telefones.forEach((tel, i) => {
                  if (i !== index) {
                     tel.principal = false;
                  }
               });
            }
         },

         formatarCPF() {
            let value = this.cpf.replace(/\D/g, '');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            this.cpf = value;
         },

         formatarTelefone(index) {
            let value = this.telefones[index].numero.replace(/\D/g, '');
            if (value.length <= 10) {
               value = value.replace(/(\d{2})(\d)/, '($1) $2');
               value = value.replace(/(\d{4})(\d)/, '$1-$2');
            } else {
               value = value.replace(/(\d{2})(\d)/, '($1) $2');
               value = value.replace(/(\d{5})(\d)/, '$1-$2');
            }
            this.telefones[index].numero = value;
         }
      }
   }
</script>