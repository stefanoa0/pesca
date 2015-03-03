<?php

class Application_Model_TipoRenda
{
    private $dbTableTiploRenda;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableTiploRenda = new Application_Model_DbTable_TipoRenda();
        
        $select = $this->dbTableTiploRenda->select()->from($this->dbTableTiploRenda)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTiploRenda->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTableTiploRenda = new Application_Model_DbTable_TipoRenda();
        $arr = $this->dbTableTiploRenda->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableTiploRenda = new Application_Model_DbTable_TipoRenda();
        
        $dadosTipoRenda = array( 'ttr_descricao' => $request['inputTipoRenda' ] );
        
        $this->dbTableTiploRenda->insert($dadosTipoRenda);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableTiploRenda = new Application_Model_DbTable_TipoRenda();
        
        $dadosTipoRenda = array( 'ttr_descricao' => $request['inputTipoRenda' ] );
        
        $whereTipoRenda= $this->dbTableTiploRenda->getAdapter() ->quoteInto('"ttr_id" = ?', $request['idTipoRenda']);
        
        $this->dbTableTiploRenda->update($dadosTipoRenda, $whereTipoRenda);
    }
    
    public function delete($idTipoRenda)
    {
        $this->dbTableTiploRenda = new Application_Model_DbTable_TipoRenda();       
                
        $whereTipoRenda= $this->dbTableTiploRenda->getAdapter()->quoteInto('"ttr_id" = ?', $idTipoRenda);
        
        $this->dbTableTiploRenda->delete($whereTipoRenda);
    }
}

