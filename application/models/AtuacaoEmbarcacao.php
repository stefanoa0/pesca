<?php

class Application_Model_AtuacaoEmbarcacao
{

public function select($where = null, $order = null, $limit = null) {
        $this->dbTableAtuacaoEmbarcacao = new Application_Model_DbTable_AtuacaoEmbarcacao();

        $select = $this->dbTableAtuacaoEmbarcacao->select()->from($this->dbTableAtuacaoEmbarcacao)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableAtuacaoEmbarcacao->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableAtuacaoEmbarcacao = new Application_Model_DbTable_AtuacaoEmbarcacao();
        $arr = $this->dbTableAtuacaoEmbarcacao->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableAtuacaoEmbarcacao = new Application_Model_DbTable_AtuacaoEmbarcacao();

        $dadosAtuacaoEmbarcacao = array();

        $this->dbTableAtuacaoEmbarcacao->insert($dadosAtuacaoEmbarcacao);

        return;
    }

    public function update(array $request) {
        $this->dbTableAtuacaoEmbarcacao = new Application_Model_DbTable_AtuacaoEmbarcacao();

        $dadosAtuacaoEmbarcacao = array();

        $whereAtuacaoEmbarcacao = $this->dbTableAtuacaoEmbarcacao->getAdapter()->quoteInto('"tae_id" = ?', $request['tae_id']);

        $this->dbTableAtuacaoEmbarcacao->update($dadosAtuacaoEmbarcacao, $whereAtuacaoEmbarcacao);
    }

    public function delete($input_id) {
        $this->dbTableAtuacaoEmbarcacao = new Application_Model_DbTable_AtuacaoEmbarcacao();

        $whereAtuacaoEmbarcacao = $this->dbTableAtuacaoEmbarcacao->getAdapter()->quoteInto('"tae_id" = ?', $input_id);

        $this->dbTableAtuacaoEmbarcacao->delete($whereAtuacaoEmbarcacao);
    }
    
    public function insertAtEmbarcacaoHasAreaPesca($idEmbarcacao, $idAreaPesca) {
        $dbTable_AtEmbarcacaoHasAreaPesca = new Application_Model_DbTable_AtuacaoEmbarcacaoHasAreaPesca();

        $dadosAtEmbarcacaoHasAreaPesca = array(
            'tae_id' => $idEmbarcacao,
            'tfp_id' => $idAreaPesca
        );
        $dbTable_AtEmbarcacaoHasAreaPesca->insert($dadosAtEmbarcacaoHasAreaPesca);

        return;
    }
}

