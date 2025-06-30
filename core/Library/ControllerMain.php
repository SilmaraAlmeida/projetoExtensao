<?php

namespace Core\Library;

use Core\Library\Request;

class ControllerMain
{
    protected $controller;
    protected $method;
    protected $action;
    protected $request;
    public $model;

    use RequestTrait;

    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarConstruct();
    }

    /**
     * auxiliarconstruct
     *
     * @return void
     */
    public function auxiliarconstruct()
    {
        $aParametros        = Self::getRotaParametros();
        $this->controller   = $aParametros['controller'];
        $this->method       = $aParametros['method'];
        $this->action       = $aParametros['action'];
        $this->model        = $this->loadModel($this->controller);
        $this->request      = new Request();

        // carregar helper padrão
        $this->loadHelper(["formulario", "utilits"]);

        // Verifida os controllers autorizados sem login efetuado, permitindo passar controller Api que serão validados a parte
        if (substr($this->controller, 0, 3) != "Api") {

            if (!in_array($this->controller, CONTROLLER_AUTH)) {
                if (!Session::get("userId")) {
                    return Redirect::page("login", ['msgError' => "Para acessar a rotina favor antes efetuar o login."]);
                }
            }

        }
    }

    /**
     * validaNivelAcesso
     *
     * @param string $nivelMinimo Nível mínimo necessário (CN, A ou G)
     * @return void
     */
    public function validaNivelAcesso(string $nivelMinimo = 'CN')
    {
        // Define a hierarquia de níveis (do menor para o maior privilégio)
        $hierarquiaNiveis = [
            'CN' => 1, // Contribuinte normativo
            'A'  => 2, // Anunciante  
            'G'  => 3  // Gestor
        ];

        $nivelUsuario = Session::get("userNivel");

        // Verifica se os níveis existem na hierarquia
        if (!isset($hierarquiaNiveis[$nivelUsuario]) || !isset($hierarquiaNiveis[$nivelMinimo])) {
            return Redirect::page("sistema", ["msgError" => "Nível de acesso inválido"]);
        }

        // Verifica se o usuário possui nível suficiente
        if ($hierarquiaNiveis[$nivelUsuario] < $hierarquiaNiveis[$nivelMinimo]) {
            return Redirect::page("sistema", ["msgError" => "Você não possui permissão neste programa"]);
        }
    }

    /**
     * loadModel
     *
     * @param string $nomeModel 
     * @return void|object
     */
    public function loadModel($nomeModel)
    {
        $pathModel = "App\Model\\" . $nomeModel . "Model";
        
        if (class_exists($pathModel)) {
            return new $pathModel();
        }
    }

    /**
     * loadHelper
     *
     * @param string|array $nomeHelper 
     * @return void
     */
    public function loadHelper($nomeHelper)
    {
        if (gettype($nomeHelper) == "string") {
            $nomeHelper = [$nomeHelper];
        }

        foreach ($nomeHelper AS $value) {
            $pathHelperAtom = ".." . DIRECTORY_SEPARATOR . "core" . DIRECTORY_SEPARATOR . "Helper" . DIRECTORY_SEPARATOR . "{$value}.php";
            
            if (file_exists($pathHelperAtom)) {
                require_once $pathHelperAtom;
            } else {
                $pathHelperUser = ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "Helper" . DIRECTORY_SEPARATOR . "{$value}.php";

                if (file_exists($pathHelperUser)) {
                    require_once $pathHelperUser;
                }
            }        
        }
    }

    /**
     * loadView
     *
     * @param string $nome 
     * @param array $dados 
     * @param bool $exibeCabRodape 
     * @return void
     */
    public function loadView($nome, $dados = [], $exibeCabRodape = true)
    {
        $aDados = $dados;
        $pathView = ".." . DIRECTORY_SEPARATOR . "app" . DIRECTORY_SEPARATOR . "View" . DIRECTORY_SEPARATOR;

        // carrega cabeçalho
        if ($exibeCabRodape) {
            require_once $pathView . "Comuns" . DIRECTORY_SEPARATOR . "cabecalho.php";
        }

        // erros na validação do formulário
        if (Session::get("inputs") != false) {
            $dados['data'] = Session::getDestroy("inputs");
        }

        // Será utilizado para recuperar valores e preencher o formulário
        if (isset($dados['data'])) {
			$_POST = $dados['data'];
		} else {
			if (count($dados) > 0) {
				$_POST = $dados;
			}
		}
        
        // Será utilizado futuramente para recuperar valores quando idenficado
        if (Session::get("errors") != false) {
            $_POST['formErrors'] = Session::getDestroy('errors');
        }

        // carrega a página
        if (file_exists($pathView . $nome . ".php")) {
            require_once $pathView . $nome . ".php";
        } else {
            require_once $pathView . "Comuns" . DIRECTORY_SEPARATOR . "erros.php";
        }

        // carrega rodapé
        if ($exibeCabRodape) {
            require_once $pathView . "Comuns" . DIRECTORY_SEPARATOR . "rodape.php";
        }
    }
}