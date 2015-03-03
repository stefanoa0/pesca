<?php

class Application_Model_Maturidade
{
    private $dbTableMaturidade;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableMaturidade = new Application_Model_DbTable_MaturidadeCamarao();
        $select = $this->dbTableMaturidade->select()
                ->from($this->dbTableMaturidade)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMaturidade->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableMaturidade = new Application_Model_DbTable_MaturidadeCamarao();
        $arr = $this->dbTableMaturidade->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableMaturidade = new Application_Model_DbTable_MaturidadeCamarao();
        
        $dadosMaturidade = array(
            'tmat_tipo' => $request['maturidade']
        );
        
        $this->dbTableMaturidade->insert($dadosMaturidade);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableMaturidade = new Application_Model_DbTable_MaturidadeCamarao();
        
        $dadosMaturidade = array(
            'tareap_areapesca' => $request['areaPesca']
        );
        
        $whereMaturidade= $this->dbTableMaturidade->getAdapter()
                ->quoteInto('"tareap_id" = ?', $request['idMaturidade']);
        
        $this->dbTableMaturidade->update($dadosMaturidade, $whereMaturidade);
    }
    
    public function delete($idMaturidade)
    {
        $this->dbTableMaturidade = new Application_Model_DbTable_MaturidadeCamarao();       
                
        $whereMaturidade= $this->dbTableMaturidade->getAdapter()
                ->quoteInto('"tareap_id" = ?', $idMaturidade);
        
        $this->dbTableMaturidade->delete($whereMaturidade);
    }
    
}