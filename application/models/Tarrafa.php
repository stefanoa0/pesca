<?php

class Application_Model_Tarrafa
{
    private $dbTableTarrafa;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();
        $select = $this->dbTableTarrafa->select()
                ->from($this->dbTableTarrafa)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafa->fetchAll($select)->toArray();
    }

    public function find($id)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();
        $arr = $this->dbTableTarrafa->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();

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
        $roda = $request['roda'];
        $altura = $request['altura'];
        $numLances = $request['numLances'];
        $malha = $request['malha'];

        if(empty($roda)){
            $roda = NULL;
        }
        if(empty($altura)){
            $altura = NULL;
        }

        if(empty($numLances)){
            $numLances = NULL;
        }

        if(empty($malha)){
            $malha = NULL;
        }


        $dadosTarrafa = array(
            'tar_embarcado' => $request['embarcada'],
            'tar_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'tar_quantpescadores' => $request['numPescadores'],
            'tar_data' => $request['data'],
            'tar_tempogasto' => $request['tempoGasto'],
            'tar_roda' => $roda,
            'tar_altura' => $altura,
            'tar_malha' => $malha,
            'tar_numlances' => $numLances,
            'tar_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'tar_obs' => $request['observacao'],
            'dp_id' => $request['destinoPescado'],
            'mnt_id' => $request['id_monitoramento']
        );

        $insertArrasto = $this->dbTableTarrafa->insert($dadosTarrafa);
        return $insertArrasto;
    }

    public function update(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();

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
        $roda = $request['roda'];
        $altura = $request['altura'];
        $numLances = $request['numLances'];
        $malha = $request['malha'];

        if(empty($roda)){
            $roda = NULL;
        }
        if(empty($altura)){
            $altura = NULL;
        }

        if(empty($numLances)){
            $numLances = NULL;
        }

        if(empty($malha)){
            $malha = NULL;
        }


        $dadosTarrafa = array(
            'mnt_id' => $request['id_monitoramento'],
            'tar_embarcado' => $request['embarcada'],
            'tar_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'tar_quantpescadores' => $request['numPescadores'],
            'tar_data' => $request['data'],
            'tar_tempogasto' => $request['tempoGasto'],
            'tar_roda' => $roda,
            'tar_altura' => $altura,
            'tar_malha' => $malha,
            'tar_numlances' => $numLances,
            'tar_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'dp_id' => $request['destinoPescado'],
            'tar_obs' => $request['observacao'],
        );


        $whereTarrafa= $this->dbTableTarrafa->getAdapter()
                ->quoteInto('"tar_id" = ?', $request['id_entrevista']);


        $this->dbTableTarrafa->update($dadosTarrafa, $whereTarrafa);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Tarrafa();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idTarrafa)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();

        $whereTarrafa= $this->dbTableTarrafa->getAdapter()
                ->quoteInto('"tar_id" = ?', $idTarrafa);

        $this->dbTableTarrafa->delete($whereTarrafa);
    }
    public function selectId(){
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();

        $select = $this->dbTableTarrafa->select()
                ->from($this->dbTableTarrafa, 'tar_id')->order('tar_id DESC')->limit('1');

        return $this->dbTableTarrafa->fetchAll($select)->toArray();
    }
    public function selectTarrafaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_VTarrafaHasPesqueiro();
        $select = $this->dbTableTarrafa->select()
                ->from($this->dbTableTarrafa)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafa->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro)
    {
        $this->dbTableTTarrafa = new Application_Model_DbTable_TarrafaHasPesqueiro();


        $dadosPesqueiro = array(
            'tar_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
        );

        $this->dbTableTTarrafa->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTTarrafa = new Application_Model_DbTable_TarrafaHasPesqueiro();

        $whereTarrafaHasPesqueiro = $this->dbTableTTarrafa->getAdapter()
                ->quoteInto('"tar_paf_id" = ?', $idPesqueiro);

        $this->dbTableTTarrafa->delete($whereTarrafaHasPesqueiro);
    }
    public function selectTarrafaHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableTarrafaHasEspCapturada = new Application_Model_DbTable_VTarrafaHasEspecieCapturada();

        $select = $this->dbTableTarrafaHasEspCapturada->select()
                ->from($this->dbTableTarrafaHasEspCapturada)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTTarrafaHasEspCapturada = new Application_Model_DbTable_TarrafaHasEspecieCapturada();

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
            'tar_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );

        $this->dbTableTTarrafaHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTTarrafaHasEspCapturada = new Application_Model_DbTable_TarrafaHasEspecieCapturada();

        $whereTarrafaHasEspCapturada = $this->dbTableTTarrafaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_tar_id" = ?', $idEspecie);

        $this->dbTableTTarrafaHasEspCapturada->delete($whereTarrafaHasEspCapturada);
    }
    public function selectEntrevistaTarrafa($where = null, $order = null, $limit = null)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_VEntrevistaTarrafa();
        $select = $this->dbTableTarrafa->select()
                ->from($this->dbTableTarrafa)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafa->fetchAll($select)->toArray();
    }
    public function selectTarrafaHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableTarrafaAvistamento = new Application_Model_DbTable_VTarrafaHasAvistamento();
        $selectAvist = $this->dbTableTarrafaAvistamento->select()
                ->from($this->dbTableTarrafaAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableTarrafaAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTTarrafaHasAvistamento = new Application_Model_DbTable_TarrafaHasAvistamento();


        $dadosAvistamento = array(
            'tar_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );

        $this->dbTableTTarrafaHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTTarrafaHasAvistamento = new Application_Model_DbTable_TarrafaHasAvistamento();

        $dadosTarrafaHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'tar_id= ?' => $idEntrevista
        );

        $this->dbTableTTarrafaHasAvistamento->delete($dadosTarrafaHasAvistamento);
    }
    
        ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableTarrafaHasBioCamarao = new Application_Model_DbTable_TarrafaHasBioCamarao();


        $dadosPesqueiro = array(
            'ttar_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableTarrafaHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableTarrafaHasBioCamarao = new Application_Model_DbTable_VTarrafaHasBioCamarao();
        $select = $this->dbTableTarrafaHasBioCamarao->select()
                ->from($this->dbTableTarrafaHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafaHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTTarrafaHasBioCamarao = new Application_Model_DbTable_TarrafaHasBioCamarao();

        $whereTarrafaHasBiometria = $this->dbTableTTarrafaHasBioCamarao->getAdapter()
                ->quoteInto('ttarbc_id = ?', $idBiometria);

        $this->dbTableTTarrafaHasBioCamarao->delete($whereTarrafaHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableTarrafaHasBioPeixe = new Application_Model_DbTable_TarrafaHasBioPeixe();


        $dadosPesqueiro = array(
            'ttar_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableTarrafaHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableTarrafaHasBioPeixe = new Application_Model_DbTable_VTarrafaHasBioPeixe();
        $select = $this->dbTableTarrafaHasBioPeixe->select()
                ->from($this->dbTableTarrafaHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafaHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTTarrafaHasBioPeixe = new Application_Model_DbTable_TarrafaHasBioPeixe();

        $whereTarrafaHasBiometria = $this->dbTableTTarrafaHasBioPeixe->getAdapter()
                ->quoteInto('ttarbp_id = ?', $idBiometria);

        $this->dbTableTTarrafaHasBioPeixe->delete($whereTarrafaHasBiometria);
        
    }

}
