<?php
/** 
 * Model Fornecedor de Insumos
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_FornecedorInsumos
{
private $dbTableFornecedorInsumos;

    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableFornecedorInsumos = new Application_Model_DbTable_FornecedorInsumos();

        $select = $this->dbTableFornecedorInsumos->select()->from($this->dbTableFornecedorInsumos)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableFornecedorInsumos->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableFornecedorInsumos = new Application_Model_DbTable_FornecedorInsumos();
        $arr = $this->dbTableFornecedorInsumos->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableFornecedorInsumos = new Application_Model_DbTable_FornecedorInsumos();

        $dadosFornecedorInsumos = array('tfi_fornecedor' => $request['tfi_fornecedor']);

        $this->dbTableFornecedorInsumos->insert($dadosFornecedorInsumos);

        return;
    }

    public function update(array $request) {
        $this->dbTableFornecedorInsumos = new Application_Model_DbTable_FornecedorInsumos();

        $dadosFornecedorInsumos = array('tfi_fornecedor' => $request['tfi_fornecedor']);

        $whereFornecedorInsumos = $this->dbTableFornecedorInsumos->getAdapter()->quoteInto('"tfi_id" = ?', $request['tfi_id']);

        $this->dbTableFornecedorInsumos->update($dadosFornecedorInsumos, $whereFornecedorInsumos);
    }

    public function delete($input_id) {
        $this->dbTableFornecedorInsumos = new Application_Model_DbTable_FornecedorInsumos();

        $whereFornecedorInsumos = $this->dbTableFornecedorInsumos->getAdapter()->quoteInto('"tfi_id" = ?', $input_id);

        $this->dbTableFornecedorInsumos->delete($whereFornecedorInsumos);
    }

}
