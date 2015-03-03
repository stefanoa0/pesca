<?php

class SavatagemController extends Zend_Controller_Action
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
        $this->ModelSavatagem = new Application_Model_Savatagem();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosSavatagem = $this->ModelSavatagem->select(NULL, 'tsav_savatagem', NULL);

        $this->view->assign("assignSavatagem", $dadosSavatagem);
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

        $this->ModelSavatagem->delete($this->_getParam('id'));

        $this->_redirect('savatagem/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('tsav_savatagem' => $this->_getParam("valor"));

        $this->ModelSavatagem->insert($setupDados);

        $this->_redirect("/savatagem/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'tsav_id' => $this->_getParam("id"),
            'tsav_savatagem' => $this->_getParam("valor")
        );

        $this->ModelSavatagem->update($setupDados);

        $this->_redirect("/savatagem/index");

        return;
    }
}

