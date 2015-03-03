<?php

class Application_Model_SobraDaPesca
{
private $dbTableSobraDaPesca;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableSobraDaPesca = new Application_Model_DbTable_SobraDaPesca();

        $select = $this->dbTableSobraDaPesca->select()->from($this->dbTableSobraDaPesca)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableSobraDaPesca->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableSobraDaPesca = new Application_Model_DbTable_SobraDaPesca();
        $arr = $this->dbTableSobraDaPesca->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableSobraDaPesca = new Application_Model_DbTable_SobraDaPesca();

        $dadosSobraDaPesca = array('tsp_sobra' => $request['tsp_sobra']);

        $this->dbTableSobraDaPesca->insert($dadosSobraDaPesca);

        return;
    }

    public function update(array $request) {
        $this->dbTableSobraDaPesca = new Application_Model_DbTable_SobraDaPesca();

        $dadosSobraDaPesca = array('tsp_sobra' => $request['tsp_sobra']);

        $whereSobraDaPesca = $this->dbTableSobraDaPesca->getAdapter()->quoteInto('"tsp_id" = ?', $request['tsp_id']);

        $this->dbTableSobraDaPesca->update($dadosSobraDaPesca, $whereSobraDaPesca);
    }

    public function delete($input_id) {
        $this->dbTableSobraDaPesca = new Application_Model_DbTable_SobraDaPesca();

        $whereSobraDaPesca = $this->dbTableSobraDaPesca->getAdapter()->quoteInto('"tsp_id" = ?', $input_id);

        $this->dbTableSobraDaPesca->delete($whereSobraDaPesca);
    }

}

