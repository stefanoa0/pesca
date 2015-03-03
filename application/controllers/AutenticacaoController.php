<?php

/**
 * Controller de autenticação
 *
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */
class AutenticacaoController extends Zend_Controller_Action {

    var $idHistorico;
    public function init() {
        
    }

    public function indexAction() {
        
    }

    /*
     * Login de usuários
     */
    public function loginAction() {
        $this->modelUsuario = new Application_Model_Usuario();
        $login = $this->_getParam('login');
        $login2 = $login;
        $senha = $this->_getParam('senha');

        if (empty($login) || empty($senha)) {
            $this->view->mensagem = "Preencha o formulário corretamente.";
        } else {
            $this->_helper->viewRenderer->setNoRender();

            $dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

            $authAdapter->setTableName('t_login')->setIdentityColumn('tl_login')->setCredentialColumn('tl_hashsenha');

            $authAdapter->setIdentity($login)->setCredential(sha1($senha));

            $result = $authAdapter->authenticate();

            if ($result->isValid()) {
                $usuario = $authAdapter->getResultRowObject();
                
                $storage = Zend_Auth::getInstance()->getStorage();
                
                $storage->write($usuario);
                //
                $idLogin = $this->modelUsuario->selectNomeLogin($login);
                $idUsuario = $this->modelUsuario->selectLogin($idLogin['tl_id']);
                $this->idHistorico = $this->modelUsuario->insertLogin($idUsuario['tu_id']);
                //
                $this->_redirect('index');
            } else {
                $this->_redirect('falha');
            }
        }
    }
    public function falhaAction(){}
    /*
     * Logout de usuários
     */
    public function logoutAction() {
        //
        $auth = Zend_Auth::getInstance();
        if($auth->hasIdentity()){
            $this->modelUsuario = new Application_Model_Usuario();
            
            $this->modelHistorico = new Application_Model_HistoricoLogin();
            $identity = $auth->getIdentity();
            $identity2 = get_object_vars($identity);
            $idUsuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
            $lastLogin = $this->modelHistorico->select('tu_id = '.$idUsuario['tu_id'], 'thl_id DESC',1);
            
            $this->modelUsuario->updateLogin($lastLogin[0]['thl_id'], $idUsuario['tu_id']);
            //
        }
        Zend_Auth::getInstance()->clearIdentity();
        
        $this->_redirect('index');
    }

}
