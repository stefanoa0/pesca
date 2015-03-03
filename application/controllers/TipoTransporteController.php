<?php

class TipoTransporteController extends Zend_Controller_Action
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
        $this->ModelTipoTransporte = new Application_Model_TipoTransporte();
    }

    public function indexAction() {

        $dadosTipoTransporte = $this->ModelTipoTransporte->select(NULL, 'ttr_transporte', NULL);

        $this->view->assign("assignTipoTransporte", $dadosTipoTransporte);
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

        $this->ModelTipoTransporte->delete($this->_getParam('id'));

        $this->_redirect('tipo-transporte/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('ttr_transporte' => $this->_getParam("valor"));

        $this->ModelTipoTransporte->insert($setupDados);

        $this->_redirect("/tipo-transporte/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'ttr_id' => $this->_getParam("id"),
            'ttr_transporte' => $this->_getParam("valor")
        );

        $this->ModelTipoTransporte->update($setupDados);

        $this->_redirect("/tipo-transporte/index");

        return;
    }
}

