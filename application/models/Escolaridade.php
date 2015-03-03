
<?php
/** 
 * Model Escolaridades
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Escolaridade
{
    private $dbTableEscolaridade;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableEscolaridade = new Application_Model_DbTable_EscolaridadeDbtable();
        
        $select = $this->dbTableEscolaridade->select()->from($this->dbTableEscolaridade)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableEscolaridade->fetchAll($select)->toArray();
    }
    
        public function find($id)
    {
        $this->dbTableEscolaridade = new Application_Model_DbTable_EscolaridadeDbtable();
        $arr = $this->dbTableEscolaridade->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableEscolaridade = new Application_Model_DbTable_EscolaridadeDbtable();
        
        $dadosEscolaridade = array( 'esc_nivel' => $request['nivelEscolaridade' ] );
        
        $this->dbTableEscolaridade->insert($dadosEscolaridade);

        return;
    }
    
    public function update(array $request)
    {
        $this->dbTableEscolaridade = new Application_Model_DbTable_EscolaridadeDbtable();
        
        $dadosEscolaridade = array( 'esc_nivel' => $request['nivelEscolaridade' ] );
        
        $whereEscolaridade= $this->dbTableEscolaridade->getAdapter() ->quoteInto('"esc_id" = ?', $request['idEscolaridade']);
        
        $this->dbTableEscolaridade->update($dadosEscolaridade, $whereEscolaridade);
    }
    
    public function delete($idEscolaridade)
    {
        $this->dbTableEscolaridade = new Application_Model_DbTable_EscolaridadeDbtable();       
                
        $whereEscolaridade= $this->dbTableEscolaridade->getAdapter()->quoteInto('"esc_id" = ?', $idEscolaridade);
        
        $this->dbTableEscolaridade->delete($whereEscolaridade);
    }
}

