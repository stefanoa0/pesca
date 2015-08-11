<?php
/** 
 * Model Arte de Pesca - Vara de Pesca
 * 
 * @package Pesca
 * @subpackage Models
 * @author Stefano Azevedo Silva <stefanouesc@gmail.com>
 * @author Marcelo Ossamu Honda <mohonda@uesc.com>
 * @version 1.0
 * @access public
 *
 */
class Application_Model_VaraPesca
{
    private $dbTableVaraPesca;

    public function select($where = null, $order = null, $limit = null)
    {
        $this->dbTableVaraPesca = new Application_Model_DbTable_VaraPesca();
        $select = $this->dbTableVaraPesca->select()
                ->from($this->dbTableVaraPesca)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableVaraPesca->fetchAll($select)->toArray();
    }
    
    public function find($id)
    {
        $this->dbTableVaraPesca = new Application_Model_DbTable_VaraPesca();
        $arr = $this->dbTableVaraPesca->find($id)->toArray();
        return $arr[0];
    }
    
    public function insert(array $request)
    {
        $this->dbTableVaraPesca = new Application_Model_DbTable_VaraPesca();
        
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
        
        $dadosVaraPesca = array(
            'vp_embarcada' => $request['embarcada'],
            'vp_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'vp_quantpescadores' => $request['numPescadores'],
            'vp_dhvolta' => $timestampVolta,
            'vp_dhsaida' => $timestampSaida, 
            'vp_tempogasto' => $request['tempoGasto'],
            'vp_diesel' => $diesel,
            'vp_oleo' => $oleo,
            'vp_alimento' => $alimento,
            'vp_gelo' => $gelo,
            'vp_obs' => $request['observacao'],
            'vp_numanzoisplinha' => $numAnzois,
            'vp_numlinhas' => $numLinhas,
            'isc_id' => $request['isca'],
            'mnt_id' => $request['id_monitoramento'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'vp_mreviva' => $request['mareviva']
        );
        
        $insertVaraPesca = $this->dbTableVaraPesca->insert($dadosVaraPesca);
        return $insertVaraPesca;
    }
    
    public function update(array $request)
    {
        $this->dbTableVaraPesca = new Application_Model_DbTable_VaraPesca();
        $this->dbTableFichaDiaria = new Application_Model_FichaDiaria();
        
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
        
        
        $dadosVaraPesca = array(
            'mnt_id' => $request['id_monitoramento'],
            'vp_embarcada' => $request['embarcada'],
            'vp_motor'=> $request['motor'],
            'bar_id' => $request['nomeBarco'],
            'tte_id' => $request['tipoBarco'],
            'tp_id_entrevistado' => $request['pescadorEntrevistado'],
            'vp_quantpescadores' => $request['numPescadores'],
            'vp_dhvolta' => $timestampVolta,
            'vp_dhsaida' => $timestampSaida, 
            'vp_tempogasto' => $request['tempoGasto'],
            'vp_diesel' => $diesel,
            'vp_oleo' => $oleo,
            'vp_alimento' => $alimento,
            'vp_gelo' => $gelo,
            'vp_obs' => $request['observacao'],
            'vp_numanzoisplinha' => $numAnzois,
            'vp_numlinhas' => $numLinhas,
            'isc_id' => $request['isca'],
            'mre_id' => $request['mare'],
            'dp_id' => $request['destinoPescado'],
            'vp_mreviva' => $request['mareviva']
        );
 
        
        $whereVaraPesca= $this->dbTableVaraPesca->getAdapter()
                ->quoteInto('"vp_id" = ?', $request['id_entrevista']);
        
        
        $this->dbTableVaraPesca->update($dadosVaraPesca, $whereVaraPesca);
    }
    public function updatePescador($idPescador,$idMantido){
        $this->dbTableVaraPescaFundo = new Application_Model_DbTable_VaraPesca();
        
        $dados = array(
                'tp_id_entrevistado' => $idMantido
               );
        
        $wherePescador = $this->dbTableVaraPescaFundo->getAdapter()
                ->quoteInto('"tp_id_entrevistado" = ?', $idPescador);


        $this->dbTableVaraPescaFundo->update($dados, $wherePescador);
    }
    public function delete($idVaraPesca)
    {
        $this->dbTableVaraPesca = new Application_Model_DbTable_VaraPesca();       
                
        $whereVaraPesca= $this->dbTableVaraPesca->getAdapter()
                ->quoteInto('"vp_id" = ?', $idVaraPesca);
        
        $this->dbTableVaraPesca->delete($whereVaraPesca);
    }
    public function selectId(){
        $this->dbTableVaraPesca = new Application_Model_DbTable_VaraPesca();
        
        $select = $this->dbTableVaraPesca->select()
                ->from($this->dbTableVaraPesca, 'vp_id')->order('vp_id DESC')->limit('1');
        
        return $this->dbTableVaraPesca->fetchAll($select)->toArray();
    }
    public function selectVaraPescaHasPesqueiro($where = null, $order = null, $limit = null)
    {
        $this->dbTableVaraPescaHasPesqueiro = new Application_Model_DbTable_VVaraPescaHasPesqueiro();
        $select = $this->dbTableVaraPescaHasPesqueiro->select()
                ->from($this->dbTableVaraPescaHasPesqueiro)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableVaraPescaHasPesqueiro->fetchAll($select)->toArray();
    }
    public function insertPesqueiro($idEntrevista,$pesqueiro, $tempoAPesqueiro, $distAPesqueiro)
    {
        $this->dbTableTVaraPescaHasPesqueiro = new Application_Model_DbTable_VaraPescaHasPesqueiro();
        
        if(empty($distAPesqueiro)){
            $distAPesqueiro = NULL;
        }
        if(empty($tempoAPesqueiro)){
            $tempoAPesqueiro = NULL;
        }
        
        $dadosPesqueiro = array(
            'vp_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoAPesqueiro,
            't_distapesqueiro' => $distAPesqueiro
        );
        
        $this->dbTableTVaraPescaHasPesqueiro->insert($dadosPesqueiro);
        return;
    }
    public function deletePesqueiro($idPesqueiro,$idEntrevista= null){
        $this->dbTableTVaraPescaHasPesqueiro = new Application_Model_DbTable_VaraPescaHasPesqueiro();       
        if(empty($idEntrevista)){
            $whereVaraPescaHasPesqueiro = $this->dbTableTVaraPescaHasPesqueiro->getAdapter()
                ->quoteInto('"vp_paf_id" = ?', $idPesqueiro);
        }
        else{
            $whereVaraPescaHasPesqueiro = $this->dbTableTVaraPescaHasPesqueiro->getAdapter()
                ->quoteInto('"vp_id" = ?', $idEntrevista);
        }
        $this->dbTableTVaraPescaHasPesqueiro->delete($whereVaraPescaHasPesqueiro);
    }
     public function updatePesqueiro($idEntrevistaPesqueiro,$idEntrevista,$pesqueiro, $tempoapesqueiro, $distapesqueiro)
    {
        $this->dbTableTVaraPescaHasPesqueiro = new Application_Model_DbTable_VaraPescaHasPesqueiro();

        if(empty($tempoapesqueiro)){  $tempoapesqueiro = null;}
        $dadosPesqueiro = array(
            'vp_id' => $idEntrevista,
            'paf_id' => $pesqueiro,
            't_tempoapesqueiro' => $tempoapesqueiro,
            't_distapesqueiro' => $distapesqueiro
        );

        $wherePescador = $this->dbTableTVaraPescaHasPesqueiro->getAdapter()
                ->quoteInto('"vp_paf_id" = ?', $idEntrevistaPesqueiro);


        $this->dbTableTVaraPescaHasPesqueiro->update($dadosPesqueiro, $wherePescador);
    }
    
    public function selectVaraPescaHasEspCapturadas($where = null, $order = null, $limit = null){
        $this->dbTableVaraPescaHasEspCapturada = new Application_Model_DbTable_VVaraPescaHasEspecieCapturada();
        
        $select = $this->dbTableVaraPescaHasEspCapturada->select()
                ->from($this->dbTableVaraPescaHasEspCapturada)->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableVaraPescaHasEspCapturada->fetchAll($select)->toArray();
    }
    public function insertEspCapturada($idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTVaraPescaHasEspCapturada = new Application_Model_DbTable_VaraPescaHasEspecieCapturada();
        
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
            'vp_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda
        );
        
        $this->dbTableTVaraPescaHasEspCapturada->insert($dadosEspecie);
        return;
    }
    
    public function updateEspCapturada($idEntrevistaEspecie,$idEntrevista, $especie, $quantidade, $peso, $precokg, $idTipoVenda)
    {
        $this->dbTableTVaraPescaHasEspCapturada = new Application_Model_DbTable_VaraPescaHasEspecieCapturada();

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
            'vp_id' => $idEntrevista,
            'esp_id' => $especie,
            'spc_quantidade' => $quantidade,
            'spc_peso_kg' => $peso,
            'spc_preco' => $precokg,
            'ttv_id' => $idTipoVenda
        );

        $wherePescador = $this->dbTableTVaraPescaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_vp_id" = ?', $idEntrevistaEspecie);


        $this->dbTableTVaraPescaHasEspCapturada->update($dadosEspecie, $wherePescador);
    }
    public function deleteEspCapturada($idEspecie){
        $this->dbTableTVaraPescaHasEspCapturada = new Application_Model_DbTable_VaraPescaHasEspecieCapturada();       
                
        $whereVaraPescaHasEspCapturada = $this->dbTableTVaraPescaHasEspCapturada->getAdapter()
                ->quoteInto('"spc_vp_id" = ?', $idEspecie);
        
        $this->dbTableTVaraPescaHasEspCapturada->delete($whereVaraPescaHasEspCapturada);
    }
    
    public function selectEntrevistaVaraPesca($where = null, $order = null, $limit = null)
    {
        $this->dbTableVaraPesca = new Application_Model_DbTable_VEntrevistaVaraPesca();
        $select = $this->dbTableVaraPesca->select()
                ->from($this->dbTableVaraPesca)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableVaraPesca->fetchAll($select)->toArray();
    }
    public function selectVaraPescaHasAvistamento($where = null, $order = null, $limit = null)
    {
        $this->dbTableVaraPescaAvistamento = new Application_Model_DbTable_VVaraPescaHasAvistamento();
        $selectAvist = $this->dbTableVaraPescaAvistamento->select()
                ->from($this->dbTableVaraPescaAvistamento)->order($order)->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableVaraPescaAvistamento->fetchAll($selectAvist)->toArray();
    }
    public function insertAvistamento($idEntrevista,$idAvistamento)
    {
        $this->dbTableTVaraPescaHasAvistamento = new Application_Model_DbTable_VaraPescaHasAvistamento();
        
        
        $dadosAvistamento = array(
            'vp_id' => $idEntrevista,
            'avs_id' => $idAvistamento
        );
        
        $this->dbTableTVaraPescaHasAvistamento->insert($dadosAvistamento);
        return;
    }
    public function deleteAvistamento($idAvistamento, $idEntrevista){
        $this->dbTableTVaraPescaHasAvistamento = new Application_Model_DbTable_VaraPescaHasAvistamento();       
                
        $dadosVaraPescaHasAvistamento = array(
            'avs_id = ?' => $idAvistamento,
            'vp_id= ?' => $idEntrevista
        );
        
        $this->dbTableTVaraPescaHasAvistamento->delete($dadosVaraPescaHasAvistamento);
    }
    
        ////////////////////BIOMETRIA CAMARAO //////////////////////////////////////////////////////////////
    public function insertBioCamarao($idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso)
    {
        $this->dbTableVaraPescaHasBioCamarao = new Application_Model_DbTable_VaraPescaHasBioCamarao();


        $dadosPesqueiro = array(
            'tvp_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbc_sexo' => $sexo,
            'tmat_id' => $maturidade,
            'tbc_comprimento_cabeca' => $compCabeca,
            'tbc_peso' => $peso
        );

        $this->dbTableVaraPescaHasBioCamarao->insert($dadosPesqueiro);
        return;
    }
    
    public function selectVBioCamarao($where = null, $order = null, $limit = null){
        $this->dbTableVaraPescaHasBioCamarao = new Application_Model_DbTable_VVaraPescaHasBioCamarao();
        $select = $this->dbTableVaraPescaHasBioCamarao->select()
                ->from($this->dbTableVaraPescaHasBioCamarao)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableVaraPescaHasBioCamarao->fetchAll($select)->toArray();
        
    }
    public function updateBioCamarao($idEntrevistaCamarao,$idEntrevista, $idEspecie,$sexo, $maturidade, $compCabeca, $peso) {
        $this->dbTableVaraPescaHasBioCamarao = new Application_Model_DbTable_VaraPescaHasBioCamarao();
        $dadosPesqueiro = array( 'tvp_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbc_sexo' => $sexo, 'tmat_id' => $maturidade, 'tbc_comprimento_cabeca' => $compCabeca, 'tbc_peso' => $peso );
        $wherePescador = $this->dbTableVaraPescaHasBioCamarao->getAdapter() ->quoteInto('"tvpbc_id" = ?', $idEntrevistaCamarao);
        $this->dbTableVaraPescaHasBioCamarao->update($dadosPesqueiro, $wherePescador);
    }
    public function deleteBioCamarao($idBiometria){
        $this->dbTableTVaraPescaHasBioCamarao = new Application_Model_DbTable_VaraPescaHasBioCamarao();

        $whereVaraPescaHasBiometria = $this->dbTableTVaraPescaHasBioCamarao->getAdapter()
                ->quoteInto('tvpbc_id = ?', $idBiometria);

        $this->dbTableTVaraPescaHasBioCamarao->delete($whereVaraPescaHasBiometria);
        
    }
////////////////BIOMETRIA PEIXES //////////////////////////////////////////////////////////////////////
    public function insertBioPeixe($idEntrevista, $idEspecie,$sexo, $comprimento, $peso)
    {
        $this->dbTableVaraPescaHasBioPeixe = new Application_Model_DbTable_VaraPescaHasBioPeixe();


        $dadosPesqueiro = array(
            'tvp_id' => $idEntrevista,
            'esp_id' => $idEspecie,
            'tbp_sexo' => $sexo,
            'tbp_comprimento' => $comprimento,
            'tbp_peso' => $peso
        );

        $this->dbTableVaraPescaHasBioPeixe->insert($dadosPesqueiro);
        return;
    }
    public function selectVBioPeixe($where = null, $order = null, $limit = null){
        $this->dbTableVaraPescaHasBioPeixe = new Application_Model_DbTable_VVaraPescaHasBioPeixe();
        $select = $this->dbTableVaraPescaHasBioPeixe->select()
                ->from($this->dbTableVaraPescaHasBioPeixe)->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableVaraPescaHasBioPeixe->fetchAll($select)->toArray();
        
    }
    public function deleteBioPeixe($idBiometria){
        $this->dbTableTVaraPescaHasBioPeixe = new Application_Model_DbTable_VaraPescaHasBioPeixe();

        $whereVaraPescaHasBiometria = $this->dbTableTVaraPescaHasBioPeixe->getAdapter()
                ->quoteInto('tvpbp_id = ?', $idBiometria);

        $this->dbTableTVaraPescaHasBioPeixe->delete($whereVaraPescaHasBiometria);
        
    }
    
    public function updateBioPeixe($idEntrevistaPeixe, $idEntrevista, $idEspecie,$sexo, $comprimento, $peso) {
	$this->dbTableVaraPescaHasBioPeixe = new Application_Model_DbTable_VaraPescaHasBioPeixe();
	$dadosPesqueiro = array( 'tvp_id' => $idEntrevista, 'esp_id' => $idEspecie, 'tbp_sexo' => $sexo, 'tbp_comprimento' => $comprimento, 'tbp_peso' => $peso );
	$wherePescador = $this->dbTableVaraPescaHasBioPeixe->getAdapter() ->quoteInto('"tvpbp_id" = ?', $idEntrevistaPeixe);
	$this->dbTableVaraPescaHasBioPeixe->update($dadosPesqueiro, $wherePescador);
}

    
    public function selectPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaVaraPesca();
        $select = $dbTable->select()->
                from('v_entrevista_varapesca', array('pto_nome', 'count(distinct(tp_nome))'))->
                group(array('pto_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaVaraPesca();
        $select = $dbTable->select()->
                from('v_entrevista_varapesca', array('pto_nome', 'count(distinct(bar_nome))'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaVaraPesca();
        $select = $dbTable->select()->
                from('v_entrevista_varapesca', array('pto_nome', 'count(vp_id)'))->
                group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEstimativaVaraPesca();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_varapesca', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados)', 'sum(monitorados)', 'sum(peso) as peso', 'mes', 'ano', 'pesototal'=> new Zend_Db_Expr('((sum(peso)/sum(monitorados))*sum(naomonitorados))+sum(peso)')))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectEstimativaByPorto($where = null,$order=null,$limit=null){
        $dbTable = new Application_Model_DbTable_VEstimativaVaraPesca();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_estimativa_varapesca', array('pto_nome', 'tap_artepesca', 'sum(naomonitorados) as naomonitorados', 'sum(monitorados) as monitorados', 'sum(peso) as peso', 'mes', 'ano'))->
                group(array('pto_nome', 'tap_artepesca', 'mes', 'ano'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    //Quantidade de variaveis por Porto FUNÇÕES PARA REPLICAR
    public function selectQuantBarcosByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaVaraPesca();
        $select = $dbTable->select()->
                from('v_entrevista_varapesca', array('pto_nome', 'count(bar_nome) as quant','bar_nome'))->
                group(array('pto_nome','bar_nome'))->
                order('quant Desc');
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectQuantCapturaByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaVaraPesca();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_varapesca', 'v_entrevista_varapesca.pto_nome')->joinLeft('v_varapesca_has_t_especie_capturada', 'v_entrevista_varapesca.vp_id = v_varapesca_has_t_especie_capturada.vp_id',
                        array('sum(v_varapesca_has_t_especie_capturada.spc_quantidade) as quant','sum(v_varapesca_has_t_especie_capturada.spc_peso_kg) as peso', 'esp_nome_comum' ))->
                group(array('pto_nome', 'esp_nome_comum'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    public function selectQuantPescadoresByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaVaraPesca();
        $select = $dbTable->select()->
                from('v_entrevista_varapesca', array('pto_nome', 'count(tp_nome)', 'tp_nome'))->
                group(array('pto_nome', 'tp_nome'));
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectCountEntrevistasByPorto($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaVaraPesca();
        
        $select = $dbTable->select()->
                from('v_entrevista_varapesca', array('pto_nome', 'count(tp_nome)'))
                ->group(array('pto_nome'));
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function cpue($where = null){
        $dbTable = new Application_Model_DbTable_VEntrevistaVaraPesca();
        $select = $dbTable->select()->setIntegrityCheck(false)->
                from('v_entrevista_varapesca', array('mesAno' => new Zend_Db_Expr("(cast(date_part('month'::text, fd_data) as varchar)) || '/' || (cast(date_part('year'::text, fd_data) as varchar))")))->
                joinLeft('v_varapesca_has_t_especie_capturada', 'v_entrevista_varapesca.vp_id = v_varapesca_has_t_especie_capturada.vp_id'
                , array('v_varapesca_has_t_especie_capturada.vp_id','cpue'=> new Zend_Db_Expr('sum(v_varapesca_has_t_especie_capturada.spc_peso_kg)'), 'v_entrevista_varapesca.tl_local','v_entrevista_varapesca.pto_nome'))->
                group(array('v_varapesca_has_t_especie_capturada.vp_id', "mesAno",'v_entrevista_varapesca.tl_local','v_entrevista_varapesca.pto_nome'))->
                order("mesAno");
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();        
    }
    
    public function selectPesqueirosVisitados($where = null,$order = null, $limit = null){
        $dbTable = new Application_Model_DbTable_VVaraPescaHasPesqueiro();
        
        $select = $dbTable->select()->from('v_varapesca_has_t_pesqueiro',array('count(vp_id)','paf_pesqueiro'))->
                group('paf_pesqueiro')->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        return $dbTable->fetchAll($select)->toArray();
    }
    
    public function selectHistogramaBiometriaPeixe($tipo, $where = null, $order = null,$limit = null){
        $this->dbTableVaraPescaHasBioPeixe = new Application_Model_DbTable_VVaraPescaHasBioPeixe();
        $select = $this->dbTableVaraPescaHasBioPeixe->select()
                ->from($this->dbTableVaraPescaHasBioPeixe,array( 'quantidade' => 'count(esp_id)', 'esp_nome_comum', $tipo = new Zend_Db_Expr('(Case When '.$tipo.'>=1 Then cast('.$tipo.' as integer) Else '.$tipo.' End)')))
                ->group(array('esp_nome_comum', $tipo))->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableVaraPescaHasBioPeixe->fetchAll($select)->toArray();
    }

    public function selectDadosBiometriaPeixe($where = null, $order = null,$limit = null){
        $this->dbTableVaraPescaHasBioPeixe = new Application_Model_DbTable_VVaraPescaHasBioPeixe();
        $select = $this->dbTableVaraPescaHasBioPeixe->select()
                ->from($this->dbTableVaraPescaHasBioPeixe,array('x'=>'tbp_comprimento', 'y'=>'tbp_peso'))
                ->order($order)->limit($limit);

        if(!is_null($where)){
            $select->where($where);
        }

        return $this->dbTableVaraPescaHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectEspeciesPeixesBiometrias()
    {
        $this->dbTableVaraPescaHasBioPeixe = new Application_Model_DbTable_VVaraPescaHasBioPeixe();
        $select = $this->dbTableVaraPescaHasBioPeixe->select()->from($this->dbTableVaraPescaHasBioPeixe, array('esp_nome_comum'=>new Zend_Db_Expr('distinct(esp_nome_comum)'), 'esp_id'))->order('esp_nome_comum');
    
        return $this->dbTableVaraPescaHasBioPeixe->fetchAll($select)->toArray();
    }
    
    public function selectPescadoresByBarco($where = null, $order = null, $limit = null){
        $this->dbTableVaraPesca = new Application_Model_DbTable_VEntrevistaVaraPesca();
        
        $select = $this->dbTableVaraPesca->select()->
                from($this->dbTableVaraPesca, array( 'bar_id' => 'distinct(bar_id)', 'bar_nome','tp_id'=> 'tp_id_entrevistado', 'tp_nome', 'tp_apelido'))->order($order)->limit($limit);
        
        if(!is_null($where)){
            $select->where($where);
        }
        
        return $this->dbTableVaraPesca->fetchAll($select)->toArray();
    }
    
    public function selectMediaEspecies($where = null, $order = null, $limit = null)
    {
        $this->dbTableVaraPescaMedia = new Application_Model_DbTable_VMediaEspeciesVaraPesca();
        $select = $this->dbTableVaraPescaMedia->select()->
                order($order)->limit($limit);
        if(!is_null($where)){
            $select->where($where);
        }
        return $this->dbTableVaraPescaMedia->fetchAll($select)->toArray();
    }
    
    public function selectAvistamentoByTipo($where = null, $limit = null)
    {
 
        $this->dbTableVaraPescaAvistamento = new Application_Model_DbTable_VVaraPescaHasAvistamento();
        $selectAvist = $this->dbTableVaraPescaAvistamento->select()->group('avs_descricao')
                ->from($this->dbTableVaraPescaAvistamento, array('quantAvist' => 'count(*)','avs_descricao'))->order('quantAvist DESC')->limit($limit);

        if(!is_null($where)){
            $selectAvist->where($where);
        }

        return $this->dbTableVaraPescaAvistamento->fetchAll($selectAvist)->toArray();
    }
}

