<?php

namespace App\Controller;

use Core\Library\ControllerMain;
use Core\Library\Redirect;

use App\Model\VagaModel;
use App\Model\CargoModel;
use App\Model\EstabelecimentoModel;

class Vaga extends ControllerMain
{
   private $vagaModel;
   private $cargoModel;
   private $estabelecimentoModel;

   public function __construct()
   {
      parent::__construct();
      $this->vagaModel = new VagaModel();
      $this->cargoModel = new CargoModel();
      $this->estabelecimentoModel = new EstabelecimentoModel();
   }

   /**
    * Página principal de vagas - agora com busca integrada
    */
   public function index()
   {
      // Parâmetros de paginação
      $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $limit = 20;
      $offset = ($page - 1) * $limit;

      // Verificar se há parâmetros de busca
      $temFiltros = !empty($_GET['busca']) || !empty($_GET['cargo_id']) || !empty($_GET['estabelecimento_id']) ||
         !empty($_GET['regime']) || !empty($_GET['contrato']) || !empty($_GET['statusVaga']);

      // Construir filtros baseado nos parâmetros GET
      $filtros = $this->construirFiltros($_GET);

      // Buscar todas as vagas
      $todasVagas = $this->vagaModel->lista('dtInicio', 'DESC');

      // Aplicar filtros se existirem
      if ($temFiltros) {
         $vagasFiltradas = $this->aplicarFiltros($todasVagas, $filtros);
      } else {
         $vagasFiltradas = $todasVagas;
      }

      // Calcular paginação
      $totalVagas = count($vagasFiltradas);
      $totalPaginas = ceil($totalVagas / $limit);

      // Aplicar paginação
      $vagas = array_slice($vagasFiltradas, $offset, $limit);

      // Dados para filtros
      $cargos = $this->cargoModel->lista('descricao', 'ASC');
      $estabelecimentos = $this->estabelecimentoModel->listaEstabelecimento('nome', 'ASC');

      // Preparar dados para view
      $dados = [
         'vagas' => $vagas,
         'total_vagas' => $totalVagas,
         'cargos' => $cargos,
         'estabelecimentos' => $estabelecimentos,
         'filtros_ativos' => $this->obterFiltrosAtivos($_GET),
         'paginacao' => [
            'pagina_atual' => $page,
            'total_paginas' => $totalPaginas,
            'total_registros' => $totalVagas,
            'por_pagina' => $limit
         ],
         'termo_busca' => isset($_GET['busca']) ? $_GET['busca'] : ''
      ];

      $this->loadView("vagas", $dados);
   }


   /**
    * Construir array de filtros baseado nos parâmetros GET
    */
   private function construirFiltros($params)
   {
      $filtros = [];

      // Busca por texto
      if (isset($params['busca']) && !empty($params['busca'])) {
         $filtros['texto'] = trim($params['busca']);
      }

      // Filtro por cargo direto
      if (isset($params['cargo_id']) && !empty($params['cargo_id'])) {
         $filtros['cargo_id'] = (int)$params['cargo_id'];
      }

      // Filtro por estabelecimento direto
      if (isset($params['estabelecimento_id']) && !empty($params['estabelecimento_id'])) {
         $filtros['estabelecimento_id'] = (int)$params['estabelecimento_id'];
      }

      // Filtro por modalidade (regime na view)
      if (isset($params['regime']) && is_array($params['regime'])) {
         if (in_array('presencial', $params['regime'])) {
            $filtros['modalidade'] = 1;
         } elseif (in_array('remoto', $params['regime'])) {
            $filtros['modalidade'] = 2;
         }
      }

      // Filtro por vínculo (contrato na view)
      if (isset($params['contrato']) && is_array($params['contrato'])) {
         if (in_array('clt', $params['contrato'])) {
            $filtros['vinculo'] = 1;
         } elseif (in_array('pj', $params['contrato'])) {
            $filtros['vinculo'] = 2;
         }
      }

      // Filtro por status da vaga
      if (isset($params['statusVaga']) && $params['statusVaga'] !== '') {
         $filtros['statusVaga'] = (int)$params['statusVaga'];
      }

      return $filtros;
   }

   /**
    * Aplicar filtros nas vagas
    */
   private function aplicarFiltros($vagas, $filtros)
   {
      if (empty($filtros)) {
         return $vagas;
      }

      return array_filter($vagas, function ($vaga) use ($filtros) {
         // Filtro por texto
         if (isset($filtros['texto'])) {
            $termo = strtolower($filtros['texto']);
            $descricao = isset($vaga['descricao']) ? strtolower($vaga['descricao']) : '';
            $sobreVaga = isset($vaga['sobreVaga']) ? strtolower($vaga['sobreVaga']) : '';

            $encontrou = strpos($descricao, $termo) !== false || strpos($sobreVaga, $termo) !== false;
            if (!$encontrou) return false;
         }

         // Filtro por cargo
         if (isset($filtros['cargo_id']) && $vaga['cargo_id'] != $filtros['cargo_id']) {
            return false;
         }

         // Filtro por estabelecimento
         if (isset($filtros['estabelecimento_id']) && $vaga['estabelecimento_id'] != $filtros['estabelecimento_id']) {
            return false;
         }

         // Filtro por modalidade
         if (isset($filtros['modalidade']) && $vaga['modalidade'] != $filtros['modalidade']) {
            return false;
         }

         // Filtro por vínculo
         if (isset($filtros['vinculo']) && $vaga['vinculo'] != $filtros['vinculo']) {
            return false;
         }

         // Filtro por status da vaga
         if (isset($filtros['statusVaga']) && (int)$vaga['statusVaga'] !== (int)$filtros['statusVaga']) {
            return false;
         }

         return true;
      });
   }

   /**
    * Obter filtros ativos para exibição
    */
   private function obterFiltrosAtivos($params)
   {
      $filtros = [];

      if (isset($params['busca']) && !empty($params['busca'])) {
         $filtros['busca'] = [
            'label' => 'Busca',
            'valor' => $params['busca'],
            'tipo' => 'texto'
         ];
      }

      if (isset($params['cargo_id']) && !empty($params['cargo_id'])) {
         $cargo = $this->cargoModel->getById($params['cargo_id']);
         $filtros['cargo_id'] = [
            'label' => 'Cargo',
            'valor' => isset($cargo['descricao']) ? $cargo['descricao'] : 'Cargo #' . $params['cargo_id'],
            'tipo' => 'cargo'
         ];
      }

      if (isset($params['estabelecimento_id']) && !empty($params['estabelecimento_id'])) {
         $estabelecimento = $this->estabelecimentoModel->getEstabelecimentoId($params['estabelecimento_id']);
         $filtros['estabelecimento_id'] = [
            'label' => 'Estabelecimento',
            'valor' => isset($estabelecimento['nome']) ? $estabelecimento['nome'] : 'Estabelecimento #' . $params['estabelecimento_id'],
            'tipo' => 'estabelecimento'
         ];
      }

      if (isset($params['statusVaga']) && $params['statusVaga'] !== '') {
         $statusLabel = '';
         switch ($params['statusVaga']) {
            case '11':
               $statusLabel = 'Em Aberto';
               break;
            case '1':
               $statusLabel = 'Pré Vaga';
               break;
            case '91':
               $statusLabel = 'Suspensa';
               break;
            case '99':
               $statusLabel = 'Finalizada';
               break;
         }

         $filtros['statusVaga'] = [
            'label' => 'Status da Vaga',
            'valor' => $statusLabel,
            'tipo'  => 'statusVaga'
         ];
      }

      return $filtros;
   }
   /**
    * Exibir detalhes de uma vaga
    * URL: /vaga/view/{action}/{id}/{parametros...}
    */
   public function detalhes($action = null, $id = null, ...$params)
   {
      // Exibir para debug (opcional)
      // echo "Ação: $action <br>ID: $id <br>Parâmetros: " . implode(", ", $params);

      // Validar ID
      if (!$id || !is_numeric($id)) {
         return Redirect::page("vaga", ['msgError' => "ID da vaga inválido."]);
      }
      // Buscar a vaga pelo ID usando o model
      $vaga = $this->model->getVagaById($id);

      if (!$vaga) {
         return Redirect::page("vaga", ['msgError' => "Vaga não encontrada."]);
      }

      // Buscar dados relacionados: cargo e estabelecimento
      $cargo = isset($vaga['cargo_id']) ? $this->cargoModel->getCargoById($vaga['cargo_id']) : null;
      $estabelecimento = isset($vaga['estabelecimento_id']) ? $this->estabelecimentoModel->getEstabelecimentoId($vaga['estabelecimento_id']) : null;

      // Buscar vagas relacionadas (mesmo cargo ou estabelecimento)
      $todasVagas = $this->model->lista('dtInicio', 'DESC');
      $vagasRelacionadas = array_slice(array_filter($todasVagas, function ($v) use ($vaga) {
         return ($v['cargo_id'] == $vaga['cargo_id'] || $v['estabelecimento_id'] == $vaga['estabelecimento_id'])
            && $v['vaga_id'] != $vaga['vaga_id']
            && $v['statusVaga'] == 11; // Apenas vagas em aberto
      }), 0, 5);

      // Preparar dados para a view
      $dados = [
         'vaga' => $vaga,
         'cargo' => $cargo,
         'estabelecimento' => $estabelecimento,
         'vagas_relacionadas' => $vagasRelacionadas,
         'action' => $action,
         'params' => $params
      ];

      // Carregar a view vagaDetalhes
      $this->loadView("vagaDetalhes", $dados);
   }
}
