<?php

class Application_Model_VPescadorHasTelefone
{
    private $dbVPescadorHasTelefone;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasTelefone = new Application_Model_DbTable_VPescadorHasTelefone();
        $select = $this->dbVPescadorHasTelefone->select()->from($this->dbVPescadorHasTelefone)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasTelefone->fetchAll($select)->toArray();
    }

}

