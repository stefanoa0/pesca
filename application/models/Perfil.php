<?php

class Application_Model_Perfil {

    private $dbTablePerfil;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTablePerfil = new Application_Model_DbTable_Perfil();

        $select = $this->dbTablePerfil->select()->from($this->dbTablePerfil)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTablePerfil->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTablePerfil = new Application_Model_DbTable_Perfil();
        $arr = $this->dbTablePerfil->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTablePerfil = new Application_Model_DbTable_Perfil();

        $dadosPerfil = array('tp_perfil' => $request['tp_perfil']);

        $this->dbTablePerfil->insert($dadosPerfil);

        return;
    }

    public function update(array $request) {
        $this->dbTablePerfil = new Application_Model_DbTable_Perfil();

        $dadosPerfil = array('tp_perfil' => $request['tp_perfil']);

        $wherePerfil = $this->dbTablePerfil->getAdapter()->quoteInto('"tp_id" = ?', $request['tp_id']);

        $this->dbTablePerfil->update($dadosPerfil, $wherePerfil);
    }

    public function delete($inputTP_ID) {
        $this->dbTablePerfil = new Application_Model_DbTable_Perfil();

        $wherePerfil = $this->dbTablePerfil->getAdapter()->quoteInto('"tp_id" = ?', $inputTP_ID);

        $this->dbTablePerfil->delete($wherePerfil);
    }

}
