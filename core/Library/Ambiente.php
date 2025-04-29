<?php

namespace Core\Library;

class Ambiente
{
    /**
     * load
     *
     * @return void
     */
    public function load()
    {
        // analisa e carregar o conteúdo do arquivo .env em um array
        $confAmbiente = parse_ini_file('..' . DIRECTORY_SEPARATOR . '.env', true);

        foreach ($confAmbiente as $key => $value) {
            if (gettype($confAmbiente[$key]) != "array") {
                $_ENV[$key] = $value;
            }
        }

        // Pegar as configurações do ambiente
        if (isset($_ENV['ENVIRONMENT'])) {
            foreach($confAmbiente[$_ENV['ENVIRONMENT']] as $key => $value) {
                $_ENV[$key] = $value;
            }
        }

        return null;
    }
}