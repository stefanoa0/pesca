<?php
/** 
 * Model Iscas
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Isca
{
    private $dbTableIsca;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableIsca = new Application_Model_DbTable_Isca();
        $select = $this->dbTableIsca->select()
                ->from($this->dbTableIsca)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableIsca->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableIsca = new Application_Model_DbTable_Isca();
        $arr = $this->dbTableIsca->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request) {
        $this->dbTableIsca = new Application_Model_DbTable_Isca();

        $dadosIsca = array('isc_tipo' => $request['isc_tipo']);

        $this->dbTableIsca->insert($dadosIsca);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableIsca = new Application_Model_DbTable_Isca();
        
        
        $dadosIsca = array(
            'isc_tipo' => $request['tipoIsca']
        );
        $whereIsca= $this->dbTableIsca->getAdapter()
                ->quoteInto('"isc_id" = ?', $request[0]);
        
        
        $this->dbTableIsca->update($dadosIsca, $whereIsca);
    }
    
    public function delete($idIsca)
    {
        $this->dbTableIsca = new Application_Model_DbTable_Isca();       
                
        $whereIsca= $this->dbTableIsca->getAdapter()
                ->quoteInto('"isc_id" = ?', $idIsca);
        
        $this->dbTableIsca->delete($whereIsca);
    }

}

