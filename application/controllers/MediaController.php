<?php

class MediaController extends Zend_Controller_Action {
    
    private $arrayMedia;
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
        
        $this->modelArrastoFundo = new Application_Model_ArrastoFundo();
    }
    
    public function indexAction(){
        
    }
    
    public function mediaespecieAction(){
        $especie = $this->_getParam("selectEspecie");
        
        
        $this->arrayMedia = $this->modelArrastoFundo->selectMediaEspecies('esp_id = '.$especie);
        
        //$this->assign('media',$this->arrayMedia[0]['max_permitido_peso']);
        
        return $this->arrayMedia[0]['max_permitido_peso'];
    }
}