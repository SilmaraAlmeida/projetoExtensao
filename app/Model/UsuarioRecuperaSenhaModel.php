<?php
/**
 * ATENÇÃO
 * 
 * ESSE MODEL VAI MUDAR EM BREVE
 * TABELA INSERIDA MANUALMENTE.
 */

namespace App\Model;

use Core\Library\ModelMain;

class UsuarioRecuperaSenhaModel extends ModelMain
{
    protected $table = "usuariorecuperasenha";

    /**
     * getRecuperaSenhaChave - Recuperar os dados do usuário especificado em $email
     *
     * @param string $chave 
     * @return array
     */
    public function getRecuperaSenhaChave($chave) 
    {
        return $this->db->where(["statusRegistro" => 1, "chave" => $chave])->first();
    }

    /**
     * desativaChave - Desativa chave de acesso
     *
     * @param mixed $id 
     * @return void
     */
    function desativaChave($id) 
    {
        $rs = $this->db->where(["id" => $id])->update(["statusRegistro" => 2, "updated_at" => date("Y-m-d H:i:s")]);
        
        if ($rs > 0) {
            return true;
        } else {
            return false;
        }      
    }

    /**
     * desativaChave - Desativa chave de acesso
     *
     * @param mixed $id 
     * @return void
     */
    function desativaChaveAntigas($id) 
    {
        $rs = $this->db->where(["id <>" => $id])->update(["statusRegistro" => 2]);
        
        if ($rs > 0) {
            return true;
        } else {
            return false;
        }      
    }
    
}