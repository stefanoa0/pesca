<?php

class Application_Model_UltimaPesca
{
   private $dbTableUltimaPesca;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableUltimaPesca = new Application_Model_DbTable_UltimaPesca();
        
        $select = $this->dbTableUltimaPesca->select()->from($this->dbTableUltimaPesca)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableUltimaPesca->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTableUltimaPesca = new Application_Model_DbTable_UltimaPesca();
        $arr = $this->dbTableUltimaPesca->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableUltimaPesca = new Application_Model_DbTable_UltimaPesca();
        
        $dadosUltimaPesca = array('tup_pesca' => $request['tup_pesca'] );
        
        $this->dbTableUltimaPesca->insert($dadosUltimaPesca);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableUltimaPesca = new Application_Model_DbTable_UltimaPesca();
        
        $dadosUltimaPesca = array( 'tup_pesca' => $request['tup_pesca'] );
        
        $whereUltimaPesca= $this->dbTableUltimaPesca->getAdapter() ->quoteInto('"tup_id" = ?', $request['tup_id']);
        
        $this->dbTableUltimaPesca->update($dadosUltimaPesca, $whereUltimaPesca);
    }
    
    public function delete($idUltimaPesca)
    {
        $this->dbTableUltimaPesca = new Application_Model_DbTable_UltimaPesca();       
                
        $whereUltimaPesca= $this->dbTableUltimaPesca->getAdapter()->quoteInto('"tup_id" = ?', $idUltimaPesca);
        
        $this->dbTableUltimaPesca->delete($whereUltimaPesca);
    }

}

