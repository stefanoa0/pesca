<?php
/** 
 * Model Arte de Pesca - Linha de Fundo
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_LinhaFundo
{    private $dbTableLinhaFundo;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        $select = $this->dbTableLinhaFundo->select()
                ->from($this->dbTableLinhaFundo)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundo->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        $arr = $this->dbTableLinhaFundo->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }

        $diesel = $request['diesel'];
        $oleo = $request['oleo'];
        $alimento = $request['alimento'];
        $gelo = $request['gelo'];
        
        $numLinhas = $request['numLinhas'];
        $numAnzois = $request['numAnzois'];
        
        if(empty($numLinhas)){
            $numLinhas = NULL;
        }
        if(empty($numAnzois)){
            $numAnzois = NULL;
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
        
        
        $dadosLinhaFundo = array(
            'lf_embarcada' => $request['embarcada'],
            'lf_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'lf_quantpescadores' => $request['numPescadores'],
            'lf_dhvolta' => $timestampVolta,
            'lf_dhsaida' => $timestampSaida, 
            'lf_tempogasto' => $request['tempoGasto'],
            'lf_diesel' => $diesel,
            'lf_oleo' => $oleo,
            'lf_alimento' => $alimento,
            'lf_gelo' => $gelo,
            'lf_obs' => $request['observacao'],
            'lf_numanzoisplinha' => $numAnzois,
            'lf_numlinhas' => $numLinhas,
            'isc_id' => $request['isca'],
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'lf_mreviva' => $request['mareviva']
        );
        
        $insertLinhaFundo = $this->dbTableLinhaFundo->insert($dadosLinhaFundo);
        return $insertLinhaFundo;
    }
    
    public function update(array $request)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        
        $timestampSaida = $request['dataSaida']." ".$request['horaSaida'];
        $timestampVolta = $request['dataVolta']." ".$request['horaVolta'];
        
        if($timestampSaida > $timestampVolta){
            $timestampVolta = 'Erro';
        }
        
        $diesel = $request['diesel'];
        $oleo = $request['oleo'];
        $alimento = $request['alimento'];
        $gelo = $request['gelo'];
        
        $numLinhas = $request['numLinhas'];
        $numAnzois = $request['numAnzois'];
        
        if(empty($numLinhas)){
            $numLinhas = NULL;
        }
        if(empty($numAnzois)){
            $numAnzois = NULL;
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
        
        
        $dadosLinhaFundo = array(
            'mnt_id' => $request['id_monitoramento'],
            'lf_embarcada' => $request['embarcada'],
            'lf_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'lf_quantpescadores' => $request['numPescadores'],
            'lf_dhvolta' => $timestampVolta,
            'lf_dhsaida' => $timestampSaida, 
            'lf_tempogasto' => $request['tempoGasto'],
            'lf_diesel' => $diesel,
            'lf_oleo' => $oleo,
            'lf_alimento' => $alimento,
            'lf_gelo' => $gelo,
            'lf_obs' => $request['observacao'],
            'lf_numanzoisplinha' => $numAnzois,
            'lf_numlinhas' => $numLinhas,
            'isc_id' => $request['isca'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'lf_mreviva' => $request['mareviva']
        );
        $whereLinhaFundo= $this->dbTableLinhaFundo->getAdapter()
                ->quoteInto('"lf_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableLinhaFundo->update($dadosLinhaFundo, $whereLinhaFundo);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableLinhaFundoFundo = new Application_Model_DbTable_LinhaFundoFundo();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableLinhaFundoFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableLinhaFundoFundo->update($dados, $wherePescador);
    }
    public function delete($idLinhaFundo)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();       
                
        $whereLinhaFundo= $this->dbTableLinhaFundo->getAdapter()
                ->quoteInto('"lf_id" = ?', $idLinhaFundo);
        
        $this->dbTableLinhaFundo->delete($whereLinhaFundo);
    }
    public function selectId(){
        $this->dbTableLinhaFundo = new Application_Model_DbTable_LinhaFundo();
        
        $select = $this->dbTableLinhaFundo->select()
                ->from($this->dbTableLinhaFundo, 'lf_id')->order('lf_id DESC')->limit('1');
        
        return $this->dbTableLinhaFundo->fetchAll($select)->toArray();
    }
    public function selectLinhaFundoHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaFundoHasPesqueiro = new Application_Model_DbTable_VLinhaFundoHasPesqueiro();
        $select = $this->dbTableLinhaFundoHasPesqueiro->select()
                ->from($this->dbTableLinhaFundoHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundoHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTLinhaFundoHasPesqueiro = new Application_Model_DbTable_LinhaFundoHasPesqueiro();
        
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        $dadosPesqueiro = array(
            'lf_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTLinhaFundoHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTLinhaFundoHasPesqueiro = new Application_Model_DbTable_LinhaFundoHasPesqueiro();       
                
        $whereLinhaFundoHasPesqueiro = $this->dbTableTLinhaFundoHasPesqueiro->getAdapter()
                ->quoteInto('"lf_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTLinhaFundoHasPesqueiro->delete($whereLinhaFundoHasPesqueiro);
        
    }
     public function updatePesqueiro($idEntrevistaPesqueiro,$idEntrevista,$pesqueiro, $tempoapesqueiro, $distapesqueiro)
    {
        $this->dbTableTLinhaFundoHasPesqueiro = new Application_Model_DbTable_LinhaFundoHasPesqueiro();

        if(empty($tempoapesqueiro)){  $tempoapesqueiro = null;}
        $dadosPesqueiro = array(
            'lf_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoapesqueiro,
            't_distapesqueiro' => $distapesqueiro
        );

        $wherePescador = $this->dbTableTLinhaFundoHasPesqueiro->getAdapter()
                ->quoteInto('"lf_paf_id" = ?', $idEntrevistaPesqueiro);


        $this->dbTableTLinhaFundoHasPesqueiro->update($dadosPesqueiro, $wherePescador);
    }
    public function selectLinhaFundoHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableLinhaFundoHasEspCapturada = new Application_Model_DbTable_VLinhaFundoHasEspecieCapturada();
        
        $select = $this->dbTableLinhaFundoHasEspCapturada->select()
                ->from($this->dbTableLinhaFundoHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableLinhaFundoHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTLinhaFundoHasEspCapturada = new Application_Model_DbTable_LinhaFundoHasEspecieCapturada();
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
            'lf_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' =>$idTipoVenda
        );
        
        $this->dbTableTLinhaFundoHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTLinhaFundoHasEspCapturada = new Application_Model_DbTable_LinhaFundoHasEspecieCapturada();       
                
        $whereLinhaFundoHasEspCapturada = $this->dbTableTLinhaFundoHasEspCapturada->getAdapter()
                ->quoteInto('"spc_lf_id" = ?', $idEspecie);
        
        $this->dbTableTLinhaFundoHasEspCapturada->delete($whereLinhaFundoHasEspCapturada);
    }
    
    public function updateEspCapturada($idEntrevistaEspecie,$idEntrevista, $especie, $quantidade, $peso, $precokg,$idTipoVenda )
    {
        $this->dbTableTLinhaFundoHasEspCapturada = new Application_Model_DbTable_LinhaFundoHasEspecieCapturada();

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
            'lf_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' =>$idTipoVenda
        );

        $wherePescador = $this->dbTableTLinhaFundoHasEspCapturada->getAdapter()
                ->quoteInto('"spc_lf_id" = ?', $idEntrevistaEspecie);


        $this->dbTableTLinhaFundoHasEspCapturada->update($dadosEspecie, $wherePescador);
    }
    
    public function selectEntrevistaLinhaFundo($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaFundo = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        $select = $this->dbTableLinhaFundo->select()
                ->from($this->dbTableLinhaFundo)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundo->fetchAll($select)->toArray();
    }
    public function selectLinhaFundoHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaFundoAvistamento = new Application_Model_DbTable_VLinhaFundoHasAvistamento();
        $selectAvist = $this->dbTableLinhaFundoAvistamento->select()
                ->from($this->dbTableLinhaFundoAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableLinhaFundoAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTLinhaFundoHasAvistamento = new Application_Model_DbTable_LinhaFundoHasAvistamento();
        
        
        $dadosAvistamento = array(
            'lf_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTLinhaFundoHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTLinhaFundoHasAvistamento = new Application_Model_DbTable_LinhaFundoHasAvistamento();       
                
        $dadosLinhaFundoHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'lf_id= ?' => $idEntrevista
        );
        
        $this->dbTableTLinhaFundoHasAvistamento->delete($dadosLinhaFundoHasAvistamento);
    }
    
        ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableLinhaFundoHasBioCamarao = new Application_Model_DbTable_LinhaFundoHasBioCamarao();


        $dadosPesqueiro = array(
            'tlf_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableLinhaFundoHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableLinhaFundoHasBioCamarao = new Application_Model_DbTable_VLinhaFundoHasBioCamarao();
        $select = $this->dbTableLinhaFundoHasBioCamarao->select()
                ->from($this->dbTableLinhaFundoHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundoHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTLinhaFundoHasBioCamarao = new Application_Model_DbTable_LinhaFundoHasBioCamarao();

        $whereLinhaFundoHasBiometria = $this->dbTableTLinhaFundoHasBioCamarao->getAdapter()
                ->quoteInto('tlfbc_id = ?', $idBiometria);

        $this->dbTableTLinhaFundoHasBioCamarao->delete($whereLinhaFundoHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableLinhaFundoHasBioPeixe = new Application_Model_DbTable_LinhaFundoHasBioPeixe();


        $dadosPesqueiro = array(
            'tlf_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableLinhaFundoHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableLinhaFundoHasBioPeixe = new Application_Model_DbTable_VLinhaFundoHasBioPeixe();
        $select = $this->dbTableLinhaFundoHasBioPeixe->select()
                ->from($this->dbTableLinhaFundoHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundoHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTLinhaFundoHasBioPeixe = new Application_Model_DbTable_LinhaFundoHasBioPeixe();

        $whereLinhaFundoHasBiometria = $this->dbTableTLinhaFundoHasBioPeixe->getAdapter()
                ->quoteInto('tlfbp_id = ?', $idBiometria);

        $this->dbTableTLinhaFundoHasBioPeixe->delete($whereLinhaFundoHasBiometria);
        
    }
    public function updateBioPeixe($idEntrevistaPeixe, $idEntrevista, $idEspecie,$sexo, $comprimento, $peso) {
	$this->dbTableLinhaFundoHasBioPeixe = new Application_Model_DbTable_LinhaFundoHasBioPeixe();
	$dadosPesqueiro = array( 'tlf_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbp_sexo' => $sexo, 'tbp_comprimento' => $comprimento, 'tbp_peso' => $peso );
	$wherePescador = $this->dbTableLinhaFundoHasBioPeixe->getAdapter() ->quoteInto('"tlfbp_id" = ?', $idEntrevistaPeixe);
	$this->dbTableLinhaFundoHasBioPeixe->update($dadosPesqueiro, $wherePescador);
    }
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        $select = $dbTable->select()->
                from('v_entrevista_linhafundo', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        $select = $dbTable->select()->
                from('v_entrevista_linhafundo', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        $select = $dbTable->select()->
                from('v_entrevista_linhafundo', array('pto_nome', 'count(lf_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaLinhaFundo();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_linhafundo', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 'sum(peso) as peso', 'mes', 'ano', 'pesototal'=> new Zend_Db_Expr('((sum(peso)/sum(monitorados))*sum(naomonitorados))+sum(peso)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEstimativaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaLinhaFundo();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_linhafundo', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(peso) as peso', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        $select = $dbTable->select()->
                from('v_entrevista_linhafundo', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_linhafundo', 'v_entrevista_linhafundo.pto_nome')->joinLeft('v_linhafundo_has_t_especie_capturada', 'v_entrevista_linhafundo.lf_id = v_linhafundo_has_t_especie_capturada.lf_id',
                        array('sum(v_linhafundo_has_t_especie_capturada.spc_quantidade) as quant','sum(v_linhafundo_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        $select = $dbTable->select()->
                from('v_entrevista_linhafundo', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        
        $select = $dbTable->select()->
                from('v_entrevista_linhafundo', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_linhafundo', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_linhafundo_has_t_especie_capturada', 'v_entrevista_linhafundo.lf_id = v_linhafundo_has_t_especie_capturada.lf_id'
                , array('v_linhafundo_has_t_especie_capturada.lf_id','cpue'=> new Zend_Db_Expr('sum(v_linhafundo_has_t_especie_capturada.spc_peso_kg)'), 'v_entrevista_linhafundo.tl_local','v_entrevista_linhafundo.pto_nome'))->
                group(array('v_linhafundo_has_t_especie_capturada.lf_id', "mesAno",'v_entrevista_linhafundo.tl_local','v_entrevista_linhafundo.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VLinhaFundoHasPesqueiro();
        
        $select = $dbTable->select()->from('v_linhafundo_has_t_pesqueiro',array('count(lf_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableLinhaFundoHasBioPeixe = new Application_Model_DbTable_VLinhaFundoHasBioPeixe();
        $select = $this->dbTableLinhaFundoHasBioPeixe->select()
                ->from($this->dbTableLinhaFundoHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundoHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableLinhaFundoHasBioPeixe = new Application_Model_DbTable_VLinhaFundoHasBioPeixe();
        $select = $this->dbTableLinhaFundoHasBioPeixe->select()
                ->from($this->dbTableLinhaFundoHasBioPeixe,array('x'=>'tbp_comprimento', 'y'=>'tbp_peso'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaFundoHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableLinhaFundoHasBioPeixe = new Application_Model_DbTable_VLinhaFundoHasBioPeixe();
        $select = $this->dbTableLinhaFundoHasBioPeixe->select()->from($this->dbTableLinhaFundoHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableLinhaFundoHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableLinhaFundo = new Application_Model_DbTable_VEntrevistaLinhaFundo();
        
        $select = $this->dbTableLinhaFundo->select()->
                from($this->dbTableLinhaFundo, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableLinhaFundo->fetchAll($select)->toArray();
    }
    
    public function selectMediaEspecies($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaFundoMedia = new Application_Model_DbTable_VMediaEspeciesLinhaFundo();
        $select = $this->dbTableLinhaFundoMedia->select()->
                order($order)->limit($limit);
        if(!is_null($where)){
            $select->where($where);
        }
        return $this->dbTableLinhaFundoMedia->fetchAll($select)->toArray();
    }
    
    public function selectAvistamentoByTipo($where = null, $limit = null)
    {
 
        $this->dbTableLinhaFundoAvistamento = new Application_Model_DbTable_VLinhaFundoHasAvistamento();
        $selectAvist = $this->dbTableLinhaFundoAvistamento->select()->group('avs_descricao')
                ->from($this->dbTableLinhaFundoAvistamento, array('quantAvist' => 'count(*)','avs_descricao'))->order('quantAvist DESC')->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableLinhaFundoAvistamento->fetchAll($selectAvist)->toArray();
    }
}

