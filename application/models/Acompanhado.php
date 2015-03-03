
<?php
/** 
 * Model Acompanhamento
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Acompanhado
{
    private $dbTableAcompanhado;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableAcompanhado = new Application_Model_DbTable_Acompanhado();

        $select = $this->dbTableAcompanhado->select()->from($this->dbTableAcompanhado)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableAcompanhado->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableAcompanhado = new Application_Model_DbTable_Acompanhado();
        $arr = $this->dbTableAcompanhado->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableAcompanhado = new Application_Model_DbTable_Acompanhado();

        $dadosAcompanhado = array('tacp_companhia' => $request['tacp_companhia']);

        $this->dbTableAcompanhado->insert($dadosAcompanhado);

        return;
    }

    public function update(array $request) {
        $this->dbTableAcompanhado = new Application_Model_DbTable_Acompanhado();

        $dadosAcompanhado = array('tacp_companhia' => $request['tacp_companhia']);

        $whereAcompanhado = $this->dbTableAcompanhado->getAdapter()->quoteInto('"tacp_id" = ?', $request['tacp_id']);

        $this->dbTableAcompanhado->update($dadosAcompanhado, $whereAcompanhado);
    }

    public function delete($input_id) {
        $this->dbTableAcompanhado = new Application_Model_DbTable_Acompanhado();

        $whereAcompanhado = $this->dbTableAcompanhado->getAdapter()->quoteInto('"tacp_id" = ?', $input_id);

        $this->dbTableAcompanhado->delete($whereAcompanhado);
    }

}

