<?php

class Application_Model_TipoCasco
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableTipoCasco = new Application_Model_DbTable_TipoCasco();

        $select = $this->dbTableTipoCasco->select()->from($this->dbTableTipoCasco)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableTipoCasco->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableTipoCasco = new Application_Model_DbTable_TipoCasco();
        $arr = $this->dbTableTipoCasco->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableTipoCasco = new Application_Model_DbTable_TipoCasco();

        $dadosTipoCasco = array('tcas_tipo' => $request['tcas_tipo']);

        $this->dbTableTipoCasco->insert($dadosTipoCasco);

        return;
    }

    public function update(array $request) {
        $this->dbTableTipoCasco = new Application_Model_DbTable_TipoCasco();

        $dadosTipoCasco = array('tcas_tipo' => $request['tcas_tipo']);

        $whereTipoCasco = $this->dbTableTipoCasco->getAdapter()->quoteInto('"tcas_id" = ?', $request['tcas_id']);

        $this->dbTableTipoCasco->update($dadosTipoCasco, $whereTipoCasco);
    }

    public function delete($input_id) {
        $this->dbTableTipoCasco = new Application_Model_DbTable_TipoCasco();

        $whereTipoCasco = $this->dbTableTipoCasco->getAdapter()->quoteInto('"tcas_id" = ?', $input_id);

        $this->dbTableTipoCasco->delete($whereTipoCasco);
    }

}

