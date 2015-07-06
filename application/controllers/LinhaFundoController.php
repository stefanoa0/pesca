<?php

class LinhaFundoController extends Zend_Controller_Action
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
        $this->modelLinhaFundo = new Application_Model_LinhaFundo();
        $this->modelMonitoramento = new Application_Model_Monitoramento();
        $this->modelFichaDiaria = new Application_Model_FichaDiaria();;
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
    public function acesso(){
        if($this->usuario['tp_id'] == 5){
            $this->_redirect('index');
        }
    }
    public function indexAction()
    {
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $barcos = $this->modelBarcos->select(null, 'bar_nome');
        $tipoEmbarcacoes = $this->modelTipoEmbarcacao->select(null, 'tte_tipoembarcacao');
        $pesqueiros = $this->modelPesqueiro->select(null, 'paf_pesqueiro');
        $especies = $this->modelEspecie->select(null, 'esp_nome');
        $mare = $this->modelMare->select();
        $isca = $this->modelIsca->select(null, 'isc_tipo');
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
        $this->view->assign('iscas', $isca);
        
        $idBarco = $this->_getParam('bar_id');
        if($idBarco){
            $this->redirect('linha-fundo/pescadores/id/'.$fichadiaria['fd_id'].'/idMonitoramento/'.$monitoramento['fd_id'].'/bar_id/'.$idBarco);
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
            $orderby = 'lf_id DESC';
        }        
        if ($ent_id > 0) {
            $dados = $this->modelLinhaFundo->selectEntrevistaLinhaFundo("lf_id =" . $ent_id);
        } elseif ($ent_pescador) {
            $dados = $this->modelLinhaFundo->selectEntrevistaLinhaFundo("tp_nome ~* '" . $ent_pescador . "'", $orderby);
        } elseif ($ent_barco) {
            $dados = $this->modelLinhaFundo->selectEntrevistaLinhaFundo("bar_nome ~* '" . $ent_barco . "'", $orderby);
       }
        elseif ($ent_apelido){
            $dados = $this->modelLinhaFundo->selectEntrevistaLinhaFundo("tp_apelido ~* '" . $ent_apelido . "'", $orderby, 20);
        }
        elseif($ent_all){
            $dados = $this->modelLinhaFundo->selectEntrevistaLinhaFundo(null, $orderby);
        }
        else {
            $dados = $this->modelLinhaFundo->selectEntrevistaLinhaFundo(null, $orderby,200);
        }

        $this->view->assign("dados", $dados);
    }

    public function editarAction(){
        $this->acesso();
         //$avistamentoLinhaFundo = new Application_Model_DbTable_VLinhaFundoHasAvistamento();
        $entrevista = $this->modelLinhaFundo->find($this->_getParam('id'));
        $this->naoexiste($entrevista);
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $barcos = $this->modelBarcos->select(null, 'bar_nome');
        $tipoEmbarcacoes = $this->modelTipoEmbarcacao->select(null, 'tte_tipoembarcacao');
        $pesqueiros = $this->modelPesqueiro->select(null, 'paf_pesqueiro');
        $especies = $this->modelEspecie->select(null, 'esp_nome_comum');
        $especiesCamarao = $this->modelEspecie->select('gen_id = 99 or gen_id = 100 or gen_id = 101');
        $monitoramento = $this->modelMonitoramento->find($entrevista['mnt_id']);
        $avistamentos = $this->modelAvistamento->select(null, 'avs_descricao');
        $iscas = $this->modelIsca->select(null, 'isc_tipo');
        $mare = $this->modelMare->select();
        $destinos = $this->modelDestinoPescado->select(null, 'dp_destino');
        $tipoVenda = $this->modelTipoVenda->select(null, 'ttv_tipovenda');
        $porto = $this->modelLinhaFundo->selectEntrevistaLinhaFundo($entrevista['lf_id'].'= lf_id');
        
        $idEntrevista = $this->_getParam('id');
        $datahoraSaida[] = explode(" ",$entrevista['lf_dhsaida']);
        $datahoraVolta[] = explode(" ",$entrevista['lf_dhvolta']);

        $vLinhaFundo = $this->modelLinhaFundo->selectLinhaFundoHasPesqueiro('lf_id='.$idEntrevista);

        $vEspecieCapturadas = $this->modelLinhaFundo->selectLinhaFundoHasEspCapturadas('lf_id='.$idEntrevista);

        $vLinhaFundoAvistamento = $this->modelLinhaFundo->selectLinhaFundoHasAvistamento('lf_id='.$idEntrevista);
        $vBioCamarao = $this->modelLinhaFundo->selectVBioCamarao('tlf_id='.$idEntrevista);
        $vBioPeixe = $this->modelLinhaFundo->selectVBioPeixe('tlf_id='.$idEntrevista);
        $maturidade = $this->modelMaturidade->select(null, 'tmat_tipo');
        
        
        $this->view->assign('vBioCamarao', $vBioCamarao);
        $this->view->assign('vBioPeixe', $vBioPeixe);
        $this->view->assign('maturidade', $maturidade);
        $this->view->assign('destinos', $destinos);
        $this->view->assign('especieCamarao', $especiesCamarao);
        $this->view->assign('avistamentos', $avistamentos);
        $this->view->assign('vLinhaFundoAvistamento', $vLinhaFundoAvistamento);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('vEspecieCapturadas', $vEspecieCapturadas);
        $this->view->assign('vLinhaFundo', $vLinhaFundo);
        $this->view->assign("entrevista", $entrevista);
        $this->view->assign("iscas", $iscas);
        $this->view->assign("mare", $mare);
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
        $idLinhaFundo = $this->modelLinhaFundo->insert($this->_getAllParams());


        $this->_redirect('linha-fundo/editar/id/'.$idLinhaFundo);
    }
    
    public function pescadoresAction(){
        
        $this->_helper->layout->disableLayout();
        $idBarco = $this->_getParam('bar_id');

        $pescadores = $this->modelLinhaFundo->selectPescadoresByBarco('bar_id = '.$idBarco, 'tp_nome');
        if(empty($pescadores)){
            $pescadores = $this->modelPescador->select(null, 'tp_nome');
        }
        
        //print_r($idBarco);
        $this->view->assign('pescadores', $pescadores);
    }

    public function atualizarAction(){
        $this->acesso();
        $idLinhaFundo = $this->_getParam('id_entrevista');
        $monitoramento = $this->modelMonitoramento->select('mnt_id='.$this->_getParam('id_monitoramento'));
        
        
        if($monitoramento[0]['fd_id'] != $this->_getParam('id_fichaDiaria')){
            $this->_redirect('arrasto-fundo/error');  
        }
        else{
            $this->modelLinhaFundo->update($this->_getAllParams());
            $this->_redirect('linha-fundo/editar/id/'.$idLinhaFundo);
        }
    }

    public function excluirAction() {
        $this->acesso();
        $this->modelLinhaFundo->delete($this->_getParam('id'));

        $idFicha = $this->_getParam('id_ficha');
        if(empty($idFicha)){
            $this->_redirect('linha-fundo/visualizar');
        }
        else{
            $this->_redirect('ficha-diaria/editar/id/'.$idFicha);
        }
    }
    
    public function tablepesqueiroAction(){//Action para tablepesqueiro
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelLinhaFundo->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vLinhaFundo = $this->modelLinhaFundo->selectLinhaFundoHasPesqueiro('lf_id=' . $idEntrevista);
        $this->view->assign('vLinhaFundo', $vLinhaFundo);
    }
    public function insertpesqueiroAction(){
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $pesqueiro = $this->_getParam("nomePesqueiro");

        $tempoapesqueiro = $this->_getParam("tempoAPesqueiro");

        $distanciapesqueiro = $this->_getParam("distAPesqueiro");

        $idEntrevista = $this->_getParam("id_entrevista");

        //$backUrl = $this->_getParam("back_url");
        $this->modelLinhaFundo->insertPesqueiro($idEntrevista, $pesqueiro, $tempoapesqueiro, $distanciapesqueiro);

        $this->redirect("/linha-fundo/tablepesqueiro/id/" . $idEntrevista);
    }
    public function deletepesqueiroAction(){
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasPesqueiro = $this->_getParam("id_entrevista_has_pesqueiro");

        //$backUrl = $this->_getParam("back_url");

        $this->modelLinhaFundo->deletePesqueiro($idEntrevistaHasPesqueiro);

        $this->redirect("/linha-fundo/tablepesqueiro/id/" . $idEntrevista);
        //$this->redirect("/linha-fundo/editar/id/" . $backUrl);
    }
    public function mediaespeciesAction(){
        $this->_helper->layout->disableLayout();
        $especie = $this->_getParam("esp_id");

        //$arrayMedias = $this->modelArrastoFundo->selectMediaEspecies();
        $arrayMedia = $this->modelLinhaFundo->selectMediaEspecies('esp_id = '.$especie);
        if(empty($arrayMedia[0]['max_permitido_peso'])){
            $arrayMedia[0]['max_permitido_peso'] = -1;
        }
        $this->view->assign("media", intval($arrayMedia[0]['max_permitido_peso']));
    }
    public function verificaespecieAction(){
         if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $especie = $this->_getParam("selectEspecie");
        
        $this->redirect("/linha-fundo/mediaespecies/esp_id/" . $especie);
    }
    public function tableespcapturaAction(){ //ACTION PARA REDIRECIONAR SEM LAYOUT
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelLinhaFundo->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vEspecieCapturadas = $this->modelLinhaFundo->selectLinhaFundoHasEspCapturadas('lf_id=' . $idEntrevista);
    
        $this->view->assign('vEspecieCapturadas', $vEspecieCapturadas);
    }
    public function insertespeciecapturadaAction(){
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $especie = $this->_getParam("selectEspecie");

        $quantidade = $this->_getParam("quantidade");

        $peso = $this->_getParam("peso");

        $preco = $this->_getParam("precokg");

        $idEntrevista = $this->_getParam("id_entrevista");

        //$backUrl = $this->_getParam("back_url");

        $idTipoVenda =  $this->_getParam("id_tipovenda");
        
        $this->modelLinhaFundo->insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $preco, $idTipoVenda);

        $this->redirect("/linha-fundo/tableespcaptura/id/" . $idEntrevista);
    }
    public function deletespecieAction(){
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasEspecie = $this->_getParam("id_entrevista_has_especie");

        //$backUrl = $this->_getParam("back_url");

        $this->modelLinhaFundo->deleteEspCapturada($idEntrevistaHasEspecie);

        $this->redirect("/linha-fundo/tableespcaptura/id/" . $idEntrevista);
        //$this->redirect("/linha-fundo/editar/id/" . $backUrl);
    }
    public function tableavistamentoAction(){ //ACTION PARA REDIRECIONAR SEM LAYOUT
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelLinhaFundo->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vLinhaFundoAvistamento = $this->modelLinhaFundo->selectLinhaFundoHasAvistamento('lf_id='.$idEntrevista);

        $this->view->assign('vLinhaFundoAvistamento', $vLinhaFundoAvistamento);
    }    
    public function insertavistamentoAction(){
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $avistamento = $this->_getParam("SelectAvistamento");

        $idEntrevista = $this->_getParam("id_entrevista");

        $this->modelLinhaFundo->insertAvistamento($idEntrevista, $avistamento);

        $this->redirect("/linha-fundo/tableavistamento/id/" . $idEntrevista);
    }
    public function deleteavistamentoAction(){
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasAvistamento = $this->_getParam("id_entrevista_has_avistamento");

        $this->modelLinhaFundo->deleteAvistamento($idEntrevistaHasAvistamento, $idEntrevista);

        $this->redirect("/linha-fundo/tableavistamento/id/" . $idEntrevista);
    }
    public function tablebiocamaraoAction(){//Action para tablepesqueiro
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelLinhaFundo->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vBioCamarao = $this->modelLinhaFundo->selectVBioCamarao('tlf_id='.$idEntrevista);
        
        $this->view->assign('vBioCamarao', $vBioCamarao);
    }
    public function insertbiocamaraoAction() {
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEntrevista = $this->_getParam("id");
        
        $idEspecie  = $this->_getParam("SelectEspecie");
        
        $sexo = $this->_getParam("SelectSexo");

        $maturidade = $this->_getParam("SelectMaturidade");

        $compCabeca = $this->_getParam("comprimentoCabeca");
        
        $peso = $this->_getParam("peso");

        $this->modelLinhaFundo->insertBioCamarao($idEntrevista, $idEspecie, $sexo, $maturidade, $compCabeca, $peso);

        $this->redirect("/linha-fundo/tablebiocamarao/id/" . $idEntrevista);
    }
    public function deletebiocamaraoAction() {
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasBioCamarao = $this->_getParam("id_entrevista_has_biocamarao");

        $this->modelLinhaFundo->deleteBioCamarao($idEntrevistaHasBioCamarao);

        $this->redirect("/linha-fundo/tablebiocamarao/id/" . $idEntrevista);
    }
    
    public function tablebiopeixeAction(){ //ACTION PARA REDIRECIONAR SEM LAYOUT
        //IMPORTANTE TER!!
        $this->_helper->layout->disableLayout();
        
        $idEntrevista = $this->_getParam('id');
        $entrevista = $this->modelLinhaFundo->find($idEntrevista);
        $this->view->assign("entrevista", $entrevista);
        $vBioPeixe = $this->modelLinhaFundo->selectVBioPeixe('tlf_id='.$idEntrevista);

        $this->view->assign('vBioPeixe', $vBioPeixe);
    }
    public function insertbiopeixeAction() {
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEntrevista = $this->_getParam("id");
        
        $idEspecie  = $this->_getParam("SelectEspecie");
        
        $sexo = $this->_getParam("SelectSexo");

        $comprimento = $this->_getParam("comprimento");
        
        $peso = $this->_getParam("peso");

        $this->modelLinhaFundo->insertBioPeixe($idEntrevista, $idEspecie, $sexo, $comprimento, $peso);

        $this->redirect("/linha-fundo/tablebiopeixe/id/" . $idEntrevista);
    }
    public function deletebiopeixeAction() {
        $this->acesso();
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEntrevista = $this->_getParam("id_entrevista");
        $idEntrevistaHasBioPeixe = $this->_getParam("id_entrevista_has_biopeixe");

        $this->modelLinhaFundo->deleteBioPeixe($idEntrevistaHasBioPeixe);

        $this->redirect("/linha-fundo/tablebiopeixe/id/" . $idEntrevista);
    }
   public function relatoriolistaAction(){
            //$this->acesso();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelLinhaFundo = new Application_Model_LinhaFundo();
		$localLinhaFundo = $localModelLinhaFundo->selectEntrevistaLinhaFundo(NULL, array('fd_id', 'mnt_id', 'lf_id'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Linha de Fundo');
		$modeloRelatorio->setLegenda(30, 'Ficha');
		$modeloRelatorio->setLegenda(80, 'Monit.');
		$modeloRelatorio->setLegenda(130, 'L. Fundo');
		$modeloRelatorio->setLegenda(180, 'Pescador');
		$modeloRelatorio->setLegenda(350, 'Embarcação');

		$modeloRelatorio->setValueAlinhadoDireita(30, 40, '');

		foreach ( $localLinhaFundo as $key => $localData ) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['fd_id']);
			$modeloRelatorio->setValueAlinhadoDireita(80, 40, $localData['mnt_id']);
			$modeloRelatorio->setValueAlinhadoDireita(130, 40, $localData['lf_id']);
			$modeloRelatorio->setValue(180, $localData['tp_nome']);
			$modeloRelatorio->setValue(350, $localData['bar_nome']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		header('Content-Disposition: attachment;filename="rel_lista_entrevista_linhafundo.pdf"');
                header("Content-type: application/x-pdf");
		echo $pdf->render();
    }
    public function relatorioAction(){
        //$this->acesso();
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelLinhaFundo = new Application_Model_LinhaFundo();
		$localLinhaFundo = $localModelLinhaFundo->selectEntrevistaLinhaFundo(NULL, array('fd_id', 'mnt_id', 'lf_id'), NULL);

		$localPesqueiro = $localModelLinhaFundo->selectLinhaFundoHasPesqueiro(NULL, array('lf_id', 'paf_pesqueiro'), NULL);
		$localEspecie = $localModelLinhaFundo->selectLinhaFundoHasEspCapturadas(NULL, array('lf_id', 'esp_nome_comum'), NULL);
		$localAvist = $localModelLinhaFundo->selectLinhaFundoHasAvistamento(NULL, array('lf_id', 'avs_descricao'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Linha de Fundo');
		$modeloRelatorio->setLegendaOff();

		foreach ( $localLinhaFundo as $key => $localData ) {
			$modeloRelatorio->setLegValueAlinhadoDireita(30, 60, 'Ficha:', $localData['fd_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(90, 60, 'Monit.:',  $localData['mnt_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(150, 70, 'L.Fundo:', $localData['lf_id']);
			$modeloRelatorio->setLegValue(220, 'Pescador: ', $localData['tp_nome']);
			$modeloRelatorio->setLegValue(450, 'Barco: ', $localData['bar_nome']);
			$modeloRelatorio->setNewLine();

// 			$localPesqueiro = $localModelLinhaFundo->selectLinhaFundoHasPesqueiro('lf_id='.$localData['lf_id'], array('lf_id', 'paf_pesqueiro'), NULL);
			foreach ( $localPesqueiro as $key => $localDataPesqueiro ) {
				if ( $localDataPesqueiro['lf_id'] ==  $localData['lf_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Pesqueiro: ',  $localDataPesqueiro['paf_pesqueiro']);
					if($localDataPesqueiro['t_tempoapesqueiro'] !== NULL){
						$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Tempo (H:M):', date_format(date_create($localDataPesqueiro['t_tempoapesqueiro']), 'H:i'));
					}
					else {
						$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Tempo (H:M):', "00:00", 'H:i');
					}
					$modeloRelatorio->setLegValueAlinhadoDireita(450, 120, 'Distância:', number_format($localDataPesqueiro['t_distapesqueiro'], 2, ',', ' '));
					$modeloRelatorio->setNewLine();
				}
			}
// 			$localEspecie = $localModelLinhaFundo->selectLinhaFundoHasEspCapturadas('lf_id='.$localData['lf_id'], array('lf_id', 'esp_nome_comum'), NULL);
			foreach ( $localEspecie as $key => $localDataEspecie ) {
				if ( $localDataEspecie['lf_id'] ==  $localData['lf_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Espécie: ',  $localDataEspecie['esp_nome_comum']);
					$modeloRelatorio->setLegValueAlinhadoDireita(280, 60, 'Quant:', $localDataEspecie['spc_quantidade']);
					$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Peso(kg):', number_format($localDataEspecie['spc_peso_kg'], 2, ',', ' '));
					$modeloRelatorio->setLegValueAlinhadoDireita(450, 120, 'Preço(R$/kg):', number_format($localDataEspecie['spc_preco'], 2, ',', ' '));
					$modeloRelatorio->setNewLine();
				}
			}
// 			$localAvist = $localModelLinhaFundo->selectLinhaFundoHasAvistamento('lf_id='.$localData['lf_id'], array('lf_id', 'avs_descricao'), NULL);
			foreach ( $localAvist as $key => $localDataAvist ) {
				if ( $localDataAvist['lf_id'] ==  $localData['lf_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Avist.: ',  $localDataAvist['avs_descricao']);
					$modeloRelatorio->setNewLine();
				}
			}
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

        header('Content-Disposition: attachment;filename="rel_entrevista_linhafundo.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }
}
