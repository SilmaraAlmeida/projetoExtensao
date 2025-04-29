<?php

namespace Core\Library;

class Session
{
    /**
     * set
     *
     * @param string $key 
     * @param mixed $value 
     * @return void
     */
    static public function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * get
     *
     * @param string $key 
     * @return mixed
     */
    static public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return false;
        }
    }

    /**
     * destroy
     *
     * @param string $key 
     * @return void
     */
    static public function destroy($key)
    {
        if (isset($_SESSION[$key])) {
            unset($_SESSION[$key]);
        }
    }

    /**
     * getDestroy
     *
     * @param string $key 
     * @return mixed
     */
    static public function getDestroy($key)
    {
        $valor = Session::get($key);
        Session::destroy($key);

        return $valor;
    }
}