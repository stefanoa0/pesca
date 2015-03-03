<?php

class Application_Model_Savatagem
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableSavatagem = new Application_Model_DbTable_Savatagem();

        $select = $this->dbTableSavatagem->select()->from($this->dbTableSavatagem)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableSavatagem->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableSavatagem = new Application_Model_DbTable_Savatagem();
        $arr = $this->dbTableSavatagem->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableSavatagem = new Application_Model_DbTable_Savatagem();

        $dadosSavatagem = array('tsav_savatagem' => $request['tsav_savatagem']);

        $this->dbTableSavatagem->insert($dadosSavatagem);

        return;
    }

    public function update(array $request) {
        $this->dbTableSavatagem = new Application_Model_DbTable_Savatagem();

        $dadosSavatagem = array('tsav_savatagem' => $request['tsav_savatagem']);

        $whereSavatagem = $this->dbTableSavatagem->getAdapter()->quoteInto('"tsav_id" = ?', $request['tsav_id']);

        $this->dbTableSavatagem->update($dadosSavatagem, $whereSavatagem);
    }

    public function delete($input_id) {
        $this->dbTableSavatagem = new Application_Model_DbTable_Savatagem();

        $whereSavatagem = $this->dbTableSavatagem->getAdapter()->quoteInto('"tsav_id" = ?', $input_id);

        $this->dbTableSavatagem->delete($whereSavatagem);
    }

}

