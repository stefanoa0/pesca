<?php

class Application_Model_Subamostra
{
    private $dbTableSubamostra;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_VSubamostra();
        $select = $this->dbTableSubamostra->select()
                ->from($this->dbTableSubamostra)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSubamostra->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_VSubamostra();
        $arr = $this->dbTableSubamostra->find($id)->toArray();
        return $arr[0];
    }

}

