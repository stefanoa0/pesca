<?php

class Application_Model_TipoCapturadaModel
{
    private $dbTable_TipoCapturadaDbtable;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTable_TipoCapturadaDbtable = new Application_Model_DbTable_TipoCapturadaDbtable();
        
        $select = $this->dbTable_TipoCapturadaDbtable->select()->from($this->dbTable_TipoCapturadaDbtable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable_TipoCapturadaDbtable->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTable_TipoCapturadaDbtable = new Application_Model_DbTable_TipoCapturadaDbtable();
        $arr = $this->dbTable_TipoCapturadaDbtable->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTable_TipoCapturadaDbtable = new Application_Model_DbTable_TipoCapturadaDbtable();
        
        $dadosTipoCapturada = array(
            'itc_tipo' => $request['tipoCapturada']
        );
        
        $this->dbTable_TipoCapturadaDbtable->insert($dadosTipoCapturada);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTable_TipoCapturadaDbtable = new Application_Model_DbTable_TipoCapturadaDbtable();
        
        $dadosTipoCapturada = array(
            'itc_tipo' => $request['tipoCapturada']
        );
        
        $whereTipoCapturada = $this->dbTable_TipoCapturadaDbtable->getAdapter()->quoteInto('"itc_id" = ?', $request['idTipoCapturada']);
        
        $this->dbTable_TipoCapturadaDbtable->update($dadosTipoCapturada, $whereTipoCapturada);
    }
    
    public function delete($idTipoCapturada)
    {
        $this->dbTable_TipoCapturadaDbtable = new Application_Model_DbTable_TipoCapturadaDbtable();       
                
        $whereTipoCapturada= $this->dbTable_TipoCapturadaDbtable->getAdapter()->quoteInto('"itc_id" = ?', $idTipoCapturada);
        
        $this->dbTable_TipoCapturadaDbtable->delete($whereTipoCapturada);
    }
    
}

