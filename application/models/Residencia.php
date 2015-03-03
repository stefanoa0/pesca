<?php

class Application_Model_Residencia
{
private $dbTableResidencia;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableResidencia = new Application_Model_DbTable_Residencia();

        $select = $this->dbTableResidencia->select()->from($this->dbTableResidencia)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableResidencia->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableResidencia = new Application_Model_DbTable_Residencia();
        $arr = $this->dbTableResidencia->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableResidencia = new Application_Model_DbTable_Residencia();

        $dadosResidencia = array('tre_residencia' => $request['tre_residencia']);

        $this->dbTableResidencia->insert($dadosResidencia);

        return;
    }

    public function update(array $request) {
        $this->dbTableResidencia = new Application_Model_DbTable_Residencia();

        $dadosResidencia = array('tre_residencia' => $request['tre_residencia']);

        $whereResidencia = $this->dbTableResidencia->getAdapter()->quoteInto('"tre_id" = ?', $request['tre_id']);

        $this->dbTableResidencia->update($dadosResidencia, $whereResidencia);
    }

    public function delete($input_id) {
        $this->dbTableResidencia = new Application_Model_DbTable_Residencia();

        $whereResidencia = $this->dbTableResidencia->getAdapter()->quoteInto('"tre_id" = ?', $input_id);

        $this->dbTableResidencia->delete($whereResidencia);
    }


}

