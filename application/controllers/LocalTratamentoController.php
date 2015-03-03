<?php

class LocalTratamentoController extends Zend_Controller_Action
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
        $this->ModelLocalTratamento = new Application_Model_LocalTratamento();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosLocalTratamento = $this->ModelLocalTratamento->select(NULL, 'tlt_local', NULL);

        $this->view->assign("assignLocalTratamento", $dadosLocalTratamento);
    }

    public function deleteAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id'] == 5){
            $this->_redirect('index');
        }
        else{
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->ModelLocalTratamento->delete($this->_getParam('id'));

        $this->_redirect('local-tratamento/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id'] == 5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tlt_local' => $this->_getParam("valor"));

        $this->ModelLocalTratamento->insert($setupDados);

        $this->_redirect("/local-tratamento/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id'] == 5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tlt_id' => $this->_getParam("id"),
            'tlt_local' => $this->_getParam("valor")
        );

        $this->ModelLocalTratamento->update($setupDados);

        $this->_redirect("/local-tratamento/index");

        return;
    }

}

