<?php
/** 
 * Model Histórico de Login
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_HistoricoLogin
{
    
    private $dbTableHistoricoLogin;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableHistoricoLogin = new Application_Model_DbTable_HistoricoLogin();
        $select = $this->dbTableHistoricoLogin->select()
                ->from($this->dbTableHistoricoLogin)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableHistoricoLogin->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableHistoricoLogin = new Application_Model_DbTable_HistoricoLogin();
        $arr = $this->dbTableHistoricoLogin->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert()
    {
        $this->dbTableHistoricoLogin = new Application_Model_DbTable_HistoricoLogin();
        
        $datahoraLogin = date('d-m-Y');
        $datahoraLogin .= ' '.date('H:i:s');
        $dadosHistoricoLogin = array(
            'thl_dhlogin' => $datahoraLogin,
            'thl_dhlogoff' => null
        );
        
        $login = $this->dbTableHistoricoLogin->insert($dadosHistoricoLogin);

        return $login;
    }
    
    public function update(array $request)
    {
        $this->dbTableHistoricoLogin = new Application_Model_DbTable_HistoricoLogin();
        
        $datahoraLogoff = date('d-m-Y');
        $datahoraLogoff .= ' '.date('H:i:s');
        
        $dadosHistoricoLogin = array(
            'thl_dhlogoff' => $request['artePesca'],
        );
        
        $whereHistoricoLogin= $this->dbTableHistoricoLogin->getAdapter()
                ->quoteInto('"thl_id" = ?', $request['id']);
        
        $this->dbTableHistoricoLogin->update($dadosHistoricoLogin, $whereHistoricoLogin);
    }
    
    public function delete($idHistoricoLogin)
    {
        $this->dbTableHistoricoLogin = new Application_Model_DbTable_HistoricoLogin();       
                
        $whereHistoricoLogin= $this->dbTableHistoricoLogin->getAdapter()
                ->quoteInto('"tap_id" = ?', $idHistoricoLogin);
        
        $this->dbTableHistoricoLogin->delete($whereHistoricoLogin);
    }
    

}

