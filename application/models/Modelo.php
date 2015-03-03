<?php

class Application_Model_Modelo
{

public function select($where = null, $order = null, $limit = null) {
        $this->dbTableModelo = new Application_Model_DbTable_Modelo();

        $select = $this->dbTableModelo->select()->from($this->dbTableModelo)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableModelo->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableModelo = new Application_Model_DbTable_Modelo();
        $arr = $this->dbTableModelo->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableModelo = new Application_Model_DbTable_Modelo();

        $dadosModelo = array('tmod_modelo' => $request['tmod_modelo']);

        $this->dbTableModelo->insert($dadosModelo);

        return;
    }

    public function update(array $request) {
        $this->dbTableModelo = new Application_Model_DbTable_Modelo();

        $dadosModelo = array('tmod_modelo' => $request['tmod_modelo']);

        $whereModelo = $this->dbTableModelo->getAdapter()->quoteInto('"tmod_id" = ?', $request['tmod_id']);

        $this->dbTableModelo->update($dadosModelo, $whereModelo);
    }

    public function delete($input_id) {
        $this->dbTableModelo = new Application_Model_DbTable_Modelo();

        $whereModelo = $this->dbTableModelo->getAdapter()->quoteInto('"tmod_id" = ?', $input_id);

        $this->dbTableModelo->delete($whereModelo);
    }
}

