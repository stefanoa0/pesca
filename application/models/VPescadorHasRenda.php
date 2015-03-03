<?php

class Application_Model_VPescadorHasRenda
{
    private $dbVPescadorHasRenda;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasRenda = new Application_Model_DbTable_VPescadorHasRenda();
        $select = $this->dbVPescadorHasRenda->select()->from($this->dbVPescadorHasRenda)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasRenda->fetchAll($select)->toArray();
    }

}