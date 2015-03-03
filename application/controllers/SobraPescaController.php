<?php

class SobraPescaController extends Zend_Controller_Action
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
        $this->ModelSobraDaPesca = new Application_Model_SobraDaPesca();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosSobraDaPesca = $this->ModelSobraDaPesca->select(NULL, 'tsp_sobra', NULL);

        $this->view->assign("assignSobraDaPesca", $dadosSobraDaPesca);
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

        $this->ModelSobraDaPesca->delete($this->_getParam('id'));

        $this->_redirect('sobra-pesca/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tsp_sobra' => $this->_getParam("valor"));

        $this->ModelSobraDaPesca->insert($setupDados);

        $this->_redirect("/sobra-pesca/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tsp_id' => $this->_getParam("id"),
            'tsp_sobra' => $this->_getParam("valor")
        );

        $this->ModelSobraDaPesca->update($setupDados);

        $this->_redirect("/sobra-pesca/index");

        return;
    }


}

