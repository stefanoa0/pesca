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

