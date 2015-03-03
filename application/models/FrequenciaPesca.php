<?php
/** 
 * Model Frequencia de Pesca
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_FrequenciaPesca
{
private $dbTableFrequenciaPesca;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableFrequenciaPesca = new Application_Model_DbTable_FrequenciaPesca();

        $select = $this->dbTableFrequenciaPesca->select()->from($this->dbTableFrequenciaPesca)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableFrequenciaPesca->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableFrequenciaPesca = new Application_Model_DbTable_FrequenciaPesca();
        $arr = $this->dbTableFrequenciaPesca->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableFrequenciaPesca = new Application_Model_DbTable_FrequenciaPesca();

        $dadosFrequenciaPesca = array('tfp_frequencia' => $request['tfp_frequencia']);

        $this->dbTableFrequenciaPesca->insert($dadosFrequenciaPesca);

        return;
    }

    public function update(array $request) {
        $this->dbTableFrequenciaPesca = new Application_Model_DbTable_FrequenciaPesca();

        $dadosFrequenciaPesca = array('tfp_frequencia' => $request['tfp_frequencia']);

        $whereFrequenciaPesca = $this->dbTableFrequenciaPesca->getAdapter()->quoteInto('"tfp_id" = ?', $request['tfp_id']);

        $this->dbTableFrequenciaPesca->update($dadosFrequenciaPesca, $whereFrequenciaPesca);
    }

    public function delete($input_id) {
        $this->dbTableFrequenciaPesca = new Application_Model_DbTable_FrequenciaPesca();

        $whereFrequenciaPesca = $this->dbTableFrequenciaPesca->getAdapter()->quoteInto('"tfp_id" = ?', $input_id);

        $this->dbTableFrequenciaPesca->delete($whereFrequenciaPesca);
    }

}

