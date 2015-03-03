<?php
/** 
 * Model Arte de Pesca - Jerere
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Jerere
{    private $dbTableJerere;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableJerere = new Application_Model_DbTable_Jerere();
        $select = $this->dbTableJerere->select()
                ->from($this->dbTableJerere)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableJerere->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableJerere = new Application_Model_DbTable_Jerere();
        $arr = $this->dbTableJerere->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableJerere = new Application_Model_DbTable_Jerere();
        
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
        
        $dadosJerere = array(
            'jre_embarcada' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'jre_quantpescadores' => $request['numPescadores'],
            'jre_dhvolta' => $timestampVolta,
            'jre_dhsaida' => $timestampSaida,
            'jre_subamostra' => $request['subamostra'],
            'jre_obs' => $request['observacao'],
            'jre_motor' => $request['motor'],
            'sa_id' => $idSubamostra,
            'jre_tempogasto' => $request['tempoGasto'],
            'jre_numarmadilhas' => $numArmadilhas,
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'jre_mreviva' => $request['mareviva'],
            'jre_combustivel' => $combustivel
        );
        
        $insertArrasto = $this->dbTableJerere->insert($dadosJerere);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableJerere = new Application_Model_DbTable_Jerere();
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        
        
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
        
        
        $dadosJerere = array(
            'mnt_id' => $request['id_monitoramento'],
            'jre_embarcada' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'jre_quantpescadores' => $request['numPescadores'],
            'jre_dhvolta' => $timestampVolta,
            'jre_dhsaida' => $timestampSaida,
            'jre_subamostra' => $request['subamostra'],
            'jre_obs' => $request['observacao'],
            'jre_motor' => $request['motor'],
            'sa_id' => $idSubamostra,
            'jre_tempogasto' => $request['tempoGasto'],
            'jre_numarmadilhas' => $numArmadilhas,
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'jre_mreviva' => $request['mareviva'],
            'jre_combustivel' => $combustivel
        );
 
        
        $whereJerere= $this->dbTableJerere->getAdapter()
                ->quoteInto('"jre_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableJerere->update($dadosJerere, $whereJerere);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Jerere();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idJerere)
    {
        $this->dbTableJerere = new Application_Model_DbTable_Jerere();       
                
        $whereJerere= $this->dbTableJerere->getAdapter()
                ->quoteInto('"jre_id" = ?', $idJerere);
        
        $this->dbTableJerere->delete($whereJerere);
    }
    public function selectId(){
        $this->dbTableJerere = new Application_Model_DbTable_Jerere();
        
        $select = $this->dbTableJerere->select()
                ->from($this->dbTableJerere, 'jre_id')->order('jre_id DESC')->limit('1');
        
        return $this->dbTableJerere->fetchAll($select)->toArray();
    }
    public function selectJerereHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableJerereHasPesqueiro = new Application_Model_DbTable_VJerereHasPesqueiro();
        $select = $this->dbTableJerereHasPesqueiro->select()
                ->from($this->dbTableJerereHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableJerereHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTJerereHasPesqueiro = new Application_Model_DbTable_JerereHasPesqueiro();
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        
        $dadosPesqueiro = array(
            'jre_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTJerereHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTJerereHasPesqueiro = new Application_Model_DbTable_JerereHasPesqueiro();       
                
        $whereJerereHasPesqueiro = $this->dbTableTJerereHasPesqueiro->getAdapter()
                ->quoteInto('"jre_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTJerereHasPesqueiro->delete($whereJerereHasPesqueiro);
        
    }
    public function selectJerereHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableJerereHasEspCapturada = new Application_Model_DbTable_VJerereHasEspecieCapturada();
        
        $select = $this->dbTableJerereHasEspCapturada->select()
                ->from($this->dbTableJerereHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableJerereHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTJerereHasEspCapturada = new Application_Model_DbTable_JerereHasEspecieCapturada();
        
        if(empty($quantidade) && empty($peso)){
            $quantidade = 'Erro';
        }
        else if(empty($quantidade)){
            $quantidade = NULL;
        }
        else if(empty($peso)){
            $peso = NULL;
        }
        if(empty($precokg)){
            $precokg = NULL;
        }
        $dadosEspecie = array(
            'jre_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda
        );
        
        $this->dbTableTJerereHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTJerereHasEspCapturada = new Application_Model_DbTable_JerereHasEspecieCapturada();       
                
        $whereJerereHasEspCapturada = $this->dbTableTJerereHasEspCapturada->getAdapter()
                ->quoteInto('"spc_jre_id" = ?', $idEspecie);
        
        $this->dbTableTJerereHasEspCapturada->delete($whereJerereHasEspCapturada);
    }
    public function selectEntrevistaJerere($where = null, $order = null, $limit = null)
    {
        $this->dbTableJerere = new Application_Model_DbTable_VEntrevistaJerere();
        $select = $this->dbTableJerere->select()
                ->from($this->dbTableJerere)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableJerere->fetchAll($select)->toArray();
    }
    public function selectJerereHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableJerereAvistamento = new Application_Model_DbTable_VJerereHasAvistamento();
        $selectAvist = $this->dbTableJerereAvistamento->select()
                ->from($this->dbTableJerereAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableJerereAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTJerereHasAvistamento = new Application_Model_DbTable_JerereHasAvistamento();
        
        
        $dadosAvistamento = array(
            'jre_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTJerereHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTJerereHasAvistamento = new Application_Model_DbTable_JerereHasAvistamento();       
                
        $dadosJerereHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'jre_id= ?' => $idEntrevista
        );
        
        $this->dbTableTJerereHasAvistamento->delete($dadosJerereHasAvistamento);
    }
    
    
////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableJerereHasBioCamarao = new Application_Model_DbTable_JerereHasBioCamarao();


        $dadosPesqueiro = array(
            'tjre_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableJerereHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableJerereHasBioCamarao = new Application_Model_DbTable_VJerereHasBioCamarao();
        $select = $this->dbTableJerereHasBioCamarao->select()
                ->from($this->dbTableJerereHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableJerereHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTJerereHasBioCamarao = new Application_Model_DbTable_JerereHasBioCamarao();

        $whereJerereHasBiometria = $this->dbTableTJerereHasBioCamarao->getAdapter()
                ->quoteInto('tjrebc_id = ?', $idBiometria);

        $this->dbTableTJerereHasBioCamarao->delete($whereJerereHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableJerereHasBioPeixe = new Application_Model_DbTable_JerereHasBioPeixe();


        $dadosPesqueiro = array(
            'tjre_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableJerereHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableJerereHasBioPeixe = new Application_Model_DbTable_VJerereHasBioPeixe();
        $select = $this->dbTableJerereHasBioPeixe->select()
                ->from($this->dbTableJerereHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableJerereHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTJerereHasBioPeixe = new Application_Model_DbTable_JerereHasBioPeixe();

        $whereJerereHasBiometria = $this->dbTableTJerereHasBioPeixe->getAdapter()
                ->quoteInto('tjrebp_id = ?', $idBiometria);

        $this->dbTableTJerereHasBioPeixe->delete($whereJerereHasBiometria);
        
    }
}

