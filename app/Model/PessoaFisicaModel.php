<?php

namespace App\Model;

use Core\Library\ModelMain;

class PessoaFisicaModel extends ModelMain
{
    protected $table = 'pessoa_fisica';
    protected $primaryKey = "pessoa_fisica_id";

    public $validationRules = [
        "nome"  => [
            "label" => 'Nome',
            "rules" => 'required|min:4|max:150'
        ],
        "cpf"  => [
            "label" => 'CPF',
            "rules" => 'required|max:11|char'
        ]
    ];
    public function getUserId($id)
    {
        return $this->db
            ->where($this->primaryKey, $id)
            ->first();
    }
    /**
     * Validação de CPF
     *
     * @param string $cpf
     * @return bool
     */
    public function validarCPF($cpf)
    {
        // Remove caracteres não numéricos
        $cpf = preg_replace('/\D/', '', $cpf);

        // Verifica se tem 11 dígitos
        if (strlen($cpf) != 11) {
            return false;
        }

        // Verifica se todos os dígitos são iguais
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }

        // Validação do primeiro dígito verificador
        $soma = 0;
        for ($i = 0; $i < 9; $i++) {
            $soma += $cpf[$i] * (10 - $i);
        }
        $resto = $soma % 11;
        $dv1 = ($resto < 2) ? 0 : 11 - $resto;

        if ($cpf[9] != $dv1) {
            return false;
        }

        // Validação do segundo dígito verificador
        $soma = 0;
        for ($i = 0; $i < 10; $i++) {
            $soma += $cpf[$i] * (11 - $i);
        }
        $resto = $soma % 11;
        $dv2 = ($resto < 2) ? 0 : 11 - $resto;

        return $cpf[10] == $dv2;
    }
}
