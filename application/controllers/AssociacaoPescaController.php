<?php

class AssociacaoPescaController extends Zend_Controller_Action
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
        $this->ModelAssociacaoPesca = new Application_Model_AssociacaoPesca();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosAssociacaoPesca = $this->ModelAssociacaoPesca->select(NULL, 'tasp_associacao', NULL);

        $this->view->assign("assignAssociacaoPesca", $dadosAssociacaoPesca);
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

        $this->ModelAssociacaoPesca->delete($this->_getParam('id'));

        $this->_redirect('associacao-pesca/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tasp_associacao' => $this->_getParam("valor"));

        $this->ModelAssociacaoPesca->insert($setupDados);

        $this->_redirect("/associacao-pesca/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tasp_id' => $this->_getParam("id"),
            'tasp_associacao' => $this->_getParam("valor")
        );

        $this->ModelAssociacaoPesca->update($setupDados);

        $this->_redirect("/associacao-pesca/index");

        return;
    }


}