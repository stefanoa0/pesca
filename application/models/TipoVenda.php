<?php

class Application_Model_TipoVenda
{
    private $dbTableTiploVenda;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableTiploVenda = new Application_Model_DbTable_TipoVenda();
        
        $select = $this->dbTableTiploVenda->select()->from($this->dbTableTiploVenda)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTiploVenda->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTableTiploVenda = new Application_Model_DbTable_TipoVenda();
        $arr = $this->dbTableTiploVenda->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableTiploVenda = new Application_Model_DbTable_TipoVenda();
        
        $dadosTipoVenda = array( 'ttv_tipovenda' => $request['inputTipoVenda' ] );
        
        $this->dbTableTiploVenda->insert($dadosTipoVenda);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableTiploVenda = new Application_Model_DbTable_TipoVenda();
        
        $dadosTipoVenda = array( 'ttv_tipovenda' => $request['inputTipoVenda' ] );
        
        $whereTipoVenda= $this->dbTableTiploVenda->getAdapter() ->quoteInto('"ttv_id" = ?', $request['idTipoVenda']);
        
        $this->dbTableTiploVenda->update($dadosTipoVenda, $whereTipoVenda);
    }
    
    public function delete($idTipoVenda)
    {
        $this->dbTableTiploVenda = new Application_Model_DbTable_TipoVenda();       
                
        $whereTipoVenda= $this->dbTableTiploVenda->getAdapter()->quoteInto('"ttv_id" = ?', $idTipoVenda);
        
        $this->dbTableTiploVenda->delete($whereTipoVenda);
    }
}



