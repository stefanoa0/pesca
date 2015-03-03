<?php
/** 
 * Model Arte de Pesca - Grosseira
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Grosseira
{
private $dbTableGrosseira;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableGrosseira = new Application_Model_DbTable_Grosseira();
        $select = $this->dbTableGrosseira->select()
                ->from($this->dbTableGrosseira)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableGrosseira->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableGrosseira = new Application_Model_DbTable_Grosseira();
        $arr = $this->dbTableGrosseira->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableGrosseira = new Application_Model_DbTable_Grosseira();
        
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
            $alimento= NULL;
        }
        if(empty($gelo)){
            $gelo = NULL;
        }
        
        
        $dadosGrosseira = array(
            'grs_embarcada' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'grs_motor'=> $request['motor'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'grs_numpescadores' => $request['numPescadores'],
            'grs_dhsaida' => $timestampSaida,
            'grs_dhvolta' => $timestampVolta,
            'grs_diesel' => $diesel, 
            'grs_oleo' => $oleo,
            'grs_alimento' => $alimento,
            'grs_gelo' => $gelo,
            'grs_numlinhas' => $numLinhas,
            'grs_numanzoisplinha' => $numAnzois,
            'grs_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'grs_obs' => $request['observacao'],
            'mnt_id' => $request['id_monitoramento'],
            'dp_id' => $request['destinoPescado'],
            'isc_id' => $request['isca']
            
        );
        
        $insertArrasto = $this->dbTableGrosseira->insert($dadosGrosseira);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableGrosseira = new Application_Model_DbTable_Grosseira();
        
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
            $alimento= NULL;
        }
        if(empty($gelo)){
            $gelo = NULL;
        }
        
        $dadosGrosseira = array(
            'mnt_id' => $request['id_monitoramento'],
            'grs_embarcada' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'grs_motor'=> $request['motor'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'grs_numpescadores' => $request['numPescadores'],
            'grs_dhsaida' => $timestampSaida,
            'grs_dhvolta' => $timestampVolta,
            'grs_diesel' => $diesel, 
            'grs_oleo' => $oleo,
            'grs_alimento' => $alimento,
            'grs_gelo' => $gelo,
            'grs_numlinhas' => $numLinhas,
            'grs_numanzoisplinha' => $numAnzois,
            'grs_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'grs_obs' => $request['observacao'],
            'dp_id' => $request['destinoPescado'],
            'isc_id' => $request['isca']
            
        );
 
        
        $whereGrosseira= $this->dbTableGrosseira->getAdapter()
                ->quoteInto('"grs_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableGrosseira->update($dadosGrosseira, $whereGrosseira);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Grosseira();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idGrosseira)
    {
        $this->dbTableGrosseira = new Application_Model_DbTable_Grosseira();       
                
        $whereGrosseira= $this->dbTableGrosseira->getAdapter()
                ->quoteInto('"grs_id" = ?', $idGrosseira);
        
        $this->dbTableGrosseira->delete($whereGrosseira);
    }
    public function selectId(){
        $this->dbTableGrosseira = new Application_Model_DbTable_Grosseira();
        
        $select = $this->dbTableGrosseira->select()
                ->from($this->dbTableGrosseira, 'grs_id')->order('grs_id DESC')->limit('1');
        
        return $this->dbTableGrosseira->fetchAll($select)->toArray();
    }
    
    public function selectGrosseiraHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableGrosseiraHasPesqueiro = new Application_Model_DbTable_VGrosseiraHasPesqueiro();
        $select = $this->dbTableGrosseiraHasPesqueiro->select()
                ->from($this->dbTableGrosseiraHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableGrosseiraHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro)
    {
        $this->dbTableTGrosseiraHasPesqueiro = new Application_Model_DbTable_GrosseiraHasPesqueiro();
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro=Null;
        }
        
        $dadosPesqueiro = array(
            'grs_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro
        );
        
        $this->dbTableTGrosseiraHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTGrosseiraHasPesqueiro = new Application_Model_DbTable_GrosseiraHasPesqueiro();       
                
        $whereGrosseiraHasPesqueiro = $this->dbTableTGrosseiraHasPesqueiro->getAdapter()
                ->quoteInto('"grs_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTGrosseiraHasPesqueiro->delete($whereGrosseiraHasPesqueiro);
        
    }
    public function selectGrosseiraHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableGrosseiraHasEspCapturada = new Application_Model_DbTable_VGrosseiraHasEspecieCapturada();
        
        $select = $this->dbTableGrosseiraHasEspCapturada->select()
                ->from($this->dbTableGrosseiraHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableGrosseiraHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTGrosseiraHasEspCapturada = new Application_Model_DbTable_GrosseiraHasEspecieCapturada();
        
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
            'grs_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );
        
        $this->dbTableTGrosseiraHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTGrosseiraHasEspCapturada = new Application_Model_DbTable_GrosseiraHasEspecieCapturada();       
                
        $whereGrosseiraHasEspCapturada = $this->dbTableTGrosseiraHasEspCapturada->getAdapter()
                ->quoteInto('"spc_grs_id" = ?', $idEspecie);
        
        $this->dbTableTGrosseiraHasEspCapturada->delete($whereGrosseiraHasEspCapturada);
    }
    public function selectEntrevistaGrosseira($where = null, $order = null, $limit = null)
    {
        $this->dbTableGrosseira = new Application_Model_DbTable_VEntrevistaGrosseira();
        $select = $this->dbTableGrosseira->select()
                ->from($this->dbTableGrosseira)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableGrosseira->fetchAll($select)->toArray();
    }
    public function selectGrosseiraHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableGrosseiraAvistamento = new Application_Model_DbTable_VGrosseiraHasAvistamento();
        $selectAvist = $this->dbTableGrosseiraAvistamento->select()
                ->from($this->dbTableGrosseiraAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableGrosseiraAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTGrosseiraHasAvistamento = new Application_Model_DbTable_GrosseiraHasAvistamento();
        
        
        $dadosAvistamento = array(
            'grs_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTGrosseiraHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTGrosseiraHasAvistamento = new Application_Model_DbTable_GrosseiraHasAvistamento();       
                
        $dadosGrosseiraHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'grs_id= ?' => $idEntrevista
        );
        
        $this->dbTableTGrosseiraHasAvistamento->delete($dadosGrosseiraHasAvistamento);
    }
    
////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableGrosseiraHasBioCamarao = new Application_Model_DbTable_GrosseiraHasBioCamarao();


        $dadosPesqueiro = array(
            'tgrs_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableGrosseiraHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableGrosseiraHasBioCamarao = new Application_Model_DbTable_VGrosseiraHasBioCamarao();
        $select = $this->dbTableGrosseiraHasBioCamarao->select()
                ->from($this->dbTableGrosseiraHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableGrosseiraHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTGrosseiraHasBioCamarao = new Application_Model_DbTable_GrosseiraHasBioCamarao();

        $whereGrosseiraHasBiometria = $this->dbTableTGrosseiraHasBioCamarao->getAdapter()
                ->quoteInto('tgrsbc_id = ?', $idBiometria);

        $this->dbTableTGrosseiraHasBioCamarao->delete($whereGrosseiraHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableGrosseiraHasBioPeixe = new Application_Model_DbTable_GrosseiraHasBioPeixe();


        $dadosPesqueiro = array(
            'tgrs_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableGrosseiraHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableGrosseiraHasBioPeixe = new Application_Model_DbTable_VGrosseiraHasBioPeixe();
        $select = $this->dbTableGrosseiraHasBioPeixe->select()
                ->from($this->dbTableGrosseiraHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableGrosseiraHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTGrosseiraHasBioPeixe = new Application_Model_DbTable_GrosseiraHasBioPeixe();

        $whereGrosseiraHasBiometria = $this->dbTableTGrosseiraHasBioPeixe->getAdapter()
                ->quoteInto('tgrsbp_id = ?', $idBiometria);

        $this->dbTableTGrosseiraHasBioPeixe->delete($whereGrosseiraHasBiometria);
        
    }
}

