<?php

class Application_Model_TipoDependente
{
    private $dbTipoDependente;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTipoDependente = new Application_Model_DbTable_TipoDependenteDbtable();
        
        $select = $this->dbTipoDependente->select()->from($this->dbTipoDependente)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTipoDependente->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTipoDependente = new Application_Model_DbTable_TipoDependenteDbtable();
        $arr = $this->dbTipoDependente->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTipoDependente = new Application_Model_DbTable_TipoDependenteDbtable();
        
        $dadosTipoDependente = array( 'ttd_tipodependente' => $request['tipoDependente' ] );
        
        $this->dbTipoDependente->insert($dadosTipoDependente);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTipoDependente = new Application_Model_DbTable_TipoDependenteDbtable();
        
        $dadosTipoDependente = array( 'ttd_tipodependente' => $request['tipoDependente' ] );
        
        $whereTipoDependente= $this->dbTipoDependente->getAdapter() ->quoteInto('"ttd_id" = ?', $request['idTipoDependente']);
        
        $this->dbTipoDependente->update($dadosTipoDependente, $whereTipoDependente);
    }
    
    public function delete($idTipoDependente)
    {
        $this->dbTipoDependente = new Application_Model_DbTable_TipoDependenteDbtable();       
                
        $whereTipoDependente= $this->dbTipoDependente->getAdapter()->quoteInto('"ttd_id" = ?', $idTipoDependente);
        
        $this->dbTipoDependente->delete($whereTipoDependente);
    }
}

