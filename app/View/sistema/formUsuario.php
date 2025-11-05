<script type="text/javascript" src="<?= baseUrl(); ?>assets/js/usuario.js"></script>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <?= formTitulo('Usuário') ?>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <form method="POST" action="<?= $this->request->formAction() ?>">

                <input type="hidden" name="usuario_id" id="usuario_id" value="<?= setValor('usuario_id') ?>">

                <div class="flex flex-wrap -mx-3">

                    <!-- Nome (Pessoa Física) -->
                    <div class="w-full lg:w-2/3 px-3 mb-6">
                        <label for="pessoa_fisica_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nome <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300" 
                                name="pessoa_fisica_id" 
                                id="pessoa_fisica_id" 
                                aria-label="Selecione a pessoa" 
                                required>
                            <option value="">Selecione uma pessoa...</option>
                            <?php if (isset($dados['usuarios']) && is_array($dados['usuarios'])): ?>
                                <?php foreach ($dados['usuarios'] as $value): ?>
                                    <option value="<?= $value['pessoa_fisica_id'] ?>"
                                        <?= (setValor('pessoa_fisica_id') == $value['pessoa_fisica_id'] ? 'selected' : '') ?>>
                                        <?= htmlspecialchars($value['nome']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                        <?= setMsgFilderError('pessoa_fisica_id') ?>
                    </div>

                    <!-- Tipo de Usuário -->
                    <div class="w-full lg:w-1/3 px-3 mb-6">
                        <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tipo de Usuário <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300" 
                                name="tipo" 
                                id="tipo" 
                                aria-label="Tipo de usuário" 
                                required>
                            <option value="" <?= (setValor('tipo') == "" ? 'selected' : "") ?>>Selecione...</option>
                            <option value="CN" <?= (setValor('tipo') == "CN" ? 'selected' : "") ?>>Candidato</option>
                            <option value="A" <?= (setValor('tipo') == "A" ? 'selected' : "") ?>>Anunciante</option>
                            <option value="G" <?= (setValor('tipo') == "G" ? 'selected' : "") ?>>Gestor</option>
                        </select>
                        <?= setMsgFilderError('tipo') ?>
                    </div>

                    <!-- Login/Email -->
                    <div class="w-full lg:w-2/3 px-3 mb-6">
                        <label for="login" class="block text-sm font-semibold text-gray-700 mb-2">
                            Login/Email <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300" 
                               id="login" 
                               name="login"
                               placeholder="Email do usuário" 
                               maxlength="50"
                               value="<?= setValor('login') ?>" 
                               required>
                        <?= setMsgFilderError('login') ?>
                    </div>

                    <?php if (in_array($this->request->getAction(), ['insert', 'update'])): ?>

                        <!-- Senha -->
                        <div class="w-full lg:w-1/2 px-3 mb-6">
                            <label for="senha" class="block text-sm font-semibold text-gray-700 mb-2">
                                Senha <?= ($this->request->getAction() == "insert" ? '<span class="text-red-500">*</span>' : '') ?>
                            </label>
                            <input type="password" 
                                   class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300" 
                                   id="senha" 
                                   name="senha"
                                   placeholder="Informe uma senha" 
                                   maxlength="60"
                                   onkeyup="checa_segur_senha('senha', 'msgSenha', 'btEnviar');"
                                   <?= ($this->request->getAction() == "insert" ? 'required' : '') ?>>
                            <div id="msgSenha" class="mt-3"></div>
                            <?= setMsgFilderError('senha') ?>
                            <?php if ($this->request->getAction() == "update"): ?>
                                <small class="block mt-2 text-xs text-gray-500">Deixe em branco para manter a senha atual</small>
                            <?php endif; ?>
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="w-full lg:w-1/2 px-3 mb-6">
                            <label for="confSenha" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirma a Senha <?= ($this->request->getAction() == "insert" ? '<span class="text-red-500">*</span>' : '') ?>
                            </label>
                            <input type="password" 
                                   class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm placeholder-gray-400 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300" 
                                   id="confSenha" 
                                   name="confSenha"
                                   placeholder="Digite a senha para conferência" 
                                   maxlength="60"
                                   onkeyup="checa_segur_senha('confSenha', 'msgConfSenha', 'btEnviar');"
                                   <?= ($this->request->getAction() == "insert" ? 'required' : '') ?>>
                            <div id="msgConfSenha" class="mt-3"></div>
                            <?= setMsgFilderError('confSenha') ?>
                        </div>

                    <?php endif; ?>

                </div>

                <div class="mt-8 pt-6 border-t border-gray-200">
                    <?= formButton() ?>
                </div>

            </form>
        </div>
        
    </div>
</div>
