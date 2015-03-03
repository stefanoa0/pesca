<?php

class Application_Model_Ratoeira
{    
   private $dbTableRatoeira;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        $select = $this->dbTableRatoeira->select()
                ->from($this->dbTableRatoeira)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeira->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        $arr = $this->dbTableRatoeira->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        
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
        $dadosRatoeira = array(
            'rat_embarcada' => $request['embarcada'],
            'rat_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'rat_quantpescadores' => $request['numPescadores'],
            'rat_dhvolta' => $timestampVolta,
            'rat_dhsaida' => $timestampSaida, 
            'rat_subamostra' => $request['subamostra'],
            'rat_obs' => $request['observacao'],
            'sa_id' => $idSubamostra,
            'rat_tempogasto' => $request['tempoGasto'],
            'rat_numarmadilhas' => $numArmadilhas,
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'rat_mreviva' => $request['mareviva'],
            'rat_combustivel' => $combustivel
        );
        
        $insertArrasto = $this->dbTableRatoeira->insert($dadosRatoeira);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        
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
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
        }
        $numArmadilhas = $request['numArmadilhas'];
        
        if(empty($numArmadilhas)){
            $numArmadilhas = NULL;
        }
        
        $dadosRatoeira = array(
            'mnt_id' => $request['id_monitoramento'],
            'rat_embarcada' => $request['embarcada'],
            'rat_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'rat_quantpescadores' => $request['numPescadores'],
            'rat_dhvolta' => $timestampVolta,
            'rat_dhsaida' => $timestampSaida, 
            'rat_subamostra' => $request['subamostra'],
            'rat_obs' => $request['observacao'],
            'sa_id' => $idSubamostra,
            'rat_tempogasto' => $request['tempoGasto'],
            'rat_numarmadilhas' => $numArmadilhas,
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'rat_mreviva' => $request['mareviva'],
            'rat_combustivel' => $combustivel
        );
 
        
        $whereRatoeira= $this->dbTableRatoeira->getAdapter()
                ->quoteInto('"rat_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableRatoeira->update($dadosRatoeira, $whereRatoeira);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Ratoeira();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idRatoeira)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();       
                
        $whereRatoeira= $this->dbTableRatoeira->getAdapter()
                ->quoteInto('"rat_id" = ?', $idRatoeira);
        
        $this->dbTableRatoeira->delete($whereRatoeira);
    }
    public function selectId(){
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        
        $select = $this->dbTableRatoeira->select()
                ->from($this->dbTableRatoeira, 'rat_id')->order('rat_id DESC')->limit('1');
        
        return $this->dbTableRatoeira->fetchAll($select)->toArray();
    }
    public function selectRatoeiraHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableRatoeiraHasPesqueiro = new Application_Model_DbTable_VRatoeiraHasPesqueiro();
        $select = $this->dbTableRatoeiraHasPesqueiro->select()
                ->from($this->dbTableRatoeiraHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeiraHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTRatoeiraHasPesqueiro = new Application_Model_DbTable_RatoeiraHasPesqueiro();
        
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
       
        $dadosPesqueiro = array(
            'rat_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTRatoeiraHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTRatoeiraHasPesqueiro = new Application_Model_DbTable_RatoeiraHasPesqueiro();       
                
        $whereRatoeiraHasPesqueiro = $this->dbTableTRatoeiraHasPesqueiro->getAdapter()
                ->quoteInto('"rat_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTRatoeiraHasPesqueiro->delete($whereRatoeiraHasPesqueiro);
        
    }
    public function selectRatoeiraHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableRatoeiraHasEspCapturada = new Application_Model_DbTable_VRatoeiraHasEspecieCapturada();
        
        $select = $this->dbTableRatoeiraHasEspCapturada->select()
                ->from($this->dbTableRatoeiraHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableRatoeiraHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTRatoeiraHasEspCapturada = new Application_Model_DbTable_RatoeiraHasEspecieCapturada();
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
            'rat_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id'=> $idTipoVenda
        );
        
        $this->dbTableTRatoeiraHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTRatoeiraHasEspCapturada = new Application_Model_DbTable_RatoeiraHasEspecieCapturada();       
                
        $whereRatoeiraHasEspCapturada = $this->dbTableTRatoeiraHasEspCapturada->getAdapter()
                ->quoteInto('"spc_rat_id" = ?', $idEspecie);
        
        $this->dbTableTRatoeiraHasEspCapturada->delete($whereRatoeiraHasEspCapturada);
    }
    public function selectEntrevistaRatoeira($where = null, $order = null, $limit = null)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_VEntrevistaRatoeira();
        $select = $this->dbTableRatoeira->select()
                ->from($this->dbTableRatoeira)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeira->fetchAll($select)->toArray();
    }
    public function selectRatoeiraHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableRatoeiraAvistamento = new Application_Model_DbTable_VRatoeiraHasAvistamento();
        $selectAvist = $this->dbTableRatoeiraAvistamento->select()
                ->from($this->dbTableRatoeiraAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableRatoeiraAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTRatoeiraHasAvistamento = new Application_Model_DbTable_RatoeiraHasAvistamento();
        
        
        $dadosAvistamento = array(
            'rat_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTRatoeiraHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTRatoeiraHasAvistamento = new Application_Model_DbTable_RatoeiraHasAvistamento();       
                
        $dadosRatoeiraHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'rat_id= ?' => $idEntrevista
        );
        
        $this->dbTableTRatoeiraHasAvistamento->delete($dadosRatoeiraHasAvistamento);
    }
    
 ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableRatoeiraHasBioCamarao = new Application_Model_DbTable_RatoeiraHasBioCamarao();


        $dadosPesqueiro = array(
            'trat_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableRatoeiraHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableRatoeiraHasBioCamarao = new Application_Model_DbTable_VRatoeiraHasBioCamarao();
        $select = $this->dbTableRatoeiraHasBioCamarao->select()
                ->from($this->dbTableRatoeiraHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeiraHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTRatoeiraHasBioCamarao = new Application_Model_DbTable_RatoeiraHasBioCamarao();

        $whereRatoeiraHasBiometria = $this->dbTableTRatoeiraHasBioCamarao->getAdapter()
                ->quoteInto('tratbc_id = ?', $idBiometria);

        $this->dbTableTRatoeiraHasBioCamarao->delete($whereRatoeiraHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableRatoeiraHasBioPeixe = new Application_Model_DbTable_RatoeiraHasBioPeixe();


        $dadosPesqueiro = array(
            'trat_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableRatoeiraHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableRatoeiraHasBioPeixe = new Application_Model_DbTable_VRatoeiraHasBioPeixe();
        $select = $this->dbTableRatoeiraHasBioPeixe->select()
                ->from($this->dbTableRatoeiraHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeiraHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTRatoeiraHasBioPeixe = new Application_Model_DbTable_RatoeiraHasBioPeixe();

        $whereRatoeiraHasBiometria = $this->dbTableTRatoeiraHasBioPeixe->getAdapter()
                ->quoteInto('tratbp_id = ?', $idBiometria);

        $this->dbTableTRatoeiraHasBioPeixe->delete($whereRatoeiraHasBiometria);
        
    }
}


