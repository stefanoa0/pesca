<?php

class BarcosController extends Zend_Controller_Action
{
    private $usuario;
    public function init()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');


        $auth = Zend_Auth::getInstance();
         if ( $auth->hasIdentity() ){
          $identity = $auth->getIdentity();
          $identity2 = get_object_vars($identity);

        }

        $this->modelUsuario = new Application_Model_Usuario();
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario",$this->usuario);
        $this->modelBarcos = new Application_Model_Barcos();
    }

    public function indexAction()
    {
        $barcos = $this->modelBarcos->select();
        $this->view->assign("barcos", $barcos);
    }

    public function deleteAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        else{
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->modelBarcos->delete($this->_getParam('id'));

        $this->_redirect('barcos/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tbar_nome' => $this->_getParam("valor"));

        $this->modelBarcos->insert($setupDados);

        $this->_redirect("/barcos/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tbar_id' => $this->_getParam("id"),
            'tbar_nome' => $this->_getParam("valor")
        );

        $this->modelBarcos->update($setupDados);

        $this->_redirect("/barcos/index");

        return;
    }
    public function novoAction(){
        $idBarco = $this->_getParam('id');
        $barco = $this->modelBarcos->select('bar_id = '.$idBarco);
        
        $this->modelEmbarcacaoDetalhada = new Application_Model_EmbarcacaoDetalhada();
        $embarcacaoDetalhada = $this->modelEmbarcacaoDetalhada->select('bar_id = '.$idBarco);
       
        
        if(!empty($embarcacaoDetalhada[0])){
            $this->redirect('barcos/editar/id/'.$idBarco);
        }
        else{
        $this->view->assign("assignBarco", $barco);
        
    //DADOS DA EMBARÇAO----------------------------------------------------------------------        
        $this->modelPorto = new Application_Model_Porto();
        $portos = $this->modelPorto->select(null, 'pto_nome');
        $this->view->assign("assignPortos", $portos);
        
        $this->modelPescador = new Application_Model_Pescador();
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $this->view->assign("assignPescadores", $pescadores);
        
        $this->modelTipoBarcos = new Application_Model_TipoEmbarcacao();
        $tipobarcos = $this->modelTipoBarcos->select(null,'tte_tipoembarcacao');
        $this->view->assign("assignTipoBarcos", $tipobarcos);
        
        $this->modelSeguroDefeso = new Application_Model_SeguroDefeso();
        $segurodefeso = $this->modelSeguroDefeso->select(null, 'tsd_seguro');
        $this->view->assign("assignSeguroDefeso", $segurodefeso);
        
        $this->modelMaterial = new Application_Model_Material();
        $material = $this->modelMaterial->select(null, 'tmt_material');
        $this->view->assign("assignMaterial", $material);
        
        $this->modelTipoCasco = new Application_Model_TipoCasco();
        $tipocasco = $this->modelTipoCasco->select(null, 'tcas_tipo');
        $this->view->assign("assignTipoCasco", $tipocasco);
        
        $this->modelTipoPagamento = new Application_Model_TipoPagamento();
        $tipopagamento = $this->modelTipoPagamento->select(null, 'tpg_pagamento');
        $this->view->assign("assignTipoPagamento", $tipopagamento);
        
        $this->modelEquipamento = new Application_Model_Equipamento();
        $equipamento = $this->modelEquipamento->select(null, 'teq_equipamento');
        $this->view->assign("assignEquipamento", $equipamento);
        
        $this->modelFinanciador = new Application_Model_Financiador();
        $financiador = $this->modelFinanciador->select(null, 'tfin_financiador');
        $this->view->assign("assignFinanciador", $financiador);
        
//DADOS DO MOTOR ---------------------------------------------------------------------- 
        
        $this->modelTipoMotor = new Application_Model_TipoMotor();
        $tipomotor = $this->modelTipoMotor->select(null, 'tmot_tipo');
        $this->view->assign("assignTipoMotor", $tipomotor);
        
        $this->modelModelos = new Application_Model_Modelo();
        $modelos = $this->modelModelos->select(null, 'tmod_modelo');
        $this->view->assign("assignModelos", $modelos);
        
        $this->modelMarcas = new Application_Model_Marca();
        $marcas = $this->modelMarcas->select(null, 'tmar_marca');
        $this->view->assign("assignMarcas", $marcas);
        
        $this->modelPostosCombustivel = new Application_Model_PostoCombustivel();
        $postos = $this->modelPostosCombustivel->select(null, 'tpc_posto');
        $this->view->assign("assignPostosCombustivel", $postos);
        
//DADOS DA ATUAÇÃO --------------------------------------------------------------------
        
        $this->modelFrequenciaPesca = new Application_Model_FrequenciaPesca();
        $frequenciapesca = $this->modelFrequenciaPesca->select(null, 'tfp_frequencia');
        $this->view->assign("assignFrequenciaPesca", $frequenciapesca);
        
        $this->modelHorarioPesca = new Application_Model_HorarioPesca();
        $horariopesca = $this->modelHorarioPesca->select(null, 'thp_horario');
        $this->view->assign("assignHorarioPesca", $horariopesca);
        
        $this->modelColonia = new Application_Model_Colonia();
        $colonia = $this->modelColonia->select(null, 'tc_nome');
        $this->view->assign("assignColonia", $colonia);
        
        $this->modelConservacaoPescado = new Application_Model_ConservacaoPescado();
        $conservacaopescado = $this->modelConservacaoPescado->select(null, 'tcp_conserva');
        $this->view->assign("assignConservacaoPescado", $conservacaopescado);
        
        $this->modelDestinoPescado = new Application_Model_DestinoPescado();
        $destinopescado = $this->modelDestinoPescado->select(null, 'dp_destino');
        $this->view->assign("assignDestinoPescado", $destinopescado);
        
        $this->modelEstacaoAno = new Application_Model_EstacaoAno();
        $estacaoano = $this->modelEstacaoAno->select(null, 'tea_estacao');
        $this->view->assign("assignEstacaoAno", $estacaoano);
        
        $this->modelTipoRenda = new Application_Model_TipoRenda();
        $outratividade = $this->modelTipoRenda->select(null, 'ttr_descricao');
        $this->view->assign("assignOutraAtividade", $outratividade);
        
        $this->modelUsuarios = new Application_Model_Usuario();
        $usuarios = $this->modelUsuarios->select(null, 'tu_nome');
        $this->view->assign("assignUsuarios", $usuarios);
        }
        
    }
    public function editarAction(){
        $this->modelCor = new Application_Model_Cor();
        $cores = $this->modelCor->select();
        $this->view->assign("assignCores", $cores);
        
        $idBarco = $this->_getParam('id');

        $barco = $this->modelBarcos->select('bar_id = '.$idBarco);
        $this->view->assign("assignBarco", $barco);
        
        $this->modelEmbarcacaoDetalhada = new Application_Model_EmbarcacaoDetalhada();
        $embarcacaoDetalhada = $this->modelEmbarcacaoDetalhada->select('bar_id = '.$idBarco);
        $this->view->assign("assignEmbarcacaoDetalhada", $embarcacaoDetalhada[0]);
        
        $this->modelMotor = new Application_Model_MotorEmbarcacao();
        $motorEmbarcacao = $this->modelMotor->select('ted_id = '.$embarcacaoDetalhada[0]['ted_id']);
        $this->view->assign("assignMotorEmbarcacao", $motorEmbarcacao[0]);
        
        $this->modelAtuacao = new Application_Model_AtuacaoEmbarcacao();
        $atuacao = $this->modelAtuacao->select('ted_id = '.$embarcacaoDetalhada[0]['ted_id']);
        $this->view->assign("assignAtuacao", $atuacao[0]);
    //DADOS DA EMBARÇAO----------------------------------------------------------------------        
        $this->modelPorto = new Application_Model_Porto();
        $portos = $this->modelPorto->select(null, 'pto_nome');
        $this->view->assign("assignPortos", $portos);
        
        $this->modelPescador = new Application_Model_Pescador();
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $this->view->assign("assignPescadores", $pescadores);
        
        $this->modelTipoBarcos = new Application_Model_TipoEmbarcacao();
        $tipobarcos = $this->modelTipoBarcos->select(null,'tte_tipoembarcacao');
        $this->view->assign("assignTipoBarcos", $tipobarcos);
        
        $this->modelSeguroDefeso = new Application_Model_SeguroDefeso();
        $segurodefeso = $this->modelSeguroDefeso->select(null, 'tsd_seguro');
        $this->view->assign("assignSeguroDefeso", $segurodefeso);
        
        $this->modelSavatagem = new Application_Model_Savatagem();
        $savatagem = $this->modelSavatagem->select(null, 'tsav_savatagem');
        $this->view->assign("assignSavatagem", $savatagem);
        
        $this->modelMaterial = new Application_Model_Material();
        $material = $this->modelMaterial->select(null, 'tmt_material');
        $this->view->assign("assignMaterial", $material);
        
        $this->modelTipoCasco = new Application_Model_TipoCasco();
        $tipocasco = $this->modelTipoCasco->select(null, 'tcas_tipo');
        $this->view->assign("assignTipoCasco", $tipocasco);
        
        $this->modelTipoPagamento = new Application_Model_TipoPagamento();
        $tipopagamento = $this->modelTipoPagamento->select(null, 'tpg_pagamento');
        $this->view->assign("assignTipoPagamento", $tipopagamento);
        
        $this->modelEquipamento = new Application_Model_Equipamento();
        $equipamento = $this->modelEquipamento->select(null, 'teq_equipamento');
        $this->view->assign("assignEquipamento", $equipamento);
        
        $this->modelFinanciador = new Application_Model_Financiador();
        $financiador = $this->modelFinanciador->select(null, 'tfin_financiador');
        $this->view->assign("assignFinanciador", $financiador);
        
//DADOS DO MOTOR ---------------------------------------------------------------------- 
        
        $this->modelTipoMotor = new Application_Model_TipoMotor();
        $tipomotor = $this->modelTipoMotor->select(null, 'tmot_tipo');
        $this->view->assign("assignTipoMotor", $tipomotor);
        
        $this->modelModelos = new Application_Model_Modelo();
        $modelos = $this->modelModelos->select(null, 'tmod_modelo');
        $this->view->assign("assignModelos", $modelos);
        
        $this->modelMarcas = new Application_Model_Marca();
        $marcas = $this->modelMarcas->select(null, 'tmar_marca');
        $this->view->assign("assignMarcas", $marcas);
        
        $this->modelPostosCombustivel = new Application_Model_PostoCombustivel();
        $postos = $this->modelPostosCombustivel->select(null, 'tpc_posto');
        $this->view->assign("assignPostosCombustivel", $postos);
        
//DADOS DA ATUAÇÃO --------------------------------------------------------------------
        
        $this->modelFrequenciaPesca = new Application_Model_FrequenciaPesca();
        $frequenciapesca = $this->modelFrequenciaPesca->select(null, 'tfp_frequencia');
        $this->view->assign("assignFrequenciaPesca", $frequenciapesca);
        
        $this->modelHorarioPesca = new Application_Model_HorarioPesca();
        $horariopesca = $this->modelHorarioPesca->select(null, 'thp_horario');
        $this->view->assign("assignHorarioPesca", $horariopesca);
        
        $this->modelAreaPesca = new Application_Model_AreaPesca();
        $areapesca = $this->modelAreaPesca->select(null, 'tareap_areapesca');
        $this->view->assign("assignAreaPesca", $areapesca);
        
        $this->modelArtePesca = new Application_Model_ArtePesca();
        $artepesca = $this->modelArtePesca->select(null, 'tap_artepesca');
        $this->view->assign("assignArtePesca", $artepesca);
        
        $this->modelColonia = new Application_Model_Colonia();
        $colonia = $this->modelColonia->select(null, 'tc_nome');
        $this->view->assign("assignColonia", $colonia);
        
        $this->modelConservacaoPescado = new Application_Model_ConservacaoPescado();
        $conservacaopescado = $this->modelConservacaoPescado->select(null, 'tcp_conserva');
        $this->view->assign("assignConservacaoPescado", $conservacaopescado);
        
        $this->modelDestinoPescado = new Application_Model_DestinoPescado();
        $destinopescado = $this->modelDestinoPescado->select(null, 'dp_destino');
        $this->view->assign("assignDestinoPescado", $destinopescado);
        
        $this->modelEstacaoAno = new Application_Model_EstacaoAno();
        $estacaoano = $this->modelEstacaoAno->select(null, 'tea_estacao');
        $this->view->assign("assignEstacaoAno", $estacaoano);
        
        $this->modelTipoRenda = new Application_Model_TipoRenda();
        $outratividade = $this->modelTipoRenda->select(null, 'ttr_descricao');
        $this->view->assign("assignOutraAtividade", $outratividade);
        
        $this->modelUsuarios = new Application_Model_Usuario();
        $usuarios = $this->modelUsuarios->select(null, 'tu_nome');
        $this->view->assign("assignUsuarios", $usuarios);
        
        $this->modelFornecedor = new Application_Model_FornecedorInsumos();
        $fornecedor = $this->modelFornecedor->select(null, 'tfi_fornecedor');
        $this->view->assign("assignFornecedores", $fornecedor);
//Views --------------------------------------------------------------------
        
        $embarcacaoCor = $this->modelEmbarcacaoDetalhada->selectVEmbarcacaoDetalhadaHasTCor('ted_id = '.$embarcacaoDetalhada[0]['ted_id']);
        $this->view->assign("assignEmbarcacaoCor", $embarcacaoCor);
        
        $embarcacaoEquipamento = $this->modelEmbarcacaoDetalhada->selectVEmbarcacaoDetalhadaHasTEquipamento('ted_id = '.$embarcacaoDetalhada[0]['ted_id']);
        $this->view->assign("assignEmbarcacaoEquipamento", $embarcacaoEquipamento);
        
        $embarcacaoMaterial = $this->modelEmbarcacaoDetalhada->selectVEmbarcacaoDetalhadaHasTMaterial('ted_id = '.$embarcacaoDetalhada[0]['ted_id']);
        $this->view->assign("assignEmbarcacaoMaterial", $embarcacaoMaterial);
        
        $embarcacaoSavatagem = $this->modelEmbarcacaoDetalhada->selectVEmbarcacaoDetalhadaHasTSavatagem('ted_id = '.$embarcacaoDetalhada[0]['ted_id']);
        $this->view->assign("assignEmbarcacaoSavatagem", $embarcacaoSavatagem);
        
        $embarcacaoSeguroDefeso = $this->modelEmbarcacaoDetalhada->selectVEmbarcacaoDetalhadaHasTSeguroDefeso('ted_id = '.$embarcacaoDetalhada[0]['ted_id']);
        $this->view->assign("assignEmbarcacaoSeguroDefeso", $embarcacaoSeguroDefeso);
        
        
        $atuacaoAreaPesca = $this->modelEmbarcacaoDetalhada->selectVAtuacaoEmbarcacaoHasTAreaPesca('tae_id = '.$atuacao[0]['tae_id']);
        $this->view->assign("assignAtuacaoAreaPesca", $atuacaoAreaPesca);
        
        $atuacaoArtePesca = $this->modelEmbarcacaoDetalhada->selectVAtuacaoEmbarcacaoHasTArtePesca('tae_id = '.$atuacao[0]['tae_id']);
        $this->view->assign("assignAtuacaoArtePesca", $atuacaoArtePesca);
        
        $atuacaoFornecedorPetrechos = $this->modelEmbarcacaoDetalhada->selectVAtuacaoEmbarcacaoHasTFornecedorPetrechos('tae_id = '.$atuacao[0]['tae_id']);
        $this->view->assign("assignAtuacaoFornecedorPetrechos", $atuacaoFornecedorPetrechos);
        
        $motorFrequencia = $this->modelEmbarcacaoDetalhada->selectVMotorEmbarcacaoHasTFrequenciaManutencao('tme_id = '.$motorEmbarcacao[0]['tme_id']);
        $this->view->assign("assignMotorFrequencia", $motorFrequencia);
        
    }
    
    public function embarcacaodetalhadaAction(){
        
        $idBarco = $this->modelBarcos->insertEmbarcacao($this->_getAllParams());
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    public function updatedetalhadaAction(){
        $idBarco = $this->modelBarcos->updateEmbarcacao($this->_getAllParams());
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    public function insertcorAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->modelEmbarcacaoDetalhada = new Application_Model_EmbarcacaoDetalhada();
        
        $idEmbarcacao = $this->_getParam("id");
        $idCor = $this->_getParam("valor");
        $idBarco = $this->_getParam("back_url");
        
        $this->modelEmbarcacaoDetalhada->insertEmbDetalhadaHasCor($idEmbarcacao, $idCor);
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    
    public function insertlicencacapturaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->modelEmbarcacaoDetalhada = new Application_Model_EmbarcacaoDetalhada();
        
        $idEmbarcacao = $this->_getParam("id");
        $idSeguro = $this->_getParam("valor");
        $idBarco = $this->_getParam("back_url");
        
        $this->modelEmbarcacaoDetalhada->insertEmbDetalhadaHasSeguroDefeso($idEmbarcacao, $idSeguro);
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    
   public function insertmaterialAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->modelEmbarcacaoDetalhada = new Application_Model_EmbarcacaoDetalhada();
        
        $idEmbarcacao = $this->_getParam("id");
        $idMaterial = $this->_getParam("valor");
        $idBarco = $this->_getParam("back_url");
        
        $this->modelEmbarcacaoDetalhada->insertEmbDetalhadaHasMaterial($idEmbarcacao, $idMaterial);
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    
    public function insertequipamentoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->modelEmbarcacaoDetalhada = new Application_Model_EmbarcacaoDetalhada();
        
        $idEmbarcacao = $this->_getParam("id");
        $idEquipamento = $this->_getParam("valor");
        $idBarco = $this->_getParam("back_url");
        
        $this->modelEmbarcacaoDetalhada->insertEmbDetalhadaHasEquipamento($idEmbarcacao, $idEquipamento);
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    
    public function insertsavatagemAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->modelEmbarcacaoDetalhada = new Application_Model_EmbarcacaoDetalhada();
        
        $idEmbarcacao = $this->_getParam("id");
        $idSavatagem = $this->_getParam("valor");
        $idBarco = $this->_getParam("back_url");
        
        $this->modelEmbarcacaoDetalhada->insertEmbDetalhadaHasSavatagem($idEmbarcacao, $idSavatagem);
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    
    public function insertfrequenciamanutencaoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->modelMotorEmbarcacao = new Application_Model_MotorEmbarcacao();
        
        $idMotor = $this->_getParam("id");
        $idFrequencia = $this->_getParam("valor");
        $idBarco = $this->_getParam("back_url");
        
        $this->modelMotorEmbarcacao->insertMotEmbarcacaoHasFrequenciaManutencao($idMotor, $idFrequencia);
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    
    public function insertareapescaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->modelAtuacaoEmbarcacao = new Application_Model_AtuacaoEmbarcacao();
        
        $idAtuacao = $this->_getParam("id");
        $idArea = $this->_getParam("valor");
        $idBarco = $this->_getParam("back_url");
        
        $this->modelAtuacaoEmbarcacao->insertAtEmbarcacaoHasAreaPesca($idAtuacao, $idArea);
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    
    public function insertartepescaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->modelAtuacaoEmbarcacao = new Application_Model_AtuacaoEmbarcacao();
        
        $idAtuacao = $this->_getParam("id");
        $idArte = $this->_getParam("valor");
        $idBarco = $this->_getParam("back_url");
        
        $this->modelAtuacaoEmbarcacao->insertAtEmbarcacaoHasArtePesca($idAtuacao, $idArte);
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    
    public function insertfornecedorAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->modelAtuacaoEmbarcacao = new Application_Model_AtuacaoEmbarcacao();
        
        $idAtuacao = $this->_getParam("id");
        $idFornecedor = $this->_getParam("valor");
        $idBarco = $this->_getParam("back_url");
        
        $this->modelAtuacaoEmbarcacao->insertAtEmbarcacaoHasFornecedorPetrechos($idAtuacao, $idFornecedor);
        
        $this->_redirect('barcos/editar/id/'.$idBarco);
    }
    
    public function indexrelatorioAction() {

    }
    
    public function relatorioAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelBarco = new Application_Model_Barcos();
        $localBarco = $localModelBarco->select(NULL, array('bar_nome'), NULL);

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório Embarcações');
        $modeloRelatorio->setLegenda(30, 'Código');
        $modeloRelatorio->setLegenda(80, 'Embarcação');

        foreach ($localBarco as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['bar_id']);
            $modeloRelatorio->setValue(80, $localData['bar_nome']);
            $modeloRelatorio->setNewLine();
        }
        $modeloRelatorio->setNewLine();
	$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_embarcacoes.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
   }
}

