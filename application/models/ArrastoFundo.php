<?php
/** 
 * Model Arte de Pesca - Arrasto de Fundo
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_ArrastoFundo
{
    private $dbTableArrastoFundo;
    private $dbTableArrastoHasPesqueiro;
    private $dbTableArrastoHasEspCapturada;
    private $dbTableArrastoHasBioCamarao;
    private $dbTableArrastoHasBioPeixe;
    
    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableArrastoFundo = new Application_Model_DbTable_ArrastoFundo();
        $select = $this->dbTableArrastoFundo->select()
                ->from($this->dbTableArrastoFundo)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoFundo->fetchAll($select)->toArray();
    }

    public function find($id)
    {
        $this->dbTableArrastoFundo = new Application_Model_DbTable_ArrastoFundo();
        $arr = $this->dbTableArrastoFundo->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request)
    {
        $this->dbTableArrastoFundo = new Application_Model_DbTable_ArrastoFundo();

        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];

        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        $diesel = $request['diesel'];
        $oleo = $request['oleo'];
        $alimento = $request['alimento'];
        $gelo = $request['gelo'];

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

        $dadosArrastoFundo = array(
            'af_embarcado' => $request['embarcada'],
            'af_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'af_quantpescadores' => $request['numPescadores'],
            'af_dhvolta' => $timestampVolta,
            'af_dhsaida' => $timestampSaida,
            'af_diesel' => $diesel,
            'af_oleo' => $oleo,
            'af_alimento' => $alimento,
            'af_gelo' => $gelo,
            'af_obs' => $request['observacao'],
            'dp_id' => $request['destinoPescado'],
            'mnt_id' => $request['id_monitoramento']

        );

        $insertEntrevista = $this->dbTableArrastoFundo->insert($dadosArrastoFundo);
        return $insertEntrevista;
    }

    public function update(array $request)
    {
        $this->dbTableArrastoFundo = new Application_Model_DbTable_ArrastoFundo();
        $this->modelMonitoramento = new Application_Model_Monitoramento();
        
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];

        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }

        
        $diesel = $request['diesel'];
        $oleo = $request['oleo'];
        $alimento = $request['alimento'];
        $gelo = $request['gelo'];

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
        
        
        $dadosArrastoFundo = array(
            'mnt_id' => $request['id_monitoramento'],
            'af_embarcado' => $request['embarcada'],
            'af_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'af_quantpescadores' => $request['numPescadores'],
            'af_dhvolta' => $timestampVolta,
            'af_dhsaida' => $timestampSaida,
            'af_diesel' => $diesel,
            'af_oleo' => $oleo,
            'af_alimento' => $alimento,
            'af_gelo' => $gelo,
            'dp_id' => $request['destinoPescado'],
            'af_obs' => $request['observacao']
        );


        $whereArrastoFundo= $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"af_id" = ?', $request['id_entrevista']);


        $this->dbTableArrastoFundo->update($dadosArrastoFundo, $whereArrastoFundo);

    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_ArrastoFundo();
        
        $dadosArrastoFundo = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dadosArrastoFundo, $wherePescador);
    }
    public function delete($idArrastoFundo)
    {
        $this->dbTableArrastoFundo = new Application_Model_DbTable_ArrastoFundo();

        $whereArrastoFundo= $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"af_id" = ?', $idArrastoFundo);

        $this->dbTableArrastoFundo->delete($whereArrastoFundo);
    }
    public function selectId(){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_ArrastoFundo();

        $select = $this->dbTableArrastoFundo->select()
                ->from($this->dbTableArrastoFundo, 'af_id')->order('af_id DESC')->limit('1');

        return $this->dbTableArrastoFundo->fetchAll($select)->toArray();
    }
    public function selectArrastoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableArrastoHasPesqueiro = new Application_Model_DbTable_VArrastoFundoHasPesqueiro();
        $select = $this->dbTableArrastoHasPesqueiro->select()
                ->from($this->dbTableArrastoHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempopesqueiro)
    {
        $this->dbTableTArrastoHasPesqueiro = new Application_Model_DbTable_ArrastoHasPesqueiro();

        if(empty($tempopesqueiro)){  $tempopesqueiro = null;}
        $dadosPesqueiro = array(
            'af_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempopesqueiro' => $tempopesqueiro
        );

        $this->dbTableTArrastoHasPesqueiro->insert($dadosPesqueiro);
        return;
    }

    
    
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTArrastoHasPesqueiro = new Application_Model_DbTable_ArrastoHasPesqueiro();

        $whereArrastoHasPesqueiro = $this->dbTableTArrastoHasPesqueiro->getAdapter()
                ->quoteInto('"af_paf_id" = ?', $idPesqueiro);

        $this->dbTableTArrastoHasPesqueiro->delete($whereArrastoHasPesqueiro);

    }
    public function selectArrastoHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableArrastoHasEspCapturada = new Application_Model_DbTable_VArrastoFundoHasEspecieCapturada();

        $select = $this->dbTableArrastoHasEspCapturada->select()
                ->from($this->dbTableArrastoHasEspCapturada)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTArrastoHasEspCapturada = new Application_Model_DbTable_ArrastoHasEspecieCapturada();

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
            'af_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );

        $this->dbTableTArrastoHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTArrastoHasEspCapturada = new Application_Model_DbTable_ArrastoHasEspecieCapturada();

        $whereArrastoHasEspCapturada = $this->dbTableTArrastoHasEspCapturada->getAdapter()
                ->quoteInto('"spc_af_id" = ?', $idEspecie);

        $this->dbTableTArrastoHasEspCapturada->delete($whereArrastoHasEspCapturada);
    }

    public function selectEntrevistaArrasto($where = null, $order = null, $limit = null)
    {
        $this->dbTableArrastoFundo = new Application_Model_DbTable_VEntrevistaArrasto();
        $select = $this->dbTableArrastoFundo->select()
                ->from($this->dbTableArrastoFundo)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoFundo->fetchAll($select)->toArray();
    }

    public function selectArrastoHasAvistamento($where = null, $order = null, $limit = null)
    {
 
        $this->dbTableArrastoFundoAvistamento = new Application_Model_DbTable_VArrastoFundoHasAvistamento();
        $selectAvist = $this->dbTableArrastoFundoAvistamento->select()
                ->from($this->dbTableArrastoFundoAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableArrastoFundoAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTArrastoHasAvistamento = new Application_Model_DbTable_ArrastoHasAvistamento();


        $dadosAvistamento = array(
            'af_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );

        $this->dbTableTArrastoHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTArrastoHasAvistamento = new Application_Model_DbTable_ArrastoHasAvistamento();

        $dadosArrastoHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'af_id= ?' => $idEntrevista
        );

        $this->dbTableTArrastoHasAvistamento->delete($dadosArrastoHasAvistamento);
    }
////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableArrastoHasBioCamarao = new Application_Model_DbTable_ArrastoFundoHasBioCamarao();


        $dadosPesqueiro = array(
            'taf_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableArrastoHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableArrastoHasBioCamarao = new Application_Model_DbTable_VArrastoFundoHasBioCamarao();
        $select = $this->dbTableArrastoHasBioCamarao->select()
                ->from($this->dbTableArrastoHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTArrastoHasBioCamarao = new Application_Model_DbTable_ArrastoFundoHasBioCamarao();

        $whereArrastoHasBiometria = $this->dbTableTArrastoHasBioCamarao->getAdapter()
                ->quoteInto('tafbc_id = ?', $idBiometria);

        $this->dbTableTArrastoHasBioCamarao->delete($whereArrastoHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableArrastoHasBioPeixe = new Application_Model_DbTable_ArrastoFundoHasBioPeixe();


        $dadosPesqueiro = array(
            'taf_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableArrastoHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableArrastoHasBioPeixe = new Application_Model_DbTable_VArrastoFundoHasBioPeixe();
        $select = $this->dbTableArrastoHasBioPeixe->select()
                ->from($this->dbTableArrastoHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTArrastoHasBioPeixe = new Application_Model_DbTable_ArrastoFundoHasBioPeixe();

        $whereArrastoHasBiometria = $this->dbTableTArrastoHasBioPeixe->getAdapter()
                ->quoteInto('tafbp_id = ?', $idBiometria);

        $this->dbTableTArrastoHasBioPeixe->delete($whereArrastoHasBiometria);
        
    }
////////////ENTREVISTAS/////////////////////////////////////////////////////////////////
    public function select_ArrastoFundo_group_EspecieCapturada() {
        $db = new Application_Model_DbTable_VArrastoFundoHasEspecieCapturada();
        $select = $db->select()
                ->from('v_arrastofundo_has_t_especie_capturada', array('count(*)','esp_nome_comum',
                'max(spc_quantidade)"max_quant"', 'AVG(spc_quantidade)"avg_quant"', 'min(spc_quantidade)"min_quant"',
                'max(spc_peso_kg)"max_peso"', 'AVG(spc_peso_kg)"avg_peso"', 'min(spc_peso_kg)"min_peso"',
                'max(spc_preco)"max_preco"', 'AVG(spc_preco)"avg_preco"', 'min(spc_preco)"min_preco"' ))
                ->group(array('esp_nome_comum'))
                ->order('esp_nome_comum');

        return $db->fetchAll($select)->toArray();
    }

    public function select_ArrastoFundo_group_Pesqueiro() {
        $db = new Application_Model_DbTable_VArrastoFundoHasPesqueiro();
        $select = $db->select()
                ->from('v_arrasto_has_t_pesqueiro', array('count(*)','paf_pesqueiro',
                'max(t_tempopesqueiro)"max_tempo"', 'AVG(t_tempopesqueiro)"avg_tempo"', 'min(t_tempopesqueiro)"min_tempo"' ))
                ->group(array('paf_pesqueiro'))
                ->order('paf_pesqueiro');

        return $db->fetchAll($select)->toArray();
    }
    
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaArrasto();
        $select = $dbTable->select()->
                from('v_entrevista_arrasto', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaArrasto();
        $select = $dbTable->select()->
                from('v_entrevista_arrasto', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaArrasto();
        $select = $dbTable->select()->
                from('v_entrevista_arrasto', array('pto_nome', 'count(af_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaArrasto();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_arrasto', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 'sum(peso) as peso', 'mes', 'ano', 'pesototal'=> new Zend_Db_Expr('((sum(peso)/sum(monitorados))*sum(naomonitorados))+sum(peso)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEstimativaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaArrasto();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_arrasto', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(peso) as peso', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    //Quantidade de variaveis por Porto FUNÇÕES PARA REPLICAR
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaArrasto();
        $select = $dbTable->select()->
                from('v_entrevista_arrasto', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaArrasto();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_arrasto', 'v_entrevista_arrasto.pto_nome')->
                joinLeft('v_arrastofundo_has_t_especie_capturada', 'v_entrevista_arrasto.af_id = v_arrastofundo_has_t_especie_capturada.af_id',
                        array('sum(v_arrastofundo_has_t_especie_capturada.spc_quantidade) as quant','sum(v_arrastofundo_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaArrasto();
        $select = $dbTable->select()->
                from('v_entrevista_arrasto', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaArrasto();
        
        $select = $dbTable->select()->
                from('v_entrevista_arrasto', array('pto_nome', 'count(af_id)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }

    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaArrasto();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_arrasto', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_arrastofundo_has_t_especie_capturada', 'v_entrevista_arrasto.af_id = v_arrastofundo_has_t_especie_capturada.af_id'
                , array('v_arrastofundo_has_t_especie_capturada.af_id','cpue'=> new Zend_Db_Expr('sum(v_arrastofundo_has_t_especie_capturada.spc_peso_kg)/v_entrevista_arrasto.dias'), 'v_entrevista_arrasto.tl_local','v_entrevista_arrasto.pto_nome'))->
                group(array('v_arrastofundo_has_t_especie_capturada.af_id', 'mesAno','v_entrevista_arrasto.dias','v_entrevista_arrasto.tl_local','v_entrevista_arrasto.pto_nome'))->
                order('mesAno');
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VArrastoFundoHasPesqueiro();
        
        $select = $dbTable->select()->from('v_arrasto_has_t_pesqueiro',array('count(af_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    /*
    public function selectPescadoresByColonia(){
        $dbTable = new Application_Model_DbTable_VEntrevistaArrasto();
        $select = $dbTable->select()->
                from('v_entrevista_arrasto', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        
        return $dbTable->fetchAll($select)->toArray();
        
    }
     */
    public function selectEspeciesCamaraoBiometrias()
    {
        $this->dbTableArrastoHasBioCamarao = new Application_Model_DbTable_VArrastoFundoHasBioCamarao();
        $select = $this->dbTableArrastoHasBioCamarao->select()->from($this->dbTableArrastoHasBioCamarao, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableArrastoHasBioCamarao->fetchAll($select)->toArray();
    }
    public function selectDadosBiometriaCamarao($where = null, $order = null,$limit = null){
        $this->dbTableArrastoHasBioCamarao = new Application_Model_DbTable_VArrastoFundoHasBioCamarao();
        $select = $this->dbTableArrastoHasBioCamarao->select()
                ->from($this->dbTableArrastoHasBioCamarao,array('x'=>'tbc_peso', 'y'=>'tbc_comprimento_cabeca'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoHasBioCamarao->fetchAll($select)->toArray();
    }
    public function selectHistogramaBiometriaCamarao($tipo,$where = null, $order = null,$limit = null){
        $this->dbTableArrastoHasBioCamarao = new Application_Model_DbTable_VArrastoFundoHasBioCamarao();
        $select = $this->dbTableArrastoHasBioCamarao->select()
                ->from($this->dbTableArrastoHasBioCamarao,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoHasBioCamarao->fetchAll($select)->toArray();
    }
    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableArrastoHasBioPeixe = new Application_Model_DbTable_VArrastoFundoHasBioPeixe();
        $select = $this->dbTableArrastoHasBioPeixe->select()
                ->from($this->dbTableArrastoHasBioPeixe,array('x'=>'tbp_peso', 'y'=>'tbp_comprimento'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableArrastoHasBioPeixe = new Application_Model_DbTable_VArrastoFundoHasBioPeixe();
        $select = $this->dbTableArrastoHasBioPeixe->select()->from($this->dbTableArrastoHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableArrastoHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableArrastoFundoHasBioPeixe = new Application_Model_DbTable_VArrastoFundoHasBioPeixe();
        $select = $this->dbTableArrastoFundoHasBioPeixe->select()
                ->from($this->dbTableArrastoFundoHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableArrastoFundoHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableArrasto = new Application_Model_DbTable_VEntrevistaArrasto();
        
        $select = $this->dbTableArrasto->select()->
                from($this->dbTableArrasto, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableArrasto->fetchAll($select)->toArray();
    }
}
