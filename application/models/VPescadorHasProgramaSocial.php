
<?php

class Application_Model_VPescadorHasProgramaSocial
{
    private $dbVPescadorHasProgramaSocial;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasProgramaSocial = new Application_Model_DbTable_VPescadorHasProgramaSocial();
        $select = $this->dbVPescadorHasProgramaSocial->select()->from($this->dbVPescadorHasProgramaSocial)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasProgramaSocial->fetchAll($select)->toArray();
    }

}
