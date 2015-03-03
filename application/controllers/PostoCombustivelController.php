<?php

class PostoCombustivelController extends Zend_Controller_Action
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
        $this->ModelPostoCombustivel = new Application_Model_PostoCombustivel();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosPostoCombustivel = $this->ModelPostoCombustivel->select(NULL, 'tpc_posto', NULL);

        $this->view->assign("assignPostoCombustivel", $dadosPostoCombustivel);
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

        $this->ModelPostoCombustivel->delete($this->_getParam('id'));

        $this->_redirect('posto-combustivel/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tpc_posto' => $this->_getParam("valor"));

        $this->ModelPostoCombustivel->insert($setupDados);

        $this->_redirect("/posto-combustivel/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tpc_id' => $this->_getParam("id"),
            'tpc_posto' => $this->_getParam("valor")
        );

        $this->ModelPostoCombustivel->update($setupDados);

        $this->_redirect("/posto-combustivel/index");

        return;
    }


}

