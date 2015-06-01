<?php

class Application_Model_Ratoeira
{    
   private $dbTableRatoeira;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        $select = $this->dbTableRatoeira->select()
                ->from($this->dbTableRatoeira)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeira->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        $arr = $this->dbTableRatoeira->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        
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
        $dadosRatoeira = array(
            'rat_embarcada' => $request['embarcada'],
            'rat_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'rat_quantpescadores' => $request['numPescadores'],
            'rat_dhvolta' => $timestampVolta,
            'rat_dhsaida' => $timestampSaida, 
            'rat_obs' => $request['observacao'],
            'rat_tempogasto' => $request['tempoGasto'],
            'rat_numarmadilhas' => $numArmadilhas,
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'rat_mreviva' => $request['mareviva'],
            'rat_combustivel' => $combustivel
        );
        
        $insertArrasto = $this->dbTableRatoeira->insert($dadosRatoeira);
        return $insertArrasto;
    }
    
    public function update(array $request)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        
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
        
        $dadosRatoeira = array(
            'mnt_id' => $request['id_monitoramento'],
            'rat_embarcada' => $request['embarcada'],
            'rat_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'rat_quantpescadores' => $request['numPescadores'],
            'rat_dhvolta' => $timestampVolta,
            'rat_dhsaida' => $timestampSaida, 
            'rat_obs' => $request['observacao'],
            'rat_tempogasto' => $request['tempoGasto'],
            'rat_numarmadilhas' => $numArmadilhas,
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'rat_mreviva' => $request['mareviva'],
            'rat_combustivel' => $combustivel
        );
 
        
        $whereRatoeira= $this->dbTableRatoeira->getAdapter()
                ->quoteInto('"rat_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableRatoeira->update($dadosRatoeira, $whereRatoeira);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableArrastoFundo = new Application_Model_DbTable_Ratoeira();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableArrastoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableArrastoFundo->update($dados, $wherePescador);
    }
    public function delete($idRatoeira)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();       
                
        $whereRatoeira= $this->dbTableRatoeira->getAdapter()
                ->quoteInto('"rat_id" = ?', $idRatoeira);
        
        $this->dbTableRatoeira->delete($whereRatoeira);
    }
    public function selectId(){
        $this->dbTableRatoeira = new Application_Model_DbTable_Ratoeira();
        
        $select = $this->dbTableRatoeira->select()
                ->from($this->dbTableRatoeira, 'rat_id')->order('rat_id DESC')->limit('1');
        
        return $this->dbTableRatoeira->fetchAll($select)->toArray();
    }
    public function selectRatoeiraHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableRatoeiraHasPesqueiro = new Application_Model_DbTable_VRatoeiraHasPesqueiro();
        $select = $this->dbTableRatoeiraHasPesqueiro->select()
                ->from($this->dbTableRatoeiraHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeiraHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTRatoeiraHasPesqueiro = new Application_Model_DbTable_RatoeiraHasPesqueiro();
        
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
       
        $dadosPesqueiro = array(
            'rat_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTRatoeiraHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTRatoeiraHasPesqueiro = new Application_Model_DbTable_RatoeiraHasPesqueiro();       
                
        $whereRatoeiraHasPesqueiro = $this->dbTableTRatoeiraHasPesqueiro->getAdapter()
                ->quoteInto('"rat_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTRatoeiraHasPesqueiro->delete($whereRatoeiraHasPesqueiro);
        
    }
    public function selectRatoeiraHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableRatoeiraHasEspCapturada = new Application_Model_DbTable_VRatoeiraHasEspecieCapturada();
        
        $select = $this->dbTableRatoeiraHasEspCapturada->select()
                ->from($this->dbTableRatoeiraHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableRatoeiraHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTRatoeiraHasEspCapturada = new Application_Model_DbTable_RatoeiraHasEspecieCapturada();
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
            'rat_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id'=> $idTipoVenda
        );
        
        $this->dbTableTRatoeiraHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTRatoeiraHasEspCapturada = new Application_Model_DbTable_RatoeiraHasEspecieCapturada();       
                
        $whereRatoeiraHasEspCapturada = $this->dbTableTRatoeiraHasEspCapturada->getAdapter()
                ->quoteInto('"spc_rat_id" = ?', $idEspecie);
        
        $this->dbTableTRatoeiraHasEspCapturada->delete($whereRatoeiraHasEspCapturada);
    }
    public function selectEntrevistaRatoeira($where = null, $order = null, $limit = null)
    {
        $this->dbTableRatoeira = new Application_Model_DbTable_VEntrevistaRatoeira();
        $select = $this->dbTableRatoeira->select()
                ->from($this->dbTableRatoeira)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeira->fetchAll($select)->toArray();
    }
    public function selectRatoeiraHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableRatoeiraAvistamento = new Application_Model_DbTable_VRatoeiraHasAvistamento();
        $selectAvist = $this->dbTableRatoeiraAvistamento->select()
                ->from($this->dbTableRatoeiraAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableRatoeiraAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTRatoeiraHasAvistamento = new Application_Model_DbTable_RatoeiraHasAvistamento();
        
        
        $dadosAvistamento = array(
            'rat_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTRatoeiraHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTRatoeiraHasAvistamento = new Application_Model_DbTable_RatoeiraHasAvistamento();       
                
        $dadosRatoeiraHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'rat_id= ?' => $idEntrevista
        );
        
        $this->dbTableTRatoeiraHasAvistamento->delete($dadosRatoeiraHasAvistamento);
    }
    
 ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableRatoeiraHasBioCamarao = new Application_Model_DbTable_RatoeiraHasBioCamarao();


        $dadosPesqueiro = array(
            'trat_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableRatoeiraHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableRatoeiraHasBioCamarao = new Application_Model_DbTable_VRatoeiraHasBioCamarao();
        $select = $this->dbTableRatoeiraHasBioCamarao->select()
                ->from($this->dbTableRatoeiraHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeiraHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTRatoeiraHasBioCamarao = new Application_Model_DbTable_RatoeiraHasBioCamarao();

        $whereRatoeiraHasBiometria = $this->dbTableTRatoeiraHasBioCamarao->getAdapter()
                ->quoteInto('tratbc_id = ?', $idBiometria);

        $this->dbTableTRatoeiraHasBioCamarao->delete($whereRatoeiraHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableRatoeiraHasBioPeixe = new Application_Model_DbTable_RatoeiraHasBioPeixe();


        $dadosPesqueiro = array(
            'trat_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableRatoeiraHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableRatoeiraHasBioPeixe = new Application_Model_DbTable_VRatoeiraHasBioPeixe();
        $select = $this->dbTableRatoeiraHasBioPeixe->select()
                ->from($this->dbTableRatoeiraHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeiraHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTRatoeiraHasBioPeixe = new Application_Model_DbTable_RatoeiraHasBioPeixe();

        $whereRatoeiraHasBiometria = $this->dbTableTRatoeiraHasBioPeixe->getAdapter()
                ->quoteInto('tratbp_id = ?', $idBiometria);

        $this->dbTableTRatoeiraHasBioPeixe->delete($whereRatoeiraHasBiometria);
        
    }
    
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaRatoeira();
        $select = $dbTable->select()->
                from('v_entrevista_ratoeira', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaRatoeira();
        $select = $dbTable->select()->
                from('v_entrevista_ratoeira', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaRatoeira();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_ratoeira', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 
                    'sum(quantidade) as quant', 'mes', 'ano', 'quanttotal'=> new Zend_Db_Expr('((sum(quantidade)/sum(monitorados))*sum(naomonitorados))+sum(quantidade)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEstimativaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaRatoeira();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_ratoeira', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(quantidade) as quantidade', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    //Quantidade de variaveis por Porto FUNÇÕES PARA REPLICAR
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaRatoeira();
        $select = $dbTable->select()->
                from('v_entrevista_ratoeira', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaRatoeira();
        $select = $dbTable->select()->
                from('v_entrevista_ratoeira', array('pto_nome', 'count(rat_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaRatoeira();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_ratoeira', 'v_entrevista_ratoeira.pto_nome')->joinLeft('v_ratoeira_has_t_especie_capturada', 'v_entrevista_ratoeira.rat_id = v_ratoeira_has_t_especie_capturada.rat_id',
                        array('sum(v_ratoeira_has_t_especie_capturada.spc_quantidade) as quant','sum(v_ratoeira_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaRatoeira();
        $select = $dbTable->select()->
                from('v_entrevista_ratoeira', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaRatoeira();
        
        $select = $dbTable->select()->
                from('v_entrevista_ratoeira', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaRatoeira();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_ratoeira', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_ratoeira_has_t_especie_capturada', 'v_entrevista_ratoeira.rat_id = v_ratoeira_has_t_especie_capturada.rat_id'
                , array('v_ratoeira_has_t_especie_capturada.rat_id','cpue'=> new Zend_Db_Expr('sum(v_ratoeira_has_t_especie_capturada.spc_quantidade)'), 'v_entrevista_ratoeira.tl_local','v_entrevista_ratoeira.pto_nome'))->
                group(array('v_ratoeira_has_t_especie_capturada.rat_id', "mesAno",'v_entrevista_ratoeira.tl_local','v_entrevista_ratoeira.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VRatoeiraHasPesqueiro();
        
        $select = $dbTable->select()->from('v_ratoeira_has_t_pesqueiro',array('count(rat_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableRatoeiraHasBioPeixe = new Application_Model_DbTable_VRatoeiraHasBioPeixe();
        $select = $this->dbTableRatoeiraHasBioPeixe->select()
                ->from($this->dbTableRatoeiraHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableRatoeiraHasBioPeixe->fetchAll($select)->toArray();
    }

    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableRatoeiraHasBioPeixe = new Application_Model_DbTable_VRatoeiraHasBioPeixe();
        $select = $this->dbTableRatoeiraHasBioPeixe->select()->from($this->dbTableRatoeiraHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableRatoeiraHasBioPeixe->fetchAll($select)->toArray();
    }
}


