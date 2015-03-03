<?php

class Application_Model_SeguroDefeso
{
private $dbTableSeguroDefeso;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableSeguroDefeso = new Application_Model_DbTable_SeguroDefeso();

        $select = $this->dbTableSeguroDefeso->select()->from($this->dbTableSeguroDefeso)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableSeguroDefeso->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableSeguroDefeso = new Application_Model_DbTable_SeguroDefeso();
        $arr = $this->dbTableSeguroDefeso->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableSeguroDefeso = new Application_Model_DbTable_SeguroDefeso();

        $dadosSeguroDefeso = array('tsd_seguro' => $request['tsd_seguro']);

        $this->dbTableSeguroDefeso->insert($dadosSeguroDefeso);

        return;
    }

    public function update(array $request) {
        $this->dbTableSeguroDefeso = new Application_Model_DbTable_SeguroDefeso();

        $dadosSeguroDefeso = array('tsd_seguro' => $request['tsd_seguro']);

        $whereSeguroDefeso = $this->dbTableSeguroDefeso->getAdapter()->quoteInto('"tsd_id" = ?', $request['tsd_id']);

        $this->dbTableSeguroDefeso->update($dadosSeguroDefeso, $whereSeguroDefeso);
    }

    public function delete($input_id) {
        $this->dbTableSeguroDefeso = new Application_Model_DbTable_SeguroDefeso();

        $whereSeguroDefeso = $this->dbTableSeguroDefeso->getAdapter()->quoteInto('"tsd_id" = ?', $input_id);

        $this->dbTableSeguroDefeso->delete($whereSeguroDefeso);
    }

}

