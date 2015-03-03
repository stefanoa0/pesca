<?php
/** 
 * Model Insumos
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Insumo
{
private $dbTableInsumo;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableInsumo = new Application_Model_DbTable_Insumo();

        $select = $this->dbTableInsumo->select()->from($this->dbTableInsumo)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableInsumo->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableInsumo = new Application_Model_DbTable_Insumo();
        $arr = $this->dbTableInsumo->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableInsumo = new Application_Model_DbTable_Insumo();

        $dadosInsumo = array('tin_insumo' => $request['tin_insumo']);

        $this->dbTableInsumo->insert($dadosInsumo);

        return;
    }

    public function update(array $request) {
        $this->dbTableInsumo = new Application_Model_DbTable_Insumo();

        $dadosInsumo = array('tin_insumo' => $request['tin_insumo']);

        $whereInsumo = $this->dbTableInsumo->getAdapter()->quoteInto('"tin_id" = ?', $request['tin_id']);

        $this->dbTableInsumo->update($dadosInsumo, $whereInsumo);
    }

    public function delete($input_id) {
        $this->dbTableInsumo = new Application_Model_DbTable_Insumo();

        $whereInsumo = $this->dbTableInsumo->getAdapter()->quoteInto('"tin_id" = ?', $input_id);

        $this->dbTableInsumo->delete($whereInsumo);
    }

}

