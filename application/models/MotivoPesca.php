<?php

class Application_Model_MotivoPesca
{
private $dbTableMotivoPesca;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableMotivoPesca = new Application_Model_DbTable_MotivoPesca();

        $select = $this->dbTableMotivoPesca->select()->from($this->dbTableMotivoPesca)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableMotivoPesca->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableMotivoPesca = new Application_Model_DbTable_MotivoPesca();
        $arr = $this->dbTableMotivoPesca->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableMotivoPesca = new Application_Model_DbTable_MotivoPesca();

        $dadosMotivoPesca = array('tmp_motivo' => $request['tmp_motivo']);

        $this->dbTableMotivoPesca->insert($dadosMotivoPesca);

        return;
    }

    public function update(array $request) {
        $this->dbTableMotivoPesca = new Application_Model_DbTable_MotivoPesca();

        $dadosMotivoPesca = array('tmp_motivo' => $request['tmp_motivo']);

        $whereMotivoPesca = $this->dbTableMotivoPesca->getAdapter()->quoteInto('"tmp_id" = ?', $request['tmp_id']);

        $this->dbTableMotivoPesca->update($dadosMotivoPesca, $whereMotivoPesca);
    }

    public function delete($input_id) {
        $this->dbTableMotivoPesca = new Application_Model_DbTable_MotivoPesca();

        $whereMotivoPesca = $this->dbTableMotivoPesca->getAdapter()->quoteInto('"tmp_id" = ?', $input_id);

        $this->dbTableMotivoPesca->delete($whereMotivoPesca);
    }

}

