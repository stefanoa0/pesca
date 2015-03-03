<?php

/** 
 * Controller da página Notícias
 * 
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class NoticiasController extends Zend_Controller_Action
{

    public function init()
    {   
      if(Zend_Auth::getInstance()->hasIdentity()){
            $this->_helper->layout->setLayout('admin');
            $auth = Zend_Auth::getInstance();
        if ( $auth->hasIdentity() ){
          $identity = $auth->getIdentity();
          //Converte do objeto para um array (tem que ser feito)
          $identity2 = get_object_vars($identity);

        }
        $this->modelUsuario = new Application_Model_Usuario();
        //Busca o usuário no banco pelo id do login
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario",$this->usuario);
        }
    }

    public function indexAction()
    {
        
    }


}

