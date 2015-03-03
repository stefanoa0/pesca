<?php

class Application_Model_Recurso
{
private $dbTableRecurso;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableRecurso = new Application_Model_DbTable_Recurso();

        $select = $this->dbTableRecurso->select()->from($this->dbTableRecurso)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableRecurso->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableRecurso = new Application_Model_DbTable_Recurso();
        $arr = $this->dbTableRecurso->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableRecurso = new Application_Model_DbTable_Recurso();

        $dadosRecurso = array('trec_recurso' => $request['trec_recurso']);

        $this->dbTableRecurso->insert($dadosRecurso);

        return;
    }

    public function update(array $request) {
        $this->dbTableRecurso = new Application_Model_DbTable_Recurso();

        $dadosRecurso = array('trec_recurso' => $request['trec_recurso']);

        $whereRecurso = $this->dbTableRecurso->getAdapter()->quoteInto('"trec_id" = ?', $request['trec_id']);

        $this->dbTableRecurso->update($dadosRecurso, $whereRecurso);
    }

    public function delete($input_id) {
        $this->dbTableRecurso = new Application_Model_DbTable_Recurso();

        $whereRecurso = $this->dbTableRecurso->getAdapter()->quoteInto('"trec_id" = ?', $input_id);

        $this->dbTableRecurso->delete($whereRecurso);
    }

}

