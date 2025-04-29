<?php

namespace Core\Library;

class Request
{
    protected $aParametros;

    use RequestTrait;

    /**
     * construct
     */
    public function __construct()
    {
        $this->aParametros = Self::getRotaParametros();
    }

    /**
     * getController
     *
     * @return string
     */
    public function getController()
    {
        return $this->aParametros['controller'];
    }

    /**
     * getMetodo
     *
     * @return string
     */
    public function getMetodo()
    {
        return $this->aParametros['method'];
    }

    /**
     * getAction
     *
     * @return string
     */
    public function getAction()
    {
        return $this->aParametros['action'];
    }

    /**
     * getGet
     *
     * @return string
     */
    public function getGet()
    {
        return $this->aParametros['get'];
    }

    /**
     * getPost
     *
     * @return string
     */
    public function getPost()
    {
        return $this->aParametros['post'];
    }

    /**
     * formAction
     *
     * @return string
     */
    public function formAction()
    {
        return baseUrl() . $this->getController() . '/' . $this->getAction();
    }
}