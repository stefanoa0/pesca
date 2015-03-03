<?php

class HorarioPescaController extends Zend_Controller_Action
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
        $this->ModelHorarioPesca = new Application_Model_HorarioPesca();
    }

    public function indexAction() {
        
        $dadosHorarioPesca = $this->ModelHorarioPesca->select(NULL, 'thp_horario', NULL);

        $this->view->assign("assignHorarioPesca", $dadosHorarioPesca);
    }

    public function deleteAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        else{
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->ModelHorarioPesca->delete($this->_getParam('id'));

        $this->_redirect('horario-pesca/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('thp_horario' => $this->_getParam("valor"));

        $this->ModelHorarioPesca->insert($setupDados);

        $this->_redirect("/horario-pesca/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21 | $this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'thp_id' => $this->_getParam("id"),
            'thp_horario' => $this->_getParam("valor")
        );

        $this->ModelHorarioPesca->update($setupDados);

        $this->_redirect("/horario-pesca/index");

        return;
    }


}

