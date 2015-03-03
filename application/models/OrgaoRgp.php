<?php

class Application_Model_OrgaoRgp
{
private $dbTableOrgaoRgp;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableOrgaoRgp = new Application_Model_DbTable_OrgaoRgp();

        $select = $this->dbTableOrgaoRgp->select()->from($this->dbTableOrgaoRgp)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableOrgaoRgp->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableOrgaoRgp = new Application_Model_DbTable_OrgaoRgp();
        $arr = $this->dbTableOrgaoRgp->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableOrgaoRgp = new Application_Model_DbTable_OrgaoRgp();

        $dadosOrgaoRgp = array('trgp_emissor' => $request['trgp_emissor']);

        $this->dbTableOrgaoRgp->insert($dadosOrgaoRgp);

        return;
    }

    public function update(array $request) {
        $this->dbTableOrgaoRgp = new Application_Model_DbTable_OrgaoRgp();

        $dadosOrgaoRgp = array('trgp_emissor' => $request['trgp_emissor']);

        $whereOrgaoRgp = $this->dbTableOrgaoRgp->getAdapter()->quoteInto('"trgp_id" = ?', $request['trgp_id']);

        $this->dbTableOrgaoRgp->update($dadosOrgaoRgp, $whereOrgaoRgp);
    }

    public function delete($input_id) {
        $this->dbTableOrgaoRgp = new Application_Model_DbTable_OrgaoRgp();

        $whereOrgaoRgp = $this->dbTableOrgaoRgp->getAdapter()->quoteInto('"trgp_id" = ?', $input_id);

        $this->dbTableOrgaoRgp->delete($whereOrgaoRgp);
    }

}

