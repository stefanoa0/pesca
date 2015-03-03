<?php

/** 
 * Model Artes de Pesca
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_ArtePesca
{
    private $dbTableArtePesca;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableArtePesca = new Application_Model_DbTable_ArtePesca();
        $select = $this->dbTableArtePesca->select()
                ->from($this->dbTableArtePesca)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArtePesca->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableArtePesca = new Application_Model_DbTable_ArtePesca();
        $arr = $this->dbTableArtePesca->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableArtePesca = new Application_Model_DbTable_ArtePesca();
        
        $dadosArtePesca = array(
            'tap_artepesca' => $request['artePesca']
        );
        
        $this->dbTableArtePesca->insert($dadosArtePesca);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableArtePesca = new Application_Model_DbTable_ArtePesca();
        
        $dadosArtePesca = array(
            'tap_artepesca' => $request['artePesca']
        );
        
        $whereArtePesca= $this->dbTableArtePesca->getAdapter()
                ->quoteInto('"tap_id" = ?', $request['idArtePesca']);
        
        $this->dbTableArtePesca->update($dadosArtePesca, $whereArtePesca);
    }
    
    public function delete($idArtePesca)
    {
        $this->dbTableArtePesca = new Application_Model_DbTable_ArtePesca();       
                
        $whereArtePesca= $this->dbTableArtePesca->getAdapter()
                ->quoteInto('"tap_id" = ?', $idArtePesca);
        
        $this->dbTableArtePesca->delete($whereArtePesca);
    }
    
}