<?php

class Application_Model_Mergulho
{
private $dbTableMergulho;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        $select = $this->dbTableMergulho->select()
                ->from($this->dbTableMergulho)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulho->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        $arr = $this->dbTableMergulho->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
       
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        
        $mareViva = $request['mareviva'];
        if($mareViva=='1'){
            $mareViva = true;
        }
        else {
            $mareViva = false;
        }
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
        }
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        $dadosMergulho = array(
            'mer_embarcada' => $request['embarcada'],
            'mer_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'mer_quantpescadores' => $request['numPescadores'],
            'mer_dhsaida' => $timestampSaida,
            'mer_dhvolta' => $timestampVolta,
            'mer_tempogasto' => $request['tempoGasto'],
            'mer_obs' => $request['observacao'],
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'mer_mreviva' => $request['mareviva'],
            'mer_combustivel' => $combustivel
        );
        
        $insertMergulho = $this->dbTableMergulho->insert($dadosMergulho);
        return $insertMergulho;
    }
    
    public function update(array $request)
    {
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        
        
        $combustivel = $request['combustivel'];
        if(empty($combustivel)){
            $combustivel = null;
        }
        
        $mareViva = $request['mareviva'];
        if($mareViva=='1'){
            $mareViva = true;
        }
        else {
            $mareViva = false;
        }
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        $dadosMergulho = array(
            'mnt_id' => $request['id_monitoramento'],
            'mer_embarcada' => $request['embarcada'],
            'mer_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'mer_quantpescadores' => $request['numPescadores'],
            'mer_dhsaida' => $timestampSaida,
            'mer_dhvolta' => $timestampVolta,
            'mer_tempogasto' => $request['tempoGasto'],
            'mer_obs' => $request['observacao'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'mer_mreviva' => $request['mareviva'],
            'mer_combustivel' => $combustivel
        );
 
        
        $whereMergulho= $this->dbTableMergulho->getAdapter()
                ->quoteInto('"mer_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableMergulho->update($dadosMergulho, $whereMergulho);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableMergulhoFundo = new Application_Model_DbTable_Mergulho();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableMergulhoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableMergulhoFundo->update($dados, $wherePescador);
    }
    public function delete($idMergulho)
    {
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();       
                
        $whereMergulho= $this->dbTableMergulho->getAdapter()
                ->quoteInto('"mer_id" = ?', $idMergulho);
        
        $this->dbTableMergulho->delete($whereMergulho);
    }
    public function selectId(){
        $this->dbTableMergulho = new Application_Model_DbTable_Mergulho();
        
        $select = $this->dbTableMergulho->select()
                ->from($this->dbTableMergulho, 'mer_id')->order('mer_id DESC')->limit('1');
        
        return $this->dbTableMergulho->fetchAll($select)->toArray();
    }
    
    
    public function selectMergulhoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableMergulhoHasPesqueiro = new Application_Model_DbTable_VMergulhoHasPesqueiro();
        $select = $this->dbTableMergulhoHasPesqueiro->select()
                ->from($this->dbTableMergulhoHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulhoHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTMergulhoHasPesqueiro = new Application_Model_DbTable_MergulhoHasPesqueiro();
        
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        $dadosPesqueiro = array(
            'mer_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTMergulhoHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTMergulhoHasPesqueiro = new Application_Model_DbTable_MergulhoHasPesqueiro();       
                
        $whereMergulhoHasPesqueiro = $this->dbTableTMergulhoHasPesqueiro->getAdapter()
                ->quoteInto('"mer_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTMergulhoHasPesqueiro->delete($whereMergulhoHasPesqueiro);
        
    }
    public function selectMergulhoHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableMergulhoHasEspCapturada = new Application_Model_DbTable_VMergulhoHasEspecieCapturada();
        
        $select = $this->dbTableMergulhoHasEspCapturada->select()
                ->from($this->dbTableMergulhoHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableMergulhoHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTMergulhoHasEspCapturada = new Application_Model_DbTable_MergulhoHasEspecieCapturada();
        
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
            'mer_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' =>$idTipoVenda
        );
        
        $this->dbTableTMergulhoHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTMergulhoHasEspCapturada = new Application_Model_DbTable_MergulhoHasEspecieCapturada();       
                
        $whereMergulhoHasEspCapturada = $this->dbTableTMergulhoHasEspCapturada->getAdapter()
                ->quoteInto('"spc_mer_id" = ?', $idEspecie);
        
        $this->dbTableTMergulhoHasEspCapturada->delete($whereMergulhoHasEspCapturada);
    }
    public function selectEntrevistaMergulho($where = null, $order = null, $limit = null)
    {
        $this->dbTableMergulho = new Application_Model_DbTable_VEntrevistaMergulho();
        $select = $this->dbTableMergulho->select()
                ->from($this->dbTableMergulho)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulho->fetchAll($select)->toArray();
    }
    public function selectMergulhoHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableMergulhoAvistamento = new Application_Model_DbTable_VMergulhoHasAvistamento();
        $selectAvist = $this->dbTableMergulhoAvistamento->select()
                ->from($this->dbTableMergulhoAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableMergulhoAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTMergulhoHasAvistamento = new Application_Model_DbTable_MergulhoHasAvistamento();
        
        
        $dadosAvistamento = array(
            'mer_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTMergulhoHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTMergulhoHasAvistamento = new Application_Model_DbTable_MergulhoHasAvistamento();       
                
        $dadosMergulhoHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'mer_id= ?' => $idEntrevista
        );
        
        $this->dbTableTMergulhoHasAvistamento->delete($dadosMergulhoHasAvistamento);
    }
    
////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableMergulhoHasBioCamarao = new Application_Model_DbTable_MergulhoHasBioCamarao();


        $dadosPesqueiro = array(
            'tmer_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableMergulhoHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableMergulhoHasBioCamarao = new Application_Model_DbTable_VMergulhoHasBioCamarao();
        $select = $this->dbTableMergulhoHasBioCamarao->select()
                ->from($this->dbTableMergulhoHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulhoHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTMergulhoHasBioCamarao = new Application_Model_DbTable_MergulhoHasBioCamarao();

        $whereMergulhoHasBiometria = $this->dbTableTMergulhoHasBioCamarao->getAdapter()
                ->quoteInto('tmerbc_id = ?', $idBiometria);

        $this->dbTableTMergulhoHasBioCamarao->delete($whereMergulhoHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableMergulhoHasBioPeixe = new Application_Model_DbTable_MergulhoHasBioPeixe();


        $dadosPesqueiro = array(
            'tmer_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableMergulhoHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableMergulhoHasBioPeixe = new Application_Model_DbTable_VMergulhoHasBioPeixe();
        $select = $this->dbTableMergulhoHasBioPeixe->select()
                ->from($this->dbTableMergulhoHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulhoHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTMergulhoHasBioPeixe = new Application_Model_DbTable_MergulhoHasBioPeixe();

        $whereMergulhoHasBiometria = $this->dbTableTMergulhoHasBioPeixe->getAdapter()
                ->quoteInto('tmerbp_id = ?', $idBiometria);

        $this->dbTableTMergulhoHasBioPeixe->delete($whereMergulhoHasBiometria);
        
    }
    
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaMergulho();
        $select = $dbTable->select()->
                from('v_entrevista_mergulho', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaMergulho();
        $select = $dbTable->select()->
                from('v_entrevista_mergulho', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaMergulho();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_mergulho', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 
                    'sum(peso) as peso', 'mes', 'ano', 'pesototal'=> new Zend_Db_Expr('((sum(peso)/sum(monitorados))*sum(naomonitorados))+sum(quantidade)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEstimativaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaMergulho();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_mergulho', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(peso) as peso', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    //Quantidade de variaveis por Porto FUNÇÕES PARA REPLICAR
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaMergulho();
        $select = $dbTable->select()->
                from('v_entrevista_mergulho', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaMergulho();
        $select = $dbTable->select()->
                from('v_entrevista_mergulho', array('pto_nome', 'count(mer_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaMergulho();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_mergulho', 'v_entrevista_mergulho.pto_nome')->joinLeft('v_mergulho_has_t_especie_capturada', 'v_entrevista_mergulho.mer_id = v_mergulho_has_t_especie_capturada.mer_id',
                        array('sum(v_mergulho_has_t_especie_capturada.spc_quantidade) as quant','sum(v_mergulho_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaMergulho();
        $select = $dbTable->select()->
                from('v_entrevista_mergulho', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaMergulho();
        
        $select = $dbTable->select()->
                from('v_entrevista_mergulho', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaMergulho();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_mergulho', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_mergulho_has_t_especie_capturada', 'v_entrevista_mergulho.mer_id = v_mergulho_has_t_especie_capturada.mer_id'
                , array('v_mergulho_has_t_especie_capturada.mer_id','cpue'=> new Zend_Db_Expr('sum(v_mergulho_has_t_especie_capturada.spc_peso_kg)'), 'v_entrevista_mergulho.tl_local','v_entrevista_mergulho.pto_nome'))->
                group(array('v_mergulho_has_t_especie_capturada.mer_id', "mesAno",'v_entrevista_mergulho.tl_local','v_entrevista_mergulho.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VMergulhoHasPesqueiro();
        
        $select = $dbTable->select()->from('v_mergulho_has_t_pesqueiro',array('count(mer_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableMergulhoHasBioPeixe = new Application_Model_DbTable_VMergulhoHasBioPeixe();
        $select = $this->dbTableMergulhoHasBioPeixe->select()
                ->from($this->dbTableMergulhoHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulhoHasBioPeixe->fetchAll($select)->toArray();
    }

    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableMergulhoHasBioPeixe = new Application_Model_DbTable_VMergulhoHasBioPeixe();
        $select = $this->dbTableMergulhoHasBioPeixe->select()->from($this->dbTableMergulhoHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableMergulhoHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableMergulhoHasBioPeixe = new Application_Model_DbTable_VMergulhoHasBioPeixe();
        $select = $this->dbTableMergulhoHasBioPeixe->select()
                ->from($this->dbTableMergulhoHasBioPeixe,array('x'=>'tbp_peso', 'y'=>'tbp_comprimento'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableMergulhoHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableMergulho = new Application_Model_DbTable_VEntrevistaMergulho();
        
        $select = $this->dbTableMergulho->select()->
                from($this->dbTableMergulho, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableMergulho->fetchAll($select)->toArray();
    }
}
