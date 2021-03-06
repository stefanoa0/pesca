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
        $this->dbTableColetaManual = new Application_Model_DbTable_ColetaManual();
        
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
        $this->dbTableColetaManualFundo = new Application_Model_DbTable_ColetaManual();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableColetaManualFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableColetaManualFundo->update($dados, $wherePescador);
    }
    public function update(array $request)
    {
        $this->dbTableColetaManual = new Application_Model_DbTable_ColetaManual();
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
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
            'cml_tempogasto' => $request['tempoGasto'],
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
    public function updatePesqueiro($idEntrevistaPesqueiro,$idEntrevista,$pesqueiro, $tempoapesqueiro, $distapesqueiro)
    {
        $this->dbTableTColetaManualHasPesqueiro = new Application_Model_DbTable_ColetaManualHasPesqueiro();

        if(empty($tempoapesqueiro)){  $tempoapesqueiro = null;}
        $dadosPesqueiro = array(
            'cml_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoapesqueiro,
            't_distapesqueiro' => $distapesqueiro
        );

        $wherePescador = $this->dbTableTColetaManualHasPesqueiro->getAdapter()
                ->quoteInto('"cml_paf_id" = ?', $idEntrevistaPesqueiro);


        $this->dbTableTColetaManualHasPesqueiro->update($dadosPesqueiro, $wherePescador);
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
            'ttv_id' => $idTipoVenda
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
    public function updateEspCapturada($idEntrevistaEspecie,$idEntrevista, $especie, $quantidade, $peso, $precokg,$idTipoVenda)
    {
        $this->dbTableTColetaManualHasEspCapturada = new Application_Model_DbTable_ColetaManualHasEspecieCapturada();

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
            'cml_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda
        );

        $wherePescador = $this->dbTableTColetaManualHasEspCapturada->getAdapter()
                ->quoteInto('"spc_cml_id" = ?', $idEntrevistaEspecie);


        $this->dbTableTColetaManualHasEspCapturada->update($dadosEspecie, $wherePescador);
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
    public function updateBioCamarao($idEntrevistaCamarao,$idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso) {
        $this->dbTableColetaManualHasBioCamarao = new Application_Model_DbTable_ColetaManualHasBioCamarao();
        $dadosPesqueiro = array( 'tcml_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbc_sexo' => $sexo, 'tmat_id' => $maturidade, 'tbc_comprimento_cabeca' => $compCabeca, 'tbc_peso' => $peso );
        $wherePescador = $this->dbTableColetaManualHasBioCamarao->getAdapter() ->quoteInto('"tcmlbc_id" = ?', $idEntrevistaCamarao);
        $this->dbTableColetaManualHasBioCamarao->update($dadosPesqueiro, $wherePescador);
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
    public function updateBioPeixe($idEntrevistaPeixe, $idEntrevista, $idEspecie,$sexo, $comprimento, $peso) {
	$this->dbTableColetaManualHasBioPeixe = new Application_Model_DbTable_ColetaManualHasBioPeixe();
	$dadosPesqueiro = array( 'tcml_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbp_sexo' => $sexo, 'tbp_comprimento' => $comprimento, 'tbp_peso' => $peso );
	$wherePescador = $this->dbTableColetaManualHasBioPeixe->getAdapter() ->quoteInto('"tcmlbp_id" = ?', $idEntrevistaPeixe);
	$this->dbTableColetaManualHasBioPeixe->update($dadosPesqueiro, $wherePescador);
    }
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaColetaManual();
        $select = $dbTable->select()->
                from('v_entrevista_coletamanual', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaColetaManual();
        $select = $dbTable->select()->
                from('v_entrevista_coletamanual', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaColetaManual();
        $select = $dbTable->select()->
                from('v_entrevista_coletamanual', array('pto_nome', 'count(cml_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaColetaManual();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_coletamanual', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 
                    'sum(quantidade) as quant', 'mes', 'ano', 'quanttotal'=> new Zend_Db_Expr('((sum(quantidade)/sum(monitorados))*sum(naomonitorados))+sum(quantidade)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEstimativaByPorto($where = null,$order=null,$limit=null){
        $dbTable = new Application_Model_DbTable_VEstimativaColetaManual();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_coletamanual', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(quantidade) as quantidade', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaColetaManual();
        $select = $dbTable->select()->
                from('v_entrevista_coletamanual', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaColetaManual();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_coletamanual', 'v_entrevista_coletamanual.pto_nome')->joinLeft('v_coletamanual_has_t_especie_capturada', 'v_entrevista_coletamanual.cml_id = v_coletamanual_has_t_especie_capturada.cml_id',
                        array('sum(v_coletamanual_has_t_especie_capturada.spc_quantidade) as quant','sum(v_coletamanual_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaColetaManual();
        $select = $dbTable->select()->
                from('v_entrevista_coletamanual', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaColetaManual();
        
        $select = $dbTable->select()->
                from('v_entrevista_coletamanual', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaColetaManual();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_coletamanual', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_coletamanual_has_t_especie_capturada', 'v_entrevista_coletamanual.cml_id = v_coletamanual_has_t_especie_capturada.cml_id'
                , array('v_coletamanual_has_t_especie_capturada.cml_id','cpue'=> new Zend_Db_Expr('sum(v_coletamanual_has_t_especie_capturada.spc_quantidade) as cpue'), 'v_entrevista_coletamanual.tl_local','v_entrevista_coletamanual.pto_nome'))->
                group(array('v_coletamanual_has_t_especie_capturada.cml_id', "mesAno",'v_entrevista_coletamanual.tl_local','v_entrevista_coletamanual.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VColetaManualHasPesqueiro();
        
        $select = $dbTable->select()->from('v_coletamanual_has_t_pesqueiro',array('count(cml_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableColetaManualHasBioPeixe = new Application_Model_DbTable_VColetaManualHasBioPeixe();
        $select = $this->dbTableColetaManualHasBioPeixe->select()
                ->from($this->dbTableColetaManualHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableColetaManualHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableColetaManualHasBioPeixe = new Application_Model_DbTable_VColetaManualHasBioPeixe();
        $select = $this->dbTableColetaManualHasBioPeixe->select()
                ->from($this->dbTableColetaManualHasBioPeixe,array('x'=>'tbp_peso', 'y'=>'tbp_comprimento'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableColetaManualHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableColetaManualHasBioPeixe = new Application_Model_DbTable_VColetaManualHasBioPeixe();
        $select = $this->dbTableColetaManualHasBioPeixe->select()->from($this->dbTableColetaManualHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableColetaManualHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableColetaManual = new Application_Model_DbTable_VEntrevistaColetaManual();
        
        $select = $this->dbTableColetaManual->select()->
                from($this->dbTableColetaManual, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableColetaManual->fetchAll($select)->toArray();
    }
    
    public function selectMediaEspecies($where = null, $order = null, $limit = null)
    {
        $this->dbTableColetaManualMedia = new Application_Model_DbTable_VMediaEspeciesColetaManual();
        $select = $this->dbTableColetaManualMedia->select()->
                order($order)->limit($limit);
        if(!is_null($where)){
            $select->where($where);
        }
        return $this->dbTableColetaManualMedia->fetchAll($select)->toArray();
    }
    public function selectAvistamentoByTipo($where = null, $limit = null)
    {
 
        $this->dbTableColetaManualAvistamento = new Application_Model_DbTable_VColetaManualHasAvistamento();
        $selectAvist = $this->dbTableColetaManualAvistamento->select()->group('avs_descricao')
                ->from($this->dbTableColetaManualAvistamento, array('quantAvist' => 'count(*)','avs_descricao'))->order('quantAvist DESC')->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableColetaManualAvistamento->fetchAll($selectAvist)->toArray();
    }
}

