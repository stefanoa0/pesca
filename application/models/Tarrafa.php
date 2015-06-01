<?php

class Application_Model_Tarrafa
{
    private $dbTableTarrafa;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();
        $select = $this->dbTableTarrafa->select()
                ->from($this->dbTableTarrafa)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafa->fetchAll($select)->toArray();
    }

    public function find($id)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();
        $arr = $this->dbTableTarrafa->find($id)->toArray();
        return $arr[0];
    }

    public function insert(array $request)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();

        
        $roda = $request['roda'];
        $altura = $request['altura'];
        $numLances = $request['numLances'];
        $malha = $request['malha'];

        if(empty($roda)){
            $roda = NULL;
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


        $dadosTarrafa = array(
            'tar_embarcado' => $request['embarcada'],
            'tar_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'tar_quantpescadores' => $request['numPescadores'],
            'tar_data' => $request['data'],
            'tar_tempogasto' => $request['tempoGasto'],
            'tar_roda' => $roda,
            'tar_altura' => $altura,
            'tar_malha' => $malha,
            'tar_numlances' => $numLances,
            'tar_obs' => $request['observacao'],
            'dp_id' => $request['destinoPescado'],
            'mnt_id' => $request['id_monitoramento']
        );

        $insertTarrafa = $this->dbTableTarrafa->insert($dadosTarrafa);
        return $insertTarrafa;
    }

    public function update(array $request)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();

        
        $roda = $request['roda'];
        $altura = $request['altura'];
        $numLances = $request['numLances'];
        $malha = $request['malha'];

        if(empty($roda)){
            $roda = NULL;
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


        $dadosTarrafa = array(
            'mnt_id' => $request['id_monitoramento'],
            'tar_embarcado' => $request['embarcada'],
            'tar_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'tar_quantpescadores' => $request['numPescadores'],
            'tar_data' => $request['data'],
            'tar_tempogasto' => $request['tempoGasto'],
            'tar_roda' => $roda,
            'tar_altura' => $altura,
            'tar_malha' => $malha,
            'tar_numlances' => $numLances,
            'dp_id' => $request['destinoPescado'],
            'tar_obs' => $request['observacao'],
        );


        $whereTarrafa= $this->dbTableTarrafa->getAdapter()
                ->quoteInto('"tar_id" = ?', $request['id_entrevista']);


        $this->dbTableTarrafa->update($dadosTarrafa, $whereTarrafa);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableTarrafaFundo = new Application_Model_DbTable_Tarrafa();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableTarrafaFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableTarrafaFundo->update($dados, $wherePescador);
    }
    public function delete($idTarrafa)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();

        $whereTarrafa= $this->dbTableTarrafa->getAdapter()
                ->quoteInto('"tar_id" = ?', $idTarrafa);

        $this->dbTableTarrafa->delete($whereTarrafa);
    }
    public function selectId(){
        $this->dbTableTarrafa = new Application_Model_DbTable_Tarrafa();

        $select = $this->dbTableTarrafa->select()
                ->from($this->dbTableTarrafa, 'tar_id')->order('tar_id DESC')->limit('1');

        return $this->dbTableTarrafa->fetchAll($select)->toArray();
    }
    public function selectTarrafaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_VTarrafaHasPesqueiro();
        $select = $this->dbTableTarrafa->select()
                ->from($this->dbTableTarrafa)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafa->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro)
    {
        $this->dbTableTTarrafa = new Application_Model_DbTable_TarrafaHasPesqueiro();


        $dadosPesqueiro = array(
            'tar_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
        );

        $this->dbTableTTarrafa->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTTarrafa = new Application_Model_DbTable_TarrafaHasPesqueiro();

        $whereTarrafaHasPesqueiro = $this->dbTableTTarrafa->getAdapter()
                ->quoteInto('"tar_paf_id" = ?', $idPesqueiro);

        $this->dbTableTTarrafa->delete($whereTarrafaHasPesqueiro);
    }
    public function selectTarrafaHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableTarrafaHasEspCapturada = new Application_Model_DbTable_VTarrafaHasEspecieCapturada();

        $select = $this->dbTableTarrafaHasEspCapturada->select()
                ->from($this->dbTableTarrafaHasEspCapturada)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTTarrafaHasEspCapturada = new Application_Model_DbTable_TarrafaHasEspecieCapturada();

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
            'tar_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );

        $this->dbTableTTarrafaHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTTarrafaHasEspCapturada = new Application_Model_DbTable_TarrafaHasEspecieCapturada();

        $whereTarrafaHasEspCapturada = $this->dbTableTTarrafaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_tar_id" = ?', $idEspecie);

        $this->dbTableTTarrafaHasEspCapturada->delete($whereTarrafaHasEspCapturada);
    }
    public function selectEntrevistaTarrafa($where = null, $order = null, $limit = null)
    {
        $this->dbTableTarrafa = new Application_Model_DbTable_VEntrevistaTarrafa();
        $select = $this->dbTableTarrafa->select()
                ->from($this->dbTableTarrafa)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafa->fetchAll($select)->toArray();
    }
    public function selectTarrafaHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableTarrafaAvistamento = new Application_Model_DbTable_VTarrafaHasAvistamento();
        $selectAvist = $this->dbTableTarrafaAvistamento->select()
                ->from($this->dbTableTarrafaAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableTarrafaAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTTarrafaHasAvistamento = new Application_Model_DbTable_TarrafaHasAvistamento();


        $dadosAvistamento = array(
            'tar_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );

        $this->dbTableTTarrafaHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTTarrafaHasAvistamento = new Application_Model_DbTable_TarrafaHasAvistamento();

        $dadosTarrafaHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'tar_id= ?' => $idEntrevista
        );

        $this->dbTableTTarrafaHasAvistamento->delete($dadosTarrafaHasAvistamento);
    }
    
        ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableTarrafaHasBioCamarao = new Application_Model_DbTable_TarrafaHasBioCamarao();


        $dadosPesqueiro = array(
            'ttar_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableTarrafaHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableTarrafaHasBioCamarao = new Application_Model_DbTable_VTarrafaHasBioCamarao();
        $select = $this->dbTableTarrafaHasBioCamarao->select()
                ->from($this->dbTableTarrafaHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafaHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTTarrafaHasBioCamarao = new Application_Model_DbTable_TarrafaHasBioCamarao();

        $whereTarrafaHasBiometria = $this->dbTableTTarrafaHasBioCamarao->getAdapter()
                ->quoteInto('ttarbc_id = ?', $idBiometria);

        $this->dbTableTTarrafaHasBioCamarao->delete($whereTarrafaHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableTarrafaHasBioPeixe = new Application_Model_DbTable_TarrafaHasBioPeixe();


        $dadosPesqueiro = array(
            'ttar_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableTarrafaHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableTarrafaHasBioPeixe = new Application_Model_DbTable_VTarrafaHasBioPeixe();
        $select = $this->dbTableTarrafaHasBioPeixe->select()
                ->from($this->dbTableTarrafaHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafaHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTTarrafaHasBioPeixe = new Application_Model_DbTable_TarrafaHasBioPeixe();

        $whereTarrafaHasBiometria = $this->dbTableTTarrafaHasBioPeixe->getAdapter()
                ->quoteInto('ttarbp_id = ?', $idBiometria);

        $this->dbTableTTarrafaHasBioPeixe->delete($whereTarrafaHasBiometria);
        
    }
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaTarrafa();
        $select = $dbTable->select()->
                from('v_entrevista_tarrafa', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaTarrafa();
        $select = $dbTable->select()->
                from('v_entrevista_tarrafa', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaTarrafa();
        $select = $dbTable->select()->
                from('v_entrevista_tarrafa', array('pto_nome', 'count(tar_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaTarrafa();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_tarrafa', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 'sum(peso) as peso', 'mes', 'ano', 'pesototal'=> new Zend_Db_Expr('((sum(peso)/sum(monitorados))*sum(naomonitorados))+sum(peso)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEstimativaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaTarrafa();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_tarrafa', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(peso) as peso', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    //Quantidade de variaveis por Porto FUNÇÕES PARA REPLICAR
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaTarrafa();
        $select = $dbTable->select()->
                from('v_entrevista_tarrafa', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaTarrafa();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_tarrafa', 'v_entrevista_tarrafa.pto_nome')->joinLeft('v_tarrafa_has_t_especie_capturada', 'v_entrevista_tarrafa.tar_id = v_tarrafa_has_t_especie_capturada.tar_id',
                        array('sum(v_tarrafa_has_t_especie_capturada.spc_quantidade) as quant','sum(v_tarrafa_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaTarrafa();
        $select = $dbTable->select()->
                from('v_entrevista_tarrafa', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaTarrafa();
        
        $select = $dbTable->select()->
                from('v_entrevista_tarrafa', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaTarrafa();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_tarrafa', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, tar_data) as varchar)) || '/' || (cast(date_part('year'::text, tar_data) as varchar))")))->
                joinLeft('v_tarrafa_has_t_especie_capturada', 'v_entrevista_tarrafa.tar_id = v_tarrafa_has_t_especie_capturada.tar_id'
                , array('v_tarrafa_has_t_especie_capturada.tar_id','cpue'=> new Zend_Db_Expr('sum(v_tarrafa_has_t_especie_capturada.spc_peso_kg)'), 'v_entrevista_tarrafa.tl_local','v_entrevista_tarrafa.pto_nome'))->
                group(array('v_tarrafa_has_t_especie_capturada.tar_id', "mesAno",'v_entrevista_tarrafa.tl_local','v_entrevista_tarrafa.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VTarrafaHasPesqueiro();
        
        $select = $dbTable->select()->from('v_tarrafa_has_t_pesqueiro',array('count(tar_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableTarrafaHasBioPeixe = new Application_Model_DbTable_VTarrafaHasBioPeixe();
        $select = $this->dbTableTarrafaHasBioPeixe->select()
                ->from($this->dbTableTarrafaHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableTarrafaHasBioPeixe->fetchAll($select)->toArray();
    }

    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableTarrafaHasBioPeixe = new Application_Model_DbTable_VTarrafaHasBioPeixe();
        $select = $this->dbTableTarrafaHasBioPeixe->select()->from($this->dbTableTarrafaHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableTarrafaHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableTarrafa = new Application_Model_DbTable_VEntrevistaTarrafa();
        
        $select = $this->dbTableTarrafa->select()->
                from($this->dbTableTarrafa, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableTarrafa->fetchAll($select)->toArray();
    }
}
