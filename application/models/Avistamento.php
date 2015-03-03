<?php
/** 
 * Model Avistamentos
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Avistamento
{
    private $dbTableAvistamento;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableAvistamento = new Application_Model_DbTable_Avistamento();
        $select = $this->dbTableAvistamento->select()
                ->from($this->dbTableAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableAvistamento->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableAvistamento = new Application_Model_DbTable_Avistamento();
        $arr = $this->dbTableAvistamento->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableAvistamento = new Application_Model_DbTable_Avistamento();
        
        $dadosAvistamento = array(
            'avs_descricao' => $request['inputAvistamento']
        );
        
        $this->dbTableAvistamento->insert($dadosAvistamento);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableAvistamento = new Application_Model_DbTable_Avistamento();
        
        $dadosAvistamento = array(
            'avs_descricao' => $request['inputAvistamento']
        );
        
        $whereAvistamento= $this->dbTableAvistamento->getAdapter()
                ->quoteInto('"tap_id" = ?', $request['idAvistamento']);
        
        $this->dbTableAvistamento->update($dadosAvistamento, $whereAvistamento);
    }
    
    public function delete($idAvistamento)
    {
        $this->dbTableAvistamento = new Application_Model_DbTable_Avistamento();       
                
        $whereAvistamento= $this->dbTableAvistamento->getAdapter()
                ->quoteInto('"avs_id" = ?', $idAvistamento);
        
        $this->dbTableAvistamento->delete($whereAvistamento);
    }
    
}