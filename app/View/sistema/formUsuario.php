<script type="text/javascript" src="<?= baseUrl(); ?>assets/js/usuario.js"></script>

<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <?= formTitulo('Usuário') ?>

        <!-- ================================================ -->
        <!-- ALERTAS DE PRÉ-SELEÇÃO (Query String)           -->
        <!-- ================================================ -->

        <!-- Alerta: Pessoa Física Pré-selecionada -->
        <?php if (!empty($dados['nome_pessoa_selecionada'])): ?>
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-check text-green-600 text-xl mt-0.5"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-semibold text-green-800">Pessoa Física Pré-selecionada</p>
                        <p class="text-sm text-green-700 mt-1">
                            <strong><?= htmlspecialchars($dados['nome_pessoa_selecionada']) ?></strong>
                            <?php if (!empty($dados['cpf_pessoa_selecionada'])): ?>
                                <span class="text-xs">
                                    (CPF: <?= substr($dados['cpf_pessoa_selecionada'], 0, 3) ?>.***.***-<?= substr($dados['cpf_pessoa_selecionada'], -2) ?>)
                                </span>
                            <?php endif; ?>
                        </p>
                        <p class="text-xs text-green-600 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Esta pessoa já está selecionada no campo "Pessoa Física" abaixo
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Alerta: Estabelecimento Pré-selecionado -->
        <?php if (!empty($dados['nome_estabelecimento_selecionado'])): ?>
            <div class="mb-4 p-4 bg-blue-50 border-l-4 border-blue-500 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-building text-blue-600 text-xl mt-0.5"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-semibold text-blue-800">Estabelecimento Pré-selecionado</p>
                        <p class="text-sm text-blue-700 mt-1">
                            <strong><?= htmlspecialchars($dados['nome_estabelecimento_selecionado']) ?></strong>
                            <?php if (!empty($dados['email_estabelecimento_selecionado'])): ?>
                                <span class="text-xs">
                                    (<?= htmlspecialchars($dados['email_estabelecimento_selecionado']) ?>)
                                </span>
                            <?php endif; ?>
                        </p>
                        <p class="text-xs text-blue-600 mt-1">
                            <i class="fas fa-info-circle mr-1"></i>
                            Este estabelecimento já está selecionado no campo "Estabelecimento" abaixo
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <!-- Alerta: Ambos Pré-selecionados (Vinculação Dupla) -->
        <?php if (!empty($dados['nome_pessoa_selecionada']) && !empty($dados['nome_estabelecimento_selecionado'])): ?>
            <div class="mb-6 p-4 bg-purple-50 border-l-4 border-purple-500 rounded-r-lg shadow-sm">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-link text-purple-600 text-xl mt-0.5"></i>
                    </div>
                    <div class="ml-3 flex-1">
                        <p class="text-sm font-semibold text-purple-800">Vinculação Dupla</p>
                        <p class="text-xs text-purple-700 mt-1">
                            Este usuário será vinculado tanto à pessoa física quanto ao estabelecimento (gerente de empresa)
                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <form method="POST" action="<?= $this->request->formAction() ?>">

                <input type="hidden" name="usuario_id" id="usuario_id" value="<?= setValor('usuario_id') ?>">

                <div class="flex flex-wrap -mx-3">

                    <!-- Tipo de Usuário -->
                    <div class="w-full px-3 mb-6">
                        <label for="tipo" class="block text-sm font-semibold text-gray-700 mb-2">
                            Tipo de Usuário <span class="text-red-500">*</span>
                        </label>
                        <select class="w-full px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                            name="tipo"
                            id="tipo"
                            aria-label="Tipo de usuário"
                            required>
                            <option value="">Selecione...</option>
                            <option value="G" <?= (setValor('tipo') == "G" ? 'selected' : '') ?>>Gestor</option>
                            <option value="CN" <?= (setValor('tipo') == "CN" ? 'selected' : '') ?>>Candidato</option>
                            <option value="A" <?= (setValor('tipo') == "A" ? 'selected' : '') ?>>Anunciante</option>
                        </select>
                        <?= setMsgFilderError('tipo') ?>
                        <small class="block mt-2 text-xs text-gray-500">
                            <i class="fas fa-info-circle mr-1"></i>
                            <strong>Gestor/Candidato:</strong> Vincula Pessoa Física |
                            <strong>Anunciante:</strong> Vincula Estabelecimento (ou ambos)
                        </small>
                    </div>

                    <!-- Pessoa Física -->
                    <div class="w-full lg:w-1/2 px-3 mb-6">
                        <label for="pessoa_fisica_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Pessoa Física
                        </label>
                        <div class="flex gap-2">
                            <select class="flex-1 px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                name="pessoa_fisica_id"
                                id="pessoa_fisica_id"
                                aria-label="Selecione a pessoa">
                                <option value="">Nenhuma (Desassociar)</option>
                                <?php if (isset($dados['pessoas_disponiveis']) && is_array($dados['pessoas_disponiveis'])): ?>
                                    <?php foreach ($dados['pessoas_disponiveis'] as $value): ?>
                                        <option value="<?= $value['pessoa_fisica_id'] ?>"
                                            <?= (setValor('pessoa_fisica_id') == $value['pessoa_fisica_id'] ? 'selected' : '') ?>>
                                            <?= htmlspecialchars($value['nome']) ?>
                                            <?php if ($value['cpf']): ?>
                                                - CPF: <?= $value['cpf'] ?>
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>

                            <!-- Botão para criar nova pessoa -->
                            <a href="<?= baseUrl() ?>pessoafisica/form/insert/0"
                                target="_blank"
                                class="inline-flex items-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors whitespace-nowrap"
                                title="Criar nova pessoa física">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                        <?= setMsgFilderError('pessoa_fisica_id') ?>
                        <small class="block mt-2 text-xs text-gray-500">
                            <i class="fas fa-user mr-1"></i>
                            Usado para Gestores e Candidatos
                        </small>
                    </div>

                    <!-- Estabelecimento -->
                    <div class="w-full lg:w-1/2 px-3 mb-6">
                        <label for="estabelecimento_id" class="block text-sm font-semibold text-gray-700 mb-2">
                            Estabelecimento
                        </label>
                        <div class="flex gap-2">
                            <select class="flex-1 px-4 py-3 bg-white border-2 border-gray-200 rounded-lg text-gray-900 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 hover:border-gray-300"
                                name="estabelecimento_id"
                                id="estabelecimento_id"
                                aria-label="Selecione o estabelecimento">
                                <option value="">Nenhum (Desassociar)</option>
                                <?php if (isset($dados['estabelecimentos_disponiveis']) && is_array($dados['estabelecimentos_disponiveis'])): ?>
                                    <?php foreach ($dados['estabelecimentos_disponiveis'] as $value): ?>
                                        <option value="<?= $value['estabelecimento_id'] ?>"
                                            <?= (setValor('estabelecimento_id') == $value['estabelecimento_id'] ? 'selected' : '') ?>>
                                            <?= htmlspecialchars($value['nome']) ?>
                                            <?php if ($value['email']): ?>
                                                - <?= $value['email'] ?>
                                            <?php endif; ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>

                            <!-- Botão para criar novo estabelecimento -->
                            <a href="<?= baseUrl() ?>estabelecimento/form/insert/0"
                                target="_blank"
                                class="inline-flex items-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors whitespace-nowrap"
                                title="Criar novo estabelecimento">
                                <i class="fas fa-plus"></i>
                            </a>
                        </div>
                        <?= setMsgFilderError('estabelecimento_id') ?>
                        <small class="block mt-2 text-xs text-gray-500">
                            <i class="fas fa-building mr-1"></i>
                            Usado para Anunciantes (empresas)
                        </small>
                    </div>

                    <!-- Login/Email -->
                    <div class="w-full px-3 mb-6">
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
                                <small class="block mt-2 text-xs text-gray-500">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Deixe em branco para manter a senha atual
                                </small>
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