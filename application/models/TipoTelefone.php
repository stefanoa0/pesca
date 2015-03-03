<?php

class Application_Model_TipoTelefone
{
    private $dbTipoTelefone;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTipoTelefone = new Application_Model_DbTable_TipoTelefoneDbtable();
        
        $select = $this->dbTipoTelefone->select()->from($this->dbTipoTelefone)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTipoTelefone->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTipoTelefone = new Application_Model_DbTable_TipoTelefoneDbtable();
        $arr = $this->dbTipoTelefone->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTipoTelefone = new Application_Model_DbTable_TipoTelefoneDbtable();
        
        $dadosTipoTelefone = array( 'ttel_desc' => $request['tipoTelefone' ] );
        
        $this->dbTipoTelefone->insert($dadosTipoTelefone);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTipoTelefone = new Application_Model_DbTable_TipoTelefoneDbtable();
        
        $dadosTipoTelefone = array( 'ttel_desc' => $request['tipoTelefone' ] );
        
        $whereTipoTelefone = $this->dbTipoTelefone->getAdapter() ->quoteInto('"ttel_id" = ?', $request['idTipoTelefone']);
        
        $this->dbTipoTelefone->update($dadosTipoTelefone, $whereTipoTelefone);
    }
    
    public function delete($idTipoTelefone)
    {
        $this->dbTipoTelefone = new Application_Model_DbTable_TipoTelefoneDbtable();       
                
        $whereTipoTelefone= $this->dbTipoTelefone->getAdapter()->quoteInto('"ttel_id" = ?', $idTipoTelefone);
        
        $this->dbTipoTelefone->delete($whereTipoTelefone);
    }
}

