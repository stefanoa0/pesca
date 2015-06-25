<?php
/** 
 * Model Arte de Pesca - Siripoia
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */
class Application_Model_Siripoia
{    private $dbTableSiripoia;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        $select = $this->dbTableSiripoia->select()
                ->from($this->dbTableSiripoia)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoia->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        $arr = $this->dbTableSiripoia->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {

        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        $numArmadilhas = $request['numArmadilhas'];
        
        if(empty($numArmadilhas)){
            $numArmadilhas = NULL;
        }
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
        }
        $dadosSiripoia = array(
            'sir_embarcada' => $request['embarcada'],
            'sir_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'sir_quantpescadores' => $request['numPescadores'],
            'sir_dhvolta' => $timestampVolta,
            'sir_dhsaida' => $timestampSaida, 
            'sir_tempogasto' => $request['tempoGasto'],
            'sir_obs' => $request['observacao'],
            'sir_numarmadilhas' => $numArmadilhas,
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'sir_mreviva' => $request['mareviva'],
            'sir_combustivel' => $combustivel
        );
        
        $insertSiripoia = $this->dbTableSiripoia->insert($dadosSiripoia);
        return $insertSiripoia;
    }
    
    public function update(array $request)
    {
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        $numArmadilhas = $request['numArmadilhas'];
        
        if(empty($numArmadilhas)){
            $numArmadilhas = NULL;
        }
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
        }
        $dadosSiripoia = array(
            'mnt_id' => $request['id_monitoramento'],
            'sir_embarcada' => $request['embarcada'],
            'sir_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'sir_quantpescadores' => $request['numPescadores'],
            'sir_dhvolta' => $timestampVolta,
            'sir_dhsaida' => $timestampSaida, 
            'sir_tempogasto' => $request['tempoGasto'],
            'sir_obs' => $request['observacao'],
            'sir_numarmadilhas' => $numArmadilhas,
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'sir_mreviva' => $request['mareviva'],
            'sir_combustivel' => $combustivel
        );
 
        
        $whereSiripoia= $this->dbTableSiripoia->getAdapter()
                ->quoteInto('"sir_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableSiripoia->update($dadosSiripoia, $whereSiripoia);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableSiripoiaFundo = new Application_Model_DbTable_Siripoia();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableSiripoiaFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableSiripoiaFundo->update($dados, $wherePescador);
    }
    public function delete($idSiripoia)
    {
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();       
                
        $whereSiripoia= $this->dbTableSiripoia->getAdapter()
                ->quoteInto('"sir_id" = ?', $idSiripoia);
        
        $this->dbTableSiripoia->delete($whereSiripoia);
    }
    public function selectId(){
        $this->dbTableSiripoia = new Application_Model_DbTable_Siripoia();
        
        $select = $this->dbTableSiripoia->select()
                ->from($this->dbTableSiripoia, 'sir_id')->order('sir_id DESC')->limit('1');
        
        return $this->dbTableSiripoia->fetchAll($select)->toArray();
    }
    public function selectSiripoiaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableSiripoiaHasPesqueiro = new Application_Model_DbTable_VSiripoiaHasPesqueiro();
        $select = $this->dbTableSiripoiaHasPesqueiro->select()
                ->from($this->dbTableSiripoiaHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoiaHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTSiripoiaHasPesqueiro = new Application_Model_DbTable_SiripoiaHasPesqueiro();
       if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        
        $dadosPesqueiro = array(
            'sir_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTSiripoiaHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTSiripoiaHasPesqueiro = new Application_Model_DbTable_SiripoiaHasPesqueiro();       
                
        $whereSiripoiaHasPesqueiro = $this->dbTableTSiripoiaHasPesqueiro->getAdapter()
                ->quoteInto('"sir_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTSiripoiaHasPesqueiro->delete($whereSiripoiaHasPesqueiro);
        
    }
    public function selectSiripoiaHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableSiripoiaHasEspCapturada = new Application_Model_DbTable_VSiripoiaHasEspecieCapturada();
        
        $select = $this->dbTableSiripoiaHasEspCapturada->select()
                ->from($this->dbTableSiripoiaHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableSiripoiaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTSiripoiaHasEspCapturada = new Application_Model_DbTable_SiripoiaHasEspecieCapturada();
        
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
            'sir_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda
        );
        
        $this->dbTableTSiripoiaHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTSiripoiaHasEspCapturada = new Application_Model_DbTable_SiripoiaHasEspecieCapturada();       
                
        $whereSiripoiaHasEspCapturada = $this->dbTableTSiripoiaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_sir_id" = ?', $idEspecie);
        
        $this->dbTableTSiripoiaHasEspCapturada->delete($whereSiripoiaHasEspCapturada);
    }
    public function selectEntrevistaSiripoia($where = null, $order = null, $limit = null)
    {
        $this->dbTableSiripoia = new Application_Model_DbTable_VEntrevistaSiripoia();
        $select = $this->dbTableSiripoia->select()
                ->from($this->dbTableSiripoia)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoia->fetchAll($select)->toArray();
    }
    public function selectSiripoiaHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableSiripoiaAvistamento = new Application_Model_DbTable_VSiripoiaHasAvistamento();
        $selectAvist = $this->dbTableSiripoiaAvistamento->select()
                ->from($this->dbTableSiripoiaAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableSiripoiaAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTSiripoiaHasAvistamento = new Application_Model_DbTable_SiripoiaHasAvistamento();
        
        
        $dadosAvistamento = array(
            'sir_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTSiripoiaHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTSiripoiaHasAvistamento = new Application_Model_DbTable_SiripoiaHasAvistamento();       
                
        $dadosSiripoiaHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'sir_id= ?' => $idEntrevista
        );
        
        $this->dbTableTSiripoiaHasAvistamento->delete($dadosSiripoiaHasAvistamento);
    }
    
 ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableSiripoiaHasBioCamarao = new Application_Model_DbTable_SiripoiaHasBioCamarao();


        $dadosPesqueiro = array(
            'tsir_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableSiripoiaHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableSiripoiaHasBioCamarao = new Application_Model_DbTable_VSiripoiaHasBioCamarao();
        $select = $this->dbTableSiripoiaHasBioCamarao->select()
                ->from($this->dbTableSiripoiaHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoiaHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTSiripoiaHasBioCamarao = new Application_Model_DbTable_SiripoiaHasBioCamarao();

        $whereSiripoiaHasBiometria = $this->dbTableTSiripoiaHasBioCamarao->getAdapter()
                ->quoteInto('tsirbc_id = ?', $idBiometria);

        $this->dbTableTSiripoiaHasBioCamarao->delete($whereSiripoiaHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableSiripoiaHasBioPeixe = new Application_Model_DbTable_SiripoiaHasBioPeixe();


        $dadosPesqueiro = array(
            'tsir_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableSiripoiaHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableSiripoiaHasBioPeixe = new Application_Model_DbTable_VSiripoiaHasBioPeixe();
        $select = $this->dbTableSiripoiaHasBioPeixe->select()
                ->from($this->dbTableSiripoiaHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoiaHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTSiripoiaHasBioPeixe = new Application_Model_DbTable_SiripoiaHasBioPeixe();

        $whereSiripoiaHasBiometria = $this->dbTableTSiripoiaHasBioPeixe->getAdapter()
                ->quoteInto('tsirbp_id = ?', $idBiometria);

        $this->dbTableTSiripoiaHasBioPeixe->delete($whereSiripoiaHasBiometria);
        
    }
    
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaSiripoia();
        $select = $dbTable->select()->
                from('v_entrevista_siripoia', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaSiripoia();
        $select = $dbTable->select()->
                from('v_entrevista_siripoia', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaSiripoia();
        $select = $dbTable->select()->
                from('v_entrevista_siripoia', array('pto_nome', 'count(sir_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaSiripoia();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_siripoia', array('pto_nome', 'tap_artepesca as arte', 'sum(naomonitorados)', 'sum(monitorados)', 
                    'sum(quantidade) as quant', 'mes', 'ano', 'quanttotal'=> new Zend_Db_Expr('((sum(quantidade)/sum(monitorados))*sum(naomonitorados))+sum(monitorados)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEstimativaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaSiripoia();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_siripoia', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(quantidade) as quantidade', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    //Quantidade de variaveis por Porto FUNÇÕES PARA REPLICAR
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaSiripoia();
        $select = $dbTable->select()->
                from('v_entrevista_siripoia', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaSiripoia();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_siripoia', 'v_entrevista_siripoia.pto_nome')->joinLeft('v_siripoia_has_t_especie_capturada', 'v_entrevista_siripoia.sir_id = v_siripoia_has_t_especie_capturada.sir_id',
                        array('sum(v_siripoia_has_t_especie_capturada.spc_quantidade) as quant','sum(v_siripoia_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaSiripoia();
        $select = $dbTable->select()->
                from('v_entrevista_siripoia', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaSiripoia();
        
        $select = $dbTable->select()->
                from('v_entrevista_siripoia', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaSiripoia();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_siripoia', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_siripoia_has_t_especie_capturada', 'v_entrevista_siripoia.sir_id = v_siripoia_has_t_especie_capturada.sir_id'
                , array('v_siripoia_has_t_especie_capturada.sir_id','cpue'=> new Zend_Db_Expr('sum(v_siripoia_has_t_especie_capturada.spc_quantidade) '), 'v_entrevista_siripoia.tl_local','v_entrevista_siripoia.pto_nome'))->
                group(array('v_siripoia_has_t_especie_capturada.sir_id', "mesAno",'v_entrevista_siripoia.tl_local','v_entrevista_siripoia.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VSiripoiaHasPesqueiro();
        
        $select = $dbTable->select()->from('v_siripoia_has_t_pesqueiro',array('count(sir_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableSiripoiaHasBioPeixe = new Application_Model_DbTable_VSiripoiaHasBioPeixe();
        $select = $this->dbTableSiripoiaHasBioPeixe->select()
                ->from($this->dbTableSiripoiaHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoiaHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableSiripoiaHasBioPeixe = new Application_Model_DbTable_VSiripoiaHasBioPeixe();
        $select = $this->dbTableSiripoiaHasBioPeixe->select()
                ->from($this->dbTableSiripoiaHasBioPeixe,array('x'=>'tbp_peso', 'y'=>'tbp_comprimento'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableSiripoiaHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableSiripoiaHasBioPeixe = new Application_Model_DbTable_VSiripoiaHasBioPeixe();
        $select = $this->dbTableSiripoiaHasBioPeixe->select()->from($this->dbTableSiripoiaHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableSiripoiaHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableSiripoia = new Application_Model_DbTable_VEntrevistaSiripoia();
        
        $select = $this->dbTableSiripoia->select()->
                from($this->dbTableSiripoia, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableSiripoia->fetchAll($select)->toArray();
    }
    
    public function selectMediaEspecies($where = null, $order = null, $limit = null)
    {
        $this->dbTableSiripoiaMedia = new Application_Model_DbTable_VMediaEspeciesSiripoia();
        $select = $this->dbTableSiripoiaMedia->select()->
                order($order)->limit($limit);
        if(!is_null($where)){
            $select->where($where);
        }
        return $this->dbTableSiripoiaMedia->fetchAll($select)->toArray();
    }
}

