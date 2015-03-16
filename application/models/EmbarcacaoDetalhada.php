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
            'tsd_id_licenca' => $idSeguroDefeso
        );
        $dbTable_EmbDetalhadaHasSeguroDefeso->insert($dadosEmbDetalhadaHasSeguroDefeso);

        return;
    }
    
    ///DELETES EMBARCACAO
    public function deleteEmbDetalhadaHasCor($idEmbarcacao, $idCor) {
        $dbTable_EmbDetalhadaHasCor = new Application_Model_DbTable_EmbarcacaoDetalhadaHasCor();

        $dadosEmbDetalhadaHasCor = array(
            'ted_id = ?' => $idEmbarcacao,
            'tcor_id  = ?' => $idCor,
        );
        $dbTable_EmbDetalhadaHasCor->delete($dadosEmbDetalhadaHasCor);

        return;
    }
    
    public function deleteEmbDetalhadaHasEquipamento($idEmbarcacao, $idEquipamento) {
        $dbTable_EmbDetalhadaHasEquipamento = new Application_Model_DbTable_EmbarcacaoDetalhadaHasEquipamento();

        $dadosEmbDetalhadaHasEquipamento = array(
            'ted_id = ?' => $idEmbarcacao,
            'teq_id  = ?' => $idEquipamento,
        );
        $dbTable_EmbDetalhadaHasEquipamento->delete($dadosEmbDetalhadaHasEquipamento);

        return;
    }
    
    public function deleteEmbDetalhadaHasMaterial($idEmbarcacao, $idMaterial) {
        $dbTable_EmbDetalhadaHasMaterial = new Application_Model_DbTable_EmbarcacaoDetalhadaHasMaterial();

        $dadosEmbDetalhadaHasMaterial = array(
            'ted_id = ?' => $idEmbarcacao,
            'tmt_id  = ?' => $idMaterial,
        );
        $dbTable_EmbDetalhadaHasMaterial->delete($dadosEmbDetalhadaHasMaterial);

        return;
    }
    
    public function deleteEmbDetalhadaHasSavatagem($idEmbarcacao, $idSavatagem) {
        $dbTable_EmbDetalhadaHasSavatagem = new Application_Model_DbTable_EmbarcacaoDetalhadaHasSavatagem();

        $dadosEmbDetalhadaHasSavatagem = array(
            'ted_id = ?' => $idEmbarcacao,
            'tsav_id  = ?' => $idSavatagem,
        );
        $dbTable_EmbDetalhadaHasSavatagem->delete($dadosEmbDetalhadaHasSavatagem);

        return;
    }
    public function deleteEmbDetalhadaHasSeguroDefeso($idEmbarcacao, $idSeguroDefeso) {
        $dbTable_EmbDetalhadaHasSeguroDefeso = new Application_Model_DbTable_EmbarcacaoDetalhadaHasSeguroDefeso();

        $dadosEmbDetalhadaHasSeguroDefeso = array(
            'ted_id = ?' => $idEmbarcacao,
            'tsd_id_licenca  = ?' => $idSeguroDefeso,
        );
        $dbTable_EmbDetalhadaHasSeguroDefeso->delete($dadosEmbDetalhadaHasSeguroDefeso);

        return;
    }
    
    public function selectVEmbarcacaoDetalhadaHasTCor($where = null, $order = null, $limit = null){
        $this->dbTable = new Application_Model_DbTable_VEmbarcacaoDetalhadaHasTCor();
        $select = $this->dbTable->select()
                ->from($this->dbTable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable->fetchAll($select)->toArray();
    }
    public function selectVEmbarcacaoDetalhadaHasTEquipamento($where = null, $order = null, $limit = null){
        $this->dbTable = new Application_Model_DbTable_VEmbarcacaoDetalhadaHasTEquipamento();
        $select = $this->dbTable->select()
                ->from($this->dbTable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable->fetchAll($select)->toArray();
    }

    public function selectVEmbarcacaoDetalhadaHasTMaterial($where = null, $order = null, $limit = null){
        $this->dbTable = new Application_Model_DbTable_VEmbarcacaoDetalhadaHasTMaterial();
        $select = $this->dbTable->select()
                ->from($this->dbTable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable->fetchAll($select)->toArray();
    }
    
    public function selectVEmbarcacaoDetalhadaHasTSavatagem($where = null, $order = null, $limit = null){
        $this->dbTable = new Application_Model_DbTable_VEmbarcacaoDetalhadaHasTSavatagem();
        $select = $this->dbTable->select()
                ->from($this->dbTable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable->fetchAll($select)->toArray();
    }
    
    public function selectVEmbarcacaoDetalhadaHasTSeguroDefeso($where = null, $order = null, $limit = null){
        $this->dbTable = new Application_Model_DbTable_VEmbarcacaoDetalhadaHasTSeguroDefeso();
        $select = $this->dbTable->select()
                ->from($this->dbTable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable->fetchAll($select)->toArray();
    }
    
    public function selectVAtuacaoEmbarcacaoHasTAreaPesca($where = null, $order = null, $limit = null){
        $this->dbTable = new Application_Model_DbTable_VAtuacaoEmbarcacaoHasTAreaPesca();
        $select = $this->dbTable->select()
                ->from($this->dbTable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable->fetchAll($select)->toArray();
    }
    
    public function selectVAtuacaoEmbarcacaoHasTArtePesca($where = null, $order = null, $limit = null){
        $this->dbTable = new Application_Model_DbTable_VAtuacaoEmbarcacaoHasTArtePesca();
        $select = $this->dbTable->select()
                ->from($this->dbTable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable->fetchAll($select)->toArray();
    }
    
    public function selectVAtuacaoEmbarcacaoHasTFornecedorPetrechos($where = null, $order = null, $limit = null){
        $this->dbTable = new Application_Model_DbTable_VAtuacaoEmbarcacaoHasTFornecedorPetrechos();
        $select = $this->dbTable->select()
                ->from($this->dbTable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable->fetchAll($select)->toArray();
    }
    
    public function selectVMotorEmbarcacaoHasTFrequenciaManutencao($where = null, $order = null, $limit = null){
        $this->dbTable = new Application_Model_DbTable_VMotorEmbarcacaoHasTFrequenciaManutencao();
        $select = $this->dbTable->select()
                ->from($this->dbTable)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTable->fetchAll($select)->toArray();
    }
}

