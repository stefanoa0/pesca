<?php

class Application_Model_ConservacaoPescado
{

public function select($where = null, $order = null, $limit = null) {
        $this->dbTableConservacaoPescado = new Application_Model_DbTable_ConservacaoPescado();

        $select = $this->dbTableConservacaoPescado->select()->from($this->dbTableConservacaoPescado)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableConservacaoPescado->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableConservacaoPescado = new Application_Model_DbTable_ConservacaoPescado();
        $arr = $this->dbTableConservacaoPescado->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableConservacaoPescado = new Application_Model_DbTable_ConservacaoPescado();

        $dadosConservacaoPescado = array('tcp_conserva' => $request['tcp_conserva']);

        $this->dbTableConservacaoPescado->insert($dadosConservacaoPescado);

        return;
    }

    public function update(array $request) {
        $this->dbTableConservacaoPescado = new Application_Model_DbTable_ConservacaoPescado();

        $dadosConservacaoPescado = array('tcp_conserva' => $request['tcp_conserva']);

        $whereConservacaoPescado = $this->dbTableConservacaoPescado->getAdapter()->quoteInto('"tcp_id" = ?', $request['tcp_id']);

        $this->dbTableConservacaoPescado->update($dadosConservacaoPescado, $whereConservacaoPescado);
    }

    public function delete($input_id) {
        $this->dbTableConservacaoPescado = new Application_Model_DbTable_ConservacaoPescado();

        $whereConservacaoPescado = $this->dbTableConservacaoPescado->getAdapter()->quoteInto('"tcp_id" = ?', $input_id);

        $this->dbTableConservacaoPescado->delete($whereConservacaoPescado);
    }
}

