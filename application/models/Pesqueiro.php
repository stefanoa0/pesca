<?php

class Application_Model_Pesqueiro
{
private $dbTablePesqueiros;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTablePesqueiros = new Application_Model_DbTable_Pesqueiro();
        $select = $this->dbTablePesqueiros->select()
                ->from($this->dbTablePesqueiros)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTablePesqueiros->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTablePesqueiros = new Application_Model_DbTable_Pesqueiro();
        $arr = $this->dbTablePesqueiros->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTablePesqueiros = new Application_Model_DbTable_Pesqueiro();
        
        $dadosPesqueiros = array(
            'paf_pesqueiro' => $request['inputNomePesqueiro']
        );
        
        $this->dbTablePesqueiros->insert($dadosPesqueiros);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTablePesqueiros = new Application_Model_DbTable_Pesqueiro();
        
        $dadosPesqueiros = array(
            'paf_pesqueiro' => $request['inputNomePesqueiro']
        );
        
        $wherePesqueiros= $this->dbTablePesqueiros->getAdapter()
                ->quoteInto('"paf_id" = ?', $request['inputIDPesqueiro']);
        
        $this->dbTablePesqueiros->update($dadosPesqueiros, $wherePesqueiros);
    }
    
    public function delete($idPesqueiro)
    {
        $this->dbTablePesqueiros = new Application_Model_DbTable_Pesqueiro();       
                
        $wherePesqueiros= $this->dbTablePesqueiros->getAdapter()
                ->quoteInto('"paf_id" = ?', $idPesqueiro);
        
        $this->dbTablePesqueiros->delete($wherePesqueiros);
    }

}

