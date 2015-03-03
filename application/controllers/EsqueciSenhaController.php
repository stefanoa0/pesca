<?php

class EsqueciSenhaController extends Zend_Controller_Action
{
    private $usuario;
    public function init()
    {   
        
        
    }

    public function indexAction()
    {
        
    }
    
    public function solicitarAction()
    {
        $email = $this->_getParam('email');
        
        $modelUsuario = new Application_Model_Usuario();
        
        $usuario = $modelUsuario->select('"tu_email" = \''.$email.'\'');
        
        if ($usuario)
        {
            $token = sha1($usuario[0]['tu_email'] . time());
            $modelAlteracaoSenha = new Application_Model_AlteracaoSenha();
            $modelAlteracaoSenha->solicitar($usuario[0]['tu_id'], $token);
            
            $mensagem = "Clique no link a seguir para alterar a sua senha: ";
            $mensagem .= "esqueci-senha/redefinir/". $token;
            $assunto = 'Redefinir a senha no Pesca.';
            
            $email = new Application_Model_Email($mensagem, $assunto, $usuario[0]['tu_email'], $usuario[0]['tu_nome']);
            $email->enviar();
            
            $this->view->mensagem = "Uma mensagem com instruções para redefinir a senha foi 
                enviada para seu endereço de e-mail.<br />
                Verifique sua caixa de entrada!";
        }
        else
        {
            $this->view->mensagem = "E-mail não cadastrado.";
        }        
        
    }
    
    public function redefinirAction()
    {
        $token = $this->_getParam('token');
        
        $modelAlteracaoSenha = new Application_Model_AlteracaoSenha();
        $alteracaoSenha = $modelAlteracaoSenha->find($token);
        
        if ($alteracaoSenha)
        {
            $alteracaoSenha = $alteracaoSenha[0];
            
            if ($alteracaoSenha['tas_dataalteracao'])
            {
                $this->view->mensagem = "Solicitação já atendida.";
            }
            else
            {            
                $modelUsuario = new Application_Model_Usuario();
                $usuario = $modelUsuario->find($alteracaoSenha['tu_id']);

                $this->view->login = $usuario['tl_login'];
                $this->view->token = $token;
            }
        }
        else
        {
            $this->view->mensagem = "Token não cadastrado.";
        }
    }
    
    public function atualizarAction()
    {
        $modelLogin = new Application_Model_Login();
        $modelAlteracaoSenha = new Application_Model_AlteracaoSenha();
        
        $senha1 = sha1($this->_getParam('senha1'));
        $senha2 = sha1($this->_getParam('senha2'));
        
        if ( $senha1 == $senha2 )
        {
            $modelLogin->update($senha1, $this->_getParam('login'));
            $modelAlteracaoSenha->update($this->_getParam('token'));            
            
            $this->view->mensagem = "Senha alterada com sucesso!";
        }
        else
        {
            $this->view->mensagem = "As senhas digitadas não coincidem.";
        }
    }
}

