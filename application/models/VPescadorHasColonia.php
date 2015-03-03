<?php

class Application_Model_VPescadorHasColonia
{
    private $dbVPescadorHasColonia;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasColonia = new Application_Model_DbTable_VPescadorHasColonia();
        $select = $this->dbVPescadorHasColonia->select()->from($this->dbVPescadorHasColonia)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasColonia->fetchAll($select)->toArray();
    }

}