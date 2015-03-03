<?php

class Application_Model_Cor
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableCor = new Application_Model_DbTable_Cor();

        $select = $this->dbTableCor->select()->from($this->dbTableCor)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableCor->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableCor = new Application_Model_DbTable_Cor();
        $arr = $this->dbTableCor->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableCor = new Application_Model_DbTable_Cor();

        $dadosCor = array('tcor_cor' => $request['tcor_cor']);

        $this->dbTableCor->insert($dadosCor);

        return;
    }

    public function update(array $request) {
        $this->dbTableCor = new Application_Model_DbTable_Cor();

        $dadosCor = array('tcor_cor' => $request['tcor_cor']);

        $whereCor = $this->dbTableCor->getAdapter()->quoteInto('"tcor_id" = ?', $request['tcor_id']);

        $this->dbTableCor->update($dadosCor, $whereCor);
    }

    public function delete($input_id) {
        $this->dbTableCor = new Application_Model_DbTable_Cor();

        $whereCor = $this->dbTableCor->getAdapter()->quoteInto('"tcor_id" = ?', $input_id);

        $this->dbTableCor->delete($whereCor);
    }

}

