<?php

class Application_Model_VPescadorHasEmbarcacao
{
    private $dbVPescadorHasEmbarcacao;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasEmbarcacao = new Application_Model_DbTable_VPescadorHasEmbarcacao();
        $select = $this->dbVPescadorHasEmbarcacao->select()->from($this->dbVPescadorHasEmbarcacao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasEmbarcacao->fetchAll($select)->toArray();
    }

}