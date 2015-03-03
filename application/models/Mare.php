<?php

class Application_Model_Mare
{
private $dbTableMare;
    public function select()
    {
        $dao = new Application_Model_DbTable_Mare();
        $select = $dao->select()->from($dao);

        return $dao->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableMare = new Application_Model_DbTable_Mare();
        $arr = $this->dbTableMare->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableMare = new Application_Model_DbTable_Mare();
        
        $dadosMare = array(
            'mre_tipo' => $request['mare'],
        );
        
        $this->dbTableMare->insert($dadosMare);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableMare = new Application_Model_DbTable_Mare();
        
        $dadosMare = array(
            'mre_tipo' => $request['mare'],
        );
        
        $whereMare= $this->dbTableMare->getAdapter()
                ->quoteInto('"mre_id" = ?', $request['id_mare']);
        
        $this->dbTableMare->update($dadosMare, $whereMare);
    }
    
    public function delete($idMare)
    {
        $this->dbTableMare = new Application_Model_DbTable_Mare();       
                
        $whereMare= $this->dbTableMare->getAdapter()
                ->quoteInto('"mre_id" = ?', $idMare);
        
        $this->dbTableMare->delete($whereMare);
    }

}

