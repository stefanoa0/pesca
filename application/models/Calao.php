<?php
/** 
 * Model Arte de Pesca - Calao
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Calao
{
    private $dbTableCalao;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableCalao = new Application_Model_DbTable_Calao();
        $select = $this->dbTableCalao->select()
                ->from($this->dbTableCalao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableCalao->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableCalao = new Application_Model_DbTable_Calao();
        $arr = $this->dbTableCalao->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableCalao = new Application_Model_DbTable_Calao();
        
        
        
        $tamanho = $request['tamanho'];
        $malha1 = $request['malha1'];
        $malha2 = $request['malha2'];
        $altura = $request['altura'];
        $numLances = $request['numLances'];
        $malha = $request['malha'];
       
        
        if(empty($tamanho)){
            $tamanho = NULL;
        }
        if(empty($malha1)){
            $malha1 = NULL;
        }
        if(empty($malha2)){
            $malha2 = NULL;
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
        
        $dadosCalao = array(
            'cal_embarcada' => $request['embarcada'],
            'cal_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['PescadorEntrevistado'],
            'cal_quantpescadores' => $request['NumPescadores'],
            'cal_data' => $request['data'],
            'cal_tempogasto' => $request['tempoGasto'], 
            'cal_tamanho' => $tamanho,
            'cal_malha1' => $malha1,
            'cal_malha2' => $malha2,
            'cal_altura' => $altura,
            'cal_malha' => $malha,
            'cal_numlances' => $numLances,
            'cal_obs' => $request['observacao'],
            'dp_id' => $request['destinoPescado'],
            'mnt_id' => $request['id_monitoramento'],
            'cal_tipo' => $request['tipocalao']
        );
        
        $insertEntrevista = $this->dbTableCalao->insert($dadosCalao);
        return $insertEntrevista;
    }
    
    public function update(array $request)
    {
        $this->dbTableCalao = new Application_Model_DbTable_Calao();
        
        
        
        $tamanho = $request['tamanho'];
        $malha1 = $request['malha1'];
        $malha2 = $request['malha2'];
        $altura = $request['altura'];
        $numLances = $request['numLances'];
        $malha = $request['malha'];
       
        if(empty($tamanho)){
            $tamanho = NULL;
        }
        if(empty($malha1)){
            $malha1 = NULL;
        }
        if(empty($malha2)){
            $malha2 = NULL;
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
        
        $dadosCalao = array(
            'mnt_id' => $request['id_monitoramento'],
            'cal_embarcada' => $request['embarcada'],
            'cal_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['PescadorEntrevistado'],
            'cal_quantpescadores' => $request['NumPescadores'],
            'cal_data' => $request['data'],
            'cal_tempogasto' => $request['tempoGasto'], 
            'cal_tamanho' => $tamanho,
            'cal_malha1' => $malha1,
            'cal_malha2' => $malha2,
            'cal_altura' => $altura,
            'cal_malha' => $malha,
            'cal_numlances' => $numLances,
            'dp_id' => $request['destinoPescado'],
            'cal_obs' => $request['observacao'],
            'cal_tipo' => $request['tipocalao']
        );
 
        
        $whereCalao= $this->dbTableCalao->getAdapter()
                ->quoteInto('"cal_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableCalao->update($dadosCalao, $whereCalao);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableCalao = new Application_Model_DbTable_Calao();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableCalao->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableCalao->update($dados, $wherePescador);
    }
    public function delete($idCalao)
    {
        $this->dbTableCalao = new Application_Model_DbTable_Calao();       
                
        $whereCalao= $this->dbTableCalao->getAdapter()
                ->quoteInto('"cal_id" = ?', $idCalao);
        
        $this->dbTableCalao->delete($whereCalao);
    }
    public function selectId(){
        $this->dbTableCalao = new Application_Model_DbTable_Calao();
        
        $select = $this->dbTableCalao->select()
                ->from($this->dbTableCalao, 'cal_id')->order('cal_id DESC')->limit('1');
        
        return $this->dbTableCalao->fetchAll($select)->toArray();
    }
    public function selectCalaoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableCalao = new Application_Model_DbTable_VCalaoHasPesqueiro();
        $select = $this->dbTableCalao->select()
                ->from($this->dbTableCalao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableCalao->fetchAll($select)->toArray();
    }
    public function selectCalaoHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableCalaoHasEspCapturada = new Application_Model_DbTable_VCalaoHasEspecieCapturada();
        
        $select = $this->dbTableCalaoHasEspCapturada->select()
                ->from($this->dbTableCalaoHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableCalaoHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro)
    {
        $this->dbTableTCalao = new Application_Model_DbTable_CalaoHasPesqueiro();
        
        
        $dadosPesqueiro = array(
            'cal_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
        );
        
        $this->dbTableTCalao->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTCalao = new Application_Model_DbTable_CalaoHasPesqueiro();       
                
        $whereCalaoHasPesqueiro = $this->dbTableTCalao->getAdapter()
                ->quoteInto('"cal_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTCalao->delete($whereCalaoHasPesqueiro);
        
    }
    public function updatePesqueiro($idEntrevistaPesqueiro,$idEntrevista,$pesqueiro)
    {
        $this->dbTableTCalaoHasPesqueiro = new Application_Model_DbTable_CalaoHasPesqueiro();

        $dadosPesqueiro = array(
            'cal_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
        );

        $wherePescador = $this->dbTableTCalaoHasPesqueiro->getAdapter()
                ->quoteInto('"cal_paf_id" = ?', $idEntrevistaPesqueiro);


        $this->dbTableTCalaoHasPesqueiro->update($dadosPesqueiro, $wherePescador);
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTCalaoHasEspCapturada = new Application_Model_DbTable_CalaoHasEspecieCapturada();
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
            'cal_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );
        
        $this->dbTableTCalaoHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTCalaoHasEspCapturada = new Application_Model_DbTable_CalaoHasEspecieCapturada();       
                
        $whereCalaoHasEspCapturada = $this->dbTableTCalaoHasEspCapturada->getAdapter()
                ->quoteInto('"spc_cal_id" = ?', $idEspecie);
        
        $this->dbTableTCalaoHasEspCapturada->delete($whereCalaoHasEspCapturada);
    }
    public function updateEspCapturada($idEntrevistaEspecie,$idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTCalaoHasEspCapturada = new Application_Model_DbTable_CalaoHasEspecieCapturada();

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
            'cal_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );

        $wherePescador = $this->dbTableTCalaoHasEspCapturada->getAdapter()
                ->quoteInto('"spc_cal_id" = ?', $idEntrevistaEspecie);


        $this->dbTableTCalaoHasEspCapturada->update($dadosEspecie, $wherePescador);
    }
    
    public function selectEntrevistaCalao($where = null, $order = null, $limit = null)
    {
        $this->dbTableCalao = new Application_Model_DbTable_VEntrevistaCalao();
        $select = $this->dbTableCalao->select()
                ->from($this->dbTableCalao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableCalao->fetchAll($select)->toArray();
    }
    public function selectCalaoHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableCalaoAvistamento = new Application_Model_DbTable_VCalaoHasAvistamento();
        $selectAvist = $this->dbTableCalaoAvistamento->select()
                ->from($this->dbTableCalaoAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableCalaoAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTCalaoHasAvistamento = new Application_Model_DbTable_CalaoHasAvistamento();
        
        
        $dadosAvistamento = array(
            'cal_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTCalaoHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTCalaoHasAvistamento = new Application_Model_DbTable_CalaoHasAvistamento();       
                
        $dadosCalaoHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'cal_id= ?' => $idEntrevista
        );
        
        $this->dbTableTCalaoHasAvistamento->delete($dadosCalaoHasAvistamento);
    }
    ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableCalaoHasBioCamarao = new Application_Model_DbTable_CalaoHasBioCamarao();


        $dadosPesqueiro = array(
            'tcal_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableCalaoHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableCalaoHasBioCamarao = new Application_Model_DbTable_VCalaoHasBioCamarao();
        $select = $this->dbTableCalaoHasBioCamarao->select()
                ->from($this->dbTableCalaoHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableCalaoHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function updateBioCamarao($idEntrevistaCamarao,$idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso) {
        $this->dbTableCalaoHasBioCamarao = new Application_Model_DbTable_CalaoHasBioCamarao();
        $dadosPesqueiro = array( 'tcal_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbc_sexo' => $sexo, 'tmat_id' => $maturidade, 'tbc_comprimento_cabeca' => $compCabeca, 'tbc_peso' => $peso );
        $wherePescador = $this->dbTableCalaoHasBioCamarao->getAdapter() ->quoteInto('"tcalbc_id" = ?', $idEntrevistaCamarao);
        $this->dbTableCalaoHasBioCamarao->update($dadosPesqueiro, $wherePescador);
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTCalaoHasBioCamarao = new Application_Model_DbTable_CalaoHasBioCamarao();

        $whereCalaoHasBiometria = $this->dbTableTCalaoHasBioCamarao->getAdapter()
                ->quoteInto('tcalbc_id = ?', $idBiometria);

        $this->dbTableTCalaoHasBioCamarao->delete($whereCalaoHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableCalaoHasBioPeixe = new Application_Model_DbTable_CalaoHasBioPeixe();


        $dadosPesqueiro = array(
            'tcal_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableCalaoHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableCalaoHasBioPeixe = new Application_Model_DbTable_VCalaoHasBioPeixe();
        $select = $this->dbTableCalaoHasBioPeixe->select()
                ->from($this->dbTableCalaoHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableCalaoHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTCalaoHasBioPeixe = new Application_Model_DbTable_CalaoHasBioPeixe();

        $whereCalaoHasBiometria = $this->dbTableTCalaoHasBioPeixe->getAdapter()
                ->quoteInto('tcalbp_id = ?', $idBiometria);

        $this->dbTableTCalaoHasBioPeixe->delete($whereCalaoHasBiometria);
        
    }
    public function updateBioPeixe($idEntrevistaPeixe, $idEntrevista, $idEspecie,$sexo, $comprimento, $peso) {
	$this->dbTableCalaoHasBioPeixe = new Application_Model_DbTable_CalaoHasBioPeixe();
	$dadosPesqueiro = array( 'tcal_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbp_sexo' => $sexo, 'tbp_comprimento' => $comprimento, 'tbp_peso' => $peso );
	$wherePescador = $this->dbTableCalaoHasBioPeixe->getAdapter() ->quoteInto('"tcalbp_id" = ?', $idEntrevistaPeixe);
	$this->dbTableCalaoHasBioPeixe->update($dadosPesqueiro, $wherePescador);
    }
    
   public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaCalao();
        $select = $dbTable->select()->
                from('v_entrevista_calao', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaCalao();
        $select = $dbTable->select()->
                from('v_entrevista_calao', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaCalao();
        $select = $dbTable->select()->
                from('v_entrevista_calao', array('pto_nome', 'count(cal_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaCalao();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_calao', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 'sum(peso) as peso', 'mes', 'ano', 'pesototal'=> new Zend_Db_Expr('((sum(peso)/sum(monitorados))*sum(naomonitorados))+sum(peso)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEstimativaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaCalao();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_calao', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(peso) as peso', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaCalao();
        $select = $dbTable->select()->
                from('v_entrevista_calao', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaCalao();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_calao', 'v_entrevista_calao.pto_nome')->joinLeft('v_calao_has_t_especie_capturada', 'v_entrevista_calao.cal_id = v_calao_has_t_especie_capturada.cal_id',
                        array('sum(v_calao_has_t_especie_capturada.spc_quantidade) as quant','sum(v_calao_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaCalao();
        $select = $dbTable->select()->
                from('v_entrevista_calao', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaCalao();
        
        $select = $dbTable->select()->
                from('v_entrevista_calao', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaCalao();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_calao', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_calao_has_t_especie_capturada', 'v_entrevista_calao.cal_id = v_calao_has_t_especie_capturada.cal_id'
                , array('v_calao_has_t_especie_capturada.cal_id','cpue'=> new Zend_Db_Expr('sum(v_calao_has_t_especie_capturada.spc_peso_kg)'), 'v_entrevista_calao.tl_local','v_entrevista_calao.pto_nome'))->
                group(array('v_calao_has_t_especie_capturada.cal_id', "mesAno",'v_entrevista_calao.tl_local','v_entrevista_calao.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VCalaoHasPesqueiro();
        
        $select = $dbTable->select()->from('v_calao_has_t_pesqueiro',array('count(cal_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableCalaoHasBioPeixe = new Application_Model_DbTable_VCalaoHasBioPeixe();
        $select = $this->dbTableCalaoHasBioPeixe->select()
                ->from($this->dbTableCalaoHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableCalaoHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableCalaoHasBioPeixe = new Application_Model_DbTable_VCalaoHasBioPeixe();
        $select = $this->dbTableCalaoHasBioPeixe->select()
                ->from($this->dbTableCalaoHasBioPeixe,array('x'=>'tbp_comprimento', 'y'=>'tbp_peso'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableCalaoHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableCalaoHasBioPeixe = new Application_Model_DbTable_VCalaoHasBioPeixe();
        $select = $this->dbTableCalaoHasBioPeixe->select()->from($this->dbTableCalaoHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableCalaoHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableCalao = new Application_Model_DbTable_VEntrevistaCalao();
        
        $select = $this->dbTableCalao->select()->
                from($this->dbTableCalao, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableCalao->fetchAll($select)->toArray();
    }
    
    public function selectMediaEspecies($where = null, $order = null, $limit = null)
    {
        $this->dbTableCalaoMedia = new Application_Model_DbTable_VMediaEspeciesCalao();
        $select = $this->dbTableCalaoMedia->select()->
                    order($order)->limit($limit);
        if(!is_null($where)){
            $select->where($where);
        }
        return $this->dbTableCalaoMedia->fetchAll($select)->toArray();
    }
    
    public function selectAvistamentoByTipo($where = null, $limit = null)
    {
 
        $this->dbTableCalaoAvistamento = new Application_Model_DbTable_VCalaoHasAvistamento();
        $selectAvist = $this->dbTableCalaoAvistamento->select()->group('avs_descricao')
                ->from($this->dbTableCalaoAvistamento, array('quantAvist' => 'count(*)','avs_descricao'))->order('quantAvist DESC')->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableCalaoAvistamento->fetchAll($selectAvist)->toArray();
    }
}

