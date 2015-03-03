<?php

class AcompanhadoController extends Zend_Controller_Action
{

    public function init()
    {
       $this->modelUsuario = new Application_Model_Usuario();
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');


        $auth = Zend_Auth::getInstance();
         if ( $auth->hasIdentity() ){
          $identity = $auth->getIdentity();
          $ArrayIdentity = get_object_vars($identity);

        }


        $this->usuario = $this->modelUsuario->selectLogin($ArrayIdentity['tl_id']);
        $this->view->assign("usuario",$this->usuario);
        $this->ModelAcompanhado = new Application_Model_Acompanhado();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosAcompanhado = $this->ModelAcompanhado->select(NULL, 'tacp_companhia', NULL);

        $this->view->assign("assignAcompanhado", $dadosAcompanhado);
    }

    public function deleteAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        else{
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->ModelAcompanhado->delete($this->_getParam('id'));

        $this->_redirect('acompanhado/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tacp_companhia' => $this->_getParam("valor"));

        $this->ModelAcompanhado->insert($setupDados);

        $this->_redirect("/acompanhado/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tacp_id' => $this->_getParam("id"),
            'tacp_companhia' => $this->_getParam("valor")
        );

        $this->ModelAcompanhado->update($setupDados);

        $this->_redirect("/acompanhado/index");

        return;
    }


}


