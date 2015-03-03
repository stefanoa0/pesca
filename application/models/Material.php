<?php

class Application_Model_Material
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableMaterial = new Application_Model_DbTable_Material();

        $select = $this->dbTableMaterial->select()->from($this->dbTableMaterial)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableMaterial->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableMaterial = new Application_Model_DbTable_Material();
        $arr = $this->dbTableMaterial->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableMaterial = new Application_Model_DbTable_Material();

        $dadosMaterial = array('tmt_material' => $request['tmt_material']);

        $this->dbTableMaterial->insert($dadosMaterial);

        return;
    }

    public function update(array $request) {
        $this->dbTableMaterial = new Application_Model_DbTable_Material();

        $dadosMaterial = array('tmt_material' => $request['tmt_material']);

        $whereMaterial = $this->dbTableMaterial->getAdapter()->quoteInto('"tmt_id" = ?', $request['tmt_id']);

        $this->dbTableMaterial->update($dadosMaterial, $whereMaterial);
    }

    public function delete($input_id) {
        $this->dbTableMaterial = new Application_Model_DbTable_Material();

        $whereMaterial = $this->dbTableMaterial->getAdapter()->quoteInto('"tmt_id" = ?', $input_id);

        $this->dbTableMaterial->delete($whereMaterial);
    }

}

