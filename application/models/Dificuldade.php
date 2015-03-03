<?php
/** 
 * Model Dificuldades
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Dificuldade
{
private $dbTableDificuldade;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableDificuldade = new Application_Model_DbTable_Dificuldade();

        $select = $this->dbTableDificuldade->select()->from($this->dbTableDificuldade)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableDificuldade->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableDificuldade = new Application_Model_DbTable_Dificuldade();
        $arr = $this->dbTableDificuldade->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableDificuldade = new Application_Model_DbTable_Dificuldade();

        $dadosDificuldade = array('tdif_dificuldade' => $request['tdif_dificuldade']);

        $this->dbTableDificuldade->insert($dadosDificuldade);

        return;
    }

    public function update(array $request) {
        $this->dbTableDificuldade = new Application_Model_DbTable_Dificuldade();

        $dadosDificuldade = array('tdif_dificuldade' => $request['tdif_dificuldade']);

        $whereDificuldade = $this->dbTableDificuldade->getAdapter()->quoteInto('"tdif_id" = ?', $request['tdif_id']);

        $this->dbTableDificuldade->update($dadosDificuldade, $whereDificuldade);
    }

    public function delete($input_id) {
        $this->dbTableDificuldade = new Application_Model_DbTable_Dificuldade();

        $whereDificuldade = $this->dbTableDificuldade->getAdapter()->quoteInto('"tdif_id" = ?', $input_id);

        $this->dbTableDificuldade->delete($whereDificuldade);
    }

}

