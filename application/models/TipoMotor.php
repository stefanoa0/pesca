<?php

class Application_Model_TipoMotor
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableTipoMotor = new Application_Model_DbTable_TipoMotor();

        $select = $this->dbTableTipoMotor->select()->from($this->dbTableTipoMotor)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableTipoMotor->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableTipoMotor = new Application_Model_DbTable_TipoMotor();
        $arr = $this->dbTableTipoMotor->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableTipoMotor = new Application_Model_DbTable_TipoMotor();

        $dadosTipoMotor = array('tmot_tipo' => $request['tmot_tipo']);

        $this->dbTableTipoMotor->insert($dadosTipoMotor);

        return;
    }

    public function update(array $request) {
        $this->dbTableTipoMotor = new Application_Model_DbTable_TipoMotor();

        $dadosTipoMotor = array('tmot_tipo' => $request['tmot_tipo']);

        $whereTipoMotor = $this->dbTableTipoMotor->getAdapter()->quoteInto('"tmot_id" = ?', $request['tmot_id']);

        $this->dbTableTipoMotor->update($dadosTipoMotor, $whereTipoMotor);
    }

    public function delete($input_id) {
        $this->dbTableTipoMotor = new Application_Model_DbTable_TipoMotor();

        $whereTipoMotor = $this->dbTableTipoMotor->getAdapter()->quoteInto('"tmot_id" = ?', $input_id);

        $this->dbTableTipoMotor->delete($whereTipoMotor);
    }

}

