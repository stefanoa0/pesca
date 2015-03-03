<?php

class SiripoiaController extends Zend_Controller_Action
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
        $this->modelSiripoia = new Application_Model_Siripoia();
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
    
    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
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

    }

    public function visualizarAction() {
        $ent_id = $this->_getParam("ent_id");
        $ent_pescador = $this->_getParam("tp_nome");
        $ent_barco = $this->_getParam("bar_nome");
        $ent_apelido = $this->_getParam("tp_apelido");

        if ($ent_id > 0) {
            $dados = $this->modelSiripoia->selectEntrevistaSiripoia("sir_id>=" . $ent_id, array('sir_id'),50);
        } elseif ($ent_pescador) {
            $dados = $this->modelSiripoia->selectEntrevistaSiripoia("tp_nome ~* '" . $ent_pescador . "'", array('tp_nome', 'sir_id DESC'));
        } elseif ($ent_barco) {
            $dados = $this->modelSiripoia->selectEntrevistaSiripoia("bar_nome ~* '" . $ent_barco . "'", array('bar_nome', 'sir_id DESC'));
       }
        elseif ($ent_apelido){
            $dados = $this->modelSiripoia->selectEntrevistaSiripoia("tp_apelido ~* '" . $ent_apelido . "'", array('tp_apelido', 'sir_id DESC'), 20);
        }
        else {
            $dados = $this->modelSiripoia->selectEntrevistaSiripoia(null, array('fd_id DESC', 'tp_nome'),20);
        }

        $this->view->assign("dados", $dados);
    }

    public function editarAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
         //$avistamentoSiripoia = new Application_Model_DbTable_VSiripoiaHasAvistamento();
        $entrevista = $this->modelSiripoia->find($this->_getParam('id'));
        $this->naoexiste($entrevista);
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $barcos = $this->modelBarcos->select(null, 'bar_nome');
        $tipoEmbarcacoes = $this->modelTipoEmbarcacao->select(null, 'tte_tipoembarcacao');
        $pesqueiros = $this->modelPesqueiro->select(null, 'paf_pesqueiro');
        $especies = $this->modelEspecie->select(null, 'esp_nome_comum');
        $especiesCamarao = $this->modelEspecie->select('gen_id = 99 or gen_id = 100 or gen_id = 101');
        $monitoramento = $this->modelMonitoramento->find($entrevista['mnt_id']);
        $this->naoexiste($monitoramento);
        $avistamentos = $this->modelAvistamento->select(null, 'avs_descricao');
        $mare = $this->modelMare->select();
        $destinos = $this->modelDestinoPescado->select(null, 'dp_destino');
        $tipoVenda = $this->modelTipoVenda->select(null, 'ttv_tipovenda');

        $idEntrevista = $this->_getParam('id');
        $datahoraSaida[] = split(" ",$entrevista['sir_dhsaida']);
        $datahoraVolta[] = split(" ",$entrevista['sir_dhvolta']);

        $vSiripoia = $this->modelSiripoia->selectSiripoiaHasPesqueiro('sir_id='.$idEntrevista);

        $vEspecieCapturadas = $this->modelSiripoia->selectSiripoiaHasEspCapturadas('sir_id='.$idEntrevista);

        $vSiripoiaAvistamento = $this->modelSiripoia->selectSiripoiaHasAvistamento('sir_id='.$idEntrevista);
        $vBioCamarao = $this->modelSiripoia->selectVBioCamarao('tsir_id='.$idEntrevista);
        $vBioPeixe = $this->modelSiripoia->selectVBioPeixe('tsir_id='.$idEntrevista);
        $maturidade = $this->modelMaturidade->select(null, 'tmat_tipo');
        
        
        $this->view->assign('vBioCamarao', $vBioCamarao);
        $this->view->assign('vBioPeixe', $vBioPeixe);
        $this->view->assign('maturidade', $maturidade);
        $this->view->assign('destinos', $destinos);
        $this->view->assign('especieCamarao', $especiesCamarao);
        $this->view->assign('avistamentos', $avistamentos);
        $this->view->assign('vSiripoiaAvistamento', $vSiripoiaAvistamento);
        $this->view->assign('mare', $mare);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('vEspecieCapturadas', $vEspecieCapturadas);
        $this->view->assign('vSiripoia', $vSiripoia);
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
    }
    public function criarAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idSiripoia = $this->modelSiripoia->insert($this->_getAllParams());


        $this->_redirect('siripoia/editar/id/'.$idSiripoia);
    }
    public function atualizarAction(){
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idSiripoia = $this->_getParam('id_entrevista');
        $monitoramento = $this->modelMonitoramento->select('mnt_id='.$this->_getParam('id_monitoramento'));
        
        
        if($monitoramento[0]['fd_id'] != $this->_getParam('id_fichaDiaria')){
            $this->_redirect('arrasto-fundo/error');  
        }
        else{
            $this->modelSiripoia->update($this->_getAllParams());

            $this->_redirect('siripoia/editar/id/'.$idSiripoia);
        }
    }
    public function excluirAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelSiripoia->delete($this->_getParam('id'));

        $idFicha = $this->_getParam('id_ficha');
        if(empty($idFicha)){
            $this->_redirect('siripoia/visualizar');
        }
        else{
            $this->_redirect('ficha-diaria/editar/id/'.$idFicha);
        }
    }
     public function insertpesqueiroAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $pesqueiro = $this->_getParam("nomePesqueiro");

        $tempoapesqueiro = $this->_getParam("tempoAPesqueiro");

        $distanciapesqueiro = $this->_getParam("distAPesqueiro");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");


        $this->modelSiripoia->insertPesqueiro($idEntrevista, $pesqueiro, $tempoapesqueiro, $distanciapesqueiro);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
    }
    public function deletepesqueiroAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevistaHasPesqueiro = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelSiripoia->deletePesqueiro($idEntrevistaHasPesqueiro);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
    }
    public function insertespeciecapturadaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);


        $especie = $this->_getParam("selectEspecie");

        $quantidade = $this->_getParam("quantidade");

        $peso = $this->_getParam("peso");

        $preco = $this->_getParam("precokg");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");

        $idTipoVenda =  $this->_getParam("id_tipovenda");

        $this->modelSiripoia->insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $preco, $idTipoVenda);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
    }
    public function deletespecieAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevistaHasEspecie = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelSiripoia->deleteEspCapturada($idEntrevistaHasEspecie);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
    }
    public function insertavistamentoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $avistamento = $this->_getParam("SelectAvistamento");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");

        $this->modelSiripoia->insertAvistamento($idEntrevista, $avistamento);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
    }
    public function deleteavistamentoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idAvistamento = $this->_getParam("id_avistamento");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");

        $this->modelSiripoia->deleteAvistamento($idAvistamento, $idEntrevista);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
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

        $backUrl = $this->_getParam("back_url");

        $this->modelSiripoia->insertBioCamarao($idEntrevista, $idEspecie, $sexo, $maturidade, $compCabeca, $peso);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
    }
    public function deletebiocamaraoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idBiometria = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelSiripoia->deleteBioCamarao($idBiometria);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
    }
    
    public function insertbiopeixeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEntrevista = $this->_getParam("id");
        
        $idEspecie  = $this->_getParam("SelectEspecie");
        
        $sexo = $this->_getParam("SelectSexo");

        $comprimento = $this->_getParam("comprimento");
        
        $peso = $this->_getParam("peso");

        $backUrl = $this->_getParam("back_url");

        $this->modelSiripoia->insertBioPeixe($idEntrevista, $idEspecie, $sexo, $comprimento, $peso);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
    }
    public function deletebiopeixeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idBiometria = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelSiripoia->deleteBioPeixe($idBiometria);

        $this->redirect("/siripoia/editar/id/" . $backUrl);
    }
    public function relatoriolistaAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelSiripoia = new Application_Model_Siripoia();
		$localSiripoia = $localModelSiripoia->selectEntrevistaSiripoia(NULL, array('fd_id', 'mnt_id', 'sir_id'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Siripóia');
		$modeloRelatorio->setLegenda(30, 'Ficha');
		$modeloRelatorio->setLegenda(80, 'Monit.');
		$modeloRelatorio->setLegenda(130, 'Siripóia');
		$modeloRelatorio->setLegenda(180, 'Pescador');
		$modeloRelatorio->setLegenda(350, 'Embarcação');

		foreach ( $localSiripoia as $key => $localData ) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['fd_id']);
			$modeloRelatorio->setValueAlinhadoDireita(80, 40, $localData['mnt_id']);
			$modeloRelatorio->setValueAlinhadoDireita(130, 40, $localData['sir_id']);
			$modeloRelatorio->setValue(180, $localData['tp_nome']);
			$modeloRelatorio->setValue(350, $localData['bar_nome']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_lista_entrevista_siripoia.pdf"');
        header("Content-type: application/x-pdf");
		echo $pdf->render();
    }

	public function relatorioAction(){
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelSiripoia = new Application_Model_Siripoia();
		$localSiripoia = $localModelSiripoia->selectEntrevistaSiripoia(NULL, array('fd_id', 'mnt_id', 'sir_id'), NULL);

		$localPesqueiro = $localModelSiripoia->selectSiripoiaHasPesqueiro(NULL, array('sir_id', 'paf_pesqueiro'), NULL);
		$localEspecie = $localModelSiripoia->selectSiripoiaHasEspCapturadas(NULL, array('sir_id', 'esp_nome_comum'), NULL);
		$localAvist = $localModelSiripoia->selectSiripoiaHasAvistamento(NULL, array('sir_id', 'avs_descricao'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório Entrevista de Siripóia');
		$modeloRelatorio->setLegendaOff();

		foreach ( $localSiripoia as $key => $localData ) {
			$modeloRelatorio->setLegValueAlinhadoDireita(30, 60, 'Ficha:', $localData['fd_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(90, 60, 'Monit.:',  $localData['mnt_id']);
			$modeloRelatorio->setLegValueAlinhadoDireita(150, 70, 'Siripóia:', $localData['sir_id']);
			$modeloRelatorio->setLegValue(220, 'Pescador: ', $localData['tp_nome']);
			$modeloRelatorio->setLegValue(450, 'Barco: ', $localData['bar_nome']);
			$modeloRelatorio->setNewLine();

			foreach ( $localPesqueiro as $key => $localDataPesqueiro ) {
				if ( $localDataPesqueiro['sir_id'] ==  $localData['sir_id'] ) {
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
				if ( $localDataEspecie['sir_id'] ==  $localData['sir_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Espécie: ',  $localDataEspecie['esp_nome_comum']);
					$modeloRelatorio->setLegValueAlinhadoDireita(280, 60, 'Quant:', $localDataEspecie['spc_quantidade']);
					$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Peso(kg):', number_format($localDataEspecie['spc_peso_kg'], 2, ',', ' '));
					$modeloRelatorio->setLegValueAlinhadoDireita(450, 120, 'Preço(R$/kg):', number_format($localDataEspecie['spc_preco'], 2, ',', ' '));
					$modeloRelatorio->setNewLine();
				}
			}
			foreach ( $localAvist as $key => $localDataAvist ) {
				if ( $localDataAvist['sir_id'] ==  $localData['sir_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Avist.: ',  $localDataAvist['avs_descricao']);
					$modeloRelatorio->setNewLine();
				}
			}
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_entrevista_siripoia.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }
}
