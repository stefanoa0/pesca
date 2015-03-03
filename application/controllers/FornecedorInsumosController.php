<?php

class FornecedorInsumosController extends Zend_Controller_Action
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
        $this->ModelFornecedorInsumos = new Application_Model_FornecedorInsumos();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosFornecedorInsumos = $this->ModelFornecedorInsumos->select(NULL, 'tfi_fornecedor', NULL);

        $this->view->assign("assignFornecedorInsumos", $dadosFornecedorInsumos);
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

        $this->ModelFornecedorInsumos->delete($this->_getParam('id'));

        $this->_redirect('fornecedor-insumos/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tfi_fornecedor' => $this->_getParam("valor"));

        $this->ModelFornecedorInsumos->insert($setupDados);

        $this->_redirect("/fornecedor-insumos/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tfi_id' => $this->_getParam("id"),
            'tfi_fornecedor' => $this->_getParam("valor")
        );

        $this->ModelFornecedorInsumos->update($setupDados);

        $this->_redirect("/fornecedor-insumos/index");

        return;
    }

}

