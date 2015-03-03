<?php

class FichaDiariaController extends Zend_Controller_Action {

    private $modelFichaDiaria;
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
        
        
        $this->modelMonitoramento = new Application_Model_Monitoramento();
        $this->modelFichaDiaria = new Application_Model_FichaDiaria();
        $this->modelPorto = new Application_Model_Porto();
        $this->modelTempo = new Application_Model_Tempo();
        $this->modelVento = new Application_Model_Vento();
        $this->modelArtePesca = new Application_Model_ArtePesca();
        $this->modelEstagiario = new Application_Model_Usuario();
        
        $this->modelArrastoFundo = new Application_Model_ArrastoFundo();
        $this->modelCalao = new Application_Model_Calao();
        $this->modelColetaManual = new Application_Model_ColetaManual();
        $this->modelEmalhe = new Application_Model_Emalhe();
        $this->modelGrosseira = new Application_Model_Grosseira();
        $this->modelJerere = new Application_Model_Jerere();
        $this->modelLinha = new Application_Model_Linha();
        $this->modelLinhaFundo = new Application_Model_LinhaFundo();
        $this->modelManzua = new Application_Model_Manzua();
        $this->modelMergulho = new Application_Model_Mergulho();
        $this->modelRatoeira = new Application_Model_Ratoeira();
        $this->modelSiripoia = new Application_Model_Siripoia();
        $this->modelTarrafa = new Application_Model_Tarrafa();
        $this->modelVaraPesca = new Application_Model_VaraPesca();
        
        
    }

    /*
     * Lista todas as artes de pesca
     */
    
    public function indexAction() {
        $fd_id = $this->_getParam("fd_id");
        $pto_id = $this->_getParam("pto_id");
        $fd_data = $this->_getParam("fd_data");
        $fd_all = $this->_getParam("fd_all");
        $fd_estagiario = $this->_getParam("fd_estagiario");
        $fd_monitor = $this->_getParam("fd_monitor");
        
        
        
        if ( $fd_id > 0 ) {
            $dados = $this->modelFichaDiaria->selectView("fd_id>=". $fd_id, array('fd_id'), 25);
        } 
        elseif ( $pto_id ) {
            $dados = $this->modelFichaDiaria->selectView("pto_nome ~*'".$pto_id."'" , NULL);
        }
        elseif ( $fd_data ) {
             $data = date('Y-m-d', strtotime($fd_data));
             $dados = $this->modelFichaDiaria->selectView("fd_data = '". $data."'" , NULL);            
        }
        elseif ( $fd_estagiario ) {
             $dados = $this->modelFichaDiaria->selectView("t_estagiario ~*'". $fd_estagiario."'" , NULL);            
        }
        elseif ( $fd_monitor ) {
             $dados = $this->modelFichaDiaria->selectView("t_monitor ~*'". $fd_monitor."'" , NULL);            
        }
        elseif($fd_all){
            $dados = $this->modelFichaDiaria->selectView(NULL, "fd_id DESC");  
        }
        else {
            $dados = $this->modelFichaDiaria->selectView(NULL, "fd_id DESC", 25);
        }
        
        
        $dadosPorto = $this->modelPorto->select();

        $this->view->assign("assignDadosPorto", $dadosPorto);
        $this->view->assign("dados", $dados);
    }

    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }
    /*
     * Exibe formulário para cadastro de um usuário
     */

    public function novoAction() {

        //------------------------------------------
        $dados = $this->modelFichaDiaria->select();

        $this->view->assign("dados", $dados);
        //--------------------------------------
        $porto = $this->modelPorto->select();

        $this->view->assign("dados_porto", $porto);
        //----------------------------------------
        $tempo = $this->modelTempo->select();

        $this->view->assign("dados_tempo", $tempo);
        //-------------------------------------------
        $vento = $this->modelVento->select();

        $this->view->assign("dados_vento", $vento);
        //-------------------------------------------
        
        $usuario = $this->modelEstagiario->select('tu_usuariodeletado = FALSE', 'tu_nome');

        $this->view->assign("users", $usuario);
        //--------------------------------------------
    }

    /*
     * Cadastra uma Arte de Pesca
     */

    public function criarAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idFichaDiaria = $this->modelFichaDiaria->insert($this->_getAllParams());
        
        
        $this->_redirect("/ficha-diaria/editar/id/" . $idFichaDiaria);
    }
    
    /*
     * Preenche um formulario com as informações de um usuário
     */

    public function editarAction() {

        $fichadiaria = $this->modelFichaDiaria->find($this->_getParam('id'));
        $this->naoexiste($fichadiaria);
        
        $this->view->assign("fichadiaria", $fichadiaria);
        //--------------------------------------
        $porto = $this->modelPorto->select(null, 'pto_id');

        $this->view->assign("dados_porto", $porto);
        //----------------------------------------
        $tempo = $this->modelTempo->select();

        $this->view->assign("dados_tempo", $tempo);
        //-------------------------------------------
        $vento = $this->modelVento->select();

        $this->view->assign("dados_vento", $vento);
        //-------------------------------------------
        $artePesca = $this->modelArtePesca->select(null, 'tap_artepesca');

        $this->view->assign("artesPesca", $artePesca);
        //---------------------------------------------
        $usuario = $this->modelEstagiario->select('tu_usuariodeletado = FALSE', 'tu_nome');

        $this->view->assign("users", $usuario);
        //--------------------------------------------
        
        $idFicha = $this->_getParam('id');
        
        $modelMonitoramentoByFichaDiaria = new Application_Model_Monitoramento();
        $vMonitoramento = $modelMonitoramentoByFichaDiaria->select("fd_id=". $idFicha, "mnt_id", null);
        $this->view->assign("vMonitoramento", $vMonitoramento);
        //--------------------------------------------------------------------------------------------
        $ArrastoFicha = $this->modelArrastoFundo->selectEntrevistaArrasto('fd_id='.$idFicha);
        $this->view->assign("arrastofundo", $ArrastoFicha);
        //--------------------------------------------------------------------------------------------
        $CalaoFicha = $this->modelCalao->selectEntrevistaCalao('fd_id='.$idFicha);
        $this->view->assign("calao", $CalaoFicha);
        //--------------------------------------------------------------------------------------------
        $ColetaManualFicha = $this->modelColetaManual->selectEntrevistaColetaManual('fd_id='.$idFicha);
        $this->view->assign("coletamanual", $ColetaManualFicha);
        //--------------------------------------------------------------------------------------------
        $EmalheFicha = $this->modelEmalhe->selectEntrevistaEmalhe('fd_id='.$idFicha);
        $this->view->assign("emalhe", $EmalheFicha);
        //--------------------------------------------------------------------------------------------
        $GrosseiraFicha = $this->modelGrosseira->selectEntrevistaGrosseira('fd_id='.$idFicha);
        $this->view->assign("grosseira", $GrosseiraFicha);
        //--------------------------------------------------------------------------------------------
        $JerereFicha = $this->modelJerere->selectEntrevistaJerere('fd_id='.$idFicha);
        $this->view->assign("jerere", $JerereFicha);
        //--------------------------------------------------------------------------------------------
        $LinhaFicha = $this->modelLinha->selectEntrevistaLinha('fd_id='.$idFicha);
        $this->view->assign("linha", $LinhaFicha);
        //--------------------------------------------------------------------------------------------
        $LinhaFundoFicha = $this->modelLinhaFundo->selectEntrevistaLinhaFundo('fd_id='.$idFicha);
        $this->view->assign("linhafundo", $LinhaFundoFicha);
         //--------------------------------------------------------------------------------------------
        $ManzuaFicha = $this->modelManzua->selectEntrevistaManzua('fd_id='.$idFicha);
        $this->view->assign("manzua", $ManzuaFicha);
         //--------------------------------------------------------------------------------------------
        $MergulhoFicha = $this->modelMergulho->selectEntrevistaMergulho('fd_id='.$idFicha);
        $this->view->assign("mergulho", $MergulhoFicha);
         //--------------------------------------------------------------------------------------------
        $RatoeiraFicha = $this->modelRatoeira->selectEntrevistaRatoeira('fd_id='.$idFicha);
        $this->view->assign("ratoeira", $RatoeiraFicha);
         //--------------------------------------------------------------------------------------------
        $SiripoiaFicha = $this->modelSiripoia->selectEntrevistaSiripoia('fd_id='.$idFicha);
        $this->view->assign("siripoia", $SiripoiaFicha);
         //--------------------------------------------------------------------------------------------
        $TarrafaFicha = $this->modelTarrafa->selectEntrevistaTarrafa('fd_id='.$idFicha);
        $this->view->assign("tarrafa", $TarrafaFicha);
         //--------------------------------------------------------------------------------------------
        $VaraPescaFicha = $this->modelVaraPesca->selectEntrevistaVaraPesca('fd_id='.$idFicha);
        $this->view->assign("varapesca", $VaraPescaFicha);
        
    }

    /*
     * Atualiza os dados do usuário
     */

    public function atualizarAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idFicha = $this->_getParam('id_fichaDiaria');
        $this->modelFichaDiaria->update($this->_getAllParams());

        $this->_redirect('/ficha-diaria/editar/id/'.$idFicha);
        
    }
    
    public function insertmonitoramentoAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        
        $Monitorada = $this->_getParam("SelectMonitorada");
        
        $idArtePesca = $this->_getParam("SelectArtePesca"); 

        $mnt_quantidade = $this->_getParam("QuantidadeEmbarcacoes");
        
        $idFicha = $this->_getParam("id_fichaDiaria");
        
        $backUrl = $this->_getParam("back_url");
       
        
        $this->modelMonitoramento->insert($idFicha, $idArtePesca, $mnt_quantidade, $Monitorada);

        $this->redirect("/ficha-diaria/editar/id/" . $backUrl);

        return;
    }
    public function deletmonitoramentoAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idMonitoramento = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelMonitoramento->delete($idMonitoramento);

        $this->redirect("/ficha-diaria/editar/id/" . $backUrl);
    }
    
    public function editarmonitoramentoAction(){
        
        $backUrl = $this->_getParam('id_ficha');
        
        $this->modelMonitoramento->update($this->_getAllParams());
        
        $this->redirect("/ficha-diaria/editar/id/".$backUrl);
    }
    public function monitoramentoAction(){
         $monitoramento = $this->_getParam('idmnt');
         $fichadiaria = $this->_getParam('id');
         
         $dadosMonitoramento = $this->modelMonitoramento->select('mnt_id = '.$monitoramento);
         $artepesca = $this->modelArtePesca->select("tap_arteficha <> '' ",'tap_id');
         
         $this->view->assign('fichadiaria', $fichadiaria);
         $this->view->assign('artepesca', $artepesca);
         $this->view->assign('monitoramento', $dadosMonitoramento[0]);
    }
    /*
     * 
     */

    public function excluirAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelFichaDiaria->delete($this->_getParam('id'));

        $this->_redirect('ficha-diaria/index');
    }
    
    public function imprimirfichatodasAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $this->relatorio_completo_pdf_ficha( NULL );
    }
    
    public function imprimirfichaidAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $tmpId = $this->_getParam('id');

        $this->relatorio_completo_pdf_ficha( 'fd_id = ' . $tmpId );
    }
   
    public function relatorio_completo_pdf_ficha( $where = null ) {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelFichaDiaria = new Application_Model_FichaDiaria();

        $localFichaDiaria = $localModelFichaDiaria->selectView( $where , array('fd_data', 'pto_nome'), NULL);
// 		$localFichaDiaria = $localModelFichaDiaria->selectView(null, array('fd_data', 'pto_nome'), NULL);

        $localModelMonitoramento = new Application_Model_Monitoramento();
        $localModelArrastoFundo = new Application_Model_ArrastoFundo();

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório de Ficha Diária');

        $modeloRelatorio->setLegendaOff();

        foreach ($localFichaDiaria as $key => $fd) {
            $modeloRelatorio->setLegValue(30, 'Ficha: ', $fd['fd_id']);
            $modeloRelatorio->setLegValue(100, 'Data: ', $fd['fd_data']);
            $modeloRelatorio->setLegValue(200, 'Porto: ', $fd['pto_nome']);
            $modeloRelatorio->setLegValue(320, 'Turno: ', $fd['fd_turno']);
            $modeloRelatorio->setLegValue(380, 'Tempo: ', $fd['tmp_estado']);
            $modeloRelatorio->setLegValue(480, 'Vento: ', $fd['vnt_forca']);
            $modeloRelatorio->setNewLine();
            $modeloRelatorio->setLegValue(30, 'Estagiario: ', $fd['t_estagiario']);
            $modeloRelatorio->setLegValue(320, 'Monitor: ', $fd['t_monitor']);
            $modeloRelatorio->setNewLine();

            $localMonitoramento = $localModelMonitoramento->select( "fd_id=". $fd['fd_id'], "mnt_id", NULL );
            foreach ($localMonitoramento as $key_m => $monitoramento) {
                $modeloRelatorio->setLegValue(60, 'Monitoramento: ', $monitoramento['mnt_id']);
                $modeloRelatorio->setLegValue(200, 'Arte: ', $monitoramento['tap_artepesca']);
                $localMon = 'Não';
                if ($monitoramento['mnt_monitorado']) {
                    $localMon = 'Sim';
                }
                $modeloRelatorio->setLegValue(320, 'Monitorado: ', $localMon);
                $modeloRelatorio->setLegValue(400, 'Quantidade: ', $monitoramento['mnt_quantidade']);
                $modeloRelatorio->setNewLine();
                
                if ($monitoramento['mnt_arte'] == 1 and $monitoramento['mnt_monitorado'] == TRUE) {
                    $localArrastoFunco = $localModelArrastoFundo->selectEntrevistaArrasto("mnt_id=" . $monitoramento['mnt_id'], array('af_id'), null);
                    foreach ($localArrastoFunco as $key_af => $arrastofundo) {
                        $modeloRelatorio->setLegValue(90, 'Entrevista: ', $arrastofundo['af_id']);
                        $modeloRelatorio->setLegValue(200, 'Mestre: ', $arrastofundo['tp_nome']);
                        $modeloRelatorio->setLegValue(400, 'Embarcação: ', $arrastofundo['bar_nome']);
                        $modeloRelatorio->setNewLine();
                        $localEmb = 'Não';
                        if ($arrastofundo['af_embarcado']) {
                            $localEmb = 'Sim';
                        }
                        $modeloRelatorio->setLegValue(90, 'Embarcado: ', $localEmb);
                        $modeloRelatorio->setLegValue(200, 'Pescadores: ', $arrastofundo['af_quantpescadores']);
                        $modeloRelatorio->setLegValue(320, 'Tipo barco: ', $arrastofundo['tte_tipoembarcacao']);
                        $localMotor = 'Não';
                        if ($arrastofundo['af_motor']) {
                            $localMotor = 'Sim';
                        }
                        $modeloRelatorio->setLegValue(480, 'Motor: ', $localMotor);
                        $modeloRelatorio->setNewLine();
                        $modeloRelatorio->setLegValue(90, 'Data/Hora saída: ', date_format(date_create($arrastofundo['af_dhsaida']), 'd/m/Y H:i'));
                        $modeloRelatorio->setLegValue(320, 'Data/Hora volta: ', date_format(date_create($arrastofundo['af_dhvolta']), 'd/m/Y H:i'));
                        $modeloRelatorio->setNewLine();
                        $modeloRelatorio->setLegValue(90, 'Alimento: ', $arrastofundo['af_alimento']);
                        $modeloRelatorio->setLegValue(200, 'Combustível: ', $arrastofundo['af_diesel']);
                        $modeloRelatorio->setLegValue(320, 'Óleo: ', $arrastofundo['af_oleo']);
                        $modeloRelatorio->setLegValue(400, 'Gelo: ', $arrastofundo['af_gelo']);
                        $modeloRelatorio->setNewLine();
                        $modeloRelatorio->setLegValue(90, 'Observações: ', $arrastofundo['af_obs']);
                        $modeloRelatorio->setNewLine();
                        
                        $localArrastoFundoPesqueiro = $localModelArrastoFundo->selectArrastoHasPesqueiro("af_id=".$arrastofundo['af_id'], null, null);
                        if ( sizeof($localArrastoFundoPesqueiro) > 0) {
							$modeloRelatorio->setLegValue(120, 'Tempo no pesqueiro(hora:min.)', '');
							$modeloRelatorio->setLegValue(270, 'Pesqueiro', '');
                            $modeloRelatorio->setNewLine();
                        }
                        foreach ($localArrastoFundoPesqueiro as $key_p => $pesqueiro) {
                            $modeloRelatorio->setValue(120, date_format(date_create($pesqueiro['t_tempopesqueiro']), 'H:i'));
                            $modeloRelatorio->setValue(270, $pesqueiro['paf_pesqueiro']);
                            $modeloRelatorio->setNewLine();
                        }
                        
                        $localArrastoFundoEspecie = $localModelArrastoFundo->selectArrastoHasEspCapturadas("af_id=".$arrastofundo['af_id'], null, null);
                        if (sizeof($localArrastoFundoEspecie) > 0) {
							$modeloRelatorio->setLegValue(120, 'Espécie capturada ', '');
                            $modeloRelatorio->setLegAlinhadoDireita(310, 40, 'Quantidade ');
                            $modeloRelatorio->setLegAlinhadoDireita(360, 90, 'Peso(kg) ');
                            $modeloRelatorio->setLegAlinhadoDireita(480, 90, 'Preço(R$/kg) ');
                            $modeloRelatorio->setNewLine();
                        }
                        foreach ($localArrastoFundoEspecie as $key_ep => $especie) {
                            $modeloRelatorio->setValue(120, $especie['esp_nome_comum']);
                            $modeloRelatorio->setValueAlinhadoDireita(310, 40, $especie['spc_quantidade']);
                            $modeloRelatorio->setValueAlinhadoDireita(360, 90, number_format($especie['spc_peso_kg'], 2, ',', ' '));
                            $modeloRelatorio->setValueAlinhadoDireita(480, 90, number_format($especie['spc_preco'], 2, ',', ' '));
                            
                            $modeloRelatorio->setNewLine();
                        }
                        
                        $localArrastoFundoAvistamento = $localModelArrastoFundo->selectArrastoHasAvistamento("af_id=".$arrastofundo['af_id'], null, null);
                        if ( sizeof($localArrastoFundoAvistamento) > 0 ) {
							$modeloRelatorio->setLegValue(120, 'Avistamento', '');
							$modeloRelatorio->setNewLine();
                        }
                        foreach ($localArrastoFundoAvistamento as $key_avs => $avistamento) {
                            $modeloRelatorio->setValue(120, $avistamento['avs_descricao']);
                            $modeloRelatorio->setNewLine();
                        }
                        $modeloRelatorio->setNewLine();
                    }
                }                    
            }

            $modeloRelatorio->setNewLine();
            $modeloRelatorio->setNewLine();
        }
        $pdf = $modeloRelatorio->getRelatorio();

         header('Content-Disposition: attachment;filename="rel_ficha_diaria.pdf"');
         header("Content-type: application/x-pdf");
         echo $pdf->render();
//		header("Content-Type: application/pdf");
//		echo $pdf->render();
    }

}
