<?php
/** 
 * Model Estrutura Residencial
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_EstruturaResidencial
{
private $dbTableEstruturaResidencial;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableEstruturaResidencial = new Application_Model_DbTable_EstruturaResidencial();

        $select = $this->dbTableEstruturaResidencial->select()->from($this->dbTableEstruturaResidencial)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableEstruturaResidencial->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableEstruturaResidencial = new Application_Model_DbTable_EstruturaResidencial();
        $arr = $this->dbTableEstruturaResidencial->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableEstruturaResidencial = new Application_Model_DbTable_EstruturaResidencial();

        $dadosEstruturaResidencial = array('terd_estrutura' => $request['terd_estrutura']);

        $this->dbTableEstruturaResidencial->insert($dadosEstruturaResidencial);

        return;
    }

    public function update(array $request) {
        $this->dbTableEstruturaResidencial = new Application_Model_DbTable_EstruturaResidencial();

        $dadosEstruturaResidencial = array('terd_estrutura' => $request['terd_estrutura']);

        $whereEstruturaResidencial = $this->dbTableEstruturaResidencial->getAdapter()->quoteInto('"terd_id" = ?', $request['terd_id']);

        $this->dbTableEstruturaResidencial->update($dadosEstruturaResidencial, $whereEstruturaResidencial);
    }

    public function delete($input_id) {
        $this->dbTableEstruturaResidencial = new Application_Model_DbTable_EstruturaResidencial();

        $whereEstruturaResidencial = $this->dbTableEstruturaResidencial->getAdapter()->quoteInto('"terd_id" = ?', $input_id);

        $this->dbTableEstruturaResidencial->delete($whereEstruturaResidencial);
    }

}

