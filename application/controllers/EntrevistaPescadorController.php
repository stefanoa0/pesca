<?php

class EntrevistaPescadorController extends Zend_Controller_Action
{

    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');

        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $identity2 = get_object_vars($identity);
        }

        $this->modelUsuario = new Application_Model_Usuario();
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario", $this->usuario);
        
        $this->modelEntrevistas = new Application_Model_Entrevistas();
    }

    public function indexAction()
    {
        $ent_pescador = $this->_getParam("tp_nome");
        $ent_barco = $this->_getParam("bar_nome");
        $ent_apelido = $this->_getParam("tp_apelido");
        $ent_porto = $this->_getParam("porto");
        $all = $this->_getParam("ent_all");
        $data = $this->_getParam('data');

        if ($ent_pescador) {
            $dados = $this->modelEntrevistas->select("tp_nome ~* '" . $ent_pescador . "'", array('tp_nome', 'id'));
        } elseif ($ent_barco) {
            $dados = $this->modelEntrevistas->select("bar_nome ~* '" . $ent_barco . "'", array('bar_nome', 'id'));
         }
        elseif ($ent_apelido){
            $dados = $this->modelEntrevistas->select("tp_apelido ~* '" . $ent_apelido . "'", array('tp_apelido', 'id'));
        }
        elseif ($ent_porto){
            $dados = $this->modelEntrevistas->select("pto_nome ~* '" . $ent_porto . "'", array('pto_nome', 'id'));
        }
        elseif($all){
            $dados = $this->modelEntrevistas->select(null, array('artepesca', 'tp_nome'));
        }
        elseif ($data){
            $data = date('Y-m-d', strtotime($data));
            $dados = $this->modelEntrevistas->select("date(data) = '".$data. "'" , array('data'));
        }
        else {
            $dados = $this->modelEntrevistas->select(null, array('artepesca', 'tp_nome'), 50);
        }

        $this->view->assign("dados", $dados);
    }
    
    

}

