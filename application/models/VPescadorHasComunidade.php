
<?php

class Application_Model_VPescadorHasComunidade
{
    private $dbVPescadorHasComunidade;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasComunidade = new Application_Model_DbTable_VPescadorHasComunidade();
        $select = $this->dbVPescadorHasComunidade->select()->from($this->dbVPescadorHasComunidade)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasComunidade->fetchAll($select)->toArray();
    }

}