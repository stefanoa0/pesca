<?php
/** 
 * Model Alteracao de Senha
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_AlteracaoSenha
{
    public function solicitar($idUsuario, $token)
    {
        date_default_timezone_set('America/Bahia');
        $dados = array(
            "tas_token"           => $token,
            "tas_datasolicitacao" => date('Y-m-d H:i:s'),
            "tu_id"               => $idUsuario
        );
        
        $dbTableAlteracaoSenha = new Application_Model_DbTable_AlteracaoSenha();
        return $dbTableAlteracaoSenha->insert($dados);
    }
    
    public function find($token)
    {
        $dao = new Application_Model_DbTable_AlteracaoSenha();
        $arr = $dao->find($token)->toArray();
        return $arr;
    }
    
    public function update($token)
    {
        $dbTableAlteracaoSenha = new Application_Model_DbTable_AlteracaoSenha();
        
        date_default_timezone_set('America/Bahia');
        $dados = array(
            "tas_dataalteracao" => date('Y-m-d H:i:s')
        );
        
        $where = $dbTableAlteracaoSenha->getAdapter()->quoteInto('"tas_token" = ?', $token);
        return $dbTableAlteracaoSenha->update($dados, $where);
    }
}

