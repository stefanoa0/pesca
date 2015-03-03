<?php

class InsumosController extends Zend_Controller_Action
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
        $this->ModelInsumo = new Application_Model_Insumo(  );
    }

    public function indexAction() {
        
        $dadosInsumo = $this->ModelInsumo->select(NULL, 'tin_insumo', NULL);

        $this->view->assign("assignInsumo", $dadosInsumo);
    }

    public function deleteAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        else{
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->ModelInsumo->delete($this->_getParam('id'));

        $this->_redirect('insumos/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tin_insumo' => $this->_getParam("valor"));

        $this->ModelInsumo->insert($setupDados);

        $this->_redirect("/insumos/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tin_id' => $this->_getParam("id"),
            'tin_insumo' => $this->_getParam("valor")
        );

        $this->ModelInsumo->update($setupDados);

        $this->_redirect("/insumos/index");

        return;
    }

}

