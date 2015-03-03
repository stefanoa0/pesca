<?php

class Application_Model_Porto
{
    private $dbTablePorto;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTablePorto = new Application_Model_DbTable_Porto();
        $select = $this->dbTablePorto->select()->from($this->dbTablePorto)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTablePorto->fetchAll($select)->toArray();
    }

    public function find($id)
    {
        $this->dbTablePorto = new Application_Model_DbTable_Porto();
        $arr = $this->dbTablePorto->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request)
    {
        $this->dbTablePorto = new Application_Model_DbTable_Porto();

        $dadosPorto = array(
            'pto_nome'  => $request['nome'],
            'pto_local'  => $request['local'],
            'tmun_id'   => $request['municipio']
        );

        $this->dbTablePorto->insert($dadosPorto);

        return;
    }

    public function update(array $request)
    {
        $this->dbTablePorto = new Application_Model_DbTable_Porto();

        $dadosPorto = array(
            'pto_nome'  => $request['nome'],
            'pto_local'  => $request['local'],
            'tmun_id'   => $request['municipio']
        );

        $wherePorto= $this->dbTablePorto->getAdapter()->quoteInto('"pto_id" = ?', $request['idPorto']);

        $this->dbTablePorto->update($dadosPorto, $wherePorto);
    }

    public function delete($idPorto)
    {
        $this->dbTablePorto = new Application_Model_DbTable_Porto();

        $wherePorto= $this->dbTablePorto->getAdapter()->quoteInto('"pto_id" = ?', $idPorto);

        $this->dbTablePorto->delete($wherePorto);
    }

	public function selectView($where = null, $order = null, $limit = null)
	{
		$dbTablePortoV = new Application_Model_DbTable_VPorto();
		$select = $dbTablePortoV->select()->from($dbTablePortoV)->order($order)->limit($limit);

		if( !is_null($where) ) {
			$select->where($where);
		}

		return $dbTablePortoV->fetchAll($select)->toArray();
	}

}