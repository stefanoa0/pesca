<?php

class Application_Model_Origem
{
private $dbTableOrigem;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableOrigem = new Application_Model_DbTable_Origem();

        $select = $this->dbTableOrigem->select()->from($this->dbTableOrigem)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableOrigem->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableOrigem = new Application_Model_DbTable_Origem();
        $arr = $this->dbTableOrigem->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableOrigem = new Application_Model_DbTable_Origem();

        $dadosOrigem = array('to_origem' => $request['to_origem']);

        $this->dbTableOrigem->insert($dadosOrigem);

        return;
    }

    public function update(array $request) {
        $this->dbTableOrigem = new Application_Model_DbTable_Origem();

        $dadosOrigem = array('to_origem' => $request['to_origem']);

        $whereOrigem = $this->dbTableOrigem->getAdapter()->quoteInto('"to_id" = ?', $request['to_id']);

        $this->dbTableOrigem->update($dadosOrigem, $whereOrigem);
    }

    public function delete($input_id) {
        $this->dbTableOrigem = new Application_Model_DbTable_Origem();

        $whereOrigem = $this->dbTableOrigem->getAdapter()->quoteInto('"to_id" = ?', $input_id);

        $this->dbTableOrigem->delete($whereOrigem);
    }

}

