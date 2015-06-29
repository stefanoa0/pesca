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
        date_default_timezone_set('America/Bahia');
    }

    public function indexAction() {
        
    }

    /*
     * Login de usuários
     */
    public function loginAction() {
        $this->modelUsuario = new Application_Model_Usuario();
        $this->modelLogin = new Application_Model_Login();
        $login = $this->_getParam('login');
        $login2 = $login;
        $senha = $this->_getParam('senha');
        $max_acesso = 3;
        //$now = date('Y-m-d H:i:s');
        $agora = new DateTime("now");
        $trintamin = date_add($agora,date_interval_create_from_date_string('30 minutes'));

        
        if (empty($login) || empty($senha)) {
            $this->view->mensagem = "Preencha o formulário corretamente.";
        } else {
            $this->_helper->viewRenderer->setNoRender();

            $dbAdapter = Zend_Db_Table_Abstract::getDefaultAdapter();
            $authAdapter = new Zend_Auth_Adapter_DbTable($dbAdapter);

            $authAdapter->setTableName('t_login')->setIdentityColumn('tl_login')->setCredentialColumn('tl_hashsenha');

            $authAdapter->setIdentity($login)->setCredential(sha1($senha));

            $result = $authAdapter->authenticate();
            $tentativa = $this->modelLogin->selectTentativa($login);
            $tentativaVal = $tentativa[0]['tl_tentativa'];
            $tempoAcesso = $this->modelLogin->selectAcesso($login);
            $tempoAcessoVal = $tempoAcesso[0]['tl_tempoacesso'];
            
                
            if($tempoAcessoVal >= date('Y-m-d H:i:s')){
                $this->_redirect('index/errorlogin');
            }
            else{
                    
                    $this->modelLogin->updateTentativa($login, 0);
                    $this->modelLogin->updateAcesso($login, null);
                if ($result->isValid() && $tentativaVal < $max_acesso) {
                    $usuario = $authAdapter->getResultRowObject();

                    $storage = Zend_Auth::getInstance()->getStorage();

                    $storage->write($usuario);
                    //
                    $idLogin = $this->modelUsuario->selectNomeLogin($login);
                    $idUsuario = $this->modelUsuario->selectLogin($idLogin['tl_id']);
                    $this->idHistorico = $this->modelUsuario->insertLogin($idUsuario['tu_id']);
                    //
                    $this->_redirect('index-admin/index');
                } 
                    
                else {
                    $tentativa = $this->modelLogin->selectTentativa($login);
                    $tentativaVal = $tentativa[0]['tl_tentativa'];
                    $valorTentativa = intval($tentativaVal);
                    $valorTentativaVal= $valorTentativa+1;
                    $this->modelLogin->updateTentativa($login, $valorTentativaVal);
                    if($tentativaVal >= $max_acesso){
                        $this->modelLogin->updateAcesso($login, $trintamin->format('Y-m-d H:i:s'));
                    }
                    $this->_redirect('index/falha');
                }
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
