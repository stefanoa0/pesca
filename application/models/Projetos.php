<?php

class Application_Model_Projetos
{   
    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableProjetos = new Application_Model_DbTable_Projetos();
        $select = $this->dbTableProjetos->select()
                ->from($this->dbTableProjetos)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableProjetos->fetchAll($select)->toArray();
    }
    
}

