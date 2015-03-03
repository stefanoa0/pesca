<?php
/** 
 * Model Arte de Pesca - Linha
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Linha
{
private $dbTableLinha;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        $select = $this->dbTableLinha->select()
                ->from($this->dbTableLinha)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinha->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        $arr = $this->dbTableLinha->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        
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
        
         $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        $diesel = $request['diesel'];
        $oleo = $request['oleo'];
        $alimento = $request['alimento'];
        $gelo = $request['gelo'];
        
        $numLinhas = $request['numLinhas'];
        $numAnzois = $request['numAnzois'];
        
        if(empty($numLinhas)){
            $numLinhas = NULL;
        }
        if(empty($numAnzois)){
            $numAnzois = NULL;
        }
        
        if(empty($diesel)){
            $diesel = NULL;
        }
        if(empty($oleo)){
            $oleo = NULL;
        }
        if(empty($alimento)){
            $alimento = NULL;
        }
        if(empty($gelo)){
            $gelo = NULL;
        }
        
        
        
        $dadosLinha = array(
            'lin_embarcada' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'lin_motor'=> $request['motor'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'lin_numpescadores' => $request['numPescadores'],
            'lin_dhsaida' => $timestampSaida,
            'lin_dhvolta' => $timestampVolta,
            'lin_diesel' => $diesel, 
            'lin_oleo' => $oleo,
            'lin_alimento' => $alimento,
            'lin_gelo' => $gelo,
            'lin_numlinhas' => $numLinhas,
            'lin_numanzoisplinha' => $numAnzois,
            'lin_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'lin_obs' => $request['observacao'],
            'mnt_id' => $request['id_monitoramento'],
            'dp_id' => $request['destinoPescado'],
            'isc_id' => $request['isca']
            
        );
        
        $insertArrasto = $this->dbTableLinha->insert($dadosLinha);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        
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
        
         $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        $diesel = $request['diesel'];
        $oleo = $request['oleo'];
        $alimento = $request['alimento'];
        $gelo = $request['gelo'];
        
        $numLinhas = $request['numLinhas'];
        $numAnzois = $request['numAnzois'];
        
        if(empty($numLinhas)){
            $numLinhas = NULL;
        }
        if(empty($numAnzois)){
            $numAnzois = NULL;
        }
        
        if(empty($diesel)){
            $diesel = NULL;
        }
        if(empty($oleo)){
            $oleo = NULL;
        }
        if(empty($alimento)){
            $alimento = NULL;
        }
        if(empty($gelo)){
            $gelo = NULL;
        }
        
        $dadosLinha = array(
            'mnt_id' => $request['id_monitoramento'],
            'lin_embarcada' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'lin_motor'=> $request['motor'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'lin_numpescadores' => $request['numPescadores'],
            'lin_dhsaida' => $timestampSaida,
            'lin_dhvolta' => $timestampVolta,
            'lin_diesel' => $diesel, 
            'lin_oleo' => $oleo,
            'lin_alimento' => $alimento,
            'lin_gelo' => $gelo,
            'lin_numlinhas' => $numLinhas,
            'lin_numanzoisplinha' => $numAnzois,
            'lin_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'lin_obs' => $request['observacao'],
            'dp_id' => $request['destinoPescado'],
            'isc_id' => $request['isca']
            
        );
 
        
        $whereLinha= $this->dbTableLinha->getAdapter()
                ->quoteInto('"lin_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableLinha->update($dadosLinha, $whereLinha);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Linha();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idLinha)
    {
        $this->dbTableLinha = new Application_Model_DbTable_Linha();       
                
        $whereLinha= $this->dbTableLinha->getAdapter()
                ->quoteInto('"lin_id" = ?', $idLinha);
        
        $this->dbTableLinha->delete($whereLinha);
    }
    public function selectId(){
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        
        $select = $this->dbTableLinha->select()
                ->from($this->dbTableLinha, 'lin_id')->order('lin_id DESC')->limit('1');
        
        return $this->dbTableLinha->fetchAll($select)->toArray();
    }
    
    public function selectLinhaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaHasPesqueiro = new Application_Model_DbTable_VLinhaHasPesqueiro();
        $select = $this->dbTableLinhaHasPesqueiro->select()
                ->from($this->dbTableLinhaHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro)
    {
        $this->dbTableTLinhaHasPesqueiro = new Application_Model_DbTable_LinhaHasPesqueiro();
        
       
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        
        $dadosPesqueiro = array(
            'lin_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro
        );
        
        $this->dbTableTLinhaHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTLinhaHasPesqueiro = new Application_Model_DbTable_LinhaHasPesqueiro();       
                
        $whereLinhaHasPesqueiro = $this->dbTableTLinhaHasPesqueiro->getAdapter()
                ->quoteInto('"lin_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTLinhaHasPesqueiro->delete($whereLinhaHasPesqueiro);
        
    }
    public function selectLinhaHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableLinhaHasEspCapturada = new Application_Model_DbTable_VLinhaHasEspecieCapturada();
        
        $select = $this->dbTableLinhaHasEspCapturada->select()
                ->from($this->dbTableLinhaHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableLinhaHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTLinhaHasEspCapturada = new Application_Model_DbTable_LinhaHasEspecieCapturada();
        
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
            'lin_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );
        
        $this->dbTableTLinhaHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTLinhaHasEspCapturada = new Application_Model_DbTable_LinhaHasEspecieCapturada();       
                
        $whereLinhaHasEspCapturada = $this->dbTableTLinhaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_lin_id" = ?', $idEspecie);
        
        $this->dbTableTLinhaHasEspCapturada->delete($whereLinhaHasEspCapturada);
    }
    public function selectEntrevistaLinha($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinha = new Application_Model_DbTable_VEntrevistaLinha();
        $select = $this->dbTableLinha->select()
                ->from($this->dbTableLinha)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinha->fetchAll($select)->toArray();
    }
    public function selectLinhaHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaAvistamento = new Application_Model_DbTable_VLinhaHasAvistamento();
        $selectAvist = $this->dbTableLinhaAvistamento->select()
                ->from($this->dbTableLinhaAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableLinhaAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTLinhaHasAvistamento = new Application_Model_DbTable_LinhaHasAvistamento();
        
        
        $dadosAvistamento = array(
            'lin_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTLinhaHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTLinhaHasAvistamento = new Application_Model_DbTable_LinhaHasAvistamento();       
                
        $dadosLinhaHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'lin_id= ?' => $idEntrevista
        );
        
        $this->dbTableTLinhaHasAvistamento->delete($dadosLinhaHasAvistamento);
    }
    
////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableLinhaHasBioCamarao = new Application_Model_DbTable_LinhaHasBioCamarao();


        $dadosPesqueiro = array(
            'tlin_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableLinhaHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableLinhaHasBioCamarao = new Application_Model_DbTable_VLinhaHasBioCamarao();
        $select = $this->dbTableLinhaHasBioCamarao->select()
                ->from($this->dbTableLinhaHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTLinhaHasBioCamarao = new Application_Model_DbTable_LinhaHasBioCamarao();

        $whereLinhaHasBiometria = $this->dbTableTLinhaHasBioCamarao->getAdapter()
                ->quoteInto('tlinbc_id = ?', $idBiometria);

        $this->dbTableTLinhaHasBioCamarao->delete($whereLinhaHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableLinhaHasBioPeixe = new Application_Model_DbTable_LinhaHasBioPeixe();


        $dadosPesqueiro = array(
            'tlin_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableLinhaHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableLinhaHasBioPeixe = new Application_Model_DbTable_VLinhaHasBioPeixe();
        $select = $this->dbTableLinhaHasBioPeixe->select()
                ->from($this->dbTableLinhaHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTLinhaHasBioPeixe = new Application_Model_DbTable_LinhaHasBioPeixe();

        $whereLinhaHasBiometria = $this->dbTableTLinhaHasBioPeixe->getAdapter()
                ->quoteInto('tlinbp_id = ?', $idBiometria);

        $this->dbTableTLinhaHasBioPeixe->delete($whereLinhaHasBiometria);
        
    }
}

