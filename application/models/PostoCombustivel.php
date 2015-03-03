<?php

class Application_Model_PostoCombustivel
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTablePostoCombustivel = new Application_Model_DbTable_PostoCombustivel();

        $select = $this->dbTablePostoCombustivel->select()->from($this->dbTablePostoCombustivel)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTablePostoCombustivel->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTablePostoCombustivel = new Application_Model_DbTable_PostoCombustivel();
        $arr = $this->dbTablePostoCombustivel->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTablePostoCombustivel = new Application_Model_DbTable_PostoCombustivel();

        $dadosPostoCombustivel = array('tpc_posto' => $request['tpc_posto']);

        $this->dbTablePostoCombustivel->insert($dadosPostoCombustivel);

        return;
    }

    public function update(array $request) {
        $this->dbTablePostoCombustivel = new Application_Model_DbTable_PostoCombustivel();

        $dadosPostoCombustivel = array('tpc_posto' => $request['tpc_posto']);

        $wherePostoCombustivel = $this->dbTablePostoCombustivel->getAdapter()->quoteInto('"tpc_id" = ?', $request['tpc_id']);

        $this->dbTablePostoCombustivel->update($dadosPostoCombustivel, $wherePostoCombustivel);
    }

    public function delete($input_id) {
        $this->dbTablePostoCombustivel = new Application_Model_DbTable_PostoCombustivel();

        $wherePostoCombustivel = $this->dbTablePostoCombustivel->getAdapter()->quoteInto('"tpc_id" = ?', $input_id);

        $this->dbTablePostoCombustivel->delete($wherePostoCombustivel);
    }

}

