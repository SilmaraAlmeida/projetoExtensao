<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;
use Core\Library\Session;

class TermoDeUsoAceite extends ControllerMain
{
    /**
     * construct
     */
    public function __construct()
    {
        $this->auxiliarConstruct();
        $this->loadHelper(['formHelper', 'tabela']);
        $this->validaNivelAcesso("CN");                     // Todos os usuários podem aceitar termos
    }

    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        return $this->loadView("sistema/listaTermoDeUsoAceite", $this->model->listaTermoDeUsoAceite());
    }

/**
 * form
 *
 * @param string $action 
 * @param integer $termodeuso_id 
 * @param integer $usuario_id
 * @return void
 */
public function form($action = null, $termodeuso_id = null, $usuario_id = null)
{
    // Para view/update, ambos os parâmetros são obrigatórios
    if ($this->action != "insert" && (empty($termodeuso_id) || empty($usuario_id))) {
        return Redirect::page($this->controller, ["msgError" => "Parâmetros insuficientes para visualizar o aceite."]);
    }

    if ($this->action == "insert") {
        $dados = [
            "dataHoraAceite" => date('Y-m-d\TH:i'),
            "usuario_id" => Session::get('userId')
        ];
    } else {
        // Buscar dados do aceite específico
        $aceiteData = $this->model->getUserId($termodeuso_id, $usuario_id);
        
        if ($aceiteData) {
            $aceiteData['dataHoraAceite'] = date('Y-m-d\TH:i', strtotime($aceiteData['dataHoraAceite']));
            $dados = $aceiteData;
        } else {
            return Redirect::page($this->controller, ["msgError" => "Aceite não encontrado."]);
        }
    }

    // Carregar dados para os selects
    $dados['termosUso'] = $this->model->getTermosUsoSelect();

    if (Session::get('userTipo') == 'G') {
        $dados['usuarios'] = $this->model->getUsuariosSelect();
    }

    return $this->loadView("sistema/formTermoDeUsoAceite", $dados);
}

    /**
     * insert
     *
     * @return void
     */
    public function insert()
    {
        $post = $this->request->getPost();
        $lError = false;

        // Se não for gestor, força o usuário logado
        if (Session::get('userTipo') != 'G') {
            $post['usuario_id'] = Session::get('userId');
        }

        // CORREÇÃO: Converter formato datetime-local para MySQL
        if (!empty($post['dataHoraAceite'])) {
            // Converte de 2025-06-29T23:19:20 para 2025-06-29 23:19:20
            $post['dataHoraAceite'] = str_replace('T', ' ', $post['dataHoraAceite']);
        } else {
            $post['dataHoraAceite'] = date('Y-m-d H:i:s');
        }

        // Verificar se já existe aceite deste termo pelo usuário
        $aceiteExistente = $this->model->db
            ->where('termodeuso_id', $post['termodeuso_id'])
            ->where('usuario_id', $post['usuario_id'])
            ->first();

        if ($aceiteExistente) {
            $lError = true;
            $errors['aceite'] = "Este usuário já aceitou este termo de uso.";
            Session::set('errors', $errors);
        }

        if (!$lError) {
            if ($this->model->insert($post)) {
                return Redirect::page($this->controller, ["msgSucesso" => "Aceite registrado com sucesso."]);
            } else {
                $lError = true;
            }
        }

        if ($lError) {
            Session::set("inputs", $post);
            return Redirect::page($this->controller);
        }
    }


    /**
     * update
     *
     * @return void
     */
    public function update()
    {
        $post = $this->request->getPost();
        $lError = false;

        // Converter formato datetime-local para MySQL
        if (!empty($post['dataHoraAceite'])) {
            $post['dataHoraAceite'] = str_replace('T', ' ', $post['dataHoraAceite']);
        } else {
            $post['dataHoraAceite'] = date('Y-m-d H:i:s');
        }

        // Verificar se o aceite existe
        if (!$this->model->verificaAceiteExiste($post['termodeuso_id'], $post['usuario_id'])) {
            return Redirect::page($this->controller, ["msgError" => "Aceite não encontrado."]);
        }

        // Para aceites, só podemos atualizar a dataHoraAceite (não a chave primária composta)
        $dadosUpdate = [
            'dataHoraAceite' => $post['dataHoraAceite']
        ];

        if ($this->model->updateAceite($post['termodeuso_id'], $post['usuario_id'], $dadosUpdate)) {
            return Redirect::page($this->controller, ["msgSucesso" => "Data/hora do aceite atualizada com sucesso."]);
        } else {
            return Redirect::page($this->controller, ["msgError" => "Falha ao atualizar o aceite."]);
        }
    }

    /**
     * delete
     *
     * @return void
     */
    public function delete()
    {
        $post = $this->request->getPost();

        // Verificar se o aceite existe antes de tentar deletar
        if (!$this->model->verificaAceiteExiste($post['termodeuso_id'], $post['usuario_id'])) {
            return Redirect::page($this->controller, ["msgError" => "Aceite não encontrado ou já foi removido."]);
        }

        if ($this->model->deleteAceite($post['termodeuso_id'], $post['usuario_id'])) {
            return Redirect::page($this->controller, ['msgSucesso' => "Aceite removido com sucesso."]);
        } else {
            return Redirect::page($this->controller, ["msgError" => "Falha ao remover o aceite."]);
        }
    }



    /**
     * aceitarTermo - Método específico para aceitar um termo
     *
     * @param int $termodeuso_id
     * @return void
     */
    public function aceitarTermo($termodeuso_id = null)
    {
        if (!$termodeuso_id) {
            return Redirect::page($this->controller, ["msgError" => "Termo de uso não informado."]);
        }

        $usuario_id = Session::get('userId');

        // Verificar se já aceitou
        $aceiteExistente = $this->model->db
            ->where('termodeuso_id', $termodeuso_id)
            ->where('usuario_id', $usuario_id)
            ->first();

        if ($aceiteExistente) {
            return Redirect::page($this->controller, ["msgError" => "Você já aceitou este termo de uso."]);
        }

        // Registrar aceite
        $dados = [
            'termodeuso_id' => $termodeuso_id,
            'usuario_id' => $usuario_id,
            'dataHoraAceite' => date('Y-m-d H:i:s')
        ];

        if ($this->model->insert($dados)) {
            return Redirect::page($this->controller, ["msgSucesso" => "Termo de uso aceito com sucesso."]);
        } else {
            return Redirect::page($this->controller, ["msgError" => "Erro ao registrar aceite."]);
        }
    }

    /**
     * meuHistorico - Lista aceites do usuário logado
     *
     * @return void
     */
    public function meuHistorico()
    {
        $usuario_id = Session::get('userId');

        $dados = $this->model->db
            ->table('termodeusoaceite')
            ->select('termodeusoaceite.*, LEFT(termodeuso.textoTermo, 100) as termo_resumo')
            ->join('termodeuso', 'termodeusoaceite.termodeuso_id = termodeuso.termodeuso_id', 'INNER')
            ->where('termodeusoaceite.usuario_id', $usuario_id)
            ->orderBy('termodeusoaceite.dataHoraAceite', 'DESC')
            ->findAll();

        return $this->loadView("sistema/historicoTermoDeUsoAceite", $dados);
    }
}
