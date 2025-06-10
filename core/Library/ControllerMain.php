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