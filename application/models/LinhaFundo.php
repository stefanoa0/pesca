<?php
/** 
 * Model Arte de Pesca - Linha de Fundo
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_LinhaFundo
{    private $dbTableLinhaFundo;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        $select = $this->dbTableLinhaFundo->select()
                ->from($this->dbTableLinhaFundo)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundo->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        $arr = $this->dbTableLinhaFundo->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        
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
        
        
        $dadosLinhaFundo = array(
            'lf_embarcada' => $request['embarcada'],
            'lf_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'lf_quantpescadores' => $request['numPescadores'],
            'lf_dhvolta' => $timestampVolta,
            'lf_dhsaida' => $timestampSaida, 
            'lf_tempogasto' => $request['tempoGasto'],
            'lf_diesel' => $diesel,
            'lf_oleo' => $oleo,
            'lf_alimento' => $alimento,
            'lf_gelo' => $gelo,
            'lf_subamostra' => $request['subamostra'],
            'lf_obs' => $request['observacao'],
            'sa_id' => $idSubamostra,
            'lf_numanzoisplinha' => $numAnzois,
            'lf_numlinhas' => $numLinhas,
            'isc_id' => $request['isca'],
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'lf_mreviva' => $request['mareviva']
        );
        
        $insertArrasto = $this->dbTableLinhaFundo->insert($dadosLinhaFundo);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        
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
        
        
        $dadosLinhaFundo = array(
            'mnt_id' => $request['id_monitoramento'],
            'lf_embarcada' => $request['embarcada'],
            'lf_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'lf_quantpescadores' => $request['numPescadores'],
            'lf_dhvolta' => $timestampVolta,
            'lf_dhsaida' => $timestampSaida, 
            'lf_tempogasto' => $request['tempoGasto'],
            'lf_diesel' => $diesel,
            'lf_oleo' => $oleo,
            'lf_alimento' => $alimento,
            'lf_gelo' => $gelo,
            'lf_subamostra' => $request['subamostra'],
            'lf_obs' => $request['observacao'],
            'sa_id' => $idSubamostra,
            'lf_numanzoisplinha' => $numAnzois,
            'lf_numlinhas' => $numLinhas,
            'isc_id' => $request['isca'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'lf_mreviva' => $request['mareviva']
        );
        $whereLinhaFundo= $this->dbTableLinhaFundo->getAdapter()
                ->quoteInto('"lf_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableLinhaFundo->update($dadosLinhaFundo, $whereLinhaFundo);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_ArrastoFundo();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idLinhaFundo)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();       
                
        $whereLinhaFundo= $this->dbTableLinhaFundo->getAdapter()
                ->quoteInto('"lf_id" = ?', $idLinhaFundo);
        
        $this->dbTableLinhaFundo->delete($whereLinhaFundo);
    }
    public function selectId(){
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        
        $select = $this->dbTableLinhaFundo->select()
                ->from($this->dbTableLinhaFundo, 'lf_id')->order('lf_id DESC')->limit('1');
        
        return $this->dbTableLinhaFundo->fetchAll($select)->toArray();
    }
    public function selectLinhaFundoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaFundoHasPesqueiro = new Application_Model_DbTable_VLinhaFundoHasPesqueiro();
        $select = $this->dbTableLinhaFundoHasPesqueiro->select()
                ->from($this->dbTableLinhaFundoHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundoHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTLinhaFundoHasPesqueiro = new Application_Model_DbTable_LinhaFundoHasPesqueiro();
        
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        $dadosPesqueiro = array(
            'lf_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTLinhaFundoHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTLinhaFundoHasPesqueiro = new Application_Model_DbTable_LinhaFundoHasPesqueiro();       
                
        $whereLinhaFundoHasPesqueiro = $this->dbTableTLinhaFundoHasPesqueiro->getAdapter()
                ->quoteInto('"lf_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTLinhaFundoHasPesqueiro->delete($whereLinhaFundoHasPesqueiro);
        
    }
    public function selectLinhaFundoHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableLinhaFundoHasEspCapturada = new Application_Model_DbTable_VLinhaFundoHasEspecieCapturada();
        
        $select = $this->dbTableLinhaFundoHasEspCapturada->select()
                ->from($this->dbTableLinhaFundoHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableLinhaFundoHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTLinhaFundoHasEspCapturada = new Application_Model_DbTable_LinhaFundoHasEspecieCapturada();
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
            'lf_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' =>$idTipoVenda
        );
        
        $this->dbTableTLinhaFundoHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTLinhaFundoHasEspCapturada = new Application_Model_DbTable_LinhaFundoHasEspecieCapturada();       
                
        $whereLinhaFundoHasEspCapturada = $this->dbTableTLinhaFundoHasEspCapturada->getAdapter()
                ->quoteInto('"spc_lf_id" = ?', $idEspecie);
        
        $this->dbTableTLinhaFundoHasEspCapturada->delete($whereLinhaFundoHasEspCapturada);
    }
    public function selectEntrevistaLinhaFundo($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        $select = $this->dbTableLinhaFundo->select()
                ->from($this->dbTableLinhaFundo)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundo->fetchAll($select)->toArray();
    }
    public function selectLinhaFundoHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaFundoAvistamento = new Application_Model_DbTable_VLinhaFundoHasAvistamento();
        $selectAvist = $this->dbTableLinhaFundoAvistamento->select()
                ->from($this->dbTableLinhaFundoAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableLinhaFundoAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTLinhaFundoHasAvistamento = new Application_Model_DbTable_LinhaFundoHasAvistamento();
        
        
        $dadosAvistamento = array(
            'lf_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTLinhaFundoHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTLinhaFundoHasAvistamento = new Application_Model_DbTable_LinhaFundoHasAvistamento();       
                
        $dadosLinhaFundoHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'lf_id= ?' => $idEntrevista
        );
        
        $this->dbTableTLinhaFundoHasAvistamento->delete($dadosLinhaFundoHasAvistamento);
    }
    
        ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableLinhaFundoHasBioCamarao = new Application_Model_DbTable_LinhaFundoHasBioCamarao();


        $dadosPesqueiro = array(
            'tlf_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableLinhaFundoHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableLinhaFundoHasBioCamarao = new Application_Model_DbTable_VLinhaFundoHasBioCamarao();
        $select = $this->dbTableLinhaFundoHasBioCamarao->select()
                ->from($this->dbTableLinhaFundoHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundoHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTLinhaFundoHasBioCamarao = new Application_Model_DbTable_LinhaFundoHasBioCamarao();

        $whereLinhaFundoHasBiometria = $this->dbTableTLinhaFundoHasBioCamarao->getAdapter()
                ->quoteInto('tlfbc_id = ?', $idBiometria);

        $this->dbTableTLinhaFundoHasBioCamarao->delete($whereLinhaFundoHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableLinhaFundoHasBioPeixe = new Application_Model_DbTable_LinhaFundoHasBioPeixe();


        $dadosPesqueiro = array(
            'tlf_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableLinhaFundoHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableLinhaFundoHasBioPeixe = new Application_Model_DbTable_VLinhaFundoHasBioPeixe();
        $select = $this->dbTableLinhaFundoHasBioPeixe->select()
                ->from($this->dbTableLinhaFundoHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundoHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTLinhaFundoHasBioPeixe = new Application_Model_DbTable_LinhaFundoHasBioPeixe();

        $whereLinhaFundoHasBiometria = $this->dbTableTLinhaFundoHasBioPeixe->getAdapter()
                ->quoteInto('tlfbp_id = ?', $idBiometria);

        $this->dbTableTLinhaFundoHasBioPeixe->delete($whereLinhaFundoHasBiometria);
        
    }
}

