<?php

class Application_Model_UfMapper
{
    public function select()
    {
        $dbTableUf = new Application_Model_DbTable_UfDbtable();
        $select = $dbTableUf->select()->from($dbTableUf);

        return $dbTableUf->fetchAll($select)->toArray();
    }
    
}
