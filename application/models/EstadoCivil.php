<?php
/** 
 * Model Estado Civil
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_EstadoCivil
{
private $dbTableEstadoCivil;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableEstadoCivil = new Application_Model_DbTable_EstadoCivil();

        $select = $this->dbTableEstadoCivil->select()->from($this->dbTableEstadoCivil)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableEstadoCivil->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableEstadoCivil = new Application_Model_DbTable_EstadoCivil();
        $arr = $this->dbTableEstadoCivil->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableEstadoCivil = new Application_Model_DbTable_EstadoCivil();

        $dadosEstadoCivil = array('tec_estado' => $request['tec_estado']);

        $this->dbTableEstadoCivil->insert($dadosEstadoCivil);

        return;
    }

    public function update(array $request) {
        $this->dbTableEstadoCivil = new Application_Model_DbTable_EstadoCivil();

        $dadosEstadoCivil = array('tec_estado' => $request['tec_estado']);

        $whereEstadoCivil = $this->dbTableEstadoCivil->getAdapter()->quoteInto('"tec_id" = ?', $request['tec_id']);

        $this->dbTableEstadoCivil->update($dadosEstadoCivil, $whereEstadoCivil);
    }

    public function delete($input_id) {
        $this->dbTableEstadoCivil = new Application_Model_DbTable_EstadoCivil();

        $whereEstadoCivil = $this->dbTableEstadoCivil->getAdapter()->quoteInto('"tec_id" = ?', $input_id);

        $this->dbTableEstadoCivil->delete($whereEstadoCivil);
    }

}

