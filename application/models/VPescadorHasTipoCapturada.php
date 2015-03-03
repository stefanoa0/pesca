
<?php

class Application_Model_VPescadorHasTipoCapturada
{
    private $dbVPescadorHasTipoCapturada;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasTipoCapturada = new Application_Model_DbTable_VPescadorHasTipoCapturada();
        $select = $this->dbVPescadorHasTipoCapturada->select()->from($this->dbVPescadorHasTipoCapturada)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasTipoCapturada->fetchAll($select)->toArray();
    }

}