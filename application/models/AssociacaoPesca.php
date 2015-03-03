<?php
/** 
 * Model Associacao de Pescaria
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_AssociacaoPesca
{
private $dbTableAssociacaoPesca;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableAssociacaoPesca = new Application_Model_DbTable_AssociacaoPesca();

        $select = $this->dbTableAssociacaoPesca->select()->from($this->dbTableAssociacaoPesca)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableAssociacaoPesca->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableAssociacaoPesca = new Application_Model_DbTable_AssociacaoPesca();
        $arr = $this->dbTableAssociacaoPesca->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableAssociacaoPesca = new Application_Model_DbTable_AssociacaoPesca();

        $dadosAssociacaoPesca = array('tasp_associacao' => $request['tasp_associacao']);

        $this->dbTableAssociacaoPesca->insert($dadosAssociacaoPesca);

        return;
    }

    public function update(array $request) {
        $this->dbTableAssociacaoPesca = new Application_Model_DbTable_AssociacaoPesca();

        $dadosAssociacaoPesca = array('tasp_associacao' => $request['tasp_associacao']);

        $whereAssociacaoPesca = $this->dbTableAssociacaoPesca->getAdapter()->quoteInto('"tasp_id" = ?', $request['tasp_id']);

        $this->dbTableAssociacaoPesca->update($dadosAssociacaoPesca, $whereAssociacaoPesca);
    }

    public function delete($input_id) {
        $this->dbTableAssociacaoPesca = new Application_Model_DbTable_AssociacaoPesca();

        $whereAssociacaoPesca = $this->dbTableAssociacaoPesca->getAdapter()->quoteInto('"tasp_id" = ?', $input_id);

        $this->dbTableAssociacaoPesca->delete($whereAssociacaoPesca);
    }

}