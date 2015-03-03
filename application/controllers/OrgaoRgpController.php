<?php

class OrgaoRgpController extends Zend_Controller_Action
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
        $this->ModelOrgaoRgp = new Application_Model_OrgaoRgp();
    }

    public function indexAction() {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $dadosOrgaoRgp = $this->ModelOrgaoRgp->select(NULL, 'trgp_emissor', NULL);

        $this->view->assign("assignOrgaoRgp", $dadosOrgaoRgp);
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

        $this->ModelOrgaoRgp->delete($this->_getParam('id'));

        $this->_redirect('orgao-rgp/index');
        }
    }


    public function insertAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array('trgp_emissor' => $this->_getParam("valor"));

        $this->ModelOrgaoRgp->insert($setupDados);

        $this->_redirect("/orgao-rgp/index");

        return;
    }

    public function updateAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $setupDados = array(
            'trgp_id' => $this->_getParam("id"),
            'trgp_emissor' => $this->_getParam("valor")
        );

        $this->ModelOrgaoRgp->update($setupDados);

        $this->_redirect("/orgao-rgp/index");

        return;
    }

}

