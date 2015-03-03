<?php

class Application_Model_Telefone
{
    
    public function getTelefone($idUsuario, $tipo)
    {
        $dbTableTelefone = new Application_Model_DbTable_VUsuarioHasTelelefone();
        
        $where = $dbTableTelefone->getAdapter()->quoteInto('"tu_id" = ?', $idUsuario);
        $where = $dbTableTelefone->getAdapter()->quoteInto('"ttel_desc" = ?', $tipo);
        
        $select = $dbTableTelefone->select()->from($dbTableTelefone)
                ->where($where);
        
        return $dbTableTelefone->fetchRow($select)->toArray();
    }
}

