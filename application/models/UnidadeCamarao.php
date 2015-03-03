<?php

class Application_Model_UnidadeCamarao
{
private $dbTableUnidadeCamarao;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableUnidadeCamarao = new Application_Model_DbTable_VUnidadeCamarao();
        $select = $this->dbTableUnidadeCamarao->select()
                ->from($this->dbTableUnidadeCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableUnidadeCamarao->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableUnidadeCamarao = new Application_Model_DbTable_VUnidadeCamarao();
        $arr = $this->dbTableUnidadeCamarao->find($id)->toArray();
        return $arr[0];
    }
    
}



