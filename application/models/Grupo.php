<?php
/** 
 * Model Filogenia - Grupos
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Grupo
{
    private $dbTableGrupo;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableGrupo = new Application_Model_DbTable_Grupo();
        
        $select = $this->dbTableGrupo->select()
                ->from($this->dbTableGrupo)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableGrupo->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableGrupo = new Application_Model_DbTable_Grupo();
        $arr = $this->dbTableGrupo->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        
        $this->dbTableGrupo = new Application_Model_DbTable_Grupo();
        
        $dadosGrupo = array(
            'grp_nome' => $request['nome_grupo']
        );
        
        $this->dbTableGrupo->insert($dadosGrupo);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableGrupo = new Application_Model_DbTable_Grupo();
        
        $dadosGrupo = array('grp_nome' => $request['nome_grupo']);
        
        $whereGrupo = $this->dbTableGrupo->getAdapter()->quoteInto('"grp_id" = ?', $request['id_grupo'], 'INTEGER');
        
        $this->dbTableGrupo->update($dadosGrupo, $whereGrupo);
    }
    
    public function delete($idGrupo)
    {
        $this->dbTableGrupo = new Application_Model_DbTable_Grupo();       
                
        $whereGrupo = $this->dbTableGrupo->getAdapter()->quoteInto('"grp_id" = ?', $idGrupo);
        
        $this->dbTableGrupo->delete($whereGrupo);
    }
    
}




