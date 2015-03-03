<?php
/** 
 * Model Estacao do Ano
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_EstacaoAno
{
private $dbTableEstacaoAno;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableEstacaoAno = new Application_Model_DbTable_EstacaoAno();

        $select = $this->dbTableEstacaoAno->select()->from($this->dbTableEstacaoAno)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableEstacaoAno->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableEstacaoAno = new Application_Model_DbTable_EstacaoAno();
        $arr = $this->dbTableEstacaoAno->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableEstacaoAno = new Application_Model_DbTable_EstacaoAno();

        $dadosEstacaoAno = array('tea_estacao' => $request['tea_estacao']);

        $this->dbTableEstacaoAno->insert($dadosEstacaoAno);

        return;
    }

    public function update(array $request) {
        $this->dbTableEstacaoAno = new Application_Model_DbTable_EstacaoAno();

        $dadosEstacaoAno = array('tea_estacao' => $request['tea_estacao']);

        $whereEstacaoAno = $this->dbTableEstacaoAno->getAdapter()->quoteInto('"tea_id" = ?', $request['tea_id']);

        $this->dbTableEstacaoAno->update($dadosEstacaoAno, $whereEstacaoAno);
    }

    public function delete($input_id) {
        $this->dbTableEstacaoAno = new Application_Model_DbTable_EstacaoAno();

        $whereEstacaoAno = $this->dbTableEstacaoAno->getAdapter()->quoteInto('"tea_id" = ?', $input_id);

        $this->dbTableEstacaoAno->delete($whereEstacaoAno);
    }

}
