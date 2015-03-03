<?php

class Application_Model_VPescadorHasDependente
{
    private $dbVPescadorHasDependente;

    public function selectDependentes($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasDependente = new Application_Model_DbTable_VPescadorHasDependente();
        $select = $this->dbVPescadorHasDependente->select()->from($this->dbVPescadorHasDependente)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasDependente->fetchAll($select)->toArray();
    }

}