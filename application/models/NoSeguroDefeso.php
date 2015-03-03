<?php

class Application_Model_NoSeguroDefeso
{
private $dbTableNoSeguroDefeso;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableNoSeguroDefeso = new Application_Model_DbTable_NoSeguroDefeso();

        $select = $this->dbTableNoSeguroDefeso->select()->from($this->dbTableNoSeguroDefeso)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableNoSeguroDefeso->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableNoSeguroDefeso = new Application_Model_DbTable_NoSeguroDefeso();
        $arr = $this->dbTableNoSeguroDefeso->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableNoSeguroDefeso = new Application_Model_DbTable_NoSeguroDefeso();

        $dadosNoSeguroDefeso = array('tns_situacao' => $request['tns_situacao']);

        $this->dbTableNoSeguroDefeso->insert($dadosNoSeguroDefeso);

        return;
    }

    public function update(array $request) {
        $this->dbTableNoSeguroDefeso = new Application_Model_DbTable_NoSeguroDefeso();

        $dadosNoSeguroDefeso = array('tns_situacao' => $request['tns_situacao']);

        $whereNoSeguroDefeso = $this->dbTableNoSeguroDefeso->getAdapter()->quoteInto('"tns_id" = ?', $request['tns_id']);

        $this->dbTableNoSeguroDefeso->update($dadosNoSeguroDefeso, $whereNoSeguroDefeso);
    }

    public function delete($input_id) {
        $this->dbTableNoSeguroDefeso = new Application_Model_DbTable_NoSeguroDefeso();

        $whereNoSeguroDefeso = $this->dbTableNoSeguroDefeso->getAdapter()->quoteInto('"tns_id" = ?', $input_id);

        $this->dbTableNoSeguroDefeso->delete($whereNoSeguroDefeso);
    }

}

