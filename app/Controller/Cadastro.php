<?php

namespace App\Controller;

use App\Model\EstabelecimentoModel;
use Core\Library\ControllerMain;
use Core\Library\Database;
use Core\Library\Session;
use Core\Library\Redirect;
use App\Model\PessoaFisicaModel;
use App\Model\UsuarioModel;
use App\Model\TermoDeUsoAceiteModel;
use App\Model\TermoDeUsoModel;

class Cadastro extends ControllerMain
{
    private $db;

    private $usuarioModel;
    private $pessoaFisicaModel;
    private $estabelecimentoModel;
    private $termoDeUsoAceiteModel;
    private $termoDeUsoModel;
    /**
     * construct
     */
    public function __construct()
    {
        $this->db = new Database(
            $_ENV['DB_CONNECTION'],
            $_ENV['DB_HOST'],
            $_ENV['DB_PORT'],
            $_ENV['DB_DATABASE'],
            $_ENV['DB_USER'],
            $_ENV['DB_PASSWORD']
        );

        $this->auxiliarConstruct();

        $this->usuarioModel = new UsuarioModel($this->db);
        $this->pessoaFisicaModel = new PessoaFisicaModel($this->db);
        $this->estabelecimentoModel = new EstabelecimentoModel($this->db);
        $this->termoDeUsoAceiteModel = new TermoDeUsoAceiteModel($this->db);
        $this->termoDeUsoModel = new TermoDeUsoModel($this->db);

        $this->loadHelper("formHelper");
    }

    /**
     * index - Exibe página de cadastro
     *
     * @return void
     */
    public function index()
    {
        return $this->loadView('login/cadastro');
    }

    /**
     * signUp - Processar cadastro de candidato
     *
     * @return void
     */
    public function signUpCandidato()
    {
        $post = $this->request->getPost();
        $errors = [];

        // Validação: Campo senha obrigatório
        if (empty($post['senha'])) {
            unset($post['senha'], $post['confSenha']);
            
            return Redirect::page($this->controller, [
                "msgError" => "O campo <b>Senha</b> deve ser preenchido.",
                "inputs"   => $post
            ]);
        }

        if (empty($post['confSenha']) || $post['senha'] !== $post['confSenha']) {
            unset($post['senha'], $post['confSenha']);

            return Redirect::page($this->controller, [
                "msgError" => "As senhas não coincidem.",
                "inputs"   => $post
            ]);
        }

        if (empty($post['nome']) || empty($post['sobrenome'])) {
            unset($post['senha'], $post['confSenha']);
            
            return Redirect::page($this->controller, [
                "msgError" => "Nome e sobrenome são obrigatórios.",
                "inputs"   => $post
            ]);
        }

        if (empty($post['cpf'])) {
            unset($post['senha'], $post['confSenha']);
            
            return Redirect::page($this->controller, [
                "msgError" => "O CPF é obrigatório.",
                "inputs"   => $post
            ]);
        }

        if (empty($post['login'])) {
            unset($post['senha'], $post['confSenha']);
            
            return Redirect::page($this->controller, [
                "msgError" => "O e-mail é obrigatório.",
                "inputs"   => $post
            ]);
        }   

        unset($post['confSenha']);
        $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);

        $postPessoaFisica = [
            "nome" => trim(($post['nome'] ?? '') . " " . ($post['sobrenome'] ?? '')),
            "cpf"  => preg_replace('/\D/', '', $post['cpf'] ?? ''),
            "visitante_id" => null,
        ];

        $postUsuario = [
            "estabelecimento_id" => null,
            "login" => trim($post['login']),
            "senha" => $post['senha'],
            "tipo"  => 'CN',
        ];

        try {
            $termoVigente = $this->termoDeUsoModel->getTermoVigente();
            
            if (empty($termoVigente) || !isset($termoVigente['termodeuso_id'])) {
                throw new \Exception("Nenhum termo de uso vigente encontrado.");
            }

            $postTermoDeUsoAceite = [
                "dataHoraAceite" => date('Y-m-d H:i:s'),
                "termodeuso_id" => $termoVigente['termodeuso_id'],
            ];

            $this->db->beginTransaction();

            $pessoaFisicaId = $this->pessoaFisicaModel->insertGetId($postPessoaFisica);
            if ($pessoaFisicaId === false || $pessoaFisicaId <= 0) {
                throw new \Exception("Falha ao cadastrar dados pessoais.");
            }

            $postUsuario['pessoa_fisica_id'] = $pessoaFisicaId;
            $usuarioId = $this->usuarioModel->insertGetId($postUsuario);
            if ($usuarioId === false || $usuarioId <= 0) {
                throw new \Exception("Falha ao criar usuário.");
            }

            $postTermoDeUsoAceite['usuario_id'] = $usuarioId;
            
            // USA insert() ao invés de insertGetId()
            if (!$this->termoDeUsoAceiteModel->insert($postTermoDeUsoAceite)) {
                throw new \Exception("Falha ao registrar aceite do termo de uso.");
            }

            $this->db->commit();

            Session::destroy('inputs');
            Session::destroy('errors');

            return Redirect::page("login", [
                "msgSucesso" => "Cadastro realizado com sucesso! Faça login para continuar."
            ]);

        } catch (\PDOException $e) {
            
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            $mensagemErro = $e->getMessage();
            $codigoErro = $e->getCode();

            if ($codigoErro == 23000 || $codigoErro == 1062) {
                if (stripos($mensagemErro, 'cpf') !== false) {
                    $mensagemErro = "Este CPF já está cadastrado.";
                } elseif (stripos($mensagemErro, 'login') !== false) {
                    $mensagemErro = "Este e-mail já está cadastrado.";
                } else {
                    $mensagemErro = "Dados já cadastrados no sistema.";
                }
            } elseif (stripos($mensagemErro, 'cannot be null') !== false) {
                $mensagemErro = "Erro ao processar cadastro. Verifique os dados informados.";
            } elseif (stripos($mensagemErro, 'Foreign key') !== false) {
                $mensagemErro = "Erro de referência nos dados. Entre em contato com o suporte.";
            } else {
                $mensagemErro = "Erro no banco de dados. Tente novamente.";
            }

            unset($post['senha'], $post['confSenha']);

            return Redirect::page($this->controller, [
                "msgError" => $mensagemErro,
                "inputs"   => $post
            ]);

        } catch (\Exception $e) {
            
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            unset($post['senha'], $post['confSenha']);

            return Redirect::page($this->controller, [
                "msgError" => $e->getMessage(),
                "inputs"   => $post
            ]);
        }
    }

    /**
     * signUpEmpresa - Processar cadastro de empresa
     *
     * @return void
     */
    public function signUpEmpresa()
    {
        $post = $this->request->getPost();
        $errors = [];

        // Validação: Campo senha obrigatório
        if (empty($post['senha'])) {
            unset($post['senha'], $post['confSenha']);
            
            return Redirect::page($this->controller, [
                "msgError" => "O campo <b>Senha</b> deve ser preenchido.",
                "inputs"   => $post
            ]);
        }

        if (empty($post['confSenha']) || $post['senha'] !== $post['confSenha']) {
            unset($post['senha'], $post['confSenha']);

            return Redirect::page($this->controller, [
                "msgError" => "As senhas não coincidem.",
                "inputs"   => $post
            ]);
        }

        if (empty($post['nome'])) {
            unset($post['senha'], $post['confSenha']);
            
            return Redirect::page($this->controller, [
                "msgError" => "O nome do estabelecimento é obrigatório.",
                "inputs"   => $post
            ]);
        }

        if (empty($post['email'])) {
            unset($post['senha'], $post['confSenha']);
            
            return Redirect::page($this->controller, [
                "msgError" => "O e-mail é obrigatório.",
                "inputs"   => $post
            ]);
        }

        unset($post['confSenha']);
        $post['senha'] = password_hash($post['senha'], PASSWORD_DEFAULT);

        $postEstabelecimento = [
            "nome"      => trim($post['nome'] ?? ''),
            "endereco"  => trim($post['endereco'] ?? ''),
            "latitude"  => trim($post['latitude'] ?? null),
            "longitude" => trim($post['longitude'] ?? null),
            "email"     => trim($post['email'] ?? ''),
        ];

        $postUsuario = [
            "estabelecimento_id" => null,
            "login" => trim($post['email'] ?? ''),
            "senha" => $post['senha'],
            "tipo"  => 'A',
        ];

        try {
            $termoVigente = $this->termoDeUsoModel->getTermoVigente();
            
            if (empty($termoVigente) || !isset($termoVigente['termodeuso_id'])) {
                throw new \Exception("Nenhum termo de uso vigente encontrado.");
            }

            $postTermoDeUsoAceite = [
                "dataHoraAceite" => date('Y-m-d H:i:s'),
                "termodeuso_id" => $termoVigente['termodeuso_id'],
            ];

            $this->db->beginTransaction();

            // Inserir estabelecimento
            $estabelecimentoId = $this->estabelecimentoModel->insertGetId($postEstabelecimento);
            if ($estabelecimentoId === false || $estabelecimentoId <= 0) {
                throw new \Exception("Falha ao cadastrar estabelecimento.");
            }

            // Inserir usuário vinculado ao estabelecimento
            $postUsuario['estabelecimento_id'] = $estabelecimentoId;
            $usuarioId = $this->usuarioModel->insertGetId($postUsuario);
            if ($usuarioId === false || $usuarioId <= 0) {
                throw new \Exception("Falha ao criar usuário.");
            }

            // Registrar aceite do termo de uso
            $postTermoDeUsoAceite['usuario_id'] = $usuarioId;
            
            if (!$this->termoDeUsoAceiteModel->insert($postTermoDeUsoAceite)) {
                throw new \Exception("Falha ao registrar aceite do termo de uso.");
            }

            $this->db->commit();

            Session::destroy('inputs');
            Session::destroy('errors');

            return Redirect::page("login", [
                "msgSucesso" => "Cadastro realizado com sucesso! Faça login para continuar."
            ]);

        } catch (\PDOException $e) {
            
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            $mensagemErro = $e->getMessage();
            $codigoErro = $e->getCode();

            if ($codigoErro == 23000 || $codigoErro == 1062) {
                if (stripos($mensagemErro, 'email') !== false) {
                    $mensagemErro = "Este e-mail já está cadastrado.";
                } elseif (stripos($mensagemErro, 'nome') !== false) {
                    $mensagemErro = "Este nome de estabelecimento já está cadastrado.";
                } elseif (stripos($mensagemErro, 'login') !== false) {
                    $mensagemErro = "Este e-mail já está cadastrado.";
                } else {
                    $mensagemErro = "Dados já cadastrados no sistema.";
                }
            } elseif (stripos($mensagemErro, 'cannot be null') !== false) {
                $mensagemErro = "Erro ao processar cadastro. Verifique os dados informados.";
            } elseif (stripos($mensagemErro, 'Foreign key') !== false) {
                $mensagemErro = "Erro de referência nos dados. Entre em contato com o suporte.";
            } else {
                $mensagemErro = "Erro no banco de dados. Tente novamente.";
            }

            unset($post['senha'], $post['confSenha']);

            return Redirect::page($this->controller, [
                "msgError" => $mensagemErro,
                "inputs"   => $post
            ]);

        } catch (\Exception $e) {
            
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }

            unset($post['senha'], $post['confSenha']);

            return Redirect::page($this->controller, [
                "msgError" => $e->getMessage(),
                "inputs"   => $post
            ]);
        }
    }
}