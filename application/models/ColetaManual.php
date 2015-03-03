<?php
/** 
 * Model Arte de Pesca - Coleta Manual
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_ColetaManual
{
private $dbTableColetaManual;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableColetaManual = new Application_Model_DbTable_ColetaManual();
        $select = $this->dbTableColetaManual->select()
                ->from($this->dbTableColetaManual)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableColetaManual->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableColetaManual = new Application_Model_DbTable_ColetaManual();
        $arr = $this->dbTableColetaManual->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableColetaManual = new Application_Model_DbTable_ColetaManual();
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
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
        }
        $dadosColetaManual = array(
            'cml_embarcada' => $request['embarcada'],
            'cml_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'cml_quantpescadores' => $request['numPescadores'],
            'cml_dhsaida' => $timestampSaida,
            'cml_dhvolta' => $timestampVolta,
            'cml_tempogasto' => $request['tempoGasto'],
            'cml_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'cml_obs' => $request['observacao'],
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'cml_mreviva' => $request['mareviva'],
            'cml_combustivel' => $combustivel
        );
        
        $insertColetaManual =$this->dbTableColetaManual->insert($dadosColetaManual);
        return $insertColetaManual;
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_ColetaManual();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function update(array $request)
    {
        $this->dbTableColetaManual = new Application_Model_DbTable_ColetaManual();
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
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
        $dadosColetaManual = array(
            'mnt_id' => $request['id_monitoramento'],
            'cml_embarcada' => $request['embarcada'],
            'cml_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'cml_quantpescadores' => $request['numPescadores'],
            'cml_dhsaida' => $timestampSaida,
            'cml_dhvolta' => $timestampVolta,
            'cml_subamostra' => $request['subamostra'],
            'cml_tempogasto' => $request['tempoGasto'],
            'cml_subamostra' => $request['subamostra'],
            'cml_obs' => $request['observacao'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'cml_mreviva' => $request['mareviva'],
            'cml_combustivel' => $combustivel
        );
 
        
        $whereColetaManual= $this->dbTableColetaManual->getAdapter()
                ->quoteInto('"cml_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableColetaManual->update($dadosColetaManual, $whereColetaManual);
    }
    
    public function delete($idColetaManual)
    {
        $this->dbTableColetaManual = new Application_Model_DbTable_ColetaManual();       
                
        $whereColetaManual= $this->dbTableColetaManual->getAdapter()
                ->quoteInto('"cml_id" = ?', $idColetaManual);
        
        $this->dbTableColetaManual->delete($whereColetaManual);
    }
    public function selectId(){
        $this->dbTableColetaManual = new Application_Model_DbTable_ColetaManual();
        
        $select = $this->dbTableColetaManual->select()
                ->from($this->dbTableColetaManual, 'cml_id')->order('cml_id DESC')->limit('1');
        
        return $this->dbTableColetaManual->fetchAll($select)->toArray();
    }
    public function selectColetaManualHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableColetaManualHasPesqueiro = new Application_Model_DbTable_VColetaManualHasPesqueiro();
        $select = $this->dbTableColetaManualHasPesqueiro->select()
                ->from($this->dbTableColetaManualHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableColetaManualHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTColetaManualHasPesqueiro = new Application_Model_DbTable_ColetaManualHasPesqueiro();
         
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if($tempoAPesqueiro == ""){
            $tempoAPesqueiro = NULL;
        }
        $dadosPesqueiro = array(
            'cml_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTColetaManualHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTColetaManualHasPesqueiro = new Application_Model_DbTable_ColetaManualHasPesqueiro();       
                
        $whereColetaManualHasPesqueiro = $this->dbTableTColetaManualHasPesqueiro->getAdapter()
                ->quoteInto('"cml_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTColetaManualHasPesqueiro->delete($whereColetaManualHasPesqueiro);
        
    }
    public function selectColetaManualHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableColetaManualHasEspCapturada = new Application_Model_DbTable_VColetaManualHasEspecieCapturada();
        
        $select = $this->dbTableColetaManualHasEspCapturada->select()
                ->from($this->dbTableColetaManualHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableColetaManualHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTColetaManualHasEspCapturada = new Application_Model_DbTable_ColetaManualHasEspecieCapturada();
        
        if(empty($quantidade) && empty($peso)){
            $quantidade = 'Erro';
        }
        else if(empty($peso)){
            $peso = NULL;
        }
        else if(empty($quantidade)){
            $quantidade = NULL;
        }
        if(empty($precokg)){
            $precokg = NULL;
        }
        
        $dadosEspecie = array(
            'cml_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda,
        );
        
        $this->dbTableTColetaManualHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTColetaManualHasEspCapturada = new Application_Model_DbTable_ColetaManualHasEspecieCapturada();       
                
        $whereColetaManualHasEspCapturada = $this->dbTableTColetaManualHasEspCapturada->getAdapter()
                ->quoteInto('"spc_cml_id" = ?', $idEspecie);
        
        $this->dbTableTColetaManualHasEspCapturada->delete($whereColetaManualHasEspCapturada);
    }
    public function selectEntrevistaColetaManual($where = null, $order = null, $limit = null)
    {
        $this->dbTableColetaManual = new Application_Model_DbTable_VEntrevistaColetaManual();
        $select = $this->dbTableColetaManual->select()
                ->from($this->dbTableColetaManual)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableColetaManual->fetchAll($select)->toArray();
    }
    public function selectColetaManualHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableColetaManualAvistamento = new Application_Model_DbTable_VColetaManualHasAvistamento();
        $selectAvist = $this->dbTableColetaManualAvistamento->select()
                ->from($this->dbTableColetaManualAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableColetaManualAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTColetaManualHasAvistamento = new Application_Model_DbTable_ColetaManualHasAvistamento();
        
        
        $dadosAvistamento = array(
            'cml_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTColetaManualHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTColetaManualHasAvistamento = new Application_Model_DbTable_ColetaManualHasAvistamento();       
                
        $dadosColetaManualHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'cml_id= ?' => $idEntrevista
        );
        
        $this->dbTableTColetaManualHasAvistamento->delete($dadosColetaManualHasAvistamento);
    }
    
////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableColetaManualHasBioCamarao = new Application_Model_DbTable_ColetaManualHasBioCamarao();


        $dadosPesqueiro = array(
            'tcml_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableColetaManualHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableColetaManualHasBioCamarao = new Application_Model_DbTable_VColetaManualHasBioCamarao();
        $select = $this->dbTableColetaManualHasBioCamarao->select()
                ->from($this->dbTableColetaManualHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableColetaManualHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTColetaManualHasBioCamarao = new Application_Model_DbTable_ColetaManualHasBioCamarao();

        $whereColetaManualHasBiometria = $this->dbTableTColetaManualHasBioCamarao->getAdapter()
                ->quoteInto('tcmlbc_id = ?', $idBiometria);

        $this->dbTableTColetaManualHasBioCamarao->delete($whereColetaManualHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableColetaManualHasBioPeixe = new Application_Model_DbTable_ColetaManualHasBioPeixe();


        $dadosPesqueiro = array(
            'tcml_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableColetaManualHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableColetaManualHasBioPeixe = new Application_Model_DbTable_VColetaManualHasBioPeixe();
        $select = $this->dbTableColetaManualHasBioPeixe->select()
                ->from($this->dbTableColetaManualHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableColetaManualHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTColetaManualHasBioPeixe = new Application_Model_DbTable_ColetaManualHasBioPeixe();

        $whereColetaManualHasBiometria = $this->dbTableTColetaManualHasBioPeixe->getAdapter()
                ->quoteInto('tcmlbp_id = ?', $idBiometria);

        $this->dbTableTColetaManualHasBioPeixe->delete($whereColetaManualHasBiometria);
        
    }
}

