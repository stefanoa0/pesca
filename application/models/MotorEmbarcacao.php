<?php

class Application_Model_MotorEmbarcacao
{
public function select($where = null, $order = null, $limit = null) {
        $this->dbTableMotorEmbarcacao = new Application_Model_DbTable_MotorEmbarcacao();

        $select = $this->dbTableMotorEmbarcacao->select()->from($this->dbTableMotorEmbarcacao)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableMotorEmbarcacao->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableMotorEmbarcacao = new Application_Model_DbTable_MotorEmbarcacao();
        $arr = $this->dbTableMotorEmbarcacao->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableMotorEmbarcacao = new Application_Model_DbTable_MotorEmbarcacao();

        $dadosMotorEmbarcacao = array();

        $this->dbTableMotorEmbarcacao->insert($dadosMotorEmbarcacao);

        return;
    }

    public function update(array $request) {
        $this->dbTableMotorEmbarcacao = new Application_Model_DbTable_MotorEmbarcacao();

        $dadosMotorEmbarcacao = array();

        $whereMotorEmbarcacao = $this->dbTableMotorEmbarcacao->getAdapter()->quoteInto('"tme_id" = ?', $request['tme_id']);

        $this->dbTableMotorEmbarcacao->update($dadosMotorEmbarcacao, $whereMotorEmbarcacao);
    }

    public function delete($input_id) {
        $this->dbTableMotorEmbarcacao = new Application_Model_DbTable_MotorEmbarcacao();

        $whereMotorEmbarcacao = $this->dbTableMotorEmbarcacao->getAdapter()->quoteInto('"tme_id" = ?', $input_id);

        $this->dbTableMotorEmbarcacao->delete($whereMotorEmbarcacao);
    }
    
    public function insertMotEmbarcacaoHasFrequenciaManutencao($idEmbarcacao, $idFrequencia) {
        $dbTable_MotEmbarcacaoHasFrequenciaManutencao = new Application_Model_DbTable_MotorEmbarcacaoHasFrequenciaManutencao();

        $dadosMotEmbarcacaoHasFrequenciaManutencao = array(
            'tme_id' => $idEmbarcacao,
            'tfp_id' => $idFrequencia
        );
        $dbTable_MotEmbarcacaoHasFrequenciaManutencao->insert($dadosMotEmbarcacaoHasFrequenciaManutencao);

        return;
    }
    

}

