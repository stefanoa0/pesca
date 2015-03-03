<?php

class Application_Model_Manzua
{    
   private $dbTableManzua;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        $select = $this->dbTableManzua->select()
                ->from($this->dbTableManzua)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzua->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        $arr = $this->dbTableManzua->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        
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
        $dadosManzua = array(
            'man_embarcada' => $request['embarcada'],
            'man_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'man_quantpescadores' => $request['numPescadores'],
            'man_dhvolta' => $timestampVolta,
            'man_dhsaida' => $timestampSaida, 
            'dp_id' => $request['destinoPescado'],
            'man_subamostra' => $request['subamostra'],
            'man_obs' => $request['observacao'],
            'sa_id' => $idSubamostra,
            'man_tempogasto' => $request['tempoGasto'],
            'man_numarmadilhas' => $numArmadilhas,
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'man_mreviva' => $request['mareviva'],
            'man_combustivel' => $combustivel
        );
        
        $insertArrasto = $this->dbTableManzua->insert($dadosManzua);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        
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
        
        $dadosManzua = array(
            'mnt_id' => $request['id_monitoramento'],
            'man_embarcada' => $request['embarcada'],
            'man_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'man_quantpescadores' => $request['numPescadores'],
            'man_dhvolta' => $timestampVolta,
            'man_dhsaida' => $timestampSaida,  
            'man_subamostra' => $request['subamostra'],
            'man_obs' => $request['observacao'],
            'sa_id' => $idSubamostra,
            'man_tempogasto' => $request['tempoGasto'],
            'man_numarmadilhas' => $numArmadilhas,
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'man_mreviva' => $request['mareviva'],
            'man_combustivel' => $combustivel
        );
        $whereManzua= $this->dbTableManzua->getAdapter()
                ->quoteInto('"man_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableManzua->update($dadosManzua, $whereManzua);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Manzua();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idManzua)
    {
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();       
                
        $whereManzua= $this->dbTableManzua->getAdapter()
                ->quoteInto('"man_id" = ?', $idManzua);
        
        $this->dbTableManzua->delete($whereManzua);
    }
    public function selectId(){
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        
        $select = $this->dbTableManzua->select()
                ->from($this->dbTableManzua, 'man_id')->order('man_id DESC')->limit('1');
        
        return $this->dbTableManzua->fetchAll($select)->toArray();
    }
    public function selectManzuaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableManzuaHasPesqueiro = new Application_Model_DbTable_VManzuaHasPesqueiro();
        $select = $this->dbTableManzuaHasPesqueiro->select()
                ->from($this->dbTableManzuaHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzuaHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTManzuaHasPesqueiro = new Application_Model_DbTable_ManzuaHasPesqueiro();
        
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        $dadosPesqueiro = array(
            'man_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTManzuaHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTManzuaHasPesqueiro = new Application_Model_DbTable_ManzuaHasPesqueiro();       
                
        $whereManzuaHasPesqueiro = $this->dbTableTManzuaHasPesqueiro->getAdapter()
                ->quoteInto('"man_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTManzuaHasPesqueiro->delete($whereManzuaHasPesqueiro);
        
    }
    public function selectManzuaHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableManzuaHasEspCapturada = new Application_Model_DbTable_VManzuaHasEspecieCapturada();
        
        $select = $this->dbTableManzuaHasEspCapturada->select()
                ->from($this->dbTableManzuaHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableManzuaHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg , $idTipoVenda)
    {
        $this->dbTableTManzuaHasEspCapturada = new Application_Model_DbTable_ManzuaHasEspecieCapturada();
        
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
            'man_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda
        );
        
        $this->dbTableTManzuaHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTManzuaHasEspCapturada = new Application_Model_DbTable_ManzuaHasEspecieCapturada();       
                
        $whereManzuaHasEspCapturada = $this->dbTableTManzuaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_man_id" = ?', $idEspecie);
        
        $this->dbTableTManzuaHasEspCapturada->delete($whereManzuaHasEspCapturada);
    }
    public function selectEntrevistaManzua($where = null, $order = null, $limit = null)
    {
        $this->dbTableManzua = new Application_Model_DbTable_VEntrevistaManzua();
        $select = $this->dbTableManzua->select()
                ->from($this->dbTableManzua)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzua->fetchAll($select)->toArray();
    }
    public function selectManzuaHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableManzuaAvistamento = new Application_Model_DbTable_VManzuaHasAvistamento();
        $selectAvist = $this->dbTableManzuaAvistamento->select()
                ->from($this->dbTableManzuaAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableManzuaAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTManzuaHasAvistamento = new Application_Model_DbTable_ManzuaHasAvistamento();
        
        
        $dadosAvistamento = array(
            'man_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTManzuaHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTManzuaHasAvistamento = new Application_Model_DbTable_ManzuaHasAvistamento();       
                
        $dadosManzuaHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'man_id= ?' => $idEntrevista
        );
        
        $this->dbTableTManzuaHasAvistamento->delete($dadosManzuaHasAvistamento);
    }
    
        ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableManzuaHasBioCamarao = new Application_Model_DbTable_ManzuaHasBioCamarao();


        $dadosPesqueiro = array(
            'tman_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableManzuaHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableManzuaHasBioCamarao = new Application_Model_DbTable_VManzuaHasBioCamarao();
        $select = $this->dbTableManzuaHasBioCamarao->select()
                ->from($this->dbTableManzuaHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzuaHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTManzuaHasBioCamarao = new Application_Model_DbTable_ManzuaHasBioCamarao();

        $whereManzuaHasBiometria = $this->dbTableTManzuaHasBioCamarao->getAdapter()
                ->quoteInto('tmanbc_id = ?', $idBiometria);

        $this->dbTableTManzuaHasBioCamarao->delete($whereManzuaHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableManzuaHasBioPeixe = new Application_Model_DbTable_ManzuaHasBioPeixe();


        $dadosPesqueiro = array(
            'tman_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableManzuaHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableManzuaHasBioPeixe = new Application_Model_DbTable_VManzuaHasBioPeixe();
        $select = $this->dbTableManzuaHasBioPeixe->select()
                ->from($this->dbTableManzuaHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzuaHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTManzuaHasBioPeixe = new Application_Model_DbTable_ManzuaHasBioPeixe();

        $whereManzuaHasBiometria = $this->dbTableTManzuaHasBioPeixe->getAdapter()
                ->quoteInto('tmanbp_id = ?', $idBiometria);

        $this->dbTableTManzuaHasBioPeixe->delete($whereManzuaHasBiometria);
        
    }

}

