<?php

/**
 * Model Municipio
 *
 * @package Pesca
 * @subpackage Models
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class Application_Model_Municipio
{
    private $dbTableMunicipio;
    
	public function select($where = null, $order = null, $limit = null)
    {
		$this->dbTableMunicipio = new Application_Model_DbTable_Municipio();
		$select = $this->dbTableMunicipio->select()->from($this->dbTableMunicipio)->order($order)->limit($limit);

		if( !is_null($where) ) {
			$select->where($where);
		}

		return $this->dbTableMunicipio->fetchAll($select)->toArray();
    }

    public function find($id)
    {
        $this->dbTableMunicipio = new Application_Model_DbTable_Municipio();
        $arr = $this->dbTableMunicipio->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request)
    {
        $this->dbTableMunicipio = new Application_Model_DbTable_Municipio();

        $dadosMunicipio = array(
            'tmun_municipio' => $request['municipio'],
            'tuf_sigla'      => $request['estado']
        );

        $this->dbTableMunicipio->insert($dadosMunicipio);

        return;
    }

    public function update(array $request)
    {
        $this->dbTableMunicipio = new Application_Model_DbTable_Municipio();

        $dadosMunicipio = array(
            'tmun_municipio' => $request['municipio'],
            'tuf_sigla'      => $request['estado']
        );

        $whereMunicipio= $this->dbTableMunicipio->getAdapter()
                ->quoteInto('"tmun_id" = ?', $request['idMunicipio']);

        $this->dbTableMunicipio->update($dadosMunicipio, $whereMunicipio);
    }

    public function delete($idMunicipio)
    {
        $this->dbTableMunicipio = new Application_Model_DbTable_Municipio();

        $whereMunicipio= $this->dbTableMunicipio->getAdapter()
                ->quoteInto('"tmun_id" = ?', $idMunicipio);

        $this->dbTableMunicipio->delete($whereMunicipio);
    }
}
