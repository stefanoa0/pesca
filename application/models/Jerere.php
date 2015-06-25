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
        $this->dbTableJerere = new Application_Model_DbTable_Jerere();
        
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
        
        $dadosJerere = array(
            'jre_embarcada' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'jre_quantpescadores' => $request['numPescadores'],
            'jre_dhvolta' => $timestampVolta,
            'jre_dhsaida' => $timestampSaida,
            'jre_obs' => $request['observacao'],
            'jre_motor' => $request['motor'],
            'jre_tempogasto' => $request['tempoGasto'],
            'jre_numarmadilhas' => $numArmadilhas,
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'jre_mreviva' => $request['mareviva'],
            'jre_combustivel' => $combustivel
        );
        
        $insertJerere = $this->dbTableJerere->insert($dadosJerere);
        return $insertJerere;
    }
    
    public function update(array $request)
    {
        $this->dbTableJerere = new Application_Model_DbTable_Jerere();
        
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
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
            'jre_obs' => $request['observacao'],
            'jre_motor' => $request['motor'],
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
        $this->dbTableJerereFundo = new Application_Model_DbTable_Jerere();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableJerereFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableJerereFundo->update($dados, $wherePescador);
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
    
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaJerere();
        $select = $dbTable->select()->
                from('v_entrevista_jerere', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaJerere();
        $select = $dbTable->select()->
                from('v_entrevista_jerere', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaJerere();
        $select = $dbTable->select()->
                from('v_entrevista_jerere', array('pto_nome', 'count(jre_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaJerere();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_jerere', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 'sum(peso) as peso', 'mes', 'ano', 'pesototal'=> new Zend_Db_Expr('((sum(peso)/sum(monitorados))*sum(naomonitorados))+sum(peso)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEstimativaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaJerere();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_jerere', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(peso) as peso', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaJerere();
        $select = $dbTable->select()->
                from('v_entrevista_jerere', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaJerere();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_jerere', 'v_entrevista_jerere.pto_nome')->joinLeft('v_jerere_has_t_especie_capturada', 'v_entrevista_jerere.jre_id = v_jerere_has_t_especie_capturada.jre_id',
                        array('sum(v_jerere_has_t_especie_capturada.spc_quantidade) as quant','sum(v_jerere_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaJerere();
        $select = $dbTable->select()->
                from('v_entrevista_jerere', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaJerere();
        
        $select = $dbTable->select()->
                from('v_entrevista_jerere', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaJerere();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_jerere', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_jerere_has_t_especie_capturada', 'v_entrevista_jerere.jre_id = v_jerere_has_t_especie_capturada.jre_id'
                , array('v_jerere_has_t_especie_capturada.jre_id','cpue'=> new Zend_Db_Expr('sum(v_jerere_has_t_especie_capturada.spc_peso_kg)'), 'v_entrevista_jerere.tl_local','v_entrevista_jerere.pto_nome'))->
                group(array('v_jerere_has_t_especie_capturada.jre_id', "mesAno",'v_entrevista_jerere.tl_local','v_entrevista_jerere.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VJerereHasPesqueiro();
        
        $select = $dbTable->select()->from('v_jerere_has_t_pesqueiro',array('count(jre_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableJerereHasBioPeixe = new Application_Model_DbTable_VJerereHasBioPeixe();
        $select = $this->dbTableJerereHasBioPeixe->select()
                ->from($this->dbTableJerereHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableJerereHasBioPeixe->fetchAll($select)->toArray();
    }

    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableJerereHasBioPeixe = new Application_Model_DbTable_VJerereHasBioPeixe();
        $select = $this->dbTableJerereHasBioPeixe->select()->from($this->dbTableJerereHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableJerereHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableJerereHasBioPeixe = new Application_Model_DbTable_VJerereHasBioPeixe();
        $select = $this->dbTableJerereHasBioPeixe->select()
                ->from($this->dbTableJerereHasBioPeixe,array('x'=>'tbp_peso', 'y'=>'tbp_comprimento'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableJerereHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableJerere = new Application_Model_DbTable_VEntrevistaJerere();
        
        $select = $this->dbTableJerere->select()->
                from($this->dbTableJerere, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableJerere->fetchAll($select)->toArray();
    }
    
    
    public function selectMediaEspecies($where = null, $order = null, $limit = null)
    {
        $this->dbTableJerereMedia = new Application_Model_DbTable_VMediaEspeciesJerere();
        $select = $this->dbTableJerereMedia->select()->
                order($order)->limit($limit);
        if(!is_null($where)){
            $select->where($where);
        }
        return $this->dbTableJerereMedia->fetchAll($select)->toArray();
    }
}

