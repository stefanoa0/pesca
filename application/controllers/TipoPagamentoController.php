<?php

class TipoPagamentoController extends Zend_Controller_Action
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
        $this->ModelTipoPagamento = new Application_Model_TipoPagamento();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosTipoPagamento = $this->ModelTipoPagamento->select(NULL, 'tpg_pagamento', NULL);

        $this->view->assign("assignTipoPagamento", $dadosTipoPagamento);
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

        $this->ModelTipoPagamento->delete($this->_getParam('id'));

        $this->_redirect('tipo-pagamento/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tpg_pagamento' => $this->_getParam("valor"));

        $this->ModelTipoPagamento->insert($setupDados);

        $this->_redirect("/tipo-pagamento/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tpg_id' => $this->_getParam("id"),
            'tpg_pagamento' => $this->_getParam("valor")
        );

        $this->ModelTipoPagamento->update($setupDados);

        $this->_redirect("/tipo-pagamento/index");

        return;
    }

}

