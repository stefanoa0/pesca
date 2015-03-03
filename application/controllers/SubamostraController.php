<?php

class SubamostraController extends Zend_Controller_Action
{

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
        
        
        $this->modelSubamostra = new Application_Model_Subamostra();
    }

    public function indexAction()
    {
        $subamostras = $this->modelSubamostra->select(null, 'sa_datachegada');
        
        $this->view->assign('subamostras', $subamostras);
    }

    
}

