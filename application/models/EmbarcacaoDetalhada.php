<?php

class Application_Model_EmbarcacaoDetalhada
{
    public function select($where = null, $order = null, $limit = null) {
        $this->dbTableEmbarcacaoDetalhada = new Application_Model_DbTable_EmbarcacaoDetalhada();

        $select = $this->dbTableEmbarcacaoDetalhada->select()->from($this->dbTableEmbarcacaoDetalhada)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $this->dbTableEmbarcacaoDetalhada->fetchAll($select)->toArray();
    }

    public function find($id) {
        $this->dbTableEmbarcacaoDetalhada = new Application_Model_DbTable_EmbarcacaoDetalhada();
        $arr = $this->dbTableEmbarcacaoDetalhada->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request) {
        $this->dbTableEmbarcacaoDetalhada = new Application_Model_DbTable_EmbarcacaoDetalhada();

        $dadosEmbarcacaoDetalhada = array();

        $this->dbTableEmbarcacaoDetalhada->insert($dadosEmbarcacaoDetalhada);

        return;
    }

    public function update(array $request) {
        $this->dbTableEmbarcacaoDetalhada = new Application_Model_DbTable_EmbarcacaoDetalhada();

        $dadosEmbarcacaoDetalhada = array();

        $whereEmbarcacaoDetalhada = $this->dbTableEmbarcacaoDetalhada->getAdapter()->quoteInto('"ted_id" = ?', $request['ted_id']);

        $this->dbTableEmbarcacaoDetalhada->update($dadosEmbarcacaoDetalhada, $whereEmbarcacaoDetalhada);
    }

    public function delete($input_id) {
        $this->dbTableEmbarcacaoDetalhada = new Application_Model_DbTable_EmbarcacaoDetalhada();

        $whereEmbarcacaoDetalhada = $this->dbTableEmbarcacaoDetalhada->getAdapter()->quoteInto('"ted_id" = ?', $input_id);

        $this->dbTableEmbarcacaoDetalhada->delete($whereEmbarcacaoDetalhada);
    }
    public function insertEmbDetalhadaHasCor($idEmbarcacao, $idCor) {
        $dbTable_EmbDetalhadaHasCor = new Application_Model_DbTable_EmbarcacaoDetalhadaHasCor();

        $dadosEmbDetalhadaHasCor = array(
            'ted_id' => $idEmbarcacao,
            'tcor_id' => $idCor
        );
        $dbTable_EmbDetalhadaHasCor->insert($dadosEmbDetalhadaHasCor);

        return;
    }
    
    public function insertEmbDetalhadaHasEquipamento($idEmbarcacao, $idEquipamento) {
        $dbTable_EmbDetalhadaHasEquipamento = new Application_Model_DbTable_EmbarcacaoDetalhadaHasEquipamento();

        $dadosEmbDetalhadaHasEquipamento = array(
            'ted_id' => $idEmbarcacao,
            'teq_id' => $idEquipamento
        );
        $dbTable_EmbDetalhadaHasEquipamento->insert($dadosEmbDetalhadaHasEquipamento);

        return;
    }
    public function insertEmbDetalhadaHasMaterial($idEmbarcacao, $idMaterial) {
        $dbTable_EmbDetalhadaHasMaterial = new Application_Model_DbTable_EmbarcacaoDetalhadaHasMaterial();

        $dadosEmbDetalhadaHasMaterial = array(
            'ted_id' => $idEmbarcacao,
            'tmt_id' => $idMaterial
        );
        $dbTable_EmbDetalhadaHasMaterial->insert($dadosEmbDetalhadaHasMaterial);

        return;
    }
    public function insertEmbDetalhadaHasSavatagem($idEmbarcacao, $idSavatagem) {
        $dbTable_EmbDetalhadaHasSavatagem = new Application_Model_DbTable_EmbarcacaoDetalhadaHasSavatagem();

        $dadosEmbDetalhadaHasSavatagem = array(
            'ted_id' => $idEmbarcacao,
            'tsav_id' => $idSavatagem
        );
        $dbTable_EmbDetalhadaHasSavatagem->insert($dadosEmbDetalhadaHasSavatagem);

        return;
    }
    public function insertEmbDetalhadaHasSeguroDefeso($idEmbarcacao, $idSeguroDefeso) {
        $dbTable_EmbDetalhadaHasSeguroDefeso = new Application_Model_DbTable_EmbarcacaoDetalhadaHasSeguroDefeso();

        $dadosEmbDetalhadaHasSeguroDefeso = array(
            'ted_id' => $idEmbarcacao,
            'tsv_id' => $idSeguroDefeso
        );
        $dbTable_EmbDetalhadaHasSeguroDefeso->insert($dadosEmbDetalhadaHasSeguroDefeso);

        return;
    }
    
}

