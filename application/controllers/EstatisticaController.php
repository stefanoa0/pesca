<?php

class EstatisticaController extends Zend_Controller_Action
{

    public function init()
    {
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
    }

    public function indexAction()
    {
        // action body
    }
    
    public function pescadorAction()
    {
        $this->modelPescador = new Application_Model_Pescador();
        $this->modelArrasto = new Application_Model_ArrastoFundo();
        $this->modelCalao = new Application_Model_Calao();
        $this->modelColetaManual = new Application_Model_ColetaManual();
        $this->modelEsmalhe = new Application_Model_Esmalhe();
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
        //Quantidade de Pescadores
        $pescadores = $this->modelPescador->selectView();
        $quantPescador = count($pescadores);
        $this->view->assign("quantPescadores", $quantPescador);
        
        //Quantidade de Pescadores por gênero
        $consultaGenero = $this->modelPescador->selectPescadorBySexo();
        $this->view->assign("generoPescador", $consultaGenero);
        
        //Quantidade de Pescadores por porto e por arte de pesca
        //Arrasto de Fundo
        $arrastoPescadoresPorto = $this->modelArrasto->selectPescadoresByPorto();
        $this->view->assign("arrastoPescadoresPorto", $arrastoPescadoresPorto);
        
        //Calao
        $calaoPescadoresPorto = $this->modelCalao->selectPescadoresByPorto();
        $this->view->assign("calaoPescadoresPorto", $calaoPescadoresPorto);
        
        //ColetaManual
        $coletaManualPescadoresPorto = $this->modelCalao->selectPescadoresByPorto();
        $this->view->assign("coletaManualPescadoresPorto", $coletaManualPescadoresPorto);
        
        //Esmalhe
        $esmalhePescadoresPorto = $this->modelEsmalhe->selectPescadoresByPorto();
        $this->view->assign("esmalhePescadoresPorto", $esmalhePescadoresPorto);
        
        //Grosseira
        $grosseiraPescadoresPorto = $this->modelGrosseira->selectPescadoresByPorto();
        $this->view->assign("grosseiraPescadoresPorto", $grosseiraPescadoresPorto);
        
        //Jerere
        $jererePescadoresPorto = $this->modelJerere->selectPescadoresByPorto();
        $this->view->assign("jererePescadoresPorto", $jererePescadoresPorto);
        
        //Linha
        $linhaPescadoresPorto = $this->modelLinha->selectPescadoresByPorto();
        $this->view->assign("linhaPescadoresPorto", $linhaPescadoresPorto);
        
        //LinhaFundo
        $linhaFundoPescadoresPorto = $this->modelLinhaFundo->selectPescadoresByPorto();
        $this->view->assign("linhaFundoPescadoresPorto", $linhaFundoPescadoresPorto);
        
        //Manzua
        $manzuaPescadoresPorto = $this->modelManzua->selectPescadoresByPorto();
        $this->view->assign("manzuaPescadoresPorto", $manzuaPescadoresPorto);
        
        //Mergulho
        $mergulhoPescadoresPorto = $this->modelMergulho->selectPescadoresByPorto();
        $this->view->assign("mergulhoPescadoresPorto", $mergulhoPescadoresPorto);
        
        //Ratoeira
        $ratoeiraPescadoresPorto = $this->modelRatoeira->selectPescadoresByPorto();
        $this->view->assign("ratoeiraPescadoresPorto", $ratoeiraPescadoresPorto);
        
        //Siripoia
        $siripoiaPescadoresPorto = $this->modelSiripoia->selectPescadoresByPorto();
        $this->view->assign("siripoiaPescadoresPorto", $siripoiaPescadoresPorto);
        
        //Tarrafa
        $tarrafaPescadoresPorto = $this->modelTarrafa->selectPescadoresByPorto();
        $this->view->assign("tarrafaPescadoresPorto", $tarrafaPescadoresPorto);
        
        //VaraPesca
        $varaPescaPescadoresPorto = $this->modelVaraPesca->selectPescadoresByPorto();
        $this->view->assign("varaPescaPescadoresPorto", $varaPescaPescadoresPorto);
    }
    
    public function barcoAction()
    {
    
    }
    
    public function entrevistaAction()
    {
        // action body
    }
    
    public function capturaAction()
    {
        // action body
    }
    
    public function avistamentoAction()
    {
        // action body
    }
}

