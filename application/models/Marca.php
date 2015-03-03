<?php

class Application_Model_Marca
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableMarca = new Application_Model_DbTable_Marca();

        $select = $this->dbTableMarca->select()->from($this->dbTableMarca)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableMarca->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableMarca = new Application_Model_DbTable_Marca();
        $arr = $this->dbTableMarca->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableMarca = new Application_Model_DbTable_Marca();

        $dadosMarca = array('tmar_marca' => $request['tmar_marca']);

        $this->dbTableMarca->insert($dadosMarca);

        return;
    }

    public function update(array $request) {
        $this->dbTableMarca = new Application_Model_DbTable_Marca();

        $dadosMarca = array('tmar_marca' => $request['tmar_marca']);

        $whereMarca = $this->dbTableMarca->getAdapter()->quoteInto('"tmar_id" = ?', $request['tmar_id']);

        $this->dbTableMarca->update($dadosMarca, $whereMarca);
    }

    public function delete($input_id) {
        $this->dbTableMarca = new Application_Model_DbTable_Marca();

        $whereMarca = $this->dbTableMarca->getAdapter()->quoteInto('"tmar_id" = ?', $input_id);

        $this->dbTableMarca->delete($whereMarca);
    }

}

