<?php
/** 
 * Model Arte de Pesca  - Emalhe
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Emalhe
{
    private $dbTableEmalhe;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableEmalhe = new Application_Model_DbTable_Emalhe();
        $select = $this->dbTableEmalhe->select()
                ->from($this->dbTableEmalhe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableEmalhe->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableEmalhe = new Application_Model_DbTable_Emalhe();
        $arr = $this->dbTableEmalhe->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        $this->dbTableEmalhe = new Application_Model_DbTable_Emalhe();

        
        if($request['subamostra']==true){
        $dadosSubamostra = array(
            'sa_pescador' => $request['pescadorEntrevistado'],
            'sa_datachegada' => $request['dataRecolhimento']
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
        
        
        $tamanho = $request['tamanho'];
        $altura = $request['altura'];
        $numPanos =$request['numPanos'];
        $malha = $request['malha'];
        
        if(empty($tamanho)){
            $tamanho = NULL;
        }
        if(empty($altura)){
            $altura = NULL;
        }
        if(empty($numPanos)){
            $numPanos = NULL;
        }
        if(empty($malha)){
            $malha = NULL;
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
        
        $timestampLancamento = $request['dataLancamento']." ".$request['horaLancamento'];
        $timestampRecolhimento = $request['dataRecolhimento']." ".$request['horaRecolhimento'];
        
        if($timestampLancamento > $timestampRecolhimento){
            $timestampRecolhimento = 'Erro';
        }
        $dadosEmalhe = array(
            'em_embarcado' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'em_motor'=> $request['motor'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'em_quantpescadores' => $request['numPescadores'],
            'em_dhlancamento' => $timestampLancamento, 
            'em_dhrecolhimento' => $timestampRecolhimento,
            'em_diesel' => $diesel,
            'em_oleo' => $oleo,
            'em_alimento' => $alimento,
            'em_gelo' => $gelo,
            'em_subamostra' => $request['subamostra'],
            'sa_id' => $idSubamostra,
            'em_tamanho' => $tamanho,
            'em_altura' => $altura,
            'em_numpanos' => $numPanos,
            'em_malha' => $malha,
            'em_obs' => $request['observacao'],
            'dp_id' => $request['destinoPescado'],
            'mnt_id' => $request['id_monitoramento']
        );
        
       $insertArrasto = $this->dbTableEmalhe->insert($dadosEmalhe);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableEmalhe = new Application_Model_DbTable_Emalhe();
        $this->dbTableSubamostra = new Application_Model_DbTable_Subamostra();
        
        $diesel = $request['diesel'];
        $oleo = $request['oleo'];
        $alimento = $request['alimento'];
        $gelo = $request['gelo'];
        
        
        $tamanho = $request['tamanho'];
        $altura = $request['altura'];
        $numPanos =$request['numPanos'];
        $malha = $request['malha'];
        
        if(empty($tamanho)){
            $tamanho = NULL;
        }
        if(empty($altura)){
            $altura = NULL;
        }
        if(empty($numPanos)){
            $numPanos = NULL;
        }
        if(empty($malha)){
            $malha = NULL;
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
        
        $timestampLancamento = $request['dataLancamento']." ".$request['horaLancamento'];
        $timestampRecolhimento = $request['dataRecolhimento']." ".$request['horaRecolhimento'];
        
        if($request['subamostra']==true){
        $dadosSubamostra = array(
            'sa_pescador' => $request['pescadorEntrevistado'],
            'sa_datachegada' => $request['dataRecolhimento']
        );

        $idSubamostra =  $this->dbTableSubamostra->insert($dadosSubamostra);
        }
        else {
            $idSubamostra = null;
        }
        
        
        $dadosEmalhe = array(
            'mnt_id' => $request['id_monitoramento'],
            'em_embarcado' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'em_motor'=> $request['motor'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'em_quantpescadores' => $request['numPescadores'],
            'em_dhlancamento' => $timestampLancamento, 
            'em_dhrecolhimento' => $timestampRecolhimento,
            'em_diesel' => $diesel,
            'em_oleo' => $oleo,
            'em_alimento' => $alimento,
            'em_gelo' => $gelo,
            'em_tamanho' => $tamanho,
            'em_subamostra' => $request['subamostra'],
            'em_altura' => $altura,
            'em_numpanos' => $numPanos,
            'em_malha' => $malha,
            'dp_id' => $request['destinoPescado'],
            'em_obs' => $request['observacao']
        );
 
        
        $whereEmalhe= $this->dbTableEmalhe->getAdapter()
                ->quoteInto('"em_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableEmalhe->update($dadosEmalhe, $whereEmalhe);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Emalhe();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idEmalhe)
    {
        $this->dbTableEmalhe = new Application_Model_DbTable_Emalhe();       
                
        $whereEmalhe= $this->dbTableEmalhe->getAdapter()
                ->quoteInto('"em_id" = ?', $idEmalhe);
        
        $this->dbTableEmalhe->delete($whereEmalhe);
    }
    public function selectId(){
        $this->dbTableEmalhe = new Application_Model_DbTable_Emalhe();
        
        $select = $this->dbTableEmalhe->select()
                ->from($this->dbTableEmalhe, 'em_id')->order('em_id DESC')->limit('1');
        
        return $this->dbTableEmalhe->fetchAll($select)->toArray();
    }
    public function selectEmalheHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableEmalhe = new Application_Model_DbTable_VEmalheHasPesqueiro();
        $select = $this->dbTableEmalhe->select()
                ->from($this->dbTableEmalhe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableEmalhe->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro)
    {
        $this->dbTableTEmalhe = new Application_Model_DbTable_EmalheHasPesqueiro();
        
        
        $dadosPesqueiro = array(
            'em_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
        );
        
        $this->dbTableTEmalhe->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTEmalhe = new Application_Model_DbTable_EmalheHasPesqueiro();       
                
        $whereEmalheHasPesqueiro = $this->dbTableTEmalhe->getAdapter()
                ->quoteInto('"em_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTEmalhe->delete($whereEmalheHasPesqueiro);
        
    }
    public function selectEmalheHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableEmalheHasEspCapturada = new Application_Model_DbTable_VEmalheHasEspecieCapturada();
        
        $select = $this->dbTableEmalheHasEspCapturada->select()
                ->from($this->dbTableEmalheHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableEmalheHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTEmalheHasEspCapturada = new Application_Model_DbTable_EmalheHasEspecieCapturada();
        
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
            'em_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );
        
        $this->dbTableTEmalheHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTEmalheHasEspCapturada = new Application_Model_DbTable_EmalheHasEspecieCapturada();       
                
        $whereEmalheHasEspCapturada = $this->dbTableTEmalheHasEspCapturada->getAdapter()
                ->quoteInto('"spc_em_id" = ?', $idEspecie);
        
        $this->dbTableTEmalheHasEspCapturada->delete($whereEmalheHasEspCapturada);
    }
    public function selectEntrevistaEmalhe($where = null, $order = null, $limit = null)
    {
        $this->dbTableEmalhe = new Application_Model_DbTable_VEntrevistaEmalhe();
        $select = $this->dbTableEmalhe->select()
                ->from($this->dbTableEmalhe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableEmalhe->fetchAll($select)->toArray();
    }
    public function selectEmalheHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableEmalheAvistamento = new Application_Model_DbTable_VEmalhelHasAvistamento();
        $selectAvist = $this->dbTableEmalheAvistamento->select()
                ->from($this->dbTableEmalheAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableEmalheAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTEmalhelHasAvistamento = new Application_Model_DbTable_EmalhelHasAvistamento();
        
        
        $dadosAvistamento = array(
            'em_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTEmalhelHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTEmalhelHasAvistamento = new Application_Model_DbTable_EmalhelHasAvistamento();       
                
        $dadosEmalhelHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'em_id= ?' => $idEntrevista
        );
        
        $this->dbTableTEmalhelHasAvistamento->delete($dadosEmalhelHasAvistamento);
    }
        ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableEmalheHasBioCamarao = new Application_Model_DbTable_EmalheHasBioCamarao();


        $dadosPesqueiro = array(
            'tem_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableEmalheHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableEmalheHasBioCamarao = new Application_Model_DbTable_VEmalheHasBioCamarao();
        $select = $this->dbTableEmalheHasBioCamarao->select()
                ->from($this->dbTableEmalheHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableEmalheHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTEmalheHasBioCamarao = new Application_Model_DbTable_EmalheHasBioCamarao();

        $whereEmalheHasBiometria = $this->dbTableTEmalheHasBioCamarao->getAdapter()
                ->quoteInto('tembc_id = ?', $idBiometria);

        $this->dbTableTEmalheHasBioCamarao->delete($whereEmalheHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableEmalheHasBioPeixe = new Application_Model_DbTable_EmalheHasBioPeixe();


        $dadosPesqueiro = array(
            'tem_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableEmalheHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableEmalheHasBioPeixe = new Application_Model_DbTable_VEmalheHasBioPeixe();
        $select = $this->dbTableEmalheHasBioPeixe->select()
                ->from($this->dbTableEmalheHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableEmalheHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTEmalheHasBioPeixe = new Application_Model_DbTable_EmalheHasBioPeixe();

        $whereEmalheHasBiometria = $this->dbTableTEmalheHasBioPeixe->getAdapter()
                ->quoteInto('tembp_id = ?', $idBiometria);

        $this->dbTableTEmalheHasBioPeixe->delete($whereEmalheHasBiometria);
        
    }

}

