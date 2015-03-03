<?php
/** 
 * Model Horario de Pesca
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_HorarioPesca
{
private $dbTableHorarioPesca;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableHorarioPesca = new Application_Model_DbTable_HorarioPesca();

        $select = $this->dbTableHorarioPesca->select()->from($this->dbTableHorarioPesca)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableHorarioPesca->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableHorarioPesca = new Application_Model_DbTable_HorarioPesca();
        $arr = $this->dbTableHorarioPesca->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableHorarioPesca = new Application_Model_DbTable_HorarioPesca();

        $dadosHorarioPesca = array('thp_horario' => $request['thp_horario']);

        $this->dbTableHorarioPesca->insert($dadosHorarioPesca);

        return;
    }

    public function update(array $request) {
        $this->dbTableHorarioPesca = new Application_Model_DbTable_HorarioPesca();

        $dadosHorarioPesca = array('thp_horario' => $request['thp_horario']);

        $whereHorarioPesca = $this->dbTableHorarioPesca->getAdapter()->quoteInto('"thp_id" = ?', $request['thp_id']);

        $this->dbTableHorarioPesca->update($dadosHorarioPesca, $whereHorarioPesca);
    }

    public function delete($input_id) {
        $this->dbTableHorarioPesca = new Application_Model_DbTable_HorarioPesca();

        $whereHorarioPesca = $this->dbTableHorarioPesca->getAdapter()->quoteInto('"thp_id" = ?', $input_id);

        $this->dbTableHorarioPesca->delete($whereHorarioPesca);
    }


}

