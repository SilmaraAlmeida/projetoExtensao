<?php

namespace Core\Library;

class Redirect
{
    /**
     * page
     *
     * @param string $caminho 
     * @param array $widt 
     * @return void
     */
    static public function page($caminho, $widt = [])
    {
        if (count($widt) > 0 ) {
            foreach ($widt as $key => $value) {
                Session::set($key, $value);
            }
        }

        return header("Location: " . baseUrl() . $caminho);
    }
}