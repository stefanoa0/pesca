<?php

class TipoMotorController extends Zend_Controller_Action
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
        $this->ModelTipoMotor = new Application_Model_TipoMotor();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosTipoMotor = $this->ModelTipoMotor->select(NULL, 'tmot_tipo', NULL);

        $this->view->assign("assignTipoMotor", $dadosTipoMotor);
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

        $this->ModelTipoMotor->delete($this->_getParam('id'));

        $this->_redirect('tipo-motor/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tmot_tipo' => $this->_getParam("valor"));

        $this->ModelTipoMotor->insert($setupDados);

        $this->_redirect("/tipo-motor/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tmot_id' => $this->_getParam("id"),
            'tmot_tipo' => $this->_getParam("valor")
        );

        $this->ModelTipoMotor->update($setupDados);

        $this->_redirect("/tipo-motor/index");

        return;
    }

}

