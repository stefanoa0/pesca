<?php
/** 
 * Model Filogenia - Familias
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Familia
{
    private $dbTableFamilia;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableFamilia = new Application_Model_DbTable_Familia();
        
        $select = $this->dbTableFamilia->select()
                ->from($this->dbTableFamilia)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableFamilia->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableFamilia = new Application_Model_DbTable_Familia();
        $arr = $this->dbTableFamilia->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableOrdem= new Application_Model_DbTable_Ordem();
        $this->dbTableFamilia = new Application_Model_DbTable_Familia();
        
        $ordem_filogenetica = $request['ordem_filogenetica'];
        if(empty($ordem_filogenetica)){
            $ordem_filogenetica = null;
        }
        
        $dadosFamilia = array(
            'fam_nome' 	=> $request['nome_familia'],
            'fam_ordem_filogenetica'	=> $ordem_filogenetica,
            'fam_tipo' 	=> $request['tipo_familia'],
            'fam_caracteristica' => $request['caracteristica_familia'],
            'ord_id' 	=> $request['ordem_familia']
        );
        
        $this->dbTableFamilia->insert($dadosFamilia);
      
        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableFamilia = new Application_Model_DbTable_Familia();
        
        $ordem_filogenetica = $request['ordem_filogenetica'];
        if(empty($ordem_filogenetica)){
            $ordem_filogenetica = null;
        }
        $dadosFamilia = array(
            'fam_nome' 					=> $request['nome_familia'],
            'fam_ordem_filogenetica'	=> $ordem_filogenetica,
            'fam_tipo' 					=> $request['tipo_familia'],
            'fam_caracteristica' 		=> $request['caracteristica_familia'],
            'ord_id' 					=> $request['ordem_familia']
        );
        
        $whereFamilia = $this->dbTableFamilia->getAdapter()->quoteInto('"fam_id" = ?', $request['id_familia']);
        
        $this->dbTableFamilia->update($dadosFamilia, $whereFamilia);
    }
    
    public function delete($idFamilia)
    {
        $this->dbTableFamilia = new Application_Model_DbTable_Familia();
                
        $whereFamilia = $this->dbTableFamilia->getAdapter()->quoteInto('"fam_id" = ?', $idFamilia);
        
        $this->dbTableFamilia->delete($whereFamilia);
    }

}

