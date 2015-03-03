<?php

class Application_Model_Financiador
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableFinanciador = new Application_Model_DbTable_Financiador();

        $select = $this->dbTableFinanciador->select()->from($this->dbTableFinanciador)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableFinanciador->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableFinanciador = new Application_Model_DbTable_Financiador();
        $arr = $this->dbTableFinanciador->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableFinanciador = new Application_Model_DbTable_Financiador();

        $dadosFinanciador = array('tfin_financiador' => $request['tfin_financiador']);

        $this->dbTableFinanciador->insert($dadosFinanciador);

        return;
    }

    public function update(array $request) {
        $this->dbTableFinanciador = new Application_Model_DbTable_Financiador();

        $dadosFinanciador = array('tfin_financiador' => $request['tfin_financiador']);

        $whereFinanciador = $this->dbTableFinanciador->getAdapter()->quoteInto('"tfin_id" = ?', $request['tfin_id']);

        $this->dbTableFinanciador->update($dadosFinanciador, $whereFinanciador);
    }

    public function delete($input_id) {
        $this->dbTableFinanciador = new Application_Model_DbTable_Financiador();

        $whereFinanciador = $this->dbTableFinanciador->getAdapter()->quoteInto('"tfin_id" = ?', $input_id);

        $this->dbTableFinanciador->delete($whereFinanciador);
    }

}

