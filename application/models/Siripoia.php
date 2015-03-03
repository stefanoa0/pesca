<?php

class Application_Model_Siripoia
{    private $dbTableSiripoia;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        $select = $this->dbTableSiripoia->select()
                ->from($this->dbTableSiripoia)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoia->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        $arr = $this->dbTableSiripoia->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        if($request['subamostra']==true){
        $dadosSubamostra = array(
            'sa_pescador' => $request['pescadorEntrevistado'],
            'sa_datachegada' => $request['dataVolta']
        );
        
       $idSubamostra =  $this->dbTableSubamostra->insert($dadosSubamostra);
        }
        else {
            $idSubamostra = null;
        }
        $numArmadilhas = $request['numArmadilhas'];
        
        if(empty($numArmadilhas)){
            $numArmadilhas = NULL;
        }
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
        }
        $dadosSiripoia = array(
            'sir_embarcada' => $request['embarcada'],
            'sir_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'sir_quantpescadores' => $request['numPescadores'],
            'sir_dhvolta' => $timestampVolta,
            'sir_dhsaida' => $timestampSaida, 
            'sir_tempogasto' => $request['tempoGasto'],
            'sir_subamostra' => $request['subamostra'],
            'sir_obs' => $request['observacao'],
            'sa_id' => $idSubamostra,
            'sir_numarmadilhas' => $numArmadilhas,
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'sir_mreviva' => $request['mareviva'],
            'sir_combustivel' => $combustivel
        );
        
        $insertArrasto = $this->dbTableSiripoia->insert($dadosSiripoia);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        if($request['subamostra']==true){
        $dadosSubamostra = array(
            'sa_pescador' => $request['pescadorEntrevistado'],
            'sa_datachegada' => $request['dataVolta']
        );
        
       $idSubamostra =  $this->dbTableSubamostra->insert($dadosSubamostra);
        }
        else {
            $idSubamostra = null;
        }
        $numArmadilhas = $request['numArmadilhas'];
        
        if(empty($numArmadilhas)){
            $numArmadilhas = NULL;
        }
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
        }
        $dadosSiripoia = array(
            'mnt_id' => $request['id_monitoramento'],
            'sir_embarcada' => $request['embarcada'],
            'sir_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'sir_quantpescadores' => $request['numPescadores'],
            'sir_dhvolta' => $timestampVolta,
            'sir_dhsaida' => $timestampSaida, 
            'sir_tempogasto' => $request['tempoGasto'],
            'sir_subamostra' => $request['subamostra'],
            'sir_obs' => $request['observacao'],
            'sa_id' => $idSubamostra,
            'sir_numarmadilhas' => $numArmadilhas,
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'sir_mreviva' => $request['mareviva'],
            'sir_combustivel' => $combustivel
        );
 
        
        $whereSiripoia= $this->dbTableSiripoia->getAdapter()
                ->quoteInto('"sir_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableSiripoia->update($dadosSiripoia, $whereSiripoia);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Siripoia();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idSiripoia)
    {
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();       
                
        $whereSiripoia= $this->dbTableSiripoia->getAdapter()
                ->quoteInto('"sir_id" = ?', $idSiripoia);
        
        $this->dbTableSiripoia->delete($whereSiripoia);
    }
    public function selectId(){
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        
        $select = $this->dbTableSiripoia->select()
                ->from($this->dbTableSiripoia, 'sir_id')->order('sir_id DESC')->limit('1');
        
        return $this->dbTableSiripoia->fetchAll($select)->toArray();
    }
    public function selectSiripoiaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableSiripoiaHasPesqueiro = new Application_Model_DbTable_VSiripoiaHasPesqueiro();
        $select = $this->dbTableSiripoiaHasPesqueiro->select()
                ->from($this->dbTableSiripoiaHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoiaHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTSiripoiaHasPesqueiro = new Application_Model_DbTable_SiripoiaHasPesqueiro();
       if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        
        $dadosPesqueiro = array(
            'sir_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTSiripoiaHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTSiripoiaHasPesqueiro = new Application_Model_DbTable_SiripoiaHasPesqueiro();       
                
        $whereSiripoiaHasPesqueiro = $this->dbTableTSiripoiaHasPesqueiro->getAdapter()
                ->quoteInto('"sir_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTSiripoiaHasPesqueiro->delete($whereSiripoiaHasPesqueiro);
        
    }
    public function selectSiripoiaHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableSiripoiaHasEspCapturada = new Application_Model_DbTable_VSiripoiaHasEspecieCapturada();
        
        $select = $this->dbTableSiripoiaHasEspCapturada->select()
                ->from($this->dbTableSiripoiaHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableSiripoiaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTSiripoiaHasEspCapturada = new Application_Model_DbTable_SiripoiaHasEspecieCapturada();
        
        if(empty($quantidade) && empty($peso)){
            $quantidade = 'Erro';
        }
        if(empty($quantidade)){
            $quantidade = NULL;
        }
        if(empty($peso)){
            $peso = NULL;
        }
        if(empty($precokg)){
            $precokg = NULL;
        }
        $dadosEspecie = array(
            'sir_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda
        );
        
        $this->dbTableTSiripoiaHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTSiripoiaHasEspCapturada = new Application_Model_DbTable_SiripoiaHasEspecieCapturada();       
                
        $whereSiripoiaHasEspCapturada = $this->dbTableTSiripoiaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_sir_id" = ?', $idEspecie);
        
        $this->dbTableTSiripoiaHasEspCapturada->delete($whereSiripoiaHasEspCapturada);
    }
    public function selectEntrevistaSiripoia($where = null, $order = null, $limit = null)
    {
        $this->dbTableSiripoia = new Application_Model_DbTable_VEntrevistaSiripoia();
        $select = $this->dbTableSiripoia->select()
                ->from($this->dbTableSiripoia)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoia->fetchAll($select)->toArray();
    }
    public function selectSiripoiaHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableSiripoiaAvistamento = new Application_Model_DbTable_VSiripoiaHasAvistamento();
        $selectAvist = $this->dbTableSiripoiaAvistamento->select()
                ->from($this->dbTableSiripoiaAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableSiripoiaAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTSiripoiaHasAvistamento = new Application_Model_DbTable_SiripoiaHasAvistamento();
        
        
        $dadosAvistamento = array(
            'sir_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTSiripoiaHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTSiripoiaHasAvistamento = new Application_Model_DbTable_SiripoiaHasAvistamento();       
                
        $dadosSiripoiaHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'sir_id= ?' => $idEntrevista
        );
        
        $this->dbTableTSiripoiaHasAvistamento->delete($dadosSiripoiaHasAvistamento);
    }
    
 ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableSiripoiaHasBioCamarao = new Application_Model_DbTable_SiripoiaHasBioCamarao();


        $dadosPesqueiro = array(
            'tsir_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableSiripoiaHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableSiripoiaHasBioCamarao = new Application_Model_DbTable_VSiripoiaHasBioCamarao();
        $select = $this->dbTableSiripoiaHasBioCamarao->select()
                ->from($this->dbTableSiripoiaHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoiaHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTSiripoiaHasBioCamarao = new Application_Model_DbTable_SiripoiaHasBioCamarao();

        $whereSiripoiaHasBiometria = $this->dbTableTSiripoiaHasBioCamarao->getAdapter()
                ->quoteInto('tsirbc_id = ?', $idBiometria);

        $this->dbTableTSiripoiaHasBioCamarao->delete($whereSiripoiaHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableSiripoiaHasBioPeixe = new Application_Model_DbTable_SiripoiaHasBioPeixe();


        $dadosPesqueiro = array(
            'tsir_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableSiripoiaHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableSiripoiaHasBioPeixe = new Application_Model_DbTable_VSiripoiaHasBioPeixe();
        $select = $this->dbTableSiripoiaHasBioPeixe->select()
                ->from($this->dbTableSiripoiaHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoiaHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTSiripoiaHasBioPeixe = new Application_Model_DbTable_SiripoiaHasBioPeixe();

        $whereSiripoiaHasBiometria = $this->dbTableTSiripoiaHasBioPeixe->getAdapter()
                ->quoteInto('tsirbp_id = ?', $idBiometria);

        $this->dbTableTSiripoiaHasBioPeixe->delete($whereSiripoiaHasBiometria);
        
    }
}

