<?php

/** 
 * Model Login
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */


class Application_Model_Login
{ 
     
    public function update($senha, $login)
    {
        $dbTableLogin = new Application_Model_DbTable_Login();
        
        $dadosLogin = array(
            'tl_hashsenha'  => $senha
        );
        
        $whereLogin = $dbTableLogin->getAdapter()->quoteInto('"tl_login" = ?', $login);
        
        $dbTableLogin->update($dadosLogin, $whereLogin);
    }
    public function selectTentativa($login){
        $dbTableLogin = new Application_Model_DbTable_Login();
        
        $selectTentativa = $dbTableLogin->select('tl_tentativa')->where("tl_login =  '".$login."'");
        
        return $dbTableLogin->fetchAll($selectTentativa)->toArray();
    }
    public function updateTentativa($login, $value){
        
        $dbTableLogin = new Application_Model_DbTable_Login();
        $dadosLogin = array(
            'tl_tentativa'  => $value
        );
        
        $whereLogin = $dbTableLogin->getAdapter()->quoteInto('"tl_login" = ?', $login);
        
        $dbTableLogin->update($dadosLogin, $whereLogin);
    }
    public function selectAcesso($login){
        $dbTableLogin = new Application_Model_DbTable_Login();
        
        $selectAcesso = $dbTableLogin->select('tl_tempoacesso')->where("tl_login =  '".$login."'");
        
        return $dbTableLogin->fetchAll($selectAcesso)->toArray();
    }
    public function updateAcesso($login, $value){
        
        $dbTableLogin = new Application_Model_DbTable_Login();
        $dadosLogin = array(
            'tl_tempoacesso'  => $value
        );
        
        $whereLogin = $dbTableLogin->getAdapter()->quoteInto('"tl_login" = ?', $login);
        
        $dbTableLogin->update($dadosLogin, $whereLogin);
    }
    
}