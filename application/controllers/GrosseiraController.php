<?php

class GrosseiraController extends Zend_Controller_Action
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
        $this->modelMonitoramento = new Application_Model_Monitoramento();
        $this->modelFichaDiaria = new Application_Model_FichaDiaria();
        $this->modelGrosseira = new Application_Model_Grosseira();
        $this->modelPescador = new Application_Model_Pescador();
        $this->modelBarcos = new Application_Model_Barcos();
        $this->modelTipoEmbarcacao = new Application_Model_TipoEmbarcacao();
        $this->modelPesqueiro = new Application_Model_Pesqueiro();
        $this->modelEspecie = new Application_Model_Especie();
        $this->modelIsca = new Application_Model_Isca();
        $this->modelMaturidade = new Application_Model_Maturidade();
    }

    public function indexAction()
    {

        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $barcos = $this->modelBarcos->select(null, 'bar_nome');
        $tipoEmbarcacoes = $this->modelTipoEmbarcacao->select(null, 'tte_tipoembarcacao');
        $iscas = $this->modelIsca->select(null, 'isc_tipo');
        $destinos = $this->modelDestinoPescado->select(null, 'dp_destino');

        $monitoramento = $this->modelMonitoramento->find($this->_getParam("idMonitoramento"));
        $this->naoexiste($monitoramento);
        $fichadiaria = $this->modelFichaDiaria->find($this->_getParam('id'));
        $this->naoexiste($fichadiaria);
            
        $this->view->assign('destinos', $destinos);
        $this->view->assign('fichaDiaria', $fichadiaria);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('iscas', $iscas);
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
            $dados = $this->modelGrosseira->selectEntrevistaGrosseira("grs_id>=" . $ent_id, array('grs_id'),50);
        } elseif ($ent_pescador) {
            $dados = $this->modelGrosseira->selectEntrevistaGrosseira("tp_nome ~* '" . $ent_pescador . "'", array('tp_nome', 'grs_id DESC'));
        } elseif ($ent_barco) {
            $dados = $this->modelGrosseira->selectEntrevistaGrosseira("bar_nome ~* '" . $ent_barco . "'", array('bar_nome', 'grs_id DESC'));
       }
        elseif ($ent_apelido){
            $dados = $this->modelGrosseira->selectEntrevistaGrosseira("tp_apelido ~* '" . $ent_apelido . "'", array('tp_apelido', 'grs_id DESC'), 20);
        }
        else {
            $dados = $this->modelGrosseira->selectEntrevistaGrosseira(null, array('fd_id DESC', 'tp_nome'),20);
        }

        $this->view->assign("dados", $dados);
    }

    public function editarAction(){
         //$avistamentoGrosseira = new Application_Model_DbTable_VGrosseiraHasAvistamento();
        $entrevista = $this->modelGrosseira->find($this->_getParam('id'));
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
        $destinos = $this->modelDestinoPescado->select(null, 'dp_destino');

        
        $idEntrevista = $this->_getParam('id');
        $datahoraSaida[] = split(" ",$entrevista['grs_dhsaida']);
        $datahoraVolta[] = split(" ",$entrevista['grs_dhvolta']);

        $vGrosseira = $this->modelGrosseira->selectGrosseiraHasPesqueiro('grs_id='.$idEntrevista);

        $vEspecieCapturadas = $this->modelGrosseira->selectGrosseiraHasEspCapturadas('grs_id='.$idEntrevista);

        $vGrosseiraAvistamento = $this->modelGrosseira->selectGrosseiraHasAvistamento('grs_id='.$idEntrevista);
        $vBioCamarao = $this->modelGrosseira->selectVBioCamarao('tgrs_id='.$idEntrevista);
        $vBioPeixe = $this->modelGrosseira->selectVBioPeixe('tgrs_id='.$idEntrevista);
        $maturidade = $this->modelMaturidade->select(null, 'tmat_tipo');
        
        
        $this->view->assign('vBioCamarao', $vBioCamarao);
        $this->view->assign('vBioPeixe', $vBioPeixe);
        $this->view->assign('maturidade', $maturidade);
        $this->view->assign('destinos', $destinos);
        $this->view->assign('especieCamarao', $especiesCamarao);
        $this->view->assign('avistamentos', $avistamentos);
        $this->view->assign('vGrosseiraAvistamento', $vGrosseiraAvistamento);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('vEspecieCapturadas', $vEspecieCapturadas);
        $this->view->assign('vGrosseira', $vGrosseira);
        $this->view->assign("entrevista", $entrevista);
        $this->view->assign("iscas", $iscas);
        $this->view->assign('dataSaida', $datahoraSaida[0][0]);
        $this->view->assign('horaSaida', $datahoraSaida[0][1]);
        $this->view->assign('dataVolta', $datahoraVolta[0][0]);
        $this->view->assign('horaVolta', $datahoraVolta[0][1]);
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
        $idGrosseira = $this->modelGrosseira->insert($this->_getAllParams());


        $this->_redirect('grosseira/editar/id/'.$idGrosseira);
    }
    public function atualizarAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idGrosseira = $this->_getParam('id_entrevista');
        $monitoramento = $this->modelMonitoramento->select('mnt_id='.$this->_getParam('id_monitoramento'));
        
        
        if($monitoramento[0]['fd_id'] != $this->_getParam('id_fichaDiaria')){
            $this->_redirect('arrasto-fundo/error');  
        }
        else{
            $this->modelGrosseira->update($this->_getAllParams());
            $this->_redirect('grosseira/editar/id/'.$idGrosseira);
        }
    }
    public function excluirAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelGrosseira->delete($this->_getParam('id'));
        
        $idFicha = $this->_getParam('id_ficha');
        if(empty($idFicha)){
            $this->_redirect('grosseira/visualizar');
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

        $tempoapesqueiro = $this->_getParam("tempoAPesqueiro");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");


        $this->modelGrosseira->insertPesqueiro($idEntrevista, $pesqueiro, $tempoapesqueiro);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
    }
    public function deletepesqueiroAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevistaHasPesqueiro = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelGrosseira->deletePesqueiro($idEntrevistaHasPesqueiro);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
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


        $this->modelGrosseira->insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $preco);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
    }
    public function deletespecieAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevistaHasEspecie = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelGrosseira->deleteEspCapturada($idEntrevistaHasEspecie);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
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

        $this->modelGrosseira->insertAvistamento($idEntrevista, $avistamento);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
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

        $this->modelGrosseira->deleteAvistamento($idAvistamento, $idEntrevista);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
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

        $this->modelGrosseira->insertBioCamarao($idEntrevista, $idEspecie, $sexo, $maturidade, $compCabeca, $peso);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
    }
    public function deletebiocamaraoAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idBiometria = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelGrosseira->deleteBioCamarao($idBiometria);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
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

        $this->modelGrosseira->insertBioPeixe($idEntrevista, $idEspecie, $sexo, $comprimento, $peso);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
    }
    public function deletebiopeixeAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idBiometria = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelGrosseira->deleteBioPeixe($idBiometria);

        $this->redirect("/grosseira/editar/id/" . $backUrl);
    }
    public function relatoriolistaAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelGrosseira = new Application_Model_Grosseira();
		$localGrosseira = $localModelGrosseira->selectEntrevistaGrosseira(NULL, array('fd_id', 'mnt_id', 'grs_id'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Grosseira');
		$modeloRelatorio->setLegenda(30, 'Ficha');
		$modeloRelatorio->setLegenda(80, 'Monit.');
		$modeloRelatorio->setLegenda(130, 'Grosseira');
		$modeloRelatorio->setLegenda(180, 'Pescador');
		$modeloRelatorio->setLegenda(350, 'Embarcação');

		foreach ( $localGrosseira as $key => $localData ) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['fd_id']);
			$modeloRelatorio->setValueAlinhadoDireita(80, 40, $localData['mnt_id']);
			$modeloRelatorio->setValueAlinhadoDireita(130, 40, $localData['grs_id']);
			$modeloRelatorio->setValue(180, $localData['tp_nome']);
			$modeloRelatorio->setValue(350, $localData['bar_nome']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_lista_entrevista_grosseira.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
    }

    public function relatorioAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelGrosseira = new Application_Model_Grosseira();
		$localGrosseira = $localModelGrosseira->selectEntrevistaGrosseira(NULL, array('fd_id', 'mnt_id', 'grs_id'), NULL);

		$localPesqueiro = $localModelGrosseira->selectGrosseiraHasPesqueiro(NULL, array('grs_id', 'paf_pesqueiro'), NULL);
		$localEspecie = $localModelGrosseira->selectGrosseiraHasEspCapturadas(NULL, array('grs_id', 'esp_nome_comum'), NULL);
		$localAvist = $localModelGrosseira->selectGrosseiraHasAvistamento(NULL, array('grs_id', 'avs_descricao'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Grosseira');
		$modeloRelatorio->setLegendaOff();

		foreach ( $localGrosseira as $key => $localData ) {
			$modeloRelatorio->setLegValueAlinhadoDireita(30, 60, 'Ficha:', $localData['fd_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(90, 60, 'Monit.:',  $localData['mnt_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(150, 70, 'Gros.:', $localData['grs_id']);
			$modeloRelatorio->setLegValue(220, 'Pescador: ', $localData['tp_nome']);
			$modeloRelatorio->setLegValue(450, 'Barco: ', $localData['bar_nome']);
			$modeloRelatorio->setNewLine();

			foreach ( $localPesqueiro as $key => $localDataPesqueiro ) {
				if ( $localDataPesqueiro['grs_id'] ==  $localData['grs_id'] ) {
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
				if ( $localDataEspecie['grs_id'] ==  $localData['grs_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Espécie: ',  $localDataEspecie['esp_nome_comum']);
					$modeloRelatorio->setLegValueAlinhadoDireita(280, 60, 'Quant:', $localDataEspecie['spc_quantidade']);
					$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Peso(kg):', number_format($localDataEspecie['spc_peso_kg'], 2, ',', ' '));
					$modeloRelatorio->setLegValueAlinhadoDireita(450, 120, 'Preço(R$/kg):', number_format($localDataEspecie['spc_preco'], 2, ',', ' '));
					$modeloRelatorio->setNewLine();
				}
			}
			foreach ( $localAvist as $key => $localDataAvist ) {
				if ( $localDataAvist['grs_id'] ==  $localData['grs_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Avist.: ',  $localDataAvist['avs_descricao']);
					$modeloRelatorio->setNewLine();
				}
			}
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_entrevista_grosseira.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }
}
