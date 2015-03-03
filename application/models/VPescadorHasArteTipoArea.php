
<?php

class Application_Model_VPescadorHasArteTipoArea
{
    private $dbVPescadorHasArteTipoArea;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbVPescadorHasArteTipoArea = new Application_Model_DbTable_VPescadorHasArteTipoArea();
        $select = $this->dbVPescadorHasArteTipoArea->select()->from($this->dbVPescadorHasArteTipoArea)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbVPescadorHasArteTipoArea->fetchAll($select)->toArray();
    }

}