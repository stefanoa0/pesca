<?php

class Application_Model_Equipamento
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableEquipamento = new Application_Model_DbTable_Equipamento();

        $select = $this->dbTableEquipamento->select()->from($this->dbTableEquipamento)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableEquipamento->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableEquipamento = new Application_Model_DbTable_Equipamento();
        $arr = $this->dbTableEquipamento->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableEquipamento = new Application_Model_DbTable_Equipamento();

        $dadosEquipamento = array('teq_equipamento' => $request['teq_equipamento']);

        $this->dbTableEquipamento->insert($dadosEquipamento);

        return;
    }

    public function update(array $request) {
        $this->dbTableEquipamento = new Application_Model_DbTable_Equipamento();

        $dadosEquipamento = array('teq_equipamento' => $request['teq_equipamento']);

        $whereEquipamento = $this->dbTableEquipamento->getAdapter()->quoteInto('"teq_id" = ?', $request['teq_id']);

        $this->dbTableEquipamento->update($dadosEquipamento, $whereEquipamento);
    }

    public function delete($input_id) {
        $this->dbTableEquipamento = new Application_Model_DbTable_Equipamento();

        $whereEquipamento = $this->dbTableEquipamento->getAdapter()->quoteInto('"teq_id" = ?', $input_id);

        $this->dbTableEquipamento->delete($whereEquipamento);
    }

}

