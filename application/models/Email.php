<?php
/** 
 * Model Email
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Email
{
    private $mensagem;
    private $assunto;
    private $destinatario;

    public function  __construct($mensagem, $assunto, $destinatarioEmail, $destinatarioNome) {
        $this->assunto = utf8_decode($assunto);
        $this->mensagem = $mensagem;
        $this->destinatario['email'] = utf8_decode($destinatarioEmail);
        $this->destinatario['nome'] = utf8_decode($destinatarioNome);
    }

    public function enviar(){
        $settings = array(
            'ssl'=>'ssl',
            'port'=>465,
            'auth' => 'login',
            'username' => 'noreply.pesca@gmail.com',
            'password' => 'Pesca@Pesca'
            );
        
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $settings);
        $email_from = "noreply.pesca@gmail.com";
        $name_from = "Pesca";
        $email_to = $this->destinatario['email'];
        $name_to = $this->destinatario['nome'];

        $mail = new Zend_Mail ();
        $mail->setReplyTo($email_from, $name_from);
        $mail->setFrom ($email_from, $name_from);
        $mail->addTo ($email_to, $name_to);
        $mail->setSubject ($this->assunto);
        $mail->setBodyText ($this->mensagem);
        $mail->send($transport);
    }

    private function getConfiguracao(){        
        $conta = "noreply.pesca@gmail.com,";
        $senha = "Pesca@Pesca";

        $config = array (
            'auth' => 'login',
            'username' => $conta,
            'password' => $senha,
            'ssl' => 'tls',
            'auth' => 'login',
            'port' => 25
        );

        return $config;
    }

}

