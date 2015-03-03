<?php

class CalaoController extends Zend_Controller_Action
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
        $this->modelMonitoramento = new Application_Model_Monitoramento();
        $this->modelFichaDiaria = new Application_Model_FichaDiaria();
        $this->modelCalao = new Application_Model_Calao();
        $this->modelPescador = new Application_Model_Pescador();
        $this->modelBarcos = new Application_Model_Barcos();
        $this->modelTipoEmbarcacao = new Application_Model_TipoEmbarcacao();
        $this->modelPesqueiro = new Application_Model_Pesqueiro();
        $this->modelEspecie = new Application_Model_Especie();
        $this->modelAvistamento = new Application_Model_Avistamento();
        $this->modelMaturidade = new Application_Model_Maturidade();
        $this->modelTipoCalao = new Application_Model_TipoCalao();
    }

    public function indexAction()
    {
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $barcos = $this->modelBarcos->select(null, 'bar_nome');
        $tipoEmbarcacoes = $this->modelTipoEmbarcacao->select(null, 'tte_tipoembarcacao');
        $destinos = $this->modelDestinoPescado->select(null, 'dp_destino');
        $monitoramento = $this->modelMonitoramento->find($this->_getParam("idMonitoramento"));
        $this->naoexiste($monitoramento);
        $tipocalao = $this->modelTipoCalao->select(null, 'tcat_id');
        
        $fichadiaria = $this->modelFichaDiaria->find($this->_getParam('id'));
        $this->naoexiste($fichadiaria);
        
        $this->view->assign('tipoCalao', $tipocalao);
        $this->view->assign('fichaDiaria', $fichadiaria);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('destinos', $destinos);
        $this->view->assign('pescadores',$pescadores);
        $this->view->assign('barcos',$barcos);
        $this->view->assign('tipoEmbarcacoes',$tipoEmbarcacoes);

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

        if ($ent_id > 0) {
            $dados = $this->modelCalao->selectEntrevistaCalao("cal_id>=" . $ent_id, array('cal_id'),50);
        } elseif ($ent_pescador) {
            $dados = $this->modelCalao->selectEntrevistaCalao("tp_nome ~* '" . $ent_pescador . "'", array('tp_nome', 'cal_id DESC'));
        } elseif ($ent_barco) {
            $dados = $this->modelCalao->selectEntrevistaCalao("bar_nome ~* '" . $ent_barco . "'", array('bar_nome', 'cal_id DESC'));
       }
        elseif ($ent_apelido){
            $dados = $this->modelCalao->selectEntrevistaCalao("tp_apelido ~* '" . $ent_apelido . "'", array('tp_apelido', 'cal_id DESC'), 20);
        }
        else {
            $dados = $this->modelCalao->selectEntrevistaCalao(null, array('fd_id DESC', 'tp_nome'),20);
        }

        $this->view->assign("dados", $dados);
    }

    public function editarAction(){
        $entrevista = $this->modelCalao->find($this->_getParam('id'));
        $this->naoexiste($entrevista);
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $barcos = $this->modelBarcos->select(null, 'bar_nome');
        $tipoEmbarcacoes = $this->modelTipoEmbarcacao->select(null, 'tte_tipoembarcacao');
        $pesqueiros = $this->modelPesqueiro->select(null, 'paf_pesqueiro');
        $especies = $this->modelEspecie->select(null, 'esp_nome_comum');
        $especiesCamarao = $this->modelEspecie->select('gen_id = 99 or gen_id = 100 or gen_id = 101');
        $monitoramento = $this->modelMonitoramento->find($entrevista['mnt_id']);
        $avistamentos = $this->modelAvistamento->select(null, 'avs_descricao');
        $destinos = $this->modelDestinoPescado->select(null, 'dp_destino');
        $tipocalao = $this->modelTipoCalao->select(null, 'tcat_id');
        
        $idEntrevista = $this->_getParam('id');
        
        $vCalao = $this->modelCalao->selectCalaoHasPesqueiro('cal_id='.$idEntrevista);

        $vEspecieCapturadas = $this->modelCalao->selectCalaoHasEspCapturadas('cal_id='.$idEntrevista);

        $vCalaoAvistamento = $this->modelCalao->selectCalaoHasAvistamento('cal_id='.$idEntrevista);
        $vBioCamarao = $this->modelCalao->selectVBioCamarao('tcal_id='.$idEntrevista);
        $vBioPeixe = $this->modelCalao->selectVBioPeixe('tcal_id='.$idEntrevista);
        $maturidade = $this->modelMaturidade->select(null, 'tmat_tipo');
        
        $this->view->assign('tipoCalao', $tipocalao);
        $this->view->assign('vBioCamarao', $vBioCamarao);
        $this->view->assign('vBioPeixe', $vBioPeixe);
        $this->view->assign('maturidade', $maturidade);
        $this->view->assign('destinos', $destinos);
        $this->view->assign('especieCamarao', $especiesCamarao);
        $this->view->assign('avistamentos', $avistamentos);
        $this->view->assign('vCalaoAvistamento', $vCalaoAvistamento);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('vEspecieCapturadas', $vEspecieCapturadas);
        $this->view->assign('vCalao', $vCalao);
        $this->view->assign("entrevista", $entrevista);
        //print_r($entrevista);
        $this->view->assign('pescadores',$pescadores);
        $this->view->assign('barcos',$barcos);
        $this->view->assign('tipoEmbarcacoes',$tipoEmbarcacoes);
        $this->view->assign('pesqueiros',$pesqueiros);
        $this->view->assign('especies',$especies);

    }
    public function criarAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idCalao = $this->modelCalao->insert($this->_getAllParams());


        $this->_redirect('calao/editar/id/'.$idCalao);
    }
    public function atualizarAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idCalao = $this->_getParam('id_entrevista');
        
        $monitoramento = $this->modelMonitoramento->select('mnt_id='.$this->_getParam('id_monitoramento'));
        
        
        if($monitoramento[0]['fd_id'] != $this->_getParam('id_fichaDiaria')){
            $this->_redirect('arrasto-fundo/error');  
        }
        else{
            $this->modelCalao->update($this->_getAllParams());
            $this->_redirect('calao/editar/id/'.$idCalao);
        }
        
    }

    public function excluirAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        
        
        $this->modelCalao->delete($this->_getParam('id'));
        $idFicha = $this->_getParam('id_ficha');
        if(empty($idFicha)){
            $this->_redirect('calao/visualizar');
        }
        else{
            $this->_redirect('ficha-diaria/editar/id/'.$idFicha);
        }
    }
    public function insertpesqueiroAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $pesqueiro = $this->_getParam("nomePesqueiro");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");


        $this->modelCalao->insertPesqueiro($idEntrevista, $pesqueiro);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    public function deletepesqueiroAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevistaHasPesqueiro = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelCalao->deletePesqueiro($idEntrevistaHasPesqueiro);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    public function insertespeciecapturadaAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $especie = $this->_getParam("selectEspecie");

        $quantidade = $this->_getParam("quantidade");

        $peso = $this->_getParam("peso");

        $preco = $this->_getParam("precokg");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");


        $this->modelCalao->insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $preco);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    public function deletespecieAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevistaHasEspecie = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelCalao->deleteEspCapturada($idEntrevistaHasEspecie);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    public function insertavistamentoAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $avistamento = $this->_getParam("SelectAvistamento");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");

        $this->modelCalao->insertAvistamento($idEntrevista, $avistamento);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    public function deleteavistamentoAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idAvistamento = $this->_getParam("id_avistamento");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");

        $this->modelCalao->deleteAvistamento($idAvistamento, $idEntrevista);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    public function insertbiocamaraoAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEntrevista = $this->_getParam("id");
        
        $idEspecie  = $this->_getParam("SelectEspecie");
        
        $sexo = $this->_getParam("SelectSexo");

        $maturidade = $this->_getParam("SelectMaturidade");

        $compCabeca = $this->_getParam("comprimentoCabeca");
        
        $peso = $this->_getParam("peso");

        $backUrl = $this->_getParam("back_url");

        $this->modelCalao->insertBioCamarao($idEntrevista, $idEspecie, $sexo, $maturidade, $compCabeca, $peso);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    public function deletebiocamaraoAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idBiometria = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelCalao->deleteBioCamarao($idBiometria);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    
    public function insertbiopeixeAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEntrevista = $this->_getParam("id");
        
        $idEspecie  = $this->_getParam("SelectEspecie");
        
        $sexo = $this->_getParam("SelectSexo");

        $comprimento = $this->_getParam("comprimento");
        
        $peso = $this->_getParam("peso");

        $backUrl = $this->_getParam("back_url");

        $this->modelCalao->insertBioPeixe($idEntrevista, $idEspecie, $sexo, $comprimento, $peso);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    public function deletebiopeixeAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idBiometria = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelCalao->deleteBioPeixe($idBiometria);

        $this->redirect("/calao/editar/id/" . $backUrl);
    }
    public function relatoriolistaAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelCalao = new Application_Model_Calao();
		$localCalao = $localModelCalao->selectEntrevistaCalao(NULL, array('fd_id', 'mnt_id', 'cal_id'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Calão');
		$modeloRelatorio->setLegenda(30, 'Ficha');
		$modeloRelatorio->setLegenda(80, 'Monit.');
		$modeloRelatorio->setLegenda(130, 'Calão');
		$modeloRelatorio->setLegenda(180, 'Pescador');
		$modeloRelatorio->setLegenda(350, 'Embarcação');

		foreach ( $localCalao as $key => $localData ) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['fd_id']);
			$modeloRelatorio->setValueAlinhadoDireita(80, 40, $localData['mnt_id']);
			$modeloRelatorio->setValueAlinhadoDireita(130, 40, $localData['cal_id']);
			$modeloRelatorio->setValue(180, $localData['tp_nome']);
			$modeloRelatorio->setValue(350, $localData['bar_nome']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_lista_entrevista_calao.pdf"');
        header("Content-type: application/x-pdf");
		echo $pdf->render();
    }

    public function relatorioAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelCalao = new Application_Model_Calao();
		$localCalao = $localModelCalao->selectEntrevistaCalao(NULL, array('fd_id', 'mnt_id', 'cal_id'), NULL);

		$localPesqueiro = $localModelCalao->selectCalaoHasPesqueiro(NULL, array('cal_id', 'paf_pesqueiro'), NULL);
		$localEspecie = $localModelCalao->selectCalaoHasEspCapturadas(NULL, array('cal_id', 'esp_nome_comum'), NULL);
		$localAvist = $localModelCalao->selectCalaoHasAvistamento(NULL, array('cal_id', 'avs_descricao'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Calão');
		$modeloRelatorio->setLegendaOff();

		foreach ( $localCalao as $key => $localData ) {
			$modeloRelatorio->setLegValueAlinhadoDireita(30, 60, 'Ficha:', $localData['fd_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(90, 60, 'Monit.:',  $localData['mnt_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(150, 70, 'A.Fundo:', $localData['cal_id']);
			$modeloRelatorio->setLegValue(220, 'Pescador: ', $localData['tp_nome']);
			$modeloRelatorio->setLegValue(450, 'Barco: ', $localData['bar_nome']);
			$modeloRelatorio->setNewLine();

			foreach ( $localPesqueiro as $key => $localDataPesqueiro ) {
				if ( $localDataPesqueiro['cal_id'] ==  $localData['cal_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Pesqueiro: ',  $localDataPesqueiro['paf_pesqueiro']);
					$modeloRelatorio->setNewLine();
				}
			}
			foreach ( $localEspecie as $key => $localDataEspecie ) {
				if ( $localDataEspecie['cal_id'] ==  $localData['cal_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Espécie: ',  $localDataEspecie['esp_nome_comum']);
					$modeloRelatorio->setLegValueAlinhadoDireita(280, 60, 'Quant:', $localDataEspecie['spc_quantidade']);
					$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Peso(kg):', number_format($localDataEspecie['spc_peso_kg'], 2, ',', ' '));
					$modeloRelatorio->setLegValueAlinhadoDireita(450, 120, 'Preço(R$/kg):', number_format($localDataEspecie['spc_preco'], 2, ',', ' '));
					$modeloRelatorio->setNewLine();
				}
			}
			foreach ( $localAvist as $key => $localDataAvist ) {
				if ( $localDataAvist['cal_id'] ==  $localData['cal_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Avist.: ',  $localDataAvist['avs_descricao']);
					$modeloRelatorio->setNewLine();
				}
			}
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_entrevista_calao.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }
}

