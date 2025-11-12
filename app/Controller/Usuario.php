<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

use App\Model\UsuarioModel;
use App\Model\PessoaFisicaModel;
use App\Model\EstabelecimentoModel;

class Usuario extends ControllerMain
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarConstruct();
        $this->loadHelper(['formHelper', 'tabela']);
        $this->validaNivelAcesso("G");
    }

    /**
     * index
     * Lista todos os usuários do sistema (gestão de acessos)
     * Mostra apenas quem TEM login no sistema
     *
     * @return void
     */
    public function index()
    {
        $usuarioModel = new UsuarioModel();
        // Busca todos os usuários com JOIN para pegar nome da entidade vinculada
        $usuarios = $usuarioModel->db
            ->table('usuario')
            ->select('usuario.usuario_id, usuario.login, usuario.tipo,
                  usuario.pessoa_fisica_id, usuario.estabelecimento_id,
                  COALESCE(pessoa_fisica.nome, estabelecimento.nome) as nome,
                  pessoa_fisica.cpf,
                  estabelecimento.email as email_estabelecimento')
            ->join('pessoa_fisica', 'usuario.pessoa_fisica_id = pessoa_fisica.pessoa_fisica_id', 'LEFT')
            ->join('estabelecimento', 'usuario.estabelecimento_id = estabelecimento.estabelecimento_id', 'LEFT')
            ->orderBy('usuario.usuario_id', 'DESC')
            ->findAll();

        // Calcula estatísticas
        $estatisticas = [
            'total' => count($usuarios),
            'anunciantes' => count(array_filter($usuarios, fn($u) => $u['tipo'] === 'A')),
            'gestores' => count(array_filter($usuarios, fn($u) => $u['tipo'] === 'G')),
            'candidatos' => count(array_filter($usuarios, fn($u) => $u['tipo'] === 'CN'))
        ];

        // Dados para a view
        $dados = [
            'usuarios' => $usuarios,
            'estatisticas' => $estatisticas
        ];

        return $this->loadView("sistema/listaUsuario", $dados);
    }
    /**
     * form
     * Formulário de criação/edição de usuário
     * Suporta pré-seleção via query string: ?pessoa_fisica_id=X ou ?estabelecimento_id=Y
     *
     * @param string $action 
     * @param integer $id 
     * @return void
     */
    public function form($action = null, $id = null)
    {
        // Instancia models necessários
        $pessoaFisicaModel = new PessoaFisicaModel();
        $estabelecimentoModel = new EstabelecimentoModel();

        if ($this->action == "insert") {
            // Dados padrão para novo usuário
            $dados = [
                "usuario_id" => "",
                "tipo" => "",
                "pessoa_fisica_id" => "",
                "estabelecimento_id" => "",
                "login" => ""
            ];

            // ============================================
            // PEGA PARÂMETROS DA URL (Query String)
            // ============================================
            $getParams = $this->request->getGet();

            // Se vier pessoa_fisica_id pela URL
            if (!empty($getParams['pessoa_fisica_id'])) {
                $dados['pessoa_fisica_id'] = $getParams['pessoa_fisica_id'];

                // Busca o nome da pessoa para feedback visual
                $pessoa = $pessoaFisicaModel->db
                    ->table('pessoa_fisica')
                    ->where('pessoa_fisica_id', $getParams['pessoa_fisica_id'])
                    ->first();

                if ($pessoa) {
                    $dados['nome_pessoa_selecionada'] = $pessoa['nome'];
                    $dados['cpf_pessoa_selecionada'] = $pessoa['cpf'];
                }
            }

            // Se vier estabelecimento_id pela URL
            if (!empty($getParams['estabelecimento_id'])) {
                $dados['estabelecimento_id'] = $getParams['estabelecimento_id'];

                // Busca o nome do estabelecimento para feedback visual
                $estabelecimento = $estabelecimentoModel->db
                    ->table('estabelecimento')
                    ->where('estabelecimento_id', $getParams['estabelecimento_id'])
                    ->first();

                if ($estabelecimento) {
                    $dados['nome_estabelecimento_selecionado'] = $estabelecimento['nome'];
                    $dados['email_estabelecimento_selecionado'] = $estabelecimento['email'];
                }
            }
        } else {
            // Busca usuário existente (DIRETAMENTE, sem JOIN)
            $usuarioModel = new UsuarioModel();
            $dados = $usuarioModel->db
                ->table('usuario')
                ->where('usuario_id', $id)
                ->first();

            if (!$dados) {
                return Redirect::page('usuario', [
                    'msgError' => 'Usuário não encontrado'
                ]);
            }

            // Adiciona nome se houver vinculação
            if (!empty($dados['pessoa_fisica_id'])) {
                $pessoa = $pessoaFisicaModel->db
                    ->table('pessoa_fisica')
                    ->where('pessoa_fisica_id', $dados['pessoa_fisica_id'])
                    ->first();

                $dados['nome'] = $pessoa ? $pessoa['nome'] : null;
            } elseif (!empty($dados['estabelecimento_id'])) {
                $estabelecimento = $estabelecimentoModel->db
                    ->table('estabelecimento')
                    ->where('estabelecimento_id', $dados['estabelecimento_id'])
                    ->first();

                $dados['nome'] = $estabelecimento ? $estabelecimento['nome'] : null;
            } else {
                $dados['nome'] = 'Sem vínculo';
            }
        }

        // ============================================
        // PESSOAS FÍSICAS - TODAS
        // ============================================
        $dados['pessoas_disponiveis'] = $pessoaFisicaModel->db
            ->table('pessoa_fisica')
            ->select('pessoa_fisica_id, nome, cpf')
            ->orderBy('nome', 'ASC')
            ->findAll();

        // ============================================
        // ESTABELECIMENTOS - TODOS
        // ============================================
        $dados['estabelecimentos_disponiveis'] = $estabelecimentoModel->db
            ->table('estabelecimento')
            ->select('estabelecimento_id, nome, email')
            ->orderBy('nome', 'ASC')
            ->findAll();

        return $this->loadView("sistema/formUsuario", $dados);
    }

    /**
     * insert
     * Cria novo usuário com validações de tipo e associações
     *
     * @return void
     */
    public function insert()
    {
        $post = $this->request->getPost();
        $lError = false;
        $errors = [];

        // ============================================
        // VALIDAÇÃO: Senha obrigatória no insert
        // ============================================
        if (empty($post['senha'])) {
            $lError = true;
            $errors['senha'] = "O campo <b>Senha</b> deve ser preenchido.";
        } else {
            unset($post['confSenha']);
            $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);
        }

        // ============================================
        // VALIDAÇÃO: Tipo de usuário
        // ============================================
        if (empty($post['tipo']) || !in_array($post['tipo'], ['G', 'CN', 'A'])) {
            $lError = true;
            $errors['tipo'] = "O campo <b>Tipo de Usuário</b> é inválido.";
        }

        // ============================================
        // VALIDAÇÃO: Associações obrigatórias por tipo
        // ============================================
        if (!$lError) {
            // Gestor ou Candidato: OBRIGATÓRIO pessoa_fisica_id
            if (in_array($post['tipo'], ['G', 'CN'])) {
                if (empty($post['pessoa_fisica_id'])) {
                    $lError = true;
                    $errors['pessoa_fisica_id'] = "<b>Pessoa Física</b> é obrigatória para Gestor/Candidato.";
                }
                // Limpa estabelecimento_id (não usa)
                $post['estabelecimento_id'] = null;
            }

            // Anunciante: OBRIGATÓRIO estabelecimento_id
            if ($post['tipo'] === 'A') {
                if (empty($post['estabelecimento_id'])) {
                    $lError = true;
                    $errors['estabelecimento_id'] = "<b>Estabelecimento</b> é obrigatório para Anunciante.";
                }
                // Anunciante pode ter pessoa_fisica_id (gerente) ou não
                if (empty($post['pessoa_fisica_id'])) {
                    $post['pessoa_fisica_id'] = null;
                }
            }
        }

        // ============================================
        // VALIDAÇÃO: Email único
        // ============================================
        if (!$lError && !empty($post['login'])) {
            if ($this->model->verificaDuplicidadeEmail($post['login'])) {
                $lError = true;
                $errors['login'] = "O <b>Email</b> já está cadastrado no sistema.";
            }
        }

        // ============================================
        // Tratamento de campos vazios para NULL
        // ============================================
        if (empty($post['pessoa_fisica_id'])) {
            $post['pessoa_fisica_id'] = null;
        }
        if (empty($post['estabelecimento_id'])) {
            $post['estabelecimento_id'] = null;
        }

        // ============================================
        // Remove campos que não vão para o banco
        // ============================================
        // NÃO remove 'action' - framework precisa dele
        if (isset($post['usuario_id']) && empty($post['usuario_id'])) {
            unset($post['usuario_id']); // Remove usuario_id vazio (auto_increment)
        }

        // ============================================
        // Inserção no banco
        // ============================================
        if (!$lError) {
            // Remove action apenas antes do insert
            $dadosInsert = $post;
            unset($dadosInsert['action']);

            if ($this->model->insert($dadosInsert)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Usuário criado com sucesso."]);
            } else {
                $lError = true;
                $errors['geral'] = "Erro ao inserir registro no banco de dados.";
            }
        }

        // ============================================
        // Retorno com erros (mantém rota original)
        // ============================================
        if ($lError) {
            Session::set('errors', $errors);
            Session::set("inputs", $post);
            return Redirect::page($this->controller . '/form/insert/0'); // Rota correta
        }
    }

    /**
     * update
     * Atualiza usuário com validações de tipo e associações
     *
     * @return void
     */
    public function update()
    {
        $post = $this->request->getPost();
        $lError = false;
        $errors = [];

        // ============================================
        // VALIDAÇÃO: Tipo de usuário
        // ============================================
        if (empty($post['tipo']) || !in_array($post['tipo'], ['G', 'CN', 'A'])) {
            $lError = true;
            $errors['tipo'] = "O campo <b>Tipo de Usuário</b> é inválido.";
        }

        // ============================================
        // VALIDAÇÃO: Associações obrigatórias por tipo
        // ============================================
        if (!$lError) {
            // Gestor ou Candidato: OBRIGATÓRIO pessoa_fisica_id
            if (in_array($post['tipo'], ['G', 'CN'])) {
                if (empty($post['pessoa_fisica_id'])) {
                    $lError = true;
                    $errors['pessoa_fisica_id'] = "<b>Pessoa Física</b> é obrigatória para Gestor/Candidato.";
                }
                // Remove estabelecimento ao trocar para G/CN
                $post['estabelecimento_id'] = null;
            }

            // Anunciante: OBRIGATÓRIO estabelecimento_id
            if ($post['tipo'] === 'A') {
                if (empty($post['estabelecimento_id'])) {
                    $lError = true;
                    $errors['estabelecimento_id'] = "<b>Estabelecimento</b> é obrigatório para Anunciante.";
                }
                // Anunciante pode ter pessoa_fisica_id (gerente) ou não
                if (empty($post['pessoa_fisica_id'])) {
                    $post['pessoa_fisica_id'] = null;
                }
            }
        }

        // ============================================
        // VALIDAÇÃO: Email único (exceto o próprio)
        // ============================================
        if (!$lError && !empty($post['login']) && !empty($post['usuario_id'])) {
            $usuarioAtual = $this->model->db
                ->table('usuario')
                ->where('usuario_id', $post['usuario_id'])
                ->first();

            // Só valida se o email foi alterado
            if ($usuarioAtual && $usuarioAtual['login'] !== $post['login']) {
                if ($this->model->verificaDuplicidadeEmail($post['login'])) {
                    $lError = true;
                    $errors['login'] = "O <b>Email</b> já está cadastrado para outro usuário.";
                }
            }
        }

        // ============================================
        // Tratamento de senha
        // ============================================
        unset($post['confSenha']);

        if (empty($post['senha'])) {
            // Remove do array se estiver vazio (mantém senha atual)
            unset($post['senha']);
        } else {
            // Criptografa nova senha (Bcrypt via PASSWORD_DEFAULT)
            $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);
        }

        // ============================================
        // Tratamento de campos vazios para NULL
        // ============================================
        if (empty($post['pessoa_fisica_id'])) {
            $post['pessoa_fisica_id'] = null;
        }
        if (empty($post['estabelecimento_id'])) {
            $post['estabelecimento_id'] = null;
        }

        // ============================================
        // Atualização no banco
        // ============================================
        if (!$lError) {
            // Remove action apenas antes do update
            $dadosUpdate = $post;
            unset($dadosUpdate['action']);

            if ($this->model->update($dadosUpdate)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Registro atualizado com sucesso."]);
            } else {
                $lError = true;
                $errors['geral'] = "Erro ao atualizar registro no banco de dados.";
            }
        }

        // ============================================
        // Retorno com erros
        // ============================================
        if ($lError) {
            Session::set('errors', $errors);
            Session::set("inputs", $post);
            return Redirect::page($this->controller . '/form/update/' . $post['usuario_id']);
        }
    }

    /**
     * delete
     * Exclui usuário com verificação de dependências
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->request->getPost();

        // Validação básica
        if (empty($post['usuario_id'])) {
            return Redirect::page($this->controller, [
                'msgError' => 'ID do usuário não informado.'
            ]);
        }

        // Executa exclusão com verificação de dependências
        $resultado = $this->model->deletarComDependencias($post['usuario_id']);

        if ($resultado['sucesso']) {
            return Redirect::page($this->controller, ['msgSucesso' => $resultado['mensagem']]);
        } else {
            return Redirect::page($this->controller, ['msgError' => $resultado['mensagem']]);
        }
    }


    /**
     * formTrocarSenha
     *
     * @return void
     */
    public function formTrocarSenha()
    {
        return $this->loadView("sistema/formTrocaSenha");
    }

    /**
     * updateNovaSenha
     *
     * @return void
     */
    public function updateNovaSenha()
    {
        $post = $this->request->getPost();
        $userAtual = $this->model->getById($post["usuario_id"]);

        if ($userAtual) {
            if (password_verify(trim($post["senhaAtual"]), $userAtual['senha'])) {
                if (trim($post["novaSenha"]) == trim($post["novaSenha2"])) {
                    $novaSenhaCripyt = password_hash(trim($post["novaSenha"]), PASSWORD_DEFAULT);

                    $lUpdate = $this->model->db->where(['usuario_id' => $post['usuario_id']])->update([
                        'senha' => $novaSenhaCripyt
                    ]);

                    if ($lUpdate) {
                        Session::set("userSenha", $novaSenhaCripyt);
                        return Redirect::page("Usuario/formTrocarSenha", [
                            "msgSucesso" => "Senha alterada com sucesso !"
                        ]);
                    } else {
                        return Redirect::page("Usuario/formTrocarSenha");
                    }
                } else {
                    return Redirect::page("Usuario/formTrocarSenha", [
                        "msgError" => "Nova senha e conferência da senha estão divergentes !"
                    ]);
                }
            } else {
                return Redirect::page("Usuario/formTrocarSenha", [
                    "msgError" => "Senha atual informada não confere!"
                ]);
            }
        } else {
            return Redirect::page("Usuario/formTrocarSenha", [
                "msgError" => "Usuário inválido !"
            ]);
        }
    }

    public function configuracoes() {}
}
