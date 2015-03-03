<?php
/** 
 * Model Local de Tratamento do Pescado
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_LocalTratamento
{
private $dbTableLocalTratamento;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableLocalTratamento = new Application_Model_DbTable_LocalTratamento();

        $select = $this->dbTableLocalTratamento->select()->from($this->dbTableLocalTratamento)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableLocalTratamento->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableLocalTratamento = new Application_Model_DbTable_LocalTratamento();
        $arr = $this->dbTableLocalTratamento->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableLocalTratamento = new Application_Model_DbTable_LocalTratamento();

        $dadosLocalTratamento = array('tlt_local' => $request['tlt_local']);

        $this->dbTableLocalTratamento->insert($dadosLocalTratamento);

        return;
    }

    public function update(array $request) {
        $this->dbTableLocalTratamento = new Application_Model_DbTable_LocalTratamento();

        $dadosLocalTratamento = array('tlt_local' => $request['tlt_local']);

        $whereLocalTratamento = $this->dbTableLocalTratamento->getAdapter()->quoteInto('"tlt_id" = ?', $request['tlt_id']);

        $this->dbTableLocalTratamento->update($dadosLocalTratamento, $whereLocalTratamento);
    }

    public function delete($input_id) {
        $this->dbTableLocalTratamento = new Application_Model_DbTable_LocalTratamento();

        $whereLocalTratamento = $this->dbTableLocalTratamento->getAdapter()->quoteInto('"tlt_id" = ?', $input_id);

        $this->dbTableLocalTratamento->delete($whereLocalTratamento);
    }

}

