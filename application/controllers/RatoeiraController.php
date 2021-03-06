<?php

class RatoeiraController extends Zend_Controller_Action
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

        $this->modelDestinoPescado = new Application_Model_DestinoPescado();
        $this->modelAvistamento = new Application_Model_Avistamento();
        $this->modelRatoeira = new Application_Model_Ratoeira();
        $this->modelMonitoramento = new Application_Model_Monitoramento();
        $this->modelFichaDiaria = new Application_Model_FichaDiaria();
        $this->modelPescador = new Application_Model_Pescador();
        $this->modelBarcos = new Application_Model_Barcos();
        $this->modelTipoEmbarcacao = new Application_Model_TipoEmbarcacao();
        $this->modelPesqueiro = new Application_Model_Pesqueiro();
        $this->modelEspecie = new Application_Model_Especie();
        $this->modelMare = new Application_Model_Mare();
        $this->modelIsca = new Application_Model_Isca();
        $this->modelTipoVenda = new Application_Model_TipoVenda();
        $this->modelMaturidade = new Application_Model_Maturidade();
    }

    public function indexAction()
    {
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $barcos = $this->modelBarcos->select(null, 'bar_nome');
        $tipoEmbarcacoes = $this->modelTipoEmbarcacao->select(null, 'tte_tipoembarcacao');
        $pesqueiros = $this->modelPesqueiro->select(null, 'paf_pesqueiro');
        $especies = $this->modelEspecie->select(null, 'esp_nome');
        $mare = $this->modelMare->select();
        $destinos = $this->modelDestinoPescado->select(null, 'dp_destino');
        $monitoramento = $this->modelMonitoramento->find($this->_getParam("idMonitoramento"));
        $this->naoexiste($monitoramento);
        $fichadiaria = $this->modelFichaDiaria->find($this->_getParam('id'));
        $this->naoexiste($fichadiaria);
        
        $this->view->assign('destinos', $destinos);
        $this->view->assign('fichaDiaria', $fichadiaria);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('mare', $mare);
        $this->view->assign('pescadores',$pescadores);
        $this->view->assign('barcos',$barcos);
        $this->view->assign('tipoEmbarcacoes',$tipoEmbarcacoes);
        $this->view->assign('pesqueiros',$pesqueiros);
        $this->view->assign('especies',$especies);

        $idBarco = $this->_getParam('bar_id');
        if($idBarco){
            $this->redirect('ratoeira/pescadores/id/'.$fichadiaria['fd_id'].'/idMonitoramento/'.$monitoramento['fd_id'].'/bar_id/'.$idBarco);
        }
    }
    public function acesso(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
    }
    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }
    
    public function visualizarAction() {
        $ent_id = $this->_getParam("ent_id");
        $ent_pescador = $this->_getParam("tp_nome");
        $ent_barco = $this->_getParam("bar_nome");
        $ent_apelido = $this->_getParam("tp_apelido");
        $ent_all = $this->_getParam("ent_all");
        
        $orderby = $this->_getParam("orderby");
        if(empty($orderby)){
            $orderby = 'rat_id DESC';
        }
        if ($ent_id > 0) {
            $dados = $this->modelRatoeira->selectEntrevistaRatoeira("rat_id =" . $ent_id);
        } elseif ($ent_pescador) {
            $dados = $this->modelRatoeira->selectEntrevistaRatoeira("tp_nome ~* '" . $ent_pescador . "'", $orderby);
        } elseif ($ent_barco) {
            $dados = $this->modelRatoeira->selectEntrevistaRatoeira("bar_nome ~* '" . $ent_barco . "'", $orderby);
        }
        elseif ($ent_apelido){
            $dados = $this->modelRatoeira->selectEntrevistaRatoeira("tp_apelido ~* '" . $ent_apelido . "'", $orderby, 20);
        }
        elseif($ent_all){
            $dados = $this->modelRatoeira->selectEntrevistaRatoeira(null, $orderby);
        }
        else {
            $dados = $this->modelRatoeira->selectEntrevistaRatoeira(null, $orderby,200);
        }

        $this->view->assign("dados", $dados);
    }

    public function editarAction(){
        $this->acesso();
        $entrevista = $this->modelRatoeira->find($this->_getParam('id'));
        $this->naoexiste($entrevista);
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $barcos = $this->modelBarcos->select(null, 'bar_nome');
        $tipoEmbarcacoes = $this->modelTipoEmbarcacao->select(null, 'tte_tipoembarcacao');
        $pesqueiros = $this->modelPesqueiro->select(null, 'paf_pesqueiro');
        $especies = $this->modelEspecie->select(null, 'esp_nome_comum');
        $especiesCamarao = $this->modelEspecie->select('gen_id = 99 or gen_id = 100 or gen_id = 101');
        $monitoramento = $this->modelMonitoramento->find($entrevista['mnt_id']);
        $avistamentos = $this->modelAvistamento->select(null, 'avs_descricao');
        $mare = $this->modelMare->select();
        $destinos = $this->modelDestinoPescado->select(null, 'dp_destino');
        $tipoVenda = $this->modelTipoVenda->select(null, 'ttv_tipovenda');
        $porto = $this->modelRatoeira->selectEntrevistaRatoeira($entrevista['rat_id'].'= rat_id');
        
        $idEntrevista = $this->_getParam('id');
        $datahoraSaida[] = explode(" ",$entrevista['rat_dhsaida']);
        $datahoraVolta[] = explode(" ",$entrevista['rat_dhvolta']);

        $vRatoeira = $this->modelRatoeira->selectRatoeiraHasPesqueiro('rat_id='.$idEntrevista);

        $vEspecieCapturadas = $this->modelRatoeira->selectRatoeiraHasEspCapturadas('rat_id='.$idEntrevista);

        $vRatoeiraAvistamento = $this->modelRatoeira->selectRatoeiraHasAvistamento('rat_id='.$idEntrevista);
        $vBioCamarao = $this->modelRatoeira->selectVBioCamarao('trat_id='.$idEntrevista);
        $vBioPeixe = $this->modelRatoeira->selectVBioPeixe('trat_id='.$idEntrevista);
        $maturidade = $this->modelMaturidade->select(null, 'tmat_tipo');
        
        
        $this->view->assign('vBioCamarao', $vBioCamarao);
        $this->view->assign('vBioPeixe', $vBioPeixe);
        $this->view->assign('maturidade', $maturidade);
        $this->view->assign('destinos', $destinos);
        $this->view->assign('especieCamarao', $especiesCamarao);
        $this->view->assign('avistamentos', $avistamentos);
        $this->view->assign('vRatoeiraAvistamento', $vRatoeiraAvistamento);
        $this->view->assign('mare', $mare);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('vEspecieCapturadas', $vEspecieCapturadas);
        $this->view->assign('vRatoeira', $vRatoeira);
        $this->view->assign("entrevista", $entrevista);
        $this->view->assign('dataSaida', $datahoraSaida[0][0]);
        $this->view->assign('horaSaida', $datahoraSaida[0][1]);
        $this->view->assign('dataVolta', $datahoraVolta[0][0]);
        $this->view->assign('horaVolta', $datahoraVolta[0][1]);
        $this->view->assign('pescadores',$pescadores);
        $this->view->assign('barcos',$barcos);
        $this->view->assign('tipoEmbarcacoes',$tipoEmbarcacoes);
        $this->view->assign('pesqueiros',$pesqueiros);
        $this->view->assign('especies',$especies);
        $this->view->assign('tipovenda', $tipoVenda);
        $this->view->assign('porto', $porto[0]);
    }
    public function criarAction(){
        $this->acesso();
        $idRatoeira = $this->modelRatoeira->insert($this->_getAllParams());


        $this->_redirect('ratoeira/editar/id/'.$idRatoeira);
    }
    
    public function pescadoresAction(){
        
        $this->_helper->layout->disableLayout();
        $idBarco = $this->_getParam('bar_id');

        $pescadores = $this->modelRatoeira->selectPescadoresByBarco('bar_id = '.$idBarco, 'tp_nome');
        if(empty($pescadores)){
            $pescadores = $this->modelPescador->select(null, 'tp_nome');
        }
        
        //print_r($idBarco);
        $this->view->assign('pescadores', $pescadores);
    }
    public function atualizarAction(){
        $this->acesso();
        $idRatoeira = $this->_getParam('id_entrevista');
        $monitoramento = $this->modelMonitoramento->select('mnt_id='.$this->_getParam('id_monitoramento'));
        
        
        if($monitoramento[0]['fd_id'] != $this->_getParam('id_fichaDiaria')){
            $this->_redirect('arrasto-fundo/error');  
        }
        else{
            $this->modelRatoeira->update($this->_getAllParams());
            $this->_redirect('ratoeira/editar/id/'.$idRatoeira);
        }
    }
    public function excluirAction() {
        $this->acesso();
        $this->modelRatoeira->delete($this->_getParam('id'));

        $idFicha = $this->_getParam('id_ficha');
        if(empty($idFicha)){
            $this->_redirect('ratoeira/visualizar');
        }
        else{
            $this->_redirect('ficha-diaria/editar/id/'.$idFicha);
        }
    }
    public function tablepesqueiroAction(){//Action para tablepesqueiro
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelRatoeira->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vRatoeira = $this->modelRatoeira->selectRatoeiraHasPesqueiro('rat_id=' . $idEntrevista);
        $this->view->assign('vRatoeira', $vRatoeira);
    }
    public function insertpesqueiroAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $pesqueiro = $this->_getParam("nomePesqueiro");

        $tempoapesqueiro = $this->_getParam("tempoAPesqueiro");

        $distanciapesqueiro = $this->_getParam("distAPesqueiro");

        $idEntrevista = $this->_getParam("id_entrevista");

        //$backUrl = $this->_getParam("back_url");


        $this->modelRatoeira->insertPesqueiro($idEntrevista, $pesqueiro, $tempoapesqueiro, $distanciapesqueiro);

        $this->redirect("/ratoeira/tablepesqueiro/id/" . $idEntrevista);
    }
    public function updatepesqueiroAction() {
        if ($this->usuario['tp_id'] == 5) {
        $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $pesqueiro = $this->_getParam("nomePesqueiro");
        $tempoapesqueiro = $this->_getParam("tempoAPesqueiro");
        if(empty($tempoapesqueiro)){
        $tempoapesqueiro=null;
        }
        $distanciapesqueiro = $this->_getParam("distAPesqueiro");
        if(empty($distanciapesqueiro)){
        $distanciapesqueiro=null;
        }
        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaPesqueiro = $this->_getParam("idPesqueiro");
        $this->modelRatoeira->updatePesqueiro($idEntrevistaPesqueiro, $idEntrevista, $pesqueiro, $tempoapesqueiro, $distanciapesqueiro);
        $this->redirect("/ratoeira/tablepesqueiro/id/" . $idEntrevista);
        }
    public function deletepesqueiroAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasPesqueiro = $this->_getParam("id_entrevista_has_pesqueiro");

        //$backUrl = $this->_getParam("back_url");

        $this->modelRatoeira->deletePesqueiro($idEntrevistaHasPesqueiro);

        $this->redirect("/ratoeira/tablepesqueiro/id/" . $idEntrevista);//
        //$this->redirect("/ratoeira/editar/id/" . $backUrl);
    }
    
    public function mediaespeciesAction(){
        $this->_helper->layout->disableLayout();
        $especie = $this->_getParam("esp_id");

        //$arrayMedias = $this->modelArrastoFundo->selectMediaEspecies();
        $arrayMedia = $this->modelRatoeira->selectMediaEspecies('esp_id = '.$especie);
        if(empty($arrayMedia[0]['max_permitido_quantidade'])){
            $arrayMedia[0]['max_permitido_quantidade'] = 0;
        }
        $this->view->assign("media", intval($arrayMedia[0]['max_permitido_quantidade']));
    }
    public function verificaespecieAction(){
         if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $especie = $this->_getParam("selectEspecie");
        
        $this->redirect("/ratoeira/mediaespecies/esp_id/" . $especie);
    }
    public function tableespcapturaAction(){ //ACTION PARA REDIRECIONAR SEM LAYOUT
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelRatoeira->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vEspecieCapturadas = $this->modelRatoeira->selectRatoeiraHasEspCapturadas('rat_id=' . $idEntrevista);
    
        $this->view->assign('vEspecieCapturadas', $vEspecieCapturadas);
    }
    public function insertespeciecapturadaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $especie = $this->_getParam("selectEspecie");

        $quantidade = $this->_getParam("quantidade");

        $peso = $this->_getParam("peso");

        $preco = $this->_getParam("precokg");

        $idEntrevista = $this->_getParam("id_entrevista");

        //$backUrl = $this->_getParam("back_url");

        $idTipoVenda =  $this->_getParam("id_tipovenda");

        $this->modelRatoeira->insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $preco, $idTipoVenda);

        $this->redirect("/ratoeira/tableespcaptura/id/" . $idEntrevista);
    }
    public function deletespecieAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasEspecie = $this->_getParam("id_entrevista_has_especie");

        //$backUrl = $this->_getParam("back_url");

        $this->modelRatoeira->deleteEspCapturada($idEntrevistaHasEspecie);

        $this->redirect("/ratoeira/tableespcaptura/id/" . $idEntrevista);
        //$this->redirect("/ratoeira/editar/id/" . $backUrl);
    }
    
    public function updateespeciecapturadaAction() {
        if ($this->usuario['tp_id'] == 5) {
        $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $especie = $this->_getParam("selectEspecie");
        $quantidade = $this->_getParam("quantidade");
        $peso = $this->_getParam("peso");
        $preco = $this->_getParam("precokg");
        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaEspecie = $this->_getParam("idRelacao");
        $this->modelRatoeira->updateEspCapturada($idEntrevistaEspecie,$idEntrevista, $especie, $quantidade, $peso, $preco);
        $this->redirect("/ratoeira/tableespcaptura/id/" . $idEntrevista);
    }

    
    public function tableavistamentoAction(){ //ACTION PARA REDIRECIONAR SEM LAYOUT
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelRatoeira->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vRatoeiraAvistamento = $this->modelRatoeira->selectRatoeiraHasAvistamento('rat_id='.$idEntrevista);

        $this->view->assign('vRatoeiraAvistamento', $vRatoeiraAvistamento);
    }
    public function insertavistamentoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $avistamento = $this->_getParam("SelectAvistamento");

        $idEntrevista = $this->_getParam("id_entrevista");

        $this->modelRatoeira->insertAvistamento($idEntrevista, $avistamento);

        $this->redirect("/ratoeira/tableavistamento/id/" . $idEntrevista);
    }
    public function deleteavistamentoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasAvistamento = $this->_getParam("id_entrevista_has_avistamento");
        
        $this->modelRatoeira->deleteAvistamento($idEntrevistaHasAvistamento, $idEntrevista);

        $this->redirect("/ratoeira/tableavistamento/id/" . $idEntrevista);
    }
    
    public function tablebiocamaraoAction(){//Action para tablepesqueiro
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelRatoeira->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vBioCamarao = $this->modelRatoeira->selectVBioCamarao('trat_id='.$idEntrevista);
        
        $this->view->assign('vBioCamarao', $vBioCamarao);
    }
    public function insertbiocamaraoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEntrevista = $this->_getParam("id");
        
        $idEspecie  = $this->_getParam("SelectEspecie");
        
        $sexo = $this->_getParam("SelectSexo");

        $maturidade = $this->_getParam("SelectMaturidade");

        $compCabeca = $this->_getParam("comprimentoCabeca");
        
        $peso = $this->_getParam("peso");

        $this->modelRatoeira->insertBioCamarao($idEntrevista, $idEspecie, $sexo, $maturidade, $compCabeca, $peso);

        $this->redirect("/ratoeira/tablebiocamarao/id/" . $idEntrevista);
    }
    public function updatebiocamaraoAction() {
        if ($this->usuario['tp_id'] == 5) {
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $idRelacao = $this->_getParam("idRelacaoBioCamarao");
        $idEntrevista = $this->_getParam("id");
        $idEspecie = $this->_getParam("SelectEspecie");
        $sexo = $this->_getParam("SelectSexo");
        $maturidade = $this->_getParam("SelectMaturidade");
        $compCabeca = $this->_getParam("comprimentoCabeca");
        $peso = $this->_getParam("peso");
//$backUrl = $this->_getParam("back_url");
        $this->modelRatoeira->updateBioCamarao($idRelacao, $idEntrevista, $idEspecie, $sexo, $maturidade, $compCabeca, $peso);
//$this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
        $this->redirect("/ratoeira/tablebiocamarao/id/" . $idEntrevista);
    }
    public function deletebiocamaraoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasBioCamarao = $this->_getParam("id_entrevista_has_biocamarao");

        $this->modelRatoeira->deleteBioCamarao($idEntrevistaHasBioCamarao);

        $this->redirect("/ratoeira/tablebiocamarao/id/" . $idEntrevista);
    }
    
    public function tablebiopeixeAction(){ //ACTION PARA REDIRECIONAR SEM LAYOUT
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelRatoeira->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vBioPeixe = $this->modelRatoeira->selectVBioPeixe('trat_id='.$idEntrevista);

        $this->view->assign('vBioPeixe', $vBioPeixe);
    }
    public function insertbiopeixeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEntrevista = $this->_getParam("id");
        
        $idEspecie  = $this->_getParam("SelectEspecie");
        
        $sexo = $this->_getParam("SelectSexo");

        $comprimento = $this->_getParam("comprimento");
        
        $peso = $this->_getParam("peso");

        $this->modelRatoeira->insertBioPeixe($idEntrevista, $idEspecie, $sexo, $comprimento, $peso);

        $this->redirect("/ratoeira/tablebiopeixe/id/" . $idEntrevista);
    }
    public function deletebiopeixeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasBioPeixe = $this->_getParam("id_entrevista_has_biopeixe");

        $this->modelRatoeira->deleteBioPeixe($idEntrevistaHasBioPeixe);

        $this->redirect("/ratoeira/tablebiopeixe/id/" . $idEntrevista);
    }
    
    public function updatebiopeixeAction() {
        if($this->usuario['tp_id']==5){
        $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $idEntrevista = $this->_getParam("id");
        $idEspecie = $this->_getParam("SelectEspecie");
        $sexo = $this->_getParam("SelectSexo");
        $comprimento = $this->_getParam("comprimento");
        $peso = $this->_getParam("peso");
        $idEntrevistaPeixe = $this->_getParam("idRelacaoBioPeixe");
        $this->modelRatoeira->updateBioPeixe($idEntrevistaPeixe,$idEntrevista, $idEspecie, $sexo, $comprimento, $peso);
        //$this->redirect("/ratoeira/editar/id/" . $backUrl);
        $this->redirect("/ratoeira/tablebiopeixe/id/" . $idEntrevista);
    }

    public function relatoriolistaAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelRatoeira = new Application_Model_Ratoeira();
		$localRatoeira = $localModelRatoeira->selectEntrevistaRatoeira(NULL, array('fd_id', 'mnt_id', 'rat_id'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Ratoeira');
		$modeloRelatorio->setLegenda(30, 'Ficha');
		$modeloRelatorio->setLegenda(80, 'Monit.');
		$modeloRelatorio->setLegenda(130, 'Ratoeira');
		$modeloRelatorio->setLegenda(180, 'Pescador');
		$modeloRelatorio->setLegenda(350, 'Embarcação');

		foreach ( $localRatoeira as $key => $localData ) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['fd_id']);
			$modeloRelatorio->setValueAlinhadoDireita(80, 40, $localData['mnt_id']);
			$modeloRelatorio->setValueAlinhadoDireita(130, 40, $localData['rat_id']);
			$modeloRelatorio->setValue(180, $localData['tp_nome']);
			$modeloRelatorio->setValue(350, $localData['bar_nome']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_lista_entrevista_ratoeira.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
    }

   public function relatorioAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelRatoeira = new Application_Model_Ratoeira();
		$localRatoeira = $localModelRatoeira->selectEntrevistaRatoeira(NULL, array('fd_id', 'mnt_id', 'rat_id'), NULL);

		$localPesqueiro = $localModelRatoeira->selectRatoeiraHasPesqueiro(NULL, array('rat_id', 'paf_pesqueiro'), NULL);
		$localEspecie = $localModelRatoeira->selectRatoeiraHasEspCapturadas(NULL, array('rat_id', 'esp_nome_comum'), NULL);
		$localAvist = $localModelRatoeira->selectRatoeiraHasAvistamento(NULL, array('rat_id', 'avs_descricao'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Ratoeira');
		$modeloRelatorio->setLegendaOff();

		foreach ( $localRatoeira as $key => $localData ) {
			$modeloRelatorio->setLegValueAlinhadoDireita(30, 60, 'Ficha:', $localData['fd_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(90, 60, 'Monit.:',  $localData['mnt_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(150, 70, 'Ratoeira:', $localData['rat_id']);
			$modeloRelatorio->setLegValue(220, 'Pescador: ', $localData['tp_nome']);
			$modeloRelatorio->setLegValue(450, 'Barco: ', $localData['bar_nome']);
			$modeloRelatorio->setNewLine();

			foreach ( $localPesqueiro as $key => $localDataPesqueiro ) {
				if ( $localDataPesqueiro['rat_id'] ==  $localData['rat_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Pesqueiro: ',  $localDataPesqueiro['paf_pesqueiro']);
					if($localDataPesqueiro['t_tempoapesqueiro'] !== NULL){
						$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Tempo (H:M):', date_format(date_create($localDataPesqueiro['t_tempoapesqueiro']), 'H:i'));
					}
					else{
						$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Tempo (H:M):', "00:00", 'H:i');
					}
					$modeloRelatorio->setLegValueAlinhadoDireita(450, 120, 'Distância:', number_format($localDataPesqueiro['t_distapesqueiro'], 2, ',', ' '));
					$modeloRelatorio->setNewLine();
				}
			}
			foreach ( $localEspecie as $key => $localDataEspecie ) {
				if ( $localDataEspecie['rat_id'] ==  $localData['rat_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Espécie: ',  $localDataEspecie['esp_nome_comum']);
					$modeloRelatorio->setLegValueAlinhadoDireita(280, 60, 'Quant:', $localDataEspecie['spc_quantidade']);
					$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Peso(kg):', number_format($localDataEspecie['spc_peso_kg'], 2, ',', ' '));
					$modeloRelatorio->setLegValueAlinhadoDireita(450, 120, 'Preço(R$/kg):', number_format($localDataEspecie['spc_preco'], 2, ',', ' '));
					$modeloRelatorio->setNewLine();
				}
			}
			foreach ( $localAvist as $key => $localDataAvist ) {
				if ( $localDataAvist['rat_id'] ==  $localData['rat_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Avist.: ',  $localDataAvist['avs_descricao']);
					$modeloRelatorio->setNewLine();
				}
			}
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_entrevista_ratoeira.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }
}
