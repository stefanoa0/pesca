
<?php

class Application_Model_VPescadorHasPorto
{
    private $dbVPescadorHasPorto;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasPorto = new Application_Model_DbTable_VPescadorHasPorto();
        $select = $this->dbVPescadorHasPorto->select()->from($this->dbVPescadorHasPorto)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasPorto->fetchAll($select)->toArray();
    }

}