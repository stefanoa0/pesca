<?php

class Application_Model_Ordem
{
    private $dbTableOrdem;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableOrdem = new Application_Model_DbTable_Ordem();
        
        $select = $this->dbTableOrdem->select()
                ->from($this->dbTableOrdem)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableOrdem->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableOrdem = new Application_Model_DbTable_Ordem();
        $arr = $this->dbTableOrdem->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableGrupo = new Application_Model_DbTable_Grupo();
        $this->dbTableOrdem = new Application_Model_DbTable_Ordem();
        
        $dadosOrdem = array(
            'ord_nome' => $request['nome_ordem'],
            'ord_caracteristica' => $request['caracteristica_ordem'],
            'grp_id' => $request['grupo_ordem']
        );
        
        $this->dbTableOrdem->insert($dadosOrdem);
        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableGrupo = new Application_Model_DbTable_Grupo();
        $this->dbTableOrdem = new Application_Model_DbTable_Ordem();
       
        $dadosOrdem = array(
            'ord_nome' => $request['nome_ordem'],
            'ord_caracteristica' => $request['caracteristica_ordem'],
            'grp_id' => $request['grupo_ordem']
        );

        $whereOrdem = $this->dbTableOrdem->getAdapter()->quoteInto('"ord_id" = ?', $request['id_ordem']);

        $this->dbTableOrdem->update($dadosOrdem, $whereOrdem);
    }
    
    public function delete($idOrdem)
    {
        $this->dbTableOrdem = new Application_Model_DbTable_Ordem();       
                
        $whereOrdem = $this->dbTableOrdem->getAdapter()->quoteInto('"ord_id" = ?', $idOrdem);
        
        $this->dbTableOrdem->delete($whereOrdem);
    }

}

