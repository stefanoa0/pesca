<?php

class Application_Model_TipoTransporte
{
   private $dbTableTipoTransporte;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableTipoTransporte = new Application_Model_DbTable_TipoTransporte();

        $select = $this->dbTableTipoTransporte->select()->from($this->dbTableTipoTransporte)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableTipoTransporte->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableTipoTransporte = new Application_Model_DbTable_TipoTransporte();
        $arr = $this->dbTableTipoTransporte->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableTipoTransporte = new Application_Model_DbTable_TipoTransporte();

        $dadosTipoTransporte = array('ttr_transporte' => $request['ttr_transporte']);

        $this->dbTableTipoTransporte->insert($dadosTipoTransporte);

        return;
    }

    public function update(array $request) {
        $this->dbTableTipoTransporte = new Application_Model_DbTable_TipoTransporte();

        $dadosTipoTransporte = array('ttr_transporte' => $request['ttr_transporte']);

        $whereTipoTransporte = $this->dbTableTipoTransporte->getAdapter()->quoteInto('"ttr_id" = ?', $request['ttr_id']);

        $this->dbTableTipoTransporte->update($dadosTipoTransporte, $whereTipoTransporte);
    }

    public function delete($input_id) {
        $this->dbTableTipoTransporte = new Application_Model_DbTable_TipoTransporte();

        $whereTipoTransporte = $this->dbTableTipoTransporte->getAdapter()->quoteInto('"ttr_id" = ?', $input_id);

        $this->dbTableTipoTransporte->delete($whereTipoTransporte);
    }

}

