<?php

class Application_Model_TipoPagamento
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableTipoPagamento = new Application_Model_DbTable_TipoPagamento();

        $select = $this->dbTableTipoPagamento->select()->from($this->dbTableTipoPagamento)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableTipoPagamento->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableTipoPagamento = new Application_Model_DbTable_TipoPagamento();
        $arr = $this->dbTableTipoPagamento->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableTipoPagamento = new Application_Model_DbTable_TipoPagamento();

        $dadosTipoPagamento = array('tpg_pagamento' => $request['tpg_pagamento']);

        $this->dbTableTipoPagamento->insert($dadosTipoPagamento);

        return;
    }

    public function update(array $request) {
        $this->dbTableTipoPagamento = new Application_Model_DbTable_TipoPagamento();

        $dadosTipoPagamento = array('tpg_pagamento' => $request['tpg_pagamento']);

        $whereTipoPagamento = $this->dbTableTipoPagamento->getAdapter()->quoteInto('"tpg_id" = ?', $request['tpg_id']);

        $this->dbTableTipoPagamento->update($dadosTipoPagamento, $whereTipoPagamento);
    }

    public function delete($input_id) {
        $this->dbTableTipoPagamento = new Application_Model_DbTable_TipoPagamento();

        $whereTipoPagamento = $this->dbTableTipoPagamento->getAdapter()->quoteInto('"tpg_id" = ?', $input_id);

        $this->dbTableTipoPagamento->delete($whereTipoPagamento);
    }

}

