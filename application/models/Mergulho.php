<?php

class Application_Model_Mergulho
{
private $dbTableMergulho;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        $select = $this->dbTableMergulho->select()
                ->from($this->dbTableMergulho)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulho->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        $arr = $this->dbTableMergulho->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        if($request['subamostra']==true){
            $dadosSubamostra = array(
                'sa_pescador' => $request['pescadorEntrevistado'],
                'sa_datachegada' => $request['data']
            );
        
            $idSubamostra =  $this->dbTableSubamostra->insert($dadosSubamostra);
        }
        else {
            $idSubamostra = null;
        }
        
        $mareViva = $request['mareviva'];
        if($mareViva=='1'){
            $mareViva = true;
        }
        else {
            $mareViva = false;
        }
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
        }
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        $dadosMergulho = array(
            'mer_embarcada' => $request['embarcada'],
            'mer_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'mer_quantpescadores' => $request['numPescadores'],
            'mer_dhsaida' => $timestampSaida,
            'mer_dhvolta' => $timestampVolta,
            'mer_tempogasto' => $request['tempoGasto'],
            'mer_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'mer_obs' => $request['observacao'],
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'mer_mreviva' => $request['mareviva'],
            'mer_combustivel' => $combustivel
        );
        
        $insertArrasto = $this->dbTableMergulho->insert($dadosMergulho);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        
        if($request['subamostra']==true){
            $dadosSubamostra = array(
                'sa_pescador' => $request['pescadorEntrevistado'],
                'sa_datachegada' => $request['data']
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
        
        $mareViva = $request['mareviva'];
        if($mareViva=='1'){
            $mareViva = true;
        }
        else {
            $mareViva = false;
        }
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        $dadosMergulho = array(
            'mnt_id' => $request['id_monitoramento'],
            'mer_embarcada' => $request['embarcada'],
            'mer_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'mer_quantpescadores' => $request['numPescadores'],
            'mer_dhsaida' => $timestampSaida,
            'mer_dhvolta' => $timestampVolta,
            'mer_tempogasto' => $request['tempoGasto'],
            'mer_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'mer_obs' => $request['observacao'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'mer_mreviva' => $request['mareviva'],
            'mer_combustivel' => $combustivel
        );
 
        
        $whereMergulho= $this->dbTableMergulho->getAdapter()
                ->quoteInto('"mer_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableMergulho->update($dadosMergulho, $whereMergulho);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Mergulho();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idMergulho)
    {
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();       
                
        $whereMergulho= $this->dbTableMergulho->getAdapter()
                ->quoteInto('"mer_id" = ?', $idMergulho);
        
        $this->dbTableMergulho->delete($whereMergulho);
    }
    public function selectId(){
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        
        $select = $this->dbTableMergulho->select()
                ->from($this->dbTableMergulho, 'mer_id')->order('mer_id DESC')->limit('1');
        
        return $this->dbTableMergulho->fetchAll($select)->toArray();
    }
    
    
    public function selectMergulhoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableMergulhoHasPesqueiro = new Application_Model_DbTable_VMergulhoHasPesqueiro();
        $select = $this->dbTableMergulhoHasPesqueiro->select()
                ->from($this->dbTableMergulhoHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulhoHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTMergulhoHasPesqueiro = new Application_Model_DbTable_MergulhoHasPesqueiro();
        
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        $dadosPesqueiro = array(
            'mer_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTMergulhoHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTMergulhoHasPesqueiro = new Application_Model_DbTable_MergulhoHasPesqueiro();       
                
        $whereMergulhoHasPesqueiro = $this->dbTableTMergulhoHasPesqueiro->getAdapter()
                ->quoteInto('"mer_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTMergulhoHasPesqueiro->delete($whereMergulhoHasPesqueiro);
        
    }
    public function selectMergulhoHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableMergulhoHasEspCapturada = new Application_Model_DbTable_VMergulhoHasEspecieCapturada();
        
        $select = $this->dbTableMergulhoHasEspCapturada->select()
                ->from($this->dbTableMergulhoHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableMergulhoHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTMergulhoHasEspCapturada = new Application_Model_DbTable_MergulhoHasEspecieCapturada();
        
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
            'mer_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' =>$idTipoVenda
        );
        
        $this->dbTableTMergulhoHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTMergulhoHasEspCapturada = new Application_Model_DbTable_MergulhoHasEspecieCapturada();       
                
        $whereMergulhoHasEspCapturada = $this->dbTableTMergulhoHasEspCapturada->getAdapter()
                ->quoteInto('"spc_mer_id" = ?', $idEspecie);
        
        $this->dbTableTMergulhoHasEspCapturada->delete($whereMergulhoHasEspCapturada);
    }
    public function selectEntrevistaMergulho($where = null, $order = null, $limit = null)
    {
        $this->dbTableMergulho = new Application_Model_DbTable_VEntrevistaMergulho();
        $select = $this->dbTableMergulho->select()
                ->from($this->dbTableMergulho)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulho->fetchAll($select)->toArray();
    }
    public function selectMergulhoHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableMergulhoAvistamento = new Application_Model_DbTable_VMergulhoHasAvistamento();
        $selectAvist = $this->dbTableMergulhoAvistamento->select()
                ->from($this->dbTableMergulhoAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableMergulhoAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTMergulhoHasAvistamento = new Application_Model_DbTable_MergulhoHasAvistamento();
        
        
        $dadosAvistamento = array(
            'mer_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTMergulhoHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTMergulhoHasAvistamento = new Application_Model_DbTable_MergulhoHasAvistamento();       
                
        $dadosMergulhoHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'mer_id= ?' => $idEntrevista
        );
        
        $this->dbTableTMergulhoHasAvistamento->delete($dadosMergulhoHasAvistamento);
    }
    
////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableMergulhoHasBioCamarao = new Application_Model_DbTable_MergulhoHasBioCamarao();


        $dadosPesqueiro = array(
            'tmer_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableMergulhoHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableMergulhoHasBioCamarao = new Application_Model_DbTable_VMergulhoHasBioCamarao();
        $select = $this->dbTableMergulhoHasBioCamarao->select()
                ->from($this->dbTableMergulhoHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulhoHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTMergulhoHasBioCamarao = new Application_Model_DbTable_MergulhoHasBioCamarao();

        $whereMergulhoHasBiometria = $this->dbTableTMergulhoHasBioCamarao->getAdapter()
                ->quoteInto('tmerbc_id = ?', $idBiometria);

        $this->dbTableTMergulhoHasBioCamarao->delete($whereMergulhoHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableMergulhoHasBioPeixe = new Application_Model_DbTable_MergulhoHasBioPeixe();


        $dadosPesqueiro = array(
            'tmer_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableMergulhoHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableMergulhoHasBioPeixe = new Application_Model_DbTable_VMergulhoHasBioPeixe();
        $select = $this->dbTableMergulhoHasBioPeixe->select()
                ->from($this->dbTableMergulhoHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulhoHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTMergulhoHasBioPeixe = new Application_Model_DbTable_MergulhoHasBioPeixe();

        $whereMergulhoHasBiometria = $this->dbTableTMergulhoHasBioPeixe->getAdapter()
                ->quoteInto('tmerbp_id = ?', $idBiometria);

        $this->dbTableTMergulhoHasBioPeixe->delete($whereMergulhoHasBiometria);
        
    }
}
