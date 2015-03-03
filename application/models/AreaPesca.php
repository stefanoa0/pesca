<?php

/** 
 * Model Area de Pesca
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_AreaPesca
{
    private $dbTableAreaPesca;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableAreaPesca = new Application_Model_DbTable_AreaPesca();
        $select = $this->dbTableAreaPesca->select()
                ->from($this->dbTableAreaPesca)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableAreaPesca->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableAreaPesca = new Application_Model_DbTable_AreaPesca();
        $arr = $this->dbTableAreaPesca->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableAreaPesca = new Application_Model_DbTable_AreaPesca();
        
        $dadosAreaPesca = array(
            'tareap_areapesca' => $request['areaPesca']
        );
        
        $this->dbTableAreaPesca->insert($dadosAreaPesca);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableAreaPesca = new Application_Model_DbTable_AreaPesca();
        
        $dadosAreaPesca = array(
            'tareap_areapesca' => $request['areaPesca']
        );
        
        $whereAreaPesca= $this->dbTableAreaPesca->getAdapter()
                ->quoteInto('"tareap_id" = ?', $request['idAreaPesca']);
        
        $this->dbTableAreaPesca->update($dadosAreaPesca, $whereAreaPesca);
    }
    
    public function delete($idAreaPesca)
    {
        $this->dbTableAreaPesca = new Application_Model_DbTable_AreaPesca();       
                
        $whereAreaPesca= $this->dbTableAreaPesca->getAdapter()
                ->quoteInto('"tareap_id" = ?', $idAreaPesca);
        
        $this->dbTableAreaPesca->delete($whereAreaPesca);
    }
    
}