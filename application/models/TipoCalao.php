<?php

class Application_Model_TipoCalao
{
    private $dbTableTipoCalaoDbtable;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableTipoCalaoDbtable = new Application_Model_DbTable_TipoCalao();
        
        $select = $this->dbTableTipoCalaoDbtable->select()->from($this->dbTableTipoCalaoDbtable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTipoCalaoDbtable->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTableTipoCalaoDbtable = new Application_Model_DbTable_TipoCalao();
        $arr = $this->dbTableTipoCalaoDbtable->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableTipoCalaoDbtable = new Application_Model_DbTable_TipoCalao();
        
        $dadosTipoCalao = array(
            'tcat_tipo' => $request['tipocalao']
        );
        
        $this->dbTableTipoCalaoDbtable->insert($dadosTipoCalao);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableTipoCalaoDbtable = new Application_Model_DbTable_TipoCalao();
        
        $dadosTipoCalao = array(
            'tcat_tipo' => $request['tipocalao']
        );
        
        $whereTipoCalao = $this->dbTableTipoCalaoDbtable->getAdapter()->quoteInto('"tcat_id" = ?', $request['idTipoCalao']);
        
        $this->dbTableTipoCalaoDbtable->update($dadosTipoCalao, $whereTipoCalao);
    }
    
    public function delete($idTipoCalao)
    {
        $this->dbTableTipoCalaoDbtable = new Application_Model_DbTable_TipoCalao();       
                
        $whereTipoCalao= $this->dbTableTipoCalaoDbtable->getAdapter()->quoteInto('"tcat_id" = ?', $idTipoCalao);
        
        $this->dbTableTipoCalaoDbtable->delete($whereTipoCalao);
    }

}

