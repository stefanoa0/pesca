<?php

class ConservacaoPescadoController extends Zend_Controller_Action
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
        $this->ModelConservacaoPescado = new Application_Model_ConservacaoPescado();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosConservacaoPescado = $this->ModelConservacaoPescado->select(NULL, 'tcp_conserva', NULL);

        $this->view->assign("assignConservacaoPescado", $dadosConservacaoPescado);
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

        $this->ModelConservacaoPescado->delete($this->_getParam('id'));

        $this->_redirect('conservacao-pescado/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tcp_conserva' => $this->_getParam("valor"));

        $this->ModelConservacaoPescado->insert($setupDados);

        $this->_redirect("/conservacao-pescado/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tcp_id' => $this->_getParam("id"),
            'tcp_conserva' => $this->_getParam("valor")
        );

        $this->ModelConservacaoPescado->update($setupDados);

        $this->_redirect("/conservacao-pescado/index");

        return;
    }

}

