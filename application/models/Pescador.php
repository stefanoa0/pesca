<?php

/**
 * Model Pescador
 *
 * @package Pesca
 * @subpackage Models
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 */

class Application_Model_Pescador {

///_/_/_/_/_/_/_/_/_/_/_/_/_/ SELECT /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function select($where = null, $order = null, $limit = null) {
        $dao = new Application_Model_DbTable_Pescador();
        $select = $dao->select()->from($dao)->where('tp_pescadordeletado = false')->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $dao->fetchAll($select)->toArray();
    }
    public function selectDeletado($where = null, $order = null, $limit = null) {
        $dao = new Application_Model_DbTable_Pescador();
        $select = $dao->select()->from($dao)->where('tp_pescadordeletado = true')->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $dao->fetchAll($select)->toArray();
    }

    public function selectView($where = null, $order = null, $limit = null) {
        $dao = new Application_Model_DbTable_VPescador();
        $select = $dao->select()->from($dao)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $dao->fetchAll($select)->toArray();
    }
    

///_/_/_/_/_/_/_/_/_/_/_/_/_/ FIND - UTILIZA VIEW /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function find($id) {
        $dao = new Application_Model_DbTable_VPescador();
        $arr = $dao->find($id)->toArray();

        return $arr[0];
    }

 ///_/_/_/_/_/_/_/_/_/_/_/_/_/ SETUP DADOS ENDEREÇO /_/_/_/_/_/_/_/_/_/_/_/_/_/
    private function setupDadosEndereco( array $request ) {

        $dataCEP = explode("-", $request['cep']);
        $dataCEP = $dataCEP[0] . $dataCEP[1];

        if ( !$dataCEP ) {
            $dataCEP = NULL;
        }

        $dadosEndereco = array(
            'te_logradouro' => $request['logradouro'],
            'te_numero' => $request['numero'],
            'te_bairro' => $request['bairro'],
            'te_cep' => $dataCEP,
            'te_comp' => $request['complemento'],
            'tmun_id' => $request['municipio']
        );

        return $dadosEndereco;
    }

 ///_/_/_/_/_/_/_/_/_/_/_/_/_/ SETUP DADOS PESCADOR /_/_/_/_/_/_/_/_/_/_/_/_/_/
    private function setupDadosPescador( array $request ) {

        $dataNasc = $request['dataNasc'];
        if (!$dataNasc) {
            $dataNasc = NULL;
        }

        $dadosPescador = array(
            'tp_nome' => $request['nome'],
            'tp_sexo' => $request['sexo'],
            'tp_rg' => $request['rg'],
            'tp_cpf' => $request['cpf'],
            'tp_apelido' => $request['apelido'],
            'tp_matricula' => $request['matricula'],
            'tp_filiacaopai' => $request['filiacaoPai'],
            'tp_filiacaomae' => $request['filiacaoMae'],
            'tp_ctps' => $request['ctps'],
            'tp_pis' => $request['pis'],
            'tp_inss' => $request['inss'],
            'tp_nit_cei' => $request['nit_cei'],
            'tp_cma' => $request['cma'],
            'tp_rgb_maa_ibama' => $request['rgb_maa_ibama'],
            'tp_cir_cap_porto' => $request['cir_cap_porto'],
            'tp_datanasc' => $dataNasc,
            'tmun_id_natural' => $request['municipioNat'],
            'esc_id' => $request['selectEscolaridade'],
            'tp_resp_lan'  => $request['respLancamento'],
            'tp_resp_cad'  => $request['respCadastro'],
            'tp_dta_cad'  => date('d-m-y'),
            'tp_obs' => $request['obs'],
            'tpr_id' => $request['selectProjeto'],
            'tp_pescadordeletado' => 0
        );

        return $dadosPescador;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ INSERT /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insert(array $request) {

        $dbTableEndereco = new Application_Model_DbTable_Endereco();
        $dadosEndereco = $this->setupDadosEndereco( $request );
        $idEndereco = $dbTableEndereco->insert($dadosEndereco);

        $dbTablePescador = new Application_Model_DbTable_Pescador();
        $dadosPescador = $this->setupDadosPescador( $request );
        $dadosPescador['te_id']=$idEndereco;
        $idPescador = $dbTablePescador->insert($dadosPescador);

        return $idPescador;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ UPDATE /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function update(array $request) {

        $dbTableEndereco = new Application_Model_DbTable_Endereco();
        $dadosEndereco = $this->setupDadosEndereco( $request );
        $whereEndereco = "te_id = " . $request['idEndereco'];
        $dbTableEndereco->update($dadosEndereco, $whereEndereco);

        $dbTablePescador = new Application_Model_DbTable_Pescador();
        $dadosPescador = $this->setupDadosPescador( $request );
        $dadosPescador['te_id'] = $request['idEndereco'];
        $wherePescador = "tp_id = " . $request['idPescador'];
        $idPescador = $dbTablePescador->update($dadosPescador, $wherePescador);

        return $idPescador;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Dependentes vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasDependente($idPescador, $idTipoDependente, $qtde) {
        $dbTable_PescadorHasDependente = new Application_Model_DbTable_PescadorHasDependente();

        $dadosPescadorHasDependente = array(
            'tp_id' => $idPescador,
            'ttd_id' => $idTipoDependente,
            'tptd_quantidade' => $qtde
        );
        $dbTable_PescadorHasDependente->insert($dadosPescadorHasDependente);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Dependentes vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasDependente($idPescador, $idTipoDependente) {
        $dbTable_PescadorHasDependente = new Application_Model_DbTable_PescadorHasDependente();

        $dadosPescadorHasDependente = array(
            'tp_id = ?' => $idPescador,
            'ttd_id = ?' => $idTipoDependente
        );
        $dbTable_PescadorHasDependente->delete($dadosPescadorHasDependente);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Rendas vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasRenda($idPescador, $idTipoRenda, $idRenda) {
        $dbTable_PescadorHasRenda = new Application_Model_DbTable_PescadorHasRenda();

        $dadosPescadorHasRenda = array(
            'tp_id' => $idPescador,
            'ttr_id' => $idTipoRenda,
            'ren_id' => $idRenda
        );
        $dbTable_PescadorHasRenda->insert($dadosPescadorHasRenda);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Rendas vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasRenda($idPescador, $idTipoRenda, $idRenda) {
        $dbTable_PescadorHasRenda = new Application_Model_DbTable_PescadorHasRenda();

        $dadosPescadorHasRenda = array(
            'tp_id = ?' => $idPescador,
            'ttr_id  = ?' => $idTipoRenda,
            'ren_id  = ?' => $idRenda
        );
        $dbTable_PescadorHasRenda->delete($dadosPescadorHasRenda);

        return;
    }
 ///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Comunidade vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasComunidade($idPescador, $idComunidade ) {
        $dbTable_PescadorHasComunidade = new Application_Model_DbTable_PescadorHasComunidade();

        $dadosPescadorHasComunidade = array(
            'tp_id' => $idPescador,
            'tcom_id' => $idComunidade
        );
        $dbTable_PescadorHasComunidade->insert($dadosPescadorHasComunidade);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Comunidade vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasComunidade($idPescador, $idComunidade ) {
        $dbTable_PescadorHasComunidade = new Application_Model_DbTable_PescadorHasComunidade();

        $dadosPescadorHasComunidade = array(
            'tp_id = ?' => $idPescador,
            'tcom_id  = ?' => $idComunidade
        );
        $dbTable_PescadorHasComunidade->delete($dadosPescadorHasComunidade);

        return;
    }

 ///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Porto vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasPorto($idPescador, $idPorto ) {
        $dbTable_PescadorHasPorto = new Application_Model_DbTable_PescadorHasPorto();

        $dadosPescadorHasPorto = array(
            'tp_id' => $idPescador,
            'pto_id' => $idPorto
        );
        $dbTable_PescadorHasPorto->insert($dadosPescadorHasPorto);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Porto vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasPorto($idPescador, $idPorto ) {
        $dbTable_PescadorHasPorto = new Application_Model_DbTable_PescadorHasPorto();

        $dadosPescadorHasPorto = array(
            'tp_id = ?' => $idPescador,
            'pto_id  = ?' => $idPorto
        );
        $dbTable_PescadorHasPorto->delete($dadosPescadorHasPorto);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert ProgramaSocial vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasProgramaSocial($idPescador, $idProgramaSocial ) {
        $dbTable_PescadorHasProgramaSocial = new Application_Model_DbTable_PescadorHasProgramaSocial();

        $dadosPescadorHasProgramaSocial = array(
            'tp_id' => $idPescador,
            'prs_id' => $idProgramaSocial
        );
        $dbTable_PescadorHasProgramaSocial->insert($dadosPescadorHasProgramaSocial);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete ProgramaSocial vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasProgramaSocial($idPescador, $idProgramaSocial ) {
        $dbTable_PescadorHasProgramaSocial = new Application_Model_DbTable_PescadorHasProgramaSocial();

        $dadosPescadorHasProgramaSocial = array(
            'tp_id = ?' => $idPescador,
            'prs_id  = ?' => $idProgramaSocial
        );
        $dbTable_PescadorHasProgramaSocial->delete($dadosPescadorHasProgramaSocial);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Telefones vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasTelefone($idPescador, $idTelenone, $nTelefone) {
        $dbTable_PescadorHasTelefone = new Application_Model_DbTable_PescadorHasTelefone();

        $dadosPescadorHasTelefone = array(
            'tpt_tp_id' => $idPescador,
            'tpt_ttel_id' => $idTelenone,
            'tpt_telefone' => $nTelefone
        );
        $dbTable_PescadorHasTelefone->insert($dadosPescadorHasTelefone);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Telefones vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasTelefone($idPescador, $idTelenone) {
        $dbTable_PescadorHasTelefone = new Application_Model_DbTable_PescadorHasTelefone();

        $dadosPescadorHasTelefone = array(
            'tpt_tp_id = ?' => $idPescador,
            'tpt_ttel_id  = ?' => $idTelenone
        );
        $dbTable_PescadorHasTelefone->delete($dadosPescadorHasTelefone);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Colonia vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasColonia($idPescador, $idColonia, $dtaColonia) {
        $dbTable_PescadorHasColonia = new Application_Model_DbTable_PescadorHasColonia();

        if ($dtaColonia == 0) {
            $dtaColonia = new Zend_Db_Expr("NULL");
        }

        $dadosPescadorHasColonia = array(
            'tp_id' => $idPescador,
            'tc_id' => $idColonia,
            'tptc_datainsccolonia' => $dtaColonia
        );
        $dbTable_PescadorHasColonia->insert($dadosPescadorHasColonia);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Colonia vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasColonia($idPescador, $idColonia) {
        $dbTable_PescadorHasColonia = new Application_Model_DbTable_PescadorHasColonia();

        $dadosPescadorHasColonia = array(
            'tp_id = ?' => $idPescador,
            'tc_id  = ?' => $idColonia
        );
        $dbTable_PescadorHasColonia->delete($dadosPescadorHasColonia);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Area Pesca vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasArea($idPescador, $idArea) {
        $dbTable_PescadorHasArea = new Application_Model_DbTable_PescadorHasAreaPesca();

        $dadosPescadorHasArea = array(
            'tp_id' => $idPescador,
            'tareap_id' => $idArea
        );
        $dbTable_PescadorHasArea->insert($dadosPescadorHasArea);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Area Pesca vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasArea($idPescador, $idArea) {
        $dbTable_PescadorHasArea = new Application_Model_DbTable_PescadorHasAreaPesca();

        $dadosPescadorHasArea = array(
            'tp_id = ?' => $idPescador,
            'tareap_id  = ?' => $idArea
        );
        $dbTable_PescadorHasArea->delete($dadosPescadorHasArea);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Area/Tipo Pesca vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasArteTipo($idPescador, $idArte ) {
        $dbTable_PescadorHasArteTipo = new Application_Model_DbTable_PescadorHasArtePesca();

        $dadosPescadorHasArteTipo = array(
            'tp_id' => $idPescador,
            'tap_id' => $idArte,
        );
        $dbTable_PescadorHasArteTipo->insert($dadosPescadorHasArteTipo);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Area/Tipo Pesca vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasArteTipo($idPescador, $idArte ) {
        $dbTable_PescadorHasArteTipo = new Application_Model_DbTable_PescadorHasArtePesca();

        $dadosPescadorHasArteTipo = array(
            'tp_id = ?' => $idPescador,
            'tap_id  = ?' => $idArte,
        );
        $dbTable_PescadorHasArteTipo->delete($dadosPescadorHasArteTipo);

        return;
    }
///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Tipo Pesca vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasTipo($idPescador, $idTipo ) {
        $dbTable_PescadorHasTipo = new Application_Model_DbTable_PescadorHasEspecieCapturada();

        $dadosPescadorHasTipo = array(
            'tp_id' => $idPescador,
            'itc_id' => $idTipo,
        );
        $dbTable_PescadorHasTipo->insert($dadosPescadorHasTipo);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Tipo Pesca vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasTipo($idPescador, $idTipo ) {
        $dbTable_PescadorHasTipo = new Application_Model_DbTable_PescadorHasEspecieCapturada();

        $dadosPescadorHasTipo = array(
            'tp_id = ?' => $idPescador,
            'itc_id  = ?' => $idTipo,
        );
        $dbTable_PescadorHasTipo->delete($dadosPescadorHasTipo);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Insert Embarcações vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelInsertPescadorHasEmbarcacoes($idPescador, $idEmbarcacao, $idPorte, $isMotor, $idDono) {
        $dbTable_PescadorHasEmbarcacoes = new Application_Model_DbTable_PescadorHasEmbarcacao();

        $dadosPescadorHasEmbarcacoes = array(
            'tp_id' => $idPescador,
            'tte_id' => $idEmbarcacao,
            'tpe_id' => $idPorte,
            'tpte_motor' => $isMotor,
            'tpte_dono' => $idDono
        );
        $dbTable_PescadorHasEmbarcacoes->insert($dadosPescadorHasEmbarcacoes);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Delete Embarcações vindos do Cadastro de Pescador  /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function modelDeletePescadorHasEmbarcacoes($idPescadorEmbarcacao) {
        $dbTable_PescadorHasEmbarcacoes = new Application_Model_DbTable_PescadorHasEmbarcacao();

        
        $wherePescadorHasEmbarcacao= $dbTable_PescadorHasEmbarcacoes->getAdapter()
                ->quoteInto('"tpte_id" = ?', $idPescadorEmbarcacao);
        
        $dbTable_PescadorHasEmbarcacoes->delete($wherePescadorHasEmbarcacao);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ INSERT /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function delete($idPescador) {
        $dbTablePescador = new Application_Model_DbTable_Pescador();

        $dadosPescador = array(
            'tp_pescadordeletado' => TRUE
        );

        $wherePescador = $dbTablePescador->getAdapter()->quoteInto('"tp_id" = ?', $idPescador);

        $dbTablePescador->update($dadosPescador, $wherePescador);
    }
    public function restaure($idPescador) {
        $dbTablePescador = new Application_Model_DbTable_Pescador();

        $dadosPescador = array(
            'tp_pescadordeletado' => FALSE
        );

        $wherePescador = $dbTablePescador->getAdapter()->quoteInto('"tp_id" = ?', $idPescador);

        $dbTablePescador->update($dadosPescador, $wherePescador);
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ SELECT /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function select_Pescador_By_Municipio($where = null, $order = null, $limit = null) {
        $dao = new Application_Model_DbTable_VPescadorByMunicipio();
        $select = $dao->select()->from($dao)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $dao->fetchAll($select)->toArray();
    }

    public function select_Pescador_group_comunidade() {
        $db = new Application_Model_DbTable_VPescador();
        $select = $db->select()
                ->from('v_pescador', array('count(*)','tcom_id', 'tcom_nome'))
                ->group(array('tcom_id', 'tcom_nome'))
                ->order('tcom_nome');

        return $db->fetchAll($select)->toArray();
    }

    public function select_Pescador_group_colonia() {
        $db = new Application_Model_DbTable_VPescador();
        $select = $db->select()
                ->from('v_pescador', array('count(*)','tc_id', 'tc_nome'))
                ->group(array('tc_id', 'tc_nome'))
                ->order('tc_nome');

        return $db->fetchAll($select)->toArray();
    }
    public function selectPescadorByPortos($where = null, $order = null, $limit = null) {
        $dao = new Application_Model_DbTable_VPescadorByPortos();
        $select = $dao->select()->from($dao)->order($order)->limit($limit);

        if (!is_null($where)) {
            $select->where($where);
        }

        return $dao->fetchAll($select)->toArray();
    }
    
    
    
    
}
