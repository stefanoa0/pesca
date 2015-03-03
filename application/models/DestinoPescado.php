<?php
/** 
 * Model Destino do Pescado
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_DestinoPescado {

    private $dbTableDestinoPescado;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableDestinoPescado = new Application_Model_DbTable_DestinoPescado();

        $select = $this->dbTableDestinoPescado->select()->from($this->dbTableDestinoPescado)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableDestinoPescado->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableDestinoPescado = new Application_Model_DbTable_DestinoPescado();
        $arr = $this->dbTableDestinoPescado->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableDestinoPescado = new Application_Model_DbTable_DestinoPescado();

        $dadosPerfil = array('dp_destino' => $request['dp_destino']);

        $this->dbTableDestinoPescado->insert($dadosPerfil);

        return;
    }

    public function update(array $request) {
        $this->dbTableDestinoPescado = new Application_Model_DbTable_DestinoPescado();

        $dadosPerfil = array('dp_destino' => $request['dp_destino']);

        $wherePerfil = $this->dbTableDestinoPescado->getAdapter()->quoteInto('"dp_id" = ?', $request['dp_id']);

        $this->dbTableDestinoPescado->update($dadosPerfil, $wherePerfil);
    }

    public function delete($inputdp_id) {
        $this->dbTableDestinoPescado = new Application_Model_DbTable_DestinoPescado();

        $wherePerfil = $this->dbTableDestinoPescado->getAdapter()->quoteInto('"dp_id" = ?', $inputdp_id);

        $this->dbTableDestinoPescado->delete($wherePerfil);
    }

}