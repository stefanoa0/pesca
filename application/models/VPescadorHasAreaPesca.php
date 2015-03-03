<?php

class Application_Model_VPescadorHasAreaPesca
{
    private $dbVPescadorHasAreaPesca;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasAreaPesca = new Application_Model_DbTable_VPescadorHasAreaPesca();
        $select = $this->dbVPescadorHasAreaPesca->select()->from($this->dbVPescadorHasAreaPesca)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasAreaPesca->fetchAll($select)->toArray();
    }

}
