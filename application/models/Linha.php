<?php
/** 
 * Model Arte de Pesca - Linha
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */

class Application_Model_Linha
{
private $dbTableLinha;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        $select = $this->dbTableLinha->select()
                ->from($this->dbTableLinha)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinha->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        $arr = $this->dbTableLinha->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        
        
        
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
        
        $dadosLinha = array(
            'lin_embarcada' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'lin_motor'=> $request['motor'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'lin_numpescadores' => $request['numPescadores'],
            'lin_dhsaida' => $timestampSaida,
            'lin_dhvolta' => $timestampVolta,
            'lin_diesel' => $diesel, 
            'lin_oleo' => $oleo,
            'lin_alimento' => $alimento,
            'lin_gelo' => $gelo,
            'lin_numlinhas' => $numLinhas,
            'lin_numanzoisplinha' => $numAnzois,
            'lin_obs' => $request['observacao'],
            'mnt_id' => $request['id_monitoramento'],
            'dp_id' => $request['destinoPescado'],
            'isc_id' => $request['isca']
            
        );
        
        $insertLinha = $this->dbTableLinha->insert($dadosLinha);
        return $insertLinha;
    }
    
    public function update(array $request)
    {
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        
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
        
        $dadosLinha = array(
            'mnt_id' => $request['id_monitoramento'],
            'lin_embarcada' => $request['embarcada'],
            'bar_id' => $request['nomeBarco'],
            'lin_motor'=> $request['motor'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'lin_numpescadores' => $request['numPescadores'],
            'lin_dhsaida' => $timestampSaida,
            'lin_dhvolta' => $timestampVolta,
            'lin_diesel' => $diesel, 
            'lin_oleo' => $oleo,
            'lin_alimento' => $alimento,
            'lin_gelo' => $gelo,
            'lin_numlinhas' => $numLinhas,
            'lin_numanzoisplinha' => $numAnzois,
            'lin_obs' => $request['observacao'],
            'dp_id' => $request['destinoPescado'],
            'isc_id' => $request['isca']
            
        );
 
        
        $whereLinha= $this->dbTableLinha->getAdapter()
                ->quoteInto('"lin_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableLinha->update($dadosLinha, $whereLinha);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableLinhaFundo = new Application_Model_DbTable_Linha();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableLinhaFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableLinhaFundo->update($dados, $wherePescador);
    }
    public function delete($idLinha)
    {
        $this->dbTableLinha = new Application_Model_DbTable_Linha();       
                
        $whereLinha= $this->dbTableLinha->getAdapter()
                ->quoteInto('"lin_id" = ?', $idLinha);
        
        $this->dbTableLinha->delete($whereLinha);
    }
    public function selectId(){
        $this->dbTableLinha = new Application_Model_DbTable_Linha();
        
        $select = $this->dbTableLinha->select()
                ->from($this->dbTableLinha, 'lin_id')->order('lin_id DESC')->limit('1');
        
        return $this->dbTableLinha->fetchAll($select)->toArray();
    }
    
    public function selectLinhaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaHasPesqueiro = new Application_Model_DbTable_VLinhaHasPesqueiro();
        $select = $this->dbTableLinhaHasPesqueiro->select()
                ->from($this->dbTableLinhaHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro)
    {
        $this->dbTableTLinhaHasPesqueiro = new Application_Model_DbTable_LinhaHasPesqueiro();
        
       
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        
        $dadosPesqueiro = array(
            'lin_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro
        );
        
        $this->dbTableTLinhaHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro){
        $this->dbTableTLinhaHasPesqueiro = new Application_Model_DbTable_LinhaHasPesqueiro();       
                
        $whereLinhaHasPesqueiro = $this->dbTableTLinhaHasPesqueiro->getAdapter()
                ->quoteInto('"lin_paf_id" = ?', $idPesqueiro);
        
        $this->dbTableTLinhaHasPesqueiro->delete($whereLinhaHasPesqueiro);
        
    }
     public function updatePesqueiro($idEntrevistaPesqueiro,$idEntrevista,$pesqueiro, $tempoapesqueiro)
    {
        $this->dbTableTLinhaHasPesqueiro = new Application_Model_DbTable_LinhaHasPesqueiro();

        if(empty($tempoapesqueiro)){  $tempoapesqueiro = null;}
        $dadosPesqueiro = array(
            'lin_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoapesqueiro
        );

        $wherePescador = $this->dbTableTLinhaHasPesqueiro->getAdapter()
                ->quoteInto('"jre_paf_id" = ?', $idEntrevistaPesqueiro);

        $this->dbTableTLinhaHasPesqueiro->update($dadosPesqueiro, $wherePescador);
    }
    
    public function selectLinhaHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableLinhaHasEspCapturada = new Application_Model_DbTable_VLinhaHasEspecieCapturada();
        
        $select = $this->dbTableLinhaHasEspCapturada->select()
                ->from($this->dbTableLinhaHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableLinhaHasEspCapturada->fetchAll($select)->toArray();
    }

    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTLinhaHasEspCapturada = new Application_Model_DbTable_LinhaHasEspecieCapturada();
        
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
            'lin_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );
        
        $this->dbTableTLinhaHasEspCapturada->insert($dadosEspecie);
        return;
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTLinhaHasEspCapturada = new Application_Model_DbTable_LinhaHasEspecieCapturada();       
                
        $whereLinhaHasEspCapturada = $this->dbTableTLinhaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_lin_id" = ?', $idEspecie);
        
        $this->dbTableTLinhaHasEspCapturada->delete($whereLinhaHasEspCapturada);
    }
    
    public function updateEspCapturada($idEntrevistaEspecie,$idEntrevista, $especie, $quantidade, $peso, $precokg)
    {
        $this->dbTableTLinhaHasEspCapturada = new Application_Model_DbTable_LinhaHasEspecieCapturada();

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
            'lin_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg
        );

        $wherePescador = $this->dbTableTLinhaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_lin_id" = ?', $idEntrevistaEspecie);


        $this->dbTableTLinhaHasEspCapturada->update($dadosEspecie, $wherePescador);
    }
    
    public function selectEntrevistaLinha($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinha = new Application_Model_DbTable_VEntrevistaLinha();
        $select = $this->dbTableLinha->select()
                ->from($this->dbTableLinha)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinha->fetchAll($select)->toArray();
    }
    public function selectLinhaHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaAvistamento = new Application_Model_DbTable_VLinhaHasAvistamento();
        $selectAvist = $this->dbTableLinhaAvistamento->select()
                ->from($this->dbTableLinhaAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableLinhaAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTLinhaHasAvistamento = new Application_Model_DbTable_LinhaHasAvistamento();
        
        
        $dadosAvistamento = array(
            'lin_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTLinhaHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTLinhaHasAvistamento = new Application_Model_DbTable_LinhaHasAvistamento();       
                
        $dadosLinhaHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'lin_id= ?' => $idEntrevista
        );
        
        $this->dbTableTLinhaHasAvistamento->delete($dadosLinhaHasAvistamento);
    }
    
////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableLinhaHasBioCamarao = new Application_Model_DbTable_LinhaHasBioCamarao();


        $dadosPesqueiro = array(
            'tlin_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableLinhaHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableLinhaHasBioCamarao = new Application_Model_DbTable_VLinhaHasBioCamarao();
        $select = $this->dbTableLinhaHasBioCamarao->select()
                ->from($this->dbTableLinhaHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function updateBioCamarao($idEntrevistaCamarao,$idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso) {
        $this->dbTableLinhaHasBioCamarao = new Application_Model_DbTable_LinhaHasBioCamarao();
        $dadosPesqueiro = array( 'tlin_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbc_sexo' => $sexo, 'tmat_id' => $maturidade, 'tbc_comprimento_cabeca' => $compCabeca, 'tbc_peso' => $peso );
        $wherePescador = $this->dbTableLinhaHasBioCamarao->getAdapter() ->quoteInto('"tlinbc_id" = ?', $idEntrevistaCamarao);
        $this->dbTableLinhaHasBioCamarao->update($dadosPesqueiro, $wherePescador);
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTLinhaHasBioCamarao = new Application_Model_DbTable_LinhaHasBioCamarao();

        $whereLinhaHasBiometria = $this->dbTableTLinhaHasBioCamarao->getAdapter()
                ->quoteInto('tlinbc_id = ?', $idBiometria);

        $this->dbTableTLinhaHasBioCamarao->delete($whereLinhaHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableLinhaHasBioPeixe = new Application_Model_DbTable_LinhaHasBioPeixe();


        $dadosPesqueiro = array(
            'tlin_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableLinhaHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableLinhaHasBioPeixe = new Application_Model_DbTable_VLinhaHasBioPeixe();
        $select = $this->dbTableLinhaHasBioPeixe->select()
                ->from($this->dbTableLinhaHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTLinhaHasBioPeixe = new Application_Model_DbTable_LinhaHasBioPeixe();

        $whereLinhaHasBiometria = $this->dbTableTLinhaHasBioPeixe->getAdapter()
                ->quoteInto('tlinbp_id = ?', $idBiometria);

        $this->dbTableTLinhaHasBioPeixe->delete($whereLinhaHasBiometria);
        
    }
    public function updateBioPeixe($idEntrevistaPeixe, $idEntrevista, $idEspecie,$sexo, $comprimento, $peso) {
	$this->dbTableLinhaHasBioPeixe = new Application_Model_DbTable_LinhaHasBioPeixe();
	$dadosPesqueiro = array( 'tlin_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbp_sexo' => $sexo, 'tbp_comprimento' => $comprimento, 'tbp_peso' => $peso );
	$wherePescador = $this->dbTableLinhaHasBioPeixe->getAdapter() ->quoteInto('"tlinbp_id" = ?', $idEntrevistaPeixe);
	$this->dbTableLinhaHasBioPeixe->update($dadosPesqueiro, $wherePescador);
    }
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinha();
        $select = $dbTable->select()->
                from('v_entrevista_linha', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinha();
        $select = $dbTable->select()->
                from('v_entrevista_linha', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaLinha();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_linha', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 'sum(peso) as peso', 'mes', 'ano', 'pesototal'=> new Zend_Db_Expr('((sum(peso)/sum(monitorados))*sum(naomonitorados))+sum(peso)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEstimativaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaLinha();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_linha', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(peso) as peso', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinha();
        $select = $dbTable->select()->
                from('v_entrevista_linha', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinha();
        $select = $dbTable->select()->
                from('v_entrevista_linha', array('pto_nome', 'count(lin_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinha();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_linha', 'v_entrevista_linha.pto_nome')->joinLeft('v_linha_has_t_especie_capturada', 'v_entrevista_linha.lin_id = v_linha_has_t_especie_capturada.lin_id',
                        array('sum(v_linha_has_t_especie_capturada.spc_quantidade) as quant','sum(v_linha_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinha();
        $select = $dbTable->select()->
                from('v_entrevista_linha', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinha();
        
        $select = $dbTable->select()->
                from('v_entrevista_linha', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaLinha();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_linha', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_linha_has_t_especie_capturada', 'v_entrevista_linha.lin_id = v_linha_has_t_especie_capturada.lin_id'
                , array('v_linha_has_t_especie_capturada.lin_id','cpue'=> new Zend_Db_Expr('sum(v_linha_has_t_especie_capturada.spc_peso_kg) '), 'v_entrevista_linha.tl_local','v_entrevista_linha.pto_nome'))->
                group(array('v_linha_has_t_especie_capturada.lin_id', "mesAno",'v_entrevista_linha.tl_local','v_entrevista_linha.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VLinhaHasPesqueiro();
        
        $select = $dbTable->select()->from('v_linha_has_t_pesqueiro',array('count(lin_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableLinhaHasBioPeixe = new Application_Model_DbTable_VLinhaHasBioPeixe();
        $select = $this->dbTableLinhaHasBioPeixe->select()
                ->from($this->dbTableLinhaHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaHasBioPeixe->fetchAll($select)->toArray();
    }

    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableLinhaHasBioPeixe = new Application_Model_DbTable_VLinhaHasBioPeixe();
        $select = $this->dbTableLinhaHasBioPeixe->select()->from($this->dbTableLinhaHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableLinhaHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableLinhaHasBioPeixe = new Application_Model_DbTable_VLinhaHasBioPeixe();
        $select = $this->dbTableLinhaHasBioPeixe->select()
                ->from($this->dbTableLinhaHasBioPeixe,array('x'=>'tbp_comprimento', 'y'=>'tbp_peso'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableLinhaHasBioPeixe->fetchAll($select)->toArray();
    }
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableLinha = new Application_Model_DbTable_VEntrevistaLinha();
        
        $select = $this->dbTableLinha->select()->
                from($this->dbTableLinha, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableLinha->fetchAll($select)->toArray();
    }
    
    public function selectMediaEspecies($where = null, $order = null, $limit = null)
    {
        $this->dbTableLinhaMedia = new Application_Model_DbTable_VMediaEspeciesLinha();
        $select = $this->dbTableLinhaMedia->select()->
                order($order)->limit($limit);
        if(!is_null($where)){
            $select->where($where);
        }
        return $this->dbTableLinhaMedia->fetchAll($select)->toArray();
    }
    
    public function selectAvistamentoByTipo($where = null, $limit = null)
    {
 
        $this->dbTableLinhaAvistamento = new Application_Model_DbTable_VLinhaHasAvistamento();
        $selectAvist = $this->dbTableLinhaAvistamento->select()->group('avs_descricao')
                ->from($this->dbTableLinhaAvistamento, array('quantAvist' => 'count(*)','avs_descricao'))->order('quantAvist DESC')->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableLinhaAvistamento->fetchAll($selectAvist)->toArray();
    }
}

