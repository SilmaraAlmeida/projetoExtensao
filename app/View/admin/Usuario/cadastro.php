<?php
// Configurações da página
$page_title = "Cadastre-se - Portal de Empregos Muriaé";
$page_description = "Crie sua conta gratuita no Portal de Empregos Muriaé.";

// Determinando tipo de cadastro (candidato ou empresa)
$tipo_cadastro = isset($_GET['tipo']) ? htmlspecialchars($_GET['tipo']) : 'candidato';

?>
<link href="<?= baseUrl() ?>assets/css/login.css" rel="stylesheet">
    <!-- Main Content -->
    <main class="cadastro-main">
        <div class="container">
            <div class="cadastro-container">
                <div class="cadastro-box">
                    <h1 class="cadastro-title">Criar Conta</h1>

                    <!-- Tabs para escolher tipo de cadastro -->
                    <div class="tab-container">
                        <div class="tabs">
                            <button class="tab-btn <?php echo $tipo_cadastro === 'candidato' ? 'active' : ''; ?>" 
                                    data-tab="candidato">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                                Sou Candidato
                            </button>
                            <button class="tab-btn <?php echo $tipo_cadastro === 'empresa' ? 'active' : ''; ?>" 
                                    data-tab="empresa">
                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                                </svg>
                                Sou Empresa
                            </button>
                        </div>

                        <!-- Formulário de Candidato -->
                        <div id="form-candidato" class="tab-content <?php echo $tipo_cadastro === 'candidato' ? 'active' : ''; ?>">
                            <form action="processar-cadastro.php" method="POST" class="cadastro__form" enctype="multipart/form-data">
                                <input type="hidden" name="tipo_cadastro" value="candidato">

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="nome">Nome</label>
                                        <input type="text" id="nome" name="nome" class="form-control" required placeholder="Seu nome">
                                        <div class="error-message" id="nome-error"></div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="sobrenome">Sobrenome</label>
                                        <input type="text" id="sobrenome" name="sobrenome" class="form-control" required placeholder="Seu sobrenome">
                                        <div class="error-message" id="sobrenome-error"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="cpf">CPF</label>
                                    <input type="text" id="cpf" name="cpf" class="form-control" required placeholder="000.000.000-00">
                                    <div class="error-message" id="cpf-error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="email" id="email" name="email" class="form-control" required placeholder="seu.email@exemplo.com">
                                    <div class="error-message" id="email-error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="telefone">Telefone</label>
                                    <input type="tel" id="telefone" name="telefone" class="form-control" required placeholder="(00) 00000-0000">
                                    <div class="error-message" id="telefone-error"></div>
                                </div>

                                <!-- <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="data_nascimento">Data de Nascimento</label>
                                        <input type="date" id="data_nascimento" name="data_nascimento" class="form-control" required>
                                        <div class="error-message" id="data_nascimento-error"></div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="area_atuacao">Área de Atuação</label>
                                        <select id="area_atuacao" name="area_atuacao" class="form-control" required>
                                            <option value="" selected disabled>Selecione...</option>
                                            <option value="tecnologia">Tecnologia</option>
                                            <option value="saude">Saúde</option>
                                            <option value="educacao">Educação</option>
                                            <option value="administracao">Administração</option>
                                            <option value="comercio">Comércio</option>
                                            <option value="industria">Indústria</option>
                                            <option value="logistica">Logística</option>
                                            <option value="outros">Outros</option>
                                        </select>
                                        <div class="error-message" id="area_atuacao-error"></div>
                                    </div> 
                                </div> -->

                                <!-- <div class="form-group">
                                    <label for="curriculo">Currículo (PDF)</label>
                                    <input type="file" id="curriculo" name="curriculo" class="form-control file-input" accept=".pdf">
                                    <div class="file-label">Clique para fazer upload ou arraste seu arquivo aqui</div>
                                    <div class="error-message" id="curriculo-error"></div>
                                </div> -->

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="senha">Senha</label>
                                        <input type="password" id="senha" name="senha" class="form-control" required placeholder="Sua senha">
                                        <div class="error-message" id="senha-error"></div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="confirmar_senha">Confirmar Senha</label>
                                        <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" required placeholder="Confirme sua senha">
                                        <div class="error-message" id="confirmar_senha-error"></div>
                                    </div>
                                </div>

                                <div class="form-group terms">
                                    <label class="checkbox-container">
                                        <input type="checkbox" name="aceite_termos" id="aceite_termos" required>
                                        <span class="checkmark"></span>
                                        Aceito os <a href="termos.php" target="_blank">Termos de Uso</a> e 
                                        <a href="privacidade.php" target="_blank">Política de Privacidade</a>
                                    </label>
                                    <div class="error-message" id="aceite_termos-error"></div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn--primary btn--block">
                                        Criar Conta
                                    </button>
                                </div>
                            </form>
                        </div>

                        <!-- Formulário de Empresa -->
                        <div id="form-empresa" class="tab-content <?php echo $tipo_cadastro === 'empresa' ? 'active' : ''; ?>">
                            <form action="processar-cadastro.php" method="POST" class="form">
                                <input type="hidden" name="tipo_cadastro" value="empresa">

                                <div class="form-group">
                                    <label for="nome_empresa">Nome da Empresa</label>
                                    <input type="text" id="nome_empresa" name="nome_empresa" class="form-control" required placeholder="Nome da sua empresa">
                                    <div class="error-message" id="nome_empresa-error"></div>
                                </div>

                                <div class="form-group">
                                    <label for="cnpj">CNPJ</label>
                                    <input type="text" id="cnpj" name="cnpj" class="form-control" required placeholder="00.000.000/0000-00">
                                    <div class="error-message" id="cnpj-error"></div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="email_empresa">E-mail Comercial</label>
                                        <input type="email" id="email_empresa" name="email_empresa" class="form-control" required placeholder="empresa@exemplo.com">
                                        <div class="error-message" id="email_empresa-error"></div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="telefone_empresa">Telefone Comercial</label>
                                        <input type="tel" id="telefone_empresa" name="telefone_empresa" class="form-control" required placeholder="(00) 0000-0000">
                                        <div class="error-message" id="telefone_empresa-error"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="endereco">Endereço</label>
                                    <input type="text" id="endereco" name="endereco" class="form-control" required placeholder="Rua, número, bairro">
                                    <div class="error-message" id="endereco-error"></div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="cidade">Cidade</label>
                                        <input type="text" id="cidade" name="cidade" class="form-control" required value="Muriaé" placeholder="Cidade">
                                        <div class="error-message" id="cidade-error"></div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="estado">Estado</label>
                                        <select id="estado" name="estado" class="form-control" required>
                                            <option value="MG" selected>Minas Gerais</option>
                                            <option value="RJ">Rio de Janeiro</option>
                                            <option value="SP">São Paulo</option>
                                            <option value="ES">Espírito Santo</option>
                                            <!-- Outros estados -->
                                        </select>
                                        <div class="error-message" id="estado-error"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="segmento">Segmento da Empresa</label>
                                    <select id="segmento" name="segmento" class="form-control" required>
                                        <option value="" selected disabled>Selecione...</option>
                                        <option value="tecnologia">Tecnologia</option>
                                        <option value="saude">Saúde</option>
                                        <option value="educacao">Educação</option>
                                        <option value="comercio">Comércio</option>
                                        <option value="industria">Indústria</option>
                                        <option value="servicos">Serviços</option>
                                        <option value="outros">Outros</option>
                                    </select>
                                    <div class="error-message" id="segmento-error"></div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="senha_empresa">Senha</label>
                                        <input type="password" id="senha_empresa" name="senha_empresa" class="form-control" required placeholder="Sua senha">
                                        <div class="error-message" id="senha_empresa-error"></div>
                                    </div>

                                    <div class="form-group col-6">
                                        <label for="confirmar_senha_empresa">Confirmar Senha</label>
                                        <input type="password" id="confirmar_senha_empresa" name="confirmar_senha_empresa" class="form-control" required placeholder="Confirme sua senha">
                                        <div class="error-message" id="confirmar_senha_empresa-error"></div>
                                    </div>
                                </div>

                                <div class="form-group terms">
                                    <label class="checkbox-container">
                                        <input type="checkbox" name="aceite_termos_empresa" id="aceite_termos_empresa" required>
                                        <span class="checkmark"></span>
                                        Aceito os <a href="termos.php" target="_blank">Termos de Uso</a> e 
                                        <a href="privacidade.php" target="_blank">Política de Privacidade</a>
                                    </label>
                                    <div class="error-message" id="aceite_termos_empresa-error"></div>
                                </div>

                                <div class="form-actions">
                                    <button type="submit" class="btn btn--primary btn--block">
                                        Criar Conta como Empresa
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="cadastro-footer">
                        <p>Já tem uma conta? <a href="login.php">Faça login aqui</a></p>
                    </div>
                </div>
            </div>
        </div>
    <!-- JavaScript -->
    <script src="<?= baseUrl() ?>assets/js/login.js""></script>
    </main>


