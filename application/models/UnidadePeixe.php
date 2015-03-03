<?php

class Application_Model_UnidadePeixe
{
    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableUnidadePeixe = new Application_Model_DbTable_VUnidadePeixe();
        $select = $this->dbTableUnidadePeixe->select()
                ->from($this->dbTableUnidadePeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableUnidadePeixe->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableUnidadePeixe = new Application_Model_DbTable_VUnidadePeixe();
        $arr = $this->dbTableUnidadePeixe->find($id)->toArray();
        return $arr[0];
    }

}

