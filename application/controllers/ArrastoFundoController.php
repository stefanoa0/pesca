<?php

class ArrastoFundoController extends Zend_Controller_Action {

    private $usuario;

    public function init() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $identity2 = get_object_vars($identity);
        }

        $this->modelUsuario = new Application_Model_Usuario();
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario", $this->usuario);

        $this->modelDestinoPescado = new Application_Model_DestinoPescado();
        $this->modelMonitoramento = new Application_Model_Monitoramento();
        $this->modelFichaDiaria = new Application_Model_FichaDiaria();
        $this->modelArrastoFundo = new Application_Model_ArrastoFundo();
        $this->modelPescador = new Application_Model_Pescador();
        $this->modelBarcos = new Application_Model_Barcos();
        $this->modelTipoEmbarcacao = new Application_Model_TipoEmbarcacao();
        $this->modelPesqueiro = new Application_Model_Pesqueiro();
        $this->modelEspecie = new Application_Model_Especie();
        $this->modelAvistamento = new Application_Model_Avistamento();
        $this->modelMaturidade = new Application_Model_Maturidade();
    }

    public function indexAction() {
        $pescadores = $this->modelPescador->select(null, 'tp_nome');
        $barcos = $this->modelBarcos->select(null, 'bar_nome');
        $tipoEmbarcacoes = $this->modelTipoEmbarcacao->select(null, 'tte_tipoembarcacao');
        $destinos = $this->modelDestinoPescado->select(null, 'dp_destino');

        $monitoramento = $this->modelMonitoramento->find($this->_getParam("idMonitoramento"));
        $this->naoexiste($monitoramento);
        
        $fichadiaria = $this->modelFichaDiaria->find($this->_getParam('id'));
        $this->naoexiste($fichadiaria);
        
        $this->view->assign('destinos', $destinos);
        $this->view->assign('fichaDiaria', $fichadiaria);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('pescadores', $pescadores);
        $this->view->assign('barcos', $barcos);
        $this->view->assign('tipoEmbarcacoes', $tipoEmbarcacoes);
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
            $dados = $this->modelArrastoFundo->selectEntrevistaArrasto("af_id>=" . $ent_id, array('af_id'), 50);
        } elseif ($ent_pescador) {
            $dados = $this->modelArrastoFundo->selectEntrevistaArrasto("tp_nome ~*'" . $ent_pescador . "'", array('tp_nome', 'af_id DESC'));
        } elseif ($ent_barco) {
            $dados = $this->modelArrastoFundo->selectEntrevistaArrasto("bar_nome ~* '" . $ent_barco . "'", array('bar_nome', 'af_id DESC'));
       }
        elseif ($ent_apelido){
            $dados = $this->modelArrastoFundo->selectEntrevistaArrasto("tp_apelido ~*'".$ent_apelido."'", array('tp_apelido', 'af_id DESC'));
        }
        else {
            $dados = $this->modelArrastoFundo->selectEntrevistaArrasto(null, array('fd_id DESC', 'tp_nome'), 20);
        }

        $this->view->assign("dados", $dados);
    }

    public function editarAction() {

        $entrevista = $this->modelArrastoFundo->find($this->_getParam('id'));
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
        
        
        $idEntrevista = $this->_getParam('id');
        
        
        $datahoraSaida[] = split(" ", $entrevista['af_dhsaida']);
        $datahoraVolta[] = split(" ", $entrevista['af_dhvolta']);
        $vArrastoFundo = $this->modelArrastoFundo->selectArrastoHasPesqueiro('af_id=' . $idEntrevista);
        $vEspecieCapturadas = $this->modelArrastoFundo->selectArrastoHasEspCapturadas('af_id=' . $idEntrevista);
        $vArrastoAvistamento = $this->modelArrastoFundo->selectArrastoHasAvistamento('af_id=' . $idEntrevista);           
        $vBioCamarao = $this->modelArrastoFundo->selectVBioCamarao('taf_id='.$idEntrevista);
        $vBioPeixe = $this->modelArrastoFundo->selectVBioPeixe('taf_id='.$idEntrevista);
        $maturidade = $this->modelMaturidade->select(null,'tmat_tipo');
        
        $this->view->assign('vBioCamarao', $vBioCamarao);
        $this->view->assign('vBioPeixe', $vBioPeixe);
        $this->view->assign('maturidade', $maturidade);
        $this->view->assign('especieCamarao', $especiesCamarao);
        $this->view->assign('destinos', $destinos);
        $this->view->assign('avistamentos', $avistamentos);
        $this->view->assign('vArrastoAvistamento', $vArrastoAvistamento);
        $this->view->assign('dataSaida', $datahoraSaida[0][0]);
        $this->view->assign('horaSaida', $datahoraSaida[0][1]);
        $this->view->assign('dataVolta', $datahoraVolta[0][0]);
        $this->view->assign('horaVolta', $datahoraVolta[0][1]);
        $this->view->assign('monitoramento', $monitoramento);
        $this->view->assign('vEspecieCapturadas', $vEspecieCapturadas);
        $this->view->assign('vArrastoFundo', $vArrastoFundo);
        $this->view->assign("entrevista", $entrevista);
        $this->view->assign('pescadores', $pescadores);
        $this->view->assign('barcos', $barcos);
        $this->view->assign('tipoEmbarcacoes', $tipoEmbarcacoes);
        $this->view->assign('pesqueiros', $pesqueiros);
        $this->view->assign('especies', $especies);
    }

    public function atualizarAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idArrasto = $this->_getParam('id_entrevista');
        
        $monitoramento = $this->modelMonitoramento->select('mnt_id='.$this->_getParam('id_monitoramento'));
        
        
        if($monitoramento[0]['fd_id'] != $this->_getParam('id_fichaDiaria')){
            $this->_redirect('arrasto-fundo/error');  
        }
        else{
            $this->modelArrastoFundo->update($this->_getAllParams());
        }
        $this->_redirect('arrasto-fundo/editar/id/' . $idArrasto);
    }

    public function errorAction(){
        
    }
    
    public function criarAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idArrasto = $this->modelArrastoFundo->insert($this->_getAllParams());

        $this->_redirect('arrasto-fundo/editar/id/' . $idArrasto);
    }
    public function excluirAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelArrastoFundo->delete($this->_getParam('id'));

        $idFicha = $this->_getParam('id_ficha');
        if(empty($idFicha)){
            $this->_redirect('arrasto-fundo/visualizar');
        }
        else{
            $this->_redirect('ficha-diaria/editar/id/'.$idFicha);
        }

    }

    public function insertpesqueiroAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $pesqueiro = $this->_getParam("nomePesqueiro");

        $tempopesqueiro = $this->_getParam("tempoPesqueiro");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");

        $this->modelArrastoFundo->insertPesqueiro($idEntrevista, $pesqueiro, $tempopesqueiro);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
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

        $this->modelArrastoFundo->insertBioCamarao($idEntrevista, $idEspecie, $sexo, $maturidade, $compCabeca, $peso);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
    }
    public function deletebiocamaraoAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idBiometria = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelArrastoFundo->deleteBioCamarao($idBiometria);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
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

        $this->modelArrastoFundo->insertBioPeixe($idEntrevista, $idEspecie, $sexo, $comprimento, $peso);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
    }
    public function deletebiopeixeAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idBiometria = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelArrastoFundo->deleteBioPeixe($idBiometria);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
    }
    public function deletepesqueiroAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevistaHasPesqueiro = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelArrastoFundo->deletePesqueiro($idEntrevistaHasPesqueiro);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
    }
    

    public function insertespeciecapturadaAction() {
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

        $this->modelArrastoFundo->insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $preco);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
    }

    public function deletespecieAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idEntrevistaHasEspecie = $this->_getParam("id");

        $backUrl = $this->_getParam("back_url");

        $this->modelArrastoFundo->deleteEspCapturada($idEntrevistaHasEspecie);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
    }

    public function insertavistamentoAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $avistamento = $this->_getParam("SelectAvistamento");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");

        $this->modelArrastoFundo->insertAvistamento($idEntrevista, $avistamento);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
    }

    public function deleteavistamentoAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idAvistamento = $this->_getParam("id_avistamento");

        $idEntrevista = $this->_getParam("id_entrevista");

        $backUrl = $this->_getParam("back_url");

        $this->modelArrastoFundo->deleteAvistamento($idAvistamento, $idEntrevista);

        $this->redirect("/arrasto-fundo/editar/id/" . $backUrl);
    }

    public function relatoriolistaAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelArrastoFundo = new Application_Model_ArrastoFundo();
        $localArrastoFundo = $localModelArrastoFundo->selectEntrevistaArrasto(NULL, array('fd_id', 'mnt_id', 'af_id'), NULL);

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório Entrevista de Arrasto de Fundo');
        $modeloRelatorio->setLegenda(30, 'Ficha');
        $modeloRelatorio->setLegenda(80, 'Monit.');
        $modeloRelatorio->setLegenda(130, 'Arrasto');
        $modeloRelatorio->setLegenda(180, 'Pescador');
        $modeloRelatorio->setLegenda(350, 'Embarcação');

        foreach ($localArrastoFundo as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['fd_id']);
            $modeloRelatorio->setValueAlinhadoDireita(80, 40, $localData['mnt_id']);
            $modeloRelatorio->setValueAlinhadoDireita(130, 40, $localData['af_id']);
            $modeloRelatorio->setValue(180, $localData['tp_nome']);
            $modeloRelatorio->setValue(350, $localData['bar_nome']);
            $modeloRelatorio->setNewLine();
        }
        $modeloRelatorio->setNewLine();
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_entrevista_arrastofundo.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

    public function relatorioAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelArrastoFundo = new Application_Model_ArrastoFundo();
        $localArrastoFundo = $localModelArrastoFundo->selectEntrevistaArrasto(NULL, array('fd_id', 'mnt_id', 'af_id'), NULL);

        $localPesqueiro = $localModelArrastoFundo->selectArrastoHasPesqueiro(NULL, array('af_id', 'paf_pesqueiro'), NULL);
        $localEspecie = $localModelArrastoFundo->selectArrastoHasEspCapturadas(NULL, array('af_id', 'esp_nome_comum'), NULL);
        $localAvist = $localModelArrastoFundo->selectArrastoHasAvistamento(NULL, array('af_id', 'avs_descricao'), NULL);

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório Entrevista de Arrasto de Fundo');
        $modeloRelatorio->setLegendaOff();

        foreach ($localArrastoFundo as $key => $localData) {
            $modeloRelatorio->setLegValueAlinhadoDireita(30, 60, 'Ficha:', $localData['fd_id']);
            $modeloRelatorio->setLegValueAlinhadoDireita(90, 60, 'Monit.:', $localData['mnt_id']);
            $modeloRelatorio->setLegValueAlinhadoDireita(150, 70, 'A.Fundo:', $localData['af_id']);
            $modeloRelatorio->setLegValue(220, 'Pescador: ', $localData['tp_nome']);
            $modeloRelatorio->setLegValue(450, 'Barco: ', $localData['bar_nome']);
            $modeloRelatorio->setNewLine();

            foreach ($localPesqueiro as $key => $localDataPesqueiro) {
				if ( $localDataPesqueiro['af_id'] ==  $localData['af_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Pesqueiro: ', $localDataPesqueiro['paf_pesqueiro']);
					if ($localDataPesqueiro['t_tempopesqueiro'] !== NULL) {
						$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Tempo (H:M):', date_format(date_create($localDataPesqueiro['t_tempopesqueiro']), 'H:i'));
					} else {
						$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Tempo (H:M):', "00:00");
					}
					$modeloRelatorio->setLegValueAlinhadoDireita(450, 120, 'Distância:', number_format($localDataPesqueiro['t_distapesqueiro'], 2, ',', ' '));
					$modeloRelatorio->setNewLine();
				}
            }
            foreach ($localEspecie as $key => $localDataEspecie) {
				if ( $localDataEspecie['af_id'] ==  $localData['af_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Espécie: ', $localDataEspecie['esp_nome_comum']);
					$modeloRelatorio->setLegValueAlinhadoDireita(280, 60, 'Quant:', $localDataEspecie['spc_quantidade']);
					$modeloRelatorio->setLegValueAlinhadoDireita(350, 90, 'Peso(kg):', number_format($localDataEspecie['spc_peso_kg'], 2, ',', ' '));
					$modeloRelatorio->setLegValueAlinhadoDireita(450, 120, 'Preço(R$/kg):', number_format($localDataEspecie['spc_preco'], 2, ',', ' '));
					$modeloRelatorio->setNewLine();
				}
            }
            foreach ($localAvist as $key => $localDataAvist) {
				if ( $localDataAvist['af_id'] ==  $localData['af_id'] ) {
					$modeloRelatorio->setLegValue(80, 'Avist.: ', $localDataAvist['avs_descricao']);
					$modeloRelatorio->setNewLine();
				}
            }
        }
        $modeloRelatorio->setNewLine();
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_entrevista_arrastofundo.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

    public function relatoriogroupespeciecapturadaAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelArrastoFundo = new Application_Model_ArrastoFundo();
        $localArrastoFundo = $localModelArrastoFundo->select_ArrastoFundo_group_EspecieCapturada();

        require_once "../library/ModeloRelatorioHorizontal.php";
        $modeloRelatorio = new ModeloRelatorioHorizontal();
        $modeloRelatorio->setTitulo('Relatório Arrasto de Fundo - Espécie Capturada');
        $modeloRelatorio->setLegenda(30, 'Quant.');
        $modeloRelatorio->setLegenda(80, 'Espécie');
        $modeloRelatorio->setLegendaCenter(200, 120, 'Quantidade (Max/Méd/Min)');
        $modeloRelatorio->setLegendaCenter(360, 120, 'Peso(kg) (Max/Méd/Min)');
        $modeloRelatorio->setLegendaCenter(520, 120, 'Preço(R$/kg)(Max/Méd/Min)');

        $tmpQuant = 0;
        foreach ($localArrastoFundo as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['count']);
            $tmpQuant = $tmpQuant +  $localData['count'];
            $modeloRelatorio->setValue(80, $localData['esp_nome_comum']);
            $modeloRelatorio->setValueAlinhadoDireita(200, 40, $localData['max_quant']);
            $modeloRelatorio->setValueAlinhadoDireita(240, 40, number_format($localData['avg_quant'], 2, ',', ' '));
            $modeloRelatorio->setValueAlinhadoDireita(280, 40, $localData['min_quant']);

            $modeloRelatorio->setValueAlinhadoDireita(360, 40, number_format($localData['max_peso'], 2, ',', ' '));
            $modeloRelatorio->setValueAlinhadoDireita(400, 40, number_format($localData['avg_peso'], 2, ',', ' '));
            $modeloRelatorio->setValueAlinhadoDireita(440, 40, number_format($localData['min_peso'], 2, ',', ' '));

            $modeloRelatorio->setValueAlinhadoDireita(520, 40, number_format($localData['max_preco'], 2, ',', ' '));
            $modeloRelatorio->setValueAlinhadoDireita(560, 40, number_format($localData['avg_preco'], 2, ',', ' '));
            $modeloRelatorio->setValueAlinhadoDireita(600, 40, number_format($localData['min_preco'], 2, ',', ' '));

            $modeloRelatorio->setNewLine();
        }
        $modeloRelatorio->setNewLine();
        $modeloRelatorio->setValueAlinhadoDireita(30, 40, $tmpQuant);
        $modeloRelatorio->setValue(80, 'Total de Capturadas');
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_entrevista_arrastofundo_group_especie.pdf"');
        header("Content-type: application/pdf");
        echo $pdf->render();
    }

    public function relatoriogroupesqueiroAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelArrastoFundo = new Application_Model_ArrastoFundo();
        $localArrastoFundo = $localModelArrastoFundo->select_ArrastoFundo_group_Pesqueiro();

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório  Arrasto de Fundo - Pesqueiro');
        $modeloRelatorio->setLegenda(30, 'Quant.');
        $modeloRelatorio->setLegenda(80, 'Pesqueiro');
        $modeloRelatorio->setLegendaCenter(250, 150, 'Tempo (H:M) (Max/Méd/Min)');

        $tmpQuant = 0;
        foreach ($localArrastoFundo as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['count']);
            $tmpQuant = $tmpQuant +  $localData['count'];
            $modeloRelatorio->setValue(80, $localData['paf_pesqueiro']);
            $modeloRelatorio->setValueAlinhadoDireita(250, 50, date_format(date_create($localData['max_tempo']), 'H:i'));
            $modeloRelatorio->setValueAlinhadoDireita(300, 50, date_format(date_create($localData['avg_tempo']), 'H:i'));
            $modeloRelatorio->setValueAlinhadoDireita(350, 50, date_format(date_create($localData['min_tempo']), 'H:i'));

            $modeloRelatorio->setNewLine();
        }
        $modeloRelatorio->setNewLine();
        $modeloRelatorio->setValueAlinhadoDireita(30, 40, $tmpQuant);
        $modeloRelatorio->setValue(80, 'Total de Pesqueiros');
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_entrevista_arrastofundo_group_pesqueiro.pdf"');
        header("Content-type: application/pdf");
        echo $pdf->render();
    }
    

}
