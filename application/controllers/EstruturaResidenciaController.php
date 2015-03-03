<?php

class EstruturaResidenciaController extends Zend_Controller_Action
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
        $this->ModelEstruturaResidencial = new Application_Model_EstruturaResidencial();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosEstruturaResidencial = $this->ModelEstruturaResidencial->select(NULL, 'terd_estrutura', NULL);

        $this->view->assign("assignEstruturaResidencial", $dadosEstruturaResidencial);
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

        $this->ModelEstruturaResidencial->delete($this->_getParam('id'));

        $this->_redirect('estrutura-residencia/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('terd_estrutura' => $this->_getParam("valor"));

        $this->ModelEstruturaResidencial->insert($setupDados);

        $this->_redirect("/estrutura-residencia/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'terd_id' => $this->_getParam("id"),
            'terd_estrutura' => $this->_getParam("valor")
        );

        $this->ModelEstruturaResidencial->update($setupDados);

        $this->_redirect("/estrutura-residencia/index");

        return;
    }


}

