<?php
/** 
 * Model Arte de Pesca - Manzuá
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */
class Application_Model_Manzua
{    
   private $dbTableManzua;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        $select = $this->dbTableManzua->select()
                ->from($this->dbTableManzua)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzua->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        $arr = $this->dbTableManzua->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        
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
        $dadosManzua = array(
            'man_embarcada' => $request['embarcada'],
            'man_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'man_quantpescadores' => $request['numPescadores'],
            'man_dhvolta' => $timestampVolta,
            'man_dhsaida' => $timestampSaida, 
            'dp_id' => $request['destinoPescado'],
            'man_obs' => $request['observacao'],
            'man_tempogasto' => $request['tempoGasto'],
            'man_numarmadilhas' => $numArmadilhas,
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'man_mreviva' => $request['mareviva'],
            'man_combustivel' => $combustivel
        );
        
        $insertManzua = $this->dbTableManzua->insert($dadosManzua);
        return $insertManzua;
    }
    
    public function update(array $request)
    {
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        
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
        
        $dadosManzua = array(
            'mnt_id' => $request['id_monitoramento'],
            'man_embarcada' => $request['embarcada'],
            'man_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'man_quantpescadores' => $request['numPescadores'],
            'man_dhvolta' => $timestampVolta,
            'man_dhsaida' => $timestampSaida,  
            'man_obs' => $request['observacao'],
            'man_tempogasto' => $request['tempoGasto'],
            'man_numarmadilhas' => $numArmadilhas,
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'man_mreviva' => $request['mareviva'],
            'man_combustivel' => $combustivel
        );
        $whereManzua= $this->dbTableManzua->getAdapter()
                ->quoteInto('"man_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableManzua->update($dadosManzua, $whereManzua);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableManzuaFundo = new Application_Model_DbTable_Manzua();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableManzuaFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableManzuaFundo->update($dados, $wherePescador);
    }
    public function delete($idManzua)
    {
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();       
                
        $whereManzua= $this->dbTableManzua->getAdapter()
                ->quoteInto('"man_id" = ?', $idManzua);
        
        $this->dbTableManzua->delete($whereManzua);
    }
    public function selectId(){
        $this->dbTableManzua = new Application_Model_DbTable_Manzua();
        
        $select = $this->dbTableManzua->select()
                ->from($this->dbTableManzua, 'man_id')->order('man_id DESC')->limit('1');
        
        return $this->dbTableManzua->fetchAll($select)->toArray();
    }
    public function selectManzuaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableManzuaHasPesqueiro = new Application_Model_DbTable_VManzuaHasPesqueiro();
        $select = $this->dbTableManzuaHasPesqueiro->select()
                ->from($this->dbTableManzuaHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzuaHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTManzuaHasPesqueiro = new Application_Model_DbTable_ManzuaHasPesqueiro();
        
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        $dadosPesqueiro = array(
            'man_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTManzuaHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTManzuaHasPesqueiro = new Application_Model_DbTable_ManzuaHasPesqueiro();       
                
        $whereManzuaHasPesqueiro = $this->dbTableTManzuaHasPesqueiro->getAdapter()
                ->quoteInto('"man_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTManzuaHasPesqueiro->delete($whereManzuaHasPesqueiro);
        
    }
     public function updatePesqueiro($idEntrevistaPesqueiro,$idEntrevista,$pesqueiro, $tempoapesqueiro, $distapesqueiro)
    {
        $this->dbTableTManzuaHasPesqueiro = new Application_Model_DbTable_ManzuaHasPesqueiro();

        if(empty($tempoapesqueiro)){  $tempoapesqueiro = null;}
        $dadosPesqueiro = array(
            'man_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoapesqueiro,
            't_distapesqueiro' => $distapesqueiro
        );

        $wherePescador = $this->dbTableTManzuaHasPesqueiro->getAdapter()
                ->quoteInto('"man_paf_id" = ?', $idEntrevistaPesqueiro);


        $this->dbTableTManzuaHasPesqueiro->update($dadosPesqueiro, $wherePescador);
    }
    
    public function selectManzuaHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableManzuaHasEspCapturada = new Application_Model_DbTable_VManzuaHasEspecieCapturada();
        
        $select = $this->dbTableManzuaHasEspCapturada->select()
                ->from($this->dbTableManzuaHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableManzuaHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg , $idTipoVenda)
    {
        $this->dbTableTManzuaHasEspCapturada = new Application_Model_DbTable_ManzuaHasEspecieCapturada();
        
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
            'man_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda
        );
        
        $this->dbTableTManzuaHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTManzuaHasEspCapturada = new Application_Model_DbTable_ManzuaHasEspecieCapturada();       
                
        $whereManzuaHasEspCapturada = $this->dbTableTManzuaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_man_id" = ?', $idEspecie);
        
        $this->dbTableTManzuaHasEspCapturada->delete($whereManzuaHasEspCapturada);
    }
    public function updateEspCapturada($idEntrevistaEspecie,$idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTManzuaHasEspCapturada = new Application_Model_DbTable_ManzuaHasEspecieCapturada();

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
            'man_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda
        );

        $wherePescador = $this->dbTableTManzuaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_man_id" = ?', $idEntrevistaEspecie);


        $this->dbTableTManzuaHasEspCapturada->update($dadosEspecie, $wherePescador);
    }
    
    
    public function selectEntrevistaManzua($where = null, $order = null, $limit = null)
    {
        $this->dbTableManzua = new Application_Model_DbTable_VEntrevistaManzua();
        $select = $this->dbTableManzua->select()
                ->from($this->dbTableManzua)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzua->fetchAll($select)->toArray();
    }
    public function selectManzuaHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableManzuaAvistamento = new Application_Model_DbTable_VManzuaHasAvistamento();
        $selectAvist = $this->dbTableManzuaAvistamento->select()
                ->from($this->dbTableManzuaAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableManzuaAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTManzuaHasAvistamento = new Application_Model_DbTable_ManzuaHasAvistamento();
        
        
        $dadosAvistamento = array(
            'man_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTManzuaHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTManzuaHasAvistamento = new Application_Model_DbTable_ManzuaHasAvistamento();       
                
        $dadosManzuaHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'man_id= ?' => $idEntrevista
        );
        
        $this->dbTableTManzuaHasAvistamento->delete($dadosManzuaHasAvistamento);
    }
    
        ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableManzuaHasBioCamarao = new Application_Model_DbTable_ManzuaHasBioCamarao();


        $dadosPesqueiro = array(
            'tman_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableManzuaHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableManzuaHasBioCamarao = new Application_Model_DbTable_VManzuaHasBioCamarao();
        $select = $this->dbTableManzuaHasBioCamarao->select()
                ->from($this->dbTableManzuaHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzuaHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function updateBioCamarao($idEntrevistaCamarao,$idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso) {
        $this->dbTableManzuaHasBioCamarao = new Application_Model_DbTable_ManzuaHasBioCamarao();
        $dadosPesqueiro = array( 'tman_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbc_sexo' => $sexo, 'tmat_id' => $maturidade, 'tbc_comprimento_cabeca' => $compCabeca, 'tbc_peso' => $peso );
        $wherePescador = $this->dbTableManzuaHasBioCamarao->getAdapter() ->quoteInto('"tmanbc_id" = ?', $idEntrevistaCamarao);
        $this->dbTableManzuaHasBioCamarao->update($dadosPesqueiro, $wherePescador);
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTManzuaHasBioCamarao = new Application_Model_DbTable_ManzuaHasBioCamarao();

        $whereManzuaHasBiometria = $this->dbTableTManzuaHasBioCamarao->getAdapter()
                ->quoteInto('tmanbc_id = ?', $idBiometria);

        $this->dbTableTManzuaHasBioCamarao->delete($whereManzuaHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableManzuaHasBioPeixe = new Application_Model_DbTable_ManzuaHasBioPeixe();


        $dadosPesqueiro = array(
            'tman_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableManzuaHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableManzuaHasBioPeixe = new Application_Model_DbTable_VManzuaHasBioPeixe();
        $select = $this->dbTableManzuaHasBioPeixe->select()
                ->from($this->dbTableManzuaHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzuaHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTManzuaHasBioPeixe = new Application_Model_DbTable_ManzuaHasBioPeixe();

        $whereManzuaHasBiometria = $this->dbTableTManzuaHasBioPeixe->getAdapter()
                ->quoteInto('tmanbp_id = ?', $idBiometria);

        $this->dbTableTManzuaHasBioPeixe->delete($whereManzuaHasBiometria);
        
    }
    public function updateBioPeixe($idEntrevistaPeixe, $idEntrevista, $idEspecie,$sexo, $comprimento, $peso) {
	$this->dbTableManzuaHasBioPeixe = new Application_Model_DbTable_ManzuaHasBioPeixe();
	$dadosPesqueiro = array( 'tman_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbp_sexo' => $sexo, 'tbp_comprimento' => $comprimento, 'tbp_peso' => $peso );
	$wherePescador = $this->dbTableManzuaHasBioPeixe->getAdapter() ->quoteInto('"tmanbp_id" = ?', $idEntrevistaPeixe);
	$this->dbTableManzuaHasBioPeixe->update($dadosPesqueiro, $wherePescador);
    }
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaManzua();
        $select = $dbTable->select()->
                from('v_entrevista_manzua', array('pto_nome', 'count(tp_nome)'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaManzua();
        $select = $dbTable->select()->
                from('v_entrevista_manzua', array('pto_nome', 'count(bar_nome)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaManzua();
        $select = $dbTable->select()->
                from('v_entrevista_manzua', array('pto_nome', 'count(man_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaManzua();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_manzua', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 'sum(peso) as peso', 'mes', 'ano', 'pesototal'=> new Zend_Db_Expr('((sum(peso)/sum(monitorados))*sum(naomonitorados))+sum(peso)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEstimativaByPorto($where = null,$order=null,$limit=null){
        $dbTable = new Application_Model_DbTable_VEstimativaManzua();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_manzua', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(peso) as peso', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    //Quantidade de variaveis por Porto FUNÇÕES PARA REPLICAR
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaManzua();
        $select = $dbTable->select()->
                from('v_entrevista_manzua', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaManzua();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_manzua', 'v_entrevista_manzua.pto_nome')->joinLeft('v_manzua_has_t_especie_capturada', 'v_entrevista_manzua.man_id = v_manzua_has_t_especie_capturada.man_id',
                        array('sum(v_manzua_has_t_especie_capturada.spc_quantidade) as quant','sum(v_manzua_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaManzua();
        $select = $dbTable->select()->
                from('v_entrevista_manzua', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaManzua();
        
        $select = $dbTable->select()->
                from('v_entrevista_manzua', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaManzua();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_manzua', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_manzua_has_t_especie_capturada', 'v_entrevista_manzua.man_id = v_manzua_has_t_especie_capturada.man_id'
                , array('v_manzua_has_t_especie_capturada.man_id','cpue'=> new Zend_Db_Expr('sum(v_manzua_has_t_especie_capturada.spc_peso_kg)'), 'v_entrevista_manzua.tl_local','v_entrevista_manzua.pto_nome'))->
                group(array('v_manzua_has_t_especie_capturada.man_id', "mesAno",'v_entrevista_manzua.tl_local','v_entrevista_manzua.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VManzuaHasPesqueiro();
        
        $select = $dbTable->select()->from('v_manzua_has_t_pesqueiro',array('count(man_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableManzuaHasBioPeixe = new Application_Model_DbTable_VManzuaHasBioPeixe();
        $select = $this->dbTableManzuaHasBioPeixe->select()
                ->from($this->dbTableManzuaHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzuaHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableManzuaHasBioPeixe = new Application_Model_DbTable_VManzuaHasBioPeixe();
        $select = $this->dbTableManzuaHasBioPeixe->select()
                ->from($this->dbTableManzuaHasBioPeixe,array('x'=>'tbp_comprimento', 'y'=>'tbp_peso'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableManzuaHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableManzuaHasBioPeixe = new Application_Model_DbTable_VManzuaHasBioPeixe();
        $select = $this->dbTableManzuaHasBioPeixe->select()->from($this->dbTableManzuaHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableManzuaHasBioPeixe->fetchAll($select)->toArray();
    }
    
    
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableManzua = new Application_Model_DbTable_VEntrevistaManzua();
        
        $select = $this->dbTableManzua->select()->
                from($this->dbTableManzua, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableManzua->fetchAll($select)->toArray();
    }
    
    public function selectMediaEspecies($where = null, $order = null, $limit = null)
    {
        $this->dbTableManzuaMedia = new Application_Model_DbTable_VMediaEspeciesManzua();
        $select = $this->dbTableManzuaMedia->select()->
                order($order)->limit($limit);
        if(!is_null($where)){
            $select->where($where);
        }
        return $this->dbTableManzuaMedia->fetchAll($select)->toArray();
    }
    
    public function selectAvistamentoByTipo($where = null, $limit = null)
    {
 
        $this->dbTableManzuaAvistamento = new Application_Model_DbTable_VManzuaHasAvistamento();
        $selectAvist = $this->dbTableManzuaAvistamento->select()->group('avs_descricao')
                ->from($this->dbTableManzuaAvistamento, array('quantAvist' => 'count(*)','avs_descricao'))->order('quantAvist DESC')->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableManzuaAvistamento->fetchAll($selectAvist)->toArray();
    }
}

