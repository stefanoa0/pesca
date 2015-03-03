<?php
set_time_limit(0);
/**
 * Controller de Pescadores
 *
 * @package Pesca
 * @subpackage Controllers
 * @author Elenildo João <elenildo.joao@gmail.com>
 * @version 0.1
 * @access public
 *
 *
 */
class PescadorController extends Zend_Controller_Action {

    private $modelPescador;
    private $usuario;
    private $modelPescadorEspecialista;

    public function init() {
        if (!Zend_Auth::getInstance()->hasIdentity()) {
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');


        $auth = Zend_Auth::getInstance();
        if ($auth->hasIdentity()) {
            $identity = $auth->getIdentity();
            $identity2 = get_object_vars($identity);
        }

        $this->modelUsuario = new Application_Model_Usuario();
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario", $this->usuario);


        $this->modelPescador = new Application_Model_Pescador();
        $this->modelPescadorEspecialista = new Application_Model_PescadorEspecialista();
    }

    public function indexAction() {
        $tp_id = $this->_getParam("tp_id");
        $tp_nome = $this->_getParam("tp_nome");
        $tp_apelido = $this->_getParam('tp_apelido');
        $tp_letra = $this->_getParam("tp_letra");
        $tp_all = $this->_getParam("tp_all");
        $tp_especialista = $this->_getParam("tp_especialidade");

        if ($tp_id > 0) {
            $dados = $this->modelPescador->selectView("tp_id>=" . $tp_id, array('tp_id'), 30);
        } elseif ($tp_nome) {
            $dados = $this->modelPescador->selectView("tp_nome ~*'". $tp_nome ."'", array('tp_nome', 'tp_id'));
        }
        elseif ($tp_apelido) {
            $dados = $this->modelPescador->selectView("tp_apelido ~* '" . $tp_apelido. "'", array('tp_nome', 'tp_id'));
        }
        elseif($tp_letra){
            $dados = $this->modelPescador->selectView("tp_nome LIKE '".$tp_letra."%'", array('tp_nome'));
        }
        elseif($tp_all){
            $dados = $this->modelPescador->selectView(null, array('tp_nome', 'tp_id'));
        }
        elseif($tp_especialista){
            $dados = $this->modelPescador->selectView("tp_especialidade IS DISTINCT FROM Null");
        }
        else {
            $dados = $this->modelPescador->selectView(null, array('tp_id DESC'), 20);
        }
        //print_r();
        $this->view->assign("dados", $dados);
    }

    public function visualizarAction() {
        $idPescador = $this->_getParam('id');

        $usuario = $this->modelPescador->find($idPescador);

        $this->view->assign("pescador", $usuario);
    }
    public function novoAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $modelMunicipio = new Application_Model_Municipio();
        $municipios = $modelMunicipio->select(NULL,'tmun_municipio');
        $this->view->assign("municipios", $municipios);

        $modelEscolaridade = new Application_Model_Escolaridade();
        $escolaridade = $modelEscolaridade->select();
        $this->view->assign("assignEscolaridades", $escolaridade);

        $modelUser = new Application_Model_Usuario();
        $tipoUser = $modelUser->select(NULL, 'tu_nome');
        $this->view->assign("assignUser", $tipoUser);
        
        $modelProjetos = new Application_Model_Projetos(Null, 'tpr_descricao');
        $projetos = $modelProjetos->select();
        $this->view->assign("assignProjetos", $projetos);
    }

    public function criarAction() {
        $this->modelPescador->insert($this->_getAllParams());

        $this->_redirect('pescador/index');
    }
    
    public function toerror($var){
        if(empty($var)){
            $this->redirect('exception/error');
        }
    }
    public function naoexiste($var){
        if(empty($var)){
            $this->redirect('exception/naoexiste');
        }
    }
    
    public function editarAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $idPescador = $this->_getParam('id');
        
        $this->toerror($idPescador);

        $pescador = $this->modelPescador->find($idPescador);
        
        $this->naoexiste($pescador);
        $this->view->assign("pescador", $pescador);
        
        $modelMunicipio = new Application_Model_Municipio();
        $municipios = $modelMunicipio->select(NULL,'tmun_municipio');
        $this->view->assign("municipios", $municipios);

        $modelArtePesca = new Application_Model_ArtePesca();
        $artesPesca = $modelArtePesca->select();
        $this->view->assign("artesPesca", $artesPesca);

        $modelAreaPesca = new Application_Model_AreaPesca();
        $areasPesca = $modelAreaPesca->select();
        $this->view->assign("areasPesca", $areasPesca);

        $modelColonia = new Application_Model_Colonia();
        $colonias = $modelColonia->select();
        $this->view->assign("colonias", $colonias);

        $modelEspecie = new Application_Model_Especie();
        $especies = $modelEspecie->select();
        $this->view->assign("especies", $especies);

        $modelTipoEmbarcacao = new Application_Model_TipoEmbarcacao();
        $tiposEmbarcacao = $modelTipoEmbarcacao->select();
        $this->view->assign("tiposEmbarcacao", $tiposEmbarcacao);

        $modelPorteEmbarcacao = new Application_Model_PorteEmbarcacao();
        $portesEmbarcacao = $modelPorteEmbarcacao->select();
        $this->view->assign("portesEmbarcacao", $portesEmbarcacao);

        $modelTipoCapturada = new Application_Model_TipoCapturadaModel();
        $tipoCapturadas = $modelTipoCapturada->select();
        $this->view->assign("tipoCapturadas", $tipoCapturadas);

        $modelTipoTelefone = new Application_Model_TipoTelefone();
        $tipoTelefones = $modelTipoTelefone->select();
        $this->view->assign("assignTipoTelefones", $tipoTelefones);

        $modelEscolaridade = new Application_Model_Escolaridade();
        $escolaridade = $modelEscolaridade->select();
        $this->view->assign("assignEscolaridades", $escolaridade);

        $modelTipoDependente = new Application_Model_TipoDependente();
        $tipoDependentes = $modelTipoDependente->select();
        $this->view->assign("assignTipoDependentes", $tipoDependentes);

        $modelRenda = new Application_Model_Renda();
        $rendas = $modelRenda->select();
        $this->view->assign("assignRendas", $rendas);

        $modelTipoRenda = new Application_Model_TipoRenda();
        $tipoRendas = $modelTipoRenda->select();
        $this->view->assign("assignTipoRendas", $tipoRendas);

        $modelProgramaSocial = new Application_Model_ProgramaSocial();
        $tipoProgramaSocial = $modelProgramaSocial->select();
        $this->view->assign("assignProgramaSocial", $tipoProgramaSocial);

        $modelComunidade = new Application_Model_Comunidade();
        $tipoComunidade = $modelComunidade->select();
        $this->view->assign("assignComunidade", $tipoComunidade);

        $modelPorto = new Application_Model_Porto();
        $tipoPorto = $modelPorto->select();
        $this->view->assign("assignPorto", $tipoPorto);

        $modelUser = new Application_Model_Usuario();
        $tipoUser = $modelUser->select();
        $this->view->assign("assignUser", $tipoUser);
        
        $modelBarcos = new Application_Model_Barcos();
        $barcos = $modelBarcos->select(null, 'bar_nome');
        $this->view->assign("assignBarcos", $barcos);
        
        $modelProjetos = new Application_Model_Projetos(Null, 'tpr_descricao');
        $projetos = $modelProjetos->select();
        $this->view->assign("assignProjetos", $projetos);

//     /_/_/_/_/_/_/_/_/_/_/_/_/_/ UTILIZA VIEW PARA FACILITAR MONTAGEM DA CONSULTA /_/_/_/_/_/_/_/_/_/_/_/_/_/
        $model_VPescadorHasDependente = new Application_Model_VPescadorHasDependente();
        $vPescadorHasDependente = $model_VPescadorHasDependente->selectDependentes("tp_id=" . $idPescador, "ttd_tipodependente");
        $this->view->assign("assign_vPescadorDependente", $vPescadorHasDependente);

        $model_VPescadorHasRenda = new Application_Model_VPescadorHasRenda();
        $vPescadorHasRenda = $model_VPescadorHasRenda->select("tp_id=" . $idPescador, "ttr_descricao");
        $this->view->assign("assign_vPescadorRenda", $vPescadorHasRenda);

        $model_VPescadorHasComunidade = new Application_Model_VPescadorHasComunidade();
        $vPescadorHasComunidade = $model_VPescadorHasComunidade->select("tp_id=" . $idPescador, "tcom_nome");
        $this->view->assign("assign_vPescadorComunidade", $vPescadorHasComunidade);

        $model_VPescadorHasProgramaSocial = new Application_Model_VPescadorHasProgramaSocial();
        $vPescadorHasProgramaSocial = $model_VPescadorHasProgramaSocial->select("tp_id=" . $idPescador, "prs_programa");
        $this->view->assign("assign_vPescadorProgramaSocial", $vPescadorHasProgramaSocial);

        $model_VPescadorHasTelefone = new Application_Model_VPescadorHasTelefone();
        $vPescadorHasTelefone = $model_VPescadorHasTelefone->select("tpt_tp_id=" . $idPescador, "ttel_desc");
        $this->view->assign("assign_vPescadorHasTelefone", $vPescadorHasTelefone);

        $model_VPescadorHasColonia = new Application_Model_VPescadorHasColonia();
        $vPescadorHasColonia = $model_VPescadorHasColonia->select("tp_id=" . $idPescador, "tc_nome");
        $this->view->assign("assign_vPescadorColonia", $vPescadorHasColonia);

        $model_VPescadorHasAreaPesca = new Application_Model_VPescadorHasAreaPesca();
        $vPescadorHasAreaPesca = $model_VPescadorHasAreaPesca->select("tp_id=" . $idPescador, "tareap_areapesca");
        $this->view->assign("assign_vPescadorAreaPesca", $vPescadorHasAreaPesca);

        $model_VPescadorHasArteTipoArea = new Application_Model_VPescadorHasArteTipoArea();
        $vPescadorHasArteTipoArea = $model_VPescadorHasArteTipoArea->select("tp_id=" . $idPescador, "tap_artepesca");
        $this->view->assign("assign_vPescadorArteTipoArea", $vPescadorHasArteTipoArea);

        $VPescadorHasTipoCapturada = new Application_Model_VPescadorHasTipoCapturada();
        $vPescadorHasTipoCapturada = $VPescadorHasTipoCapturada->select("tp_id=" . $idPescador, "itc_tipo");
        $this->view->assign("assign_vPescadorTipoCapturada", $vPescadorHasTipoCapturada);

        $model_VPescadorHasEmbarcacao = new Application_Model_VPescadorHasEmbarcacao();
        $vPescadorHasEmbarcacao = $model_VPescadorHasEmbarcacao->select("tp_id=" . $idPescador, "tte_tipoembarcacao");
        $this->view->assign("assign_vPescadorEmbarcacao", $vPescadorHasEmbarcacao);

        $model_VPescadorHasPorto = new Application_Model_VPescadorHasPorto();
        $vPescadorHasPorto = $model_VPescadorHasPorto->select("tp_id=" . $idPescador, "pto_nome");
        $this->view->assign("assign_vPescadorPorto", $vPescadorHasPorto);
        
//Pescador Especialista///////////////////////////////////////////////////////////////////////
        
        $assignEspecialista = $this->modelPescadorEspecialista->select("tp_id=".$idPescador);
        $this->view->assign("assignEspecialista", $assignEspecialista);
        
        
        $modelEstadoCivil = new Application_Model_EstadoCivil();
        $selectEstadoCivil = $modelEstadoCivil->select(null, "tec_id");
        $this->view->assign("selectEstadoCivil", $selectEstadoCivil);
        
        
        $modelResidencia = new Application_Model_Residencia();
        $selectResidencia = $modelResidencia->select(null, "tre_id");
        $this->view->assign("selectResidencia", $selectResidencia);
        
        $modelEstruturaResidencial = new Application_Model_EstruturaResidencial();
        $selectEstruturaResidencial = $modelEstruturaResidencial->select(null, "terd_id");
        $this->view->assign("selectEstruturaResidencial", $selectEstruturaResidencial);
        
        $modelEstacaoAno = new Application_Model_EstacaoAno();
        $selectEstacaoAno = $modelEstacaoAno->select(null, "tea_id");
        $this->view->assign("selectEstacaoAno", $selectEstacaoAno);
        
        $modelSeguroDefeso = new Application_Model_SeguroDefeso();
        $selectSeguroDefeso = $modelSeguroDefeso->select(null, "tsd_id");
        $this->view->assign("selectSeguroDefeso", $selectSeguroDefeso);
        
        $modelMotivoPesca = new Application_Model_MotivoPesca();
        $selectMotivoPesca = $modelMotivoPesca->select(null, "tmp_id");
        $this->view->assign("selectMotivoPesca", $selectMotivoPesca);
        
        $modelTipoTransporte = new Application_Model_TipoTransporte();
        $selectTipoTransporte = $modelTipoTransporte->select(null, "ttr_id");
        $this->view->assign("selectTipoTransporte", $selectTipoTransporte);
        
        $modelAcompanhado = new Application_Model_Acompanhado();
        $selectAcompanhado = $modelAcompanhado->select(null, "tacp_id");
        $this->view->assign("selectAcompanhado", $selectAcompanhado);
        
        $modelFrequenciaPesca = new Application_Model_FrequenciaPesca();
        $selectFrequenciaPesca = $modelFrequenciaPesca->select(null, "tfp_id");
        $this->view->assign("selectFrequenciaPesca", $selectFrequenciaPesca);
        
        $modelHorarioPesca = new Application_Model_HorarioPesca();
        $selectHorarioPesca = $modelHorarioPesca->select(null, "thp_id");
        $this->view->assign("selectHorarioPesca", $selectHorarioPesca);
        
        $modelUltimaPesca = new Application_Model_UltimaPesca();
        $selectUltimaPesca = $modelUltimaPesca->select(null, "tup_id");
        $this->view->assign("selectUltimaPesca", $selectUltimaPesca);
        
        $modelInsumo = new Application_Model_Insumo();
        $selectInsumo = $modelInsumo->select(null, "tin_id");
        $this->view->assign("selectInsumo", $selectInsumo);
        
        $modelFornecedorInsumos = new Application_Model_FornecedorInsumos();
        $selectFornecedorInsumos = $modelFornecedorInsumos->select(null, "tfi_id");
        $this->view->assign("selectFornecedorInsumos", $selectFornecedorInsumos);
        
        $modelRecursos = new Application_Model_Recurso();
        $selectRecursos = $modelRecursos->select(null, "trec_id");
        $this->view->assign("selectRecursos", $selectRecursos);
        
        $modelLocalTratamento = new Application_Model_LocalTratamento();
        $selectLocalTratamento = $modelLocalTratamento->select(null, "tlt_id");
        $this->view->assign("selectLocalTratamento", $selectLocalTratamento);
        
        $modelAssociacaoPesca = new Application_Model_AssociacaoPesca();
        $selectAssociacaoPesca = $modelAssociacaoPesca->select(null, "tasp_id");
        $this->view->assign("selectAssociacaoPesca", $selectAssociacaoPesca);
        
        $modelOrgaoRgp = new Application_Model_OrgaoRgp();
        $selectOrgaoRgp = $modelOrgaoRgp->select(null, "trgp_id");
        $this->view->assign("selectOrgaoRgp", $selectOrgaoRgp);
        
        $modelDificuldade = new Application_Model_Dificuldade();
        $selectDificuldade = $modelDificuldade->select(null, "tdif_id");
        $this->view->assign("selectDificuldade", $selectDificuldade);
        
        $modelDestinoPescado = new Application_Model_DestinoPescado();
        $selectDestinoPescado= $modelDestinoPescado->select(null, 'dp_id');
        $this->view->assign("selectDestinoPescado", $selectDestinoPescado);
        
        $modelSobraDaPesca = new Application_Model_SobraDaPesca();
        $selectSobraDaPesca= $modelSobraDaPesca->select(null, 'tsp_id');
        $this->view->assign("selectSobraPesca", $selectSobraDaPesca);
        
        
        
        
/////VIEWS PESCADOR ESPECIALISTA
        
        $vEspecialistaHasAcompanhado = $this->modelPescadorEspecialista->selectVAcompanhado("tps_id=" . $idPescador, "tacp_companhia");
        $this->view->assign("assign_vEspecialistaHasAcompanhado", $vEspecialistaHasAcompanhado);
        
        $vEspecialistaHasCompanhia = $this->modelPescadorEspecialista->selectVCompanhia("tps_id=" . $idPescador, "ttd_tipodependente");
        $this->view->assign("assign_vEspecialistaHasCompanhia", $vEspecialistaHasCompanhia);
        
        $vEspecialistaHasEstruturaResidencial = $this->modelPescadorEspecialista->selectVEstruturaResidencial("tps_id=" . $idPescador, "terd_estrutura");
        $this->view->assign("assign_vEspecialistaHasEstruturaResidencial", $vEspecialistaHasEstruturaResidencial);
        
        $vEspecialistaHasHorarioPesca = $this->modelPescadorEspecialista->selectVHorarioPesca("tps_id=" . $idPescador, "thp_horario");
        $this->view->assign("assign_vEspecialistaHasHorarioPesca", $vEspecialistaHasHorarioPesca);
        
        $vEspecialistaHasInsumo = $this->modelPescadorEspecialista->selectVInsumos("tps_id=" . $idPescador, "tin_insumo");
        $this->view->assign("assign_vEspecialistaHasInsumo", $vEspecialistaHasInsumo);
        
        $vEspecialistaHasMotivoPesca = $this->modelPescadorEspecialista->selectVMotivoPesca("tps_id=" . $idPescador, "tmp_motivo");
        $this->view->assign("assign_vEspecialistaHasMotivoPesca", $vEspecialistaHasMotivoPesca);
        
        $vEspecialistaHasNoSeguro = $this->modelPescadorEspecialista->selectVNoSeguro("tps_id=" . $idPescador, "ttr_descricao");
        $this->view->assign("assign_vEspecialistaHasNoSeguro", $vEspecialistaHasNoSeguro);
        
        $vEspecialistaHasParentes = $this->modelPescadorEspecialista->selectVParentes("tps_id=" . $idPescador, "ttd_tipodependente");
        $this->view->assign("assign_vEspecialistaHasParentes", $vEspecialistaHasParentes);
        
        $vEspecialistaHasProgramaSocial = $this->modelPescadorEspecialista->selectVProgramaSocial("tps_id=" . $idPescador, "prs_programa");
        $this->view->assign("assign_vEspecialistaHasProgramaSocial", $vEspecialistaHasProgramaSocial);
        
        $vEspecialistaHasSeguroDefeso = $this->modelPescadorEspecialista->selectVSeguroDefeso("tps_id=" . $idPescador, "tsd_seguro");
        $this->view->assign("assign_vEspecialistaHasSeguroDefeso", $vEspecialistaHasSeguroDefeso);
        
        $vEspecialistaHasTipoTransporte = $this->modelPescadorEspecialista->selectVTipoTransporte("tps_id=" . $idPescador, "ttr_transporte");
        $this->view->assign("assign_vEspecialistaHasTipoTransporte", $vEspecialistaHasTipoTransporte);
    
        $vEspecialistaHasDestinoPescado = $this->modelPescadorEspecialista->selectVDestinoPescado("tps_id=".$idPescador, "dp_id_pescado");
        $this->view->assign("assign_vEspecialistaHasDestinoPescado", $vEspecialistaHasDestinoPescado);
    
        $vEspecialistaHasDificuldadeArea = $this->modelPescadorEspecialista->selectVDificuldadeArea("tps_id=".$idPescador, "tdif_id_area");
        $this->view->assign("assign_vEspecialistaHasDificuldadeArea", $vEspecialistaHasDificuldadeArea);
    
        $vEspecialistaHasCompradorPescado = $this->modelPescadorEspecialista->selectVCompradorPescado("tps_id=".$idPescador, "dp_id");
        $this->view->assign("assign_vEspecialistaHasCompradorPescado", $vEspecialistaHasCompradorPescado);
        
        $vEspecialistaHasRecursos = $this->modelPescadorEspecialista->selectVRecurso("tps_id=".$idPescador, "trec_id");
        $this->view->assign("assign_vEspecialistaHasRecursos", $vEspecialistaHasRecursos);
        
        $vEspecialistaHasFornecedorInsumos = $this->modelPescadorEspecialista->selectVFornecedorInsumos("tps_id=".$idPescador, "tfi_id");
        $this->view->assign("assign_vEspecialistaHasFornecedorInsumos", $vEspecialistaHasFornecedorInsumos);
        
        $vEspecialistaHasHabilidades = $this->modelPescadorEspecialista->selectVHabilidades("tps_id=".$idPescador, "ttr_id");
        $this->view->assign("assign_vEspecialistaHasHabilidades", $vEspecialistaHasHabilidades);
        
        $vEspecialistaHasEmbarcacoes = $this->modelPescadorEspecialista->selectVBarco("tps_id=".$idPescador, "bar_id");
        $this->view->assign("assign_vEspecialistaHasEmbarcacoes", $vEspecialistaHasEmbarcacoes);
        
        
    }
    public function atualizarsemreloadAction() {
        $this->modelPescador->update($this->_getAllParams());

//        $this->_redirect('pescador/index');
    }

    public function atualizarAction() {
        $this->modelPescador->update($this->_getAllParams());

        $this->_redirect('pescador/index');
    }

    public function excluirAction() {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if ($this->usuario['tp_id'] == 15 | $this->usuario['tp_id'] == 17 | $this->usuario['tp_id'] == 21) {
            $this->_redirect('index');
        } else {
            $this->modelPescador->delete($this->_getParam('id'));

            $this->_redirect('pescador/index');
        }
    }
    public function restaureAction() {
        if ($this->usuario['tp_id'] == 15 | $this->usuario['tp_id'] == 17 | $this->usuario['tp_id'] == 21) {
            $this->_redirect('index');
        } else {
            $this->modelPescador->restaure($this->_getParam('id'));

            $this->_redirect('administrador/index');
        }
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Endereço /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function filteridAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $tp_id = $this->_getParam("id");

        $dados = $this->modelPescador->select("tp_id>=" . $tp_id, array('tp_nome', 'tp_id'));

        $this->view->assign("dados", $dados);

        $this->_redirect('pescador/index');
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Endereço /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function atualizarpescadorenderecoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $backUrl = $this->_getParam("back_url");

        $setupDados = array(
            "idEndereco" => $this->_getParam("te_id"),
            'logradouro' => $this->_getParam("te_logradouro"),
            'numero' => $this->_getParam("te_numero"),
            'bairro' => $this->_getParam("te_bairro"),
            'cep' => $this->_getParam("te_cep"),
            'complemento' => $this->_getParam("te_comp"),
            'municipio' => $this->_getParam("tmun_id"),
            'idPescador' => $this->_getParam("tp_id"),
            'nome' => $this->_getParam("tp_nome"),
            'sexo' => $this->_getParam("tp_sexo"),
            'rg' => $this->_getParam("tp_rg"),
            'cpf' => $this->_getParam("tp_cpf"),
            'apelido' => $this->_getParam("tp_apelido"),
            'matricula' => $this->_getParam("tp_matricula"),
            'filiacaoPai' => $this->_getParam("tp_filiacaopai"),
            'filiacaoMae' => $this->_getParam("tp_filiacaomae"),
            'ctps' => $this->_getParam("tp_ctps"),
            'pis' => $this->_getParam("tp_pis"),
            'inss' => $this->_getParam("tp_inss"),
            'nit_cei' => $this->_getParam("tp_nit_cei"),
            'cma' => $this->_getParam("tp_cma"),
            'rgb_maa_ibama' => $this->_getParam("tp_rgb_maa_ibama"),
            'cir_cap_porto' => $this->_getParam("tp_cir_cap_porto"),
            'dataNasc' => $this->_getParam("tp_datanasc"),
            'municipioNat' => $this->_getParam("tmun_id_natural"),
            'selectEscolaridade' => $this->_getParam("esc_id"),
            'respLancamento' => $this->_getParam("tp_resp_lan"),
            'respCadastro' => $this->_getParam("tp_resp_cad"),
            'obs' => $this->_getParam("tp_obs")
        );

        $idPescador = $this->_getParam("tp_id");

        $this->modelPescador->update($setupDados);

        $this->_redirect("/pescador/editar/id/" . $idPescador);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Endereço /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorenderecoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        

        $setupDados = array(
            'logradouro' => $this->_getParam("te_logradouro"),
            'numero' => $this->_getParam("te_numero"),
            'bairro' => $this->_getParam("te_bairro"),
            'cep' => $this->_getParam("te_cep"),
            'complemento' => $this->_getParam("te_comp"),
            'municipio' => $this->_getParam("tmun_id"),
            'nome' => $this->_getParam("tp_nome"),
            'sexo' => $this->_getParam("tp_sexo"),
            'rg' => $this->_getParam("tp_rg"),
            'cpf' => $this->_getParam("tp_cpf"),
            'apelido' => $this->_getParam("tp_apelido"),
            'matricula' => $this->_getParam("tp_matricula"),
            'filiacaoPai' => $this->_getParam("tp_filiacaopai"),
            'filiacaoMae' => $this->_getParam("tp_filiacaomae"),
            'ctps' => $this->_getParam("tp_ctps"),
            'pis' => $this->_getParam("tp_pis"),
            'inss' => $this->_getParam("tp_inss"),
            'nit_cei' => $this->_getParam("tp_nit_cei"),
            'cma' => $this->_getParam("tp_cma"),
            'rgb_maa_ibama' => $this->_getParam("tp_rgb_maa_ibama"),
            'cir_cap_porto' => $this->_getParam("tp_cir_cap_porto"),
            'dataNasc' => $this->_getParam("tp_datanasc"),
            'municipioNat' => $this->_getParam("tmun_id_natural"),
            'selectEscolaridade' => $this->_getParam("esc_id"),
            'selectProjeto' => $this->_getParam("tpr_id"),
            'respLancamento' => $this->_getParam("tp_resp_lan"),
            'respCadastro' => $this->_getParam("tp_resp_cad"),
            'obs' => $this->_getParam("tp_obs")
        );

        $idPescador = $this->modelPescador->insert($setupDados);

        $this->_redirect("/pescador/editar/id/" . $idPescador);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Dependentes /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhasdependenteAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idTipoDependente = $this->_getParam("idDependente");

        $tptd_quantidade = $this->_getParam("quant");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasDependente($idPescador, $idTipoDependente, $tptd_quantidade);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhasdependenteAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idTipoDependente = $this->_getParam("idDependente");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasDependente($idPescador, $idTipoDependente);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Renda /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhasrendaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idTipoRenda = $this->_getParam("idTipoRenda");

        $idRenda = $this->_getParam("idRenda");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasRenda($idPescador, $idTipoRenda, $idRenda);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhasrendaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idTipoRenda = $this->_getParam("idTipoRenda");

        $idRenda = $this->_getParam("idRenda");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasRenda($idPescador, $idTipoRenda, $idRenda);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_ProgramaSocial /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhascomunidadeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idComunidade = $this->_getParam("idComunidade");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasComunidade($idPescador, $idComunidade);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhascomunidadeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idComunidade = $this->_getParam("idComunidade");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasComunidade($idPescador, $idComunidade);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Porto /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhasportoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idPorto = $this->_getParam("idPorto");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasPorto($idPescador, $idPorto);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhasportoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idPorto = $this->_getParam("idPorto");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasPorto($idPescador, $idPorto);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_ProgramaSocial /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhasprogramasocialAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idProgramaSocial = $this->_getParam("idProgramaSocial");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasProgramaSocial($idPescador, $idProgramaSocial);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhasprogramasocialAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idProgramaSocial = $this->_getParam("idProgramaSocial");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasProgramaSocial($idPescador, $idProgramaSocial);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Telefone /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhastelefoneAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idTelenone = $this->_getParam("idTelenone");

        $nTelefone = $this->_getParam("nTelefone");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasTelefone($idPescador, $idTelenone, $nTelefone);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhastelefoneAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idTelenone = $this->_getParam("idTelenone");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasTelefone($idPescador, $idTelenone);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Colonia /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhascoloniaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idColonia = $this->_getParam("idColonia");

        $dtaColonia = $this->_getParam("dtaColonia");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasColonia($idPescador, $idColonia, $dtaColonia);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhascoloniaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idColonia = $this->_getParam("idColonia");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasColonia($idPescador, $idColonia);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    ///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Area /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhasareaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idArea = $this->_getParam("idArea");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasArea($idPescador, $idArea);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhasareaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idArea = $this->_getParam("idArea");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasArea($idPescador, $idArea);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    ///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Arte /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhasartetipoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idArte = $this->_getParam("idArte");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasArteTipo($idPescador, $idArte);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhasartetipoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idArte = $this->_getParam("idArte");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasArteTipo($idPescador, $idArte);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    ///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_TipoCapturada /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhastipoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idTipo = $this->_getParam("idTipo");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasTipo($idPescador, $idTipo);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhastipoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idTipo = $this->_getParam("idTipo");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasTipo($idPescador, $idTipo);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

///_/_/_/_/_/_/_/_/_/_/_/_/_/ Pescador_has_Embarcações /_/_/_/_/_/_/_/_/_/_/_/_/_/
    public function insertpescadorhasembarcacoesAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $idDono = $this->_getParam("idDono");

        $idEmbarcacao = $this->_getParam("idEmbarcacao");

        $idPorte = $this->_getParam("idPorte");

        $isMotor = $this->_getParam("isMotor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelInsertPescadorHasEmbarcacoes($idPescador, $idEmbarcacao, $idPorte, $isMotor, $idDono);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function deletepescadorhasembarcacoesAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescadorEmbarcacao = $this->_getParam("idPescadorEmbarcacao");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescador->modelDeletePescadorHasEmbarcacoes($idPescadorEmbarcacao);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }

    public function relxlspescadorAction($where = NULL) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelPescador = new Application_Model_Pescador();

        $localPescador = $localModelPescador->select($where, array('tp_nome', 'tp_id'), NULL);

        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 1, 'Pescador');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, 3, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, 3, 'Nome');
        $cont = 0;
        $linha = 4;
        foreach ($localPescador as $key => $pescador):
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $linha, $pescador['tp_id']);
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $pescador['tp_nome']);
            $linha++;
            $cont++;
        endforeach;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $linha, $cont);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="teste.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    }
//    public function gerarAction(){
//        $relatorio = $this->_getAllParams();
//        
//        switch($relatorio['tipoRelatorio']){
//            case '1': $this->
//        }
//    }
    public function imprimirtodospescadoresAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->relpdfpescador( 'tpr_id = 2' );
    }

    public function imprimirtodospescadores2Action() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->relpdfpescador( 'tpr_id = 1' );
    }

    public function imprimirpescadoridAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $pescadorId = $this->_getParam('id_pescador');

        $this->relpdfpescador( 'tp_id = ' . $pescadorId );
    }
    public function imprimirpescadorAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        $pescadorId = $this->_getParam('id_pescador');

        $this->relpdfpescador();
    }
    
    public function relpdfpescador( $where = null) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelPescador = new Application_Model_Pescador();
        $localPescador = $localModelPescador->selectView($where, array('pto_nome', 'tp_nome', 'tp_id'), NULL);

        $localModelTelefone = new Application_Model_VPescadorHasTelefone();
        $localModelDependente = new Application_Model_VPescadorHasDependente();
        $localModelRenda = new Application_Model_VPescadorHasRenda();
        $localModelProgramaSocial = new Application_Model_VPescadorHasProgramaSocial();
        $localModelAreaPesca = new Application_Model_VPescadorHasAreaPesca();
        $localModelArtePesca = new Application_Model_VPescadorHasArteTipoArea();
        $localModelTipoCapturada = new Application_Model_VPescadorHasTipoCapturada();
        $localModelEmbarcacoes = new Application_Model_VPescadorHasEmbarcacao();

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório de Pescador');

        $modeloRelatorio->setLegendaOff();

        $localDependente = $localModelDependente->selectDependentes(NULL, null, NULL);
        $localRenda = $localModelRenda->select( NULL, null, NULL);
        $localProgramaSocial = $localModelProgramaSocial->select(NULL, null, NULL);
        $localTelefone = $localModelTelefone->select(NULL, null, NULL);
        $localAreaPesca = $localModelAreaPesca->select(NULL, null, NULL);
        $localArtePesca = $localModelArtePesca->select(NULL, null, NULL);
        $localTipoCapturada = $localModelTipoCapturada->select(NULL, null, NULL);
        $localEmbarcacoes = $localModelEmbarcacoes->select(NULL, null, NULL);

        $countNPescPag = 0;
        $contPescador = 0;  
        foreach ($localPescador as $key => $pescador):
            
            $modeloRelatorio->setLegValue(30, 'Nome: ', $pescador['tp_nome']);
            $modeloRelatorio->setLegValueAlinhadoDireita(460, 70, 'Código: ', $pescador['tp_id']);
            $modeloRelatorio->setLegValue(530, 'Sexo: ', $pescador['tp_sexo']);

            $modeloRelatorio->setNewLine();
            $modeloRelatorio->setLegValue(30, 'Porto: ', $pescador['pto_nome']);
            $modeloRelatorio->setLegValue(250, 'Local: ', $pescador['tl_local']);
            $modeloRelatorio->setNewLine();
            if ($pescador['tp_datanasc']) {
                $localDate = date("d/m/Y", strtotime($pescador['tp_datanasc']));
            } else {
                $localDate = '';
            }

            $modeloRelatorio->setLegValue(50, 'Data Nascimento: ', $localDate);
            $modeloRelatorio->setLegValue(250, 'Matricula: ', $pescador['tp_matricula']);
            $modeloRelatorio->setLegValue(370, 'Apelido: ', $pescador['tp_apelido']);

            $modeloRelatorio->setNewLine();
            $modeloRelatorio->setLegValue(50, 'CPF: ', $pescador['tp_cpf']);
            $modeloRelatorio->setLegValue(150, 'RG: ', $pescador['tp_rg']);
            $modeloRelatorio->setLegValue(250, 'INSS: ', $pescador['tp_inss']);
            $modeloRelatorio->setLegValue(370, 'RGB/MAA/IBAMA: ', $pescador['tp_rgb_maa_ibama']);

            $modeloRelatorio->setNewLine();
            $modeloRelatorio->setLegValue(50, 'PIS: ', $pescador['tp_pis']);
            $modeloRelatorio->setLegValue(150, 'CTPS: ', $pescador['tp_ctps']);
            $modeloRelatorio->setLegValue(250, 'NIT/CEI: ', $pescador['tp_nit_cei']);
            $modeloRelatorio->setLegValue(370, 'CIR CAP PORTO : ', $pescador['tp_cir_cap_porto']);

            $modeloRelatorio->setNewLine();
            $modeloRelatorio->setLegValue(50, 'CMA: ', $pescador['tp_cma']);
            $modeloRelatorio->setLegValue(150, 'Pai: ', $pescador['tp_filiacaopai']);
            $modeloRelatorio->setLegValue(370, 'Mãe: ', $pescador['tp_filiacaomae']);

            $modeloRelatorio->setNewLine();
            $modeloRelatorio->setLegValue(50, 'Comunidade: ', $pescador['tcom_nome']);
            $modeloRelatorio->setLegValue(250, 'Natural: ', $pescador['munnat'] . '/' . $pescador['signat']);
            $modeloRelatorio->setLegValue(370, 'Escolaridade: ', $pescador['esc_nivel']);

            $modeloRelatorio->setNewLine();
            $modeloRelatorio->setLegValue(50, 'Logradouro: ', $pescador['te_logradouro']);
            $modeloRelatorio->setLegValue(250, 'Número: ', $pescador['te_numero']);
            $modeloRelatorio->setLegValue(370, 'Complemento: ', $pescador['te_comp']);

            $modeloRelatorio->setNewLine();
            $modeloRelatorio->setLegValue(50, 'Bairro: ', $pescador['te_bairro']);
            $modeloRelatorio->setLegValue(250, 'CEP: ', $pescador['te_cep']);
            $modeloRelatorio->setLegValue(370, 'Cidade: ', $pescador['tmun_municipio'] . '/' . $pescador['tuf_sigla']);

            $modeloRelatorio->setNewLine();
            if ($pescador['tp_dta_cad']) {
                $localDate = date("d/m/Y", strtotime($pescador['tp_dta_cad']));
            } else {
                $localDate = '';
            }
            $modeloRelatorio->setLegValue(50, 'Data Cad.: ', $localDate);
            $modeloRelatorio->setLegValue(150, 'Resp. Lan.: ', $pescador['tu_nome_lan']);
            $modeloRelatorio->setLegValue(370, 'Resp. Cad.: ', $pescador['tu_nome_cad']);
            $modeloRelatorio->setNewLine();

            $modeloRelatorio->setLegValue(50, 'Observações: ', $pescador['tp_obs']);
            $modeloRelatorio->setNewLine();

            foreach ($localDependente as $key_d => $dependente) {
				if ( $dependente['tp_id'] ==  $pescador['tp_id'] ) {
					$modeloRelatorio->setLegValue(50, 'Dependente: ', $dependente['ttd_tipodependente'] . ": " . $dependente['tptd_quantidade']);
					$modeloRelatorio->setNewLine();
				}
            }

            foreach ($localRenda as $key_r => $renda) {
				if ( $renda['tp_id'] == $pescador['tp_id'] ) {
					$modeloRelatorio->setLegValue(50, 'Renda: ', $renda['ttr_descricao'] . ": " . $renda['ren_renda']);
					$modeloRelatorio->setNewLine();
				}
            }

            foreach ($localProgramaSocial as $key_ps => $programaSocial) {
				if ( $programaSocial['tp_id'] == $pescador['tp_id']) {
					$modeloRelatorio->setLegValue(50, 'Programa Social: ', $programaSocial['prs_programa']);
					$modeloRelatorio->setNewLine();
				}
            }

            foreach ($localTelefone as $key_t => $telefone) {
				if ( $telefone['tpt_tp_id'] == $pescador['tp_id']) {
					$modeloRelatorio->setLegValue(50, 'Telefone: ', $telefone['ttel_desc'] . ": " . $telefone['tpt_telefone']);
					$modeloRelatorio->setNewLine();
				}
            }

            foreach ($localAreaPesca as $key_area => $areaPesca) {
				if ( $areaPesca['tp_id'] == $pescador['tp_id']) {
					$modeloRelatorio->setLegValue(50, 'Area de Pesca: ', $areaPesca['tareap_areapesca']);
					$modeloRelatorio->setNewLine();
				}
            }

            foreach ($localArtePesca as $key_arte => $artePesca) {
				if ( $artePesca['tp_id'] == $pescador['tp_id']) {
					$modeloRelatorio->setLegValue(50, 'Arte de Pesca: ', $artePesca['tap_artepesca']);
					$modeloRelatorio->setNewLine();
				}
            }

            foreach ($localTipoCapturada as $key_tc => $tipoCapturada) {
				if ( $tipoCapturada['tp_id'] == $pescador['tp_id']) {
					$modeloRelatorio->setLegValue(50, 'Espécies Capturadas: ', $tipoCapturada['itc_tipo']);
					$modeloRelatorio->setNewLine();
				}
            }

            foreach ($localEmbarcacoes as $key_emb => $embarcacoes) {
				if ( $embarcacoes['tp_id'] == $pescador['tp_id']) {
					$modeloRelatorio->setLegValue(50, 'Embarcações: ', $embarcacoes['tte_tipoembarcacao']);
					if ($embarcacoes['tpte_motor'] == true) {
                                                    $motor = 'Sim';
                                        } else {
                                        $motor = 'Não';
                                        }
                                        $modeloRelatorio->setLegValue(150, 'Motor: ', $motor);
					$modeloRelatorio->setLegValue(250, 'Porte: ', $embarcacoes['tpe_porte']);
					if ($embarcacoes['tpte_dono'] == 1)
						$dono = 'Sim';
					else
						$dono = 'Não';
					$modeloRelatorio->setLegValue(350, 'Proprietário: ', $dono);
					$modeloRelatorio->setNewLine();
				}
            }

            $countNPescPag = $countNPescPag + 1;

            if ( $countNPescPag > 2 ) {
				$modeloRelatorio->setForceNewPage();
				$countNPescPag = 0;
            } else {
				$modeloRelatorio->setNewLine();
			}
            $contPescador++;            
        endforeach;
        $modeloRelatorio->setLegValue(30, 'Quantidade total de Pescadores: ', $contPescador);
	$modeloRelatorio->setNewLine();
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_pescador.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

    public function imprimirpescadortodosAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->relatorioListaPescador(array('tp_nome'), "tpr_id=1" );
    }
    public function imprimirpescadordesembarqueAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->relatorioListaPescador(array('tp_nome'), "tpr_id=3" );
    }
    public function imprimirlistacodigoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->relatorioListaPescador( array('tp_id'), "tpr_id=2");
    }

    public function imprimirlistanomeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->relatorioListaPescador( array('tp_nome') , "tpr_id=2");
    }

    public function imprimirlistacomunidadeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->relatorioListaPescadorComunidade( array('tcom_nome','tp_nome'), "tpr_id=2" );
    }

    public function imprimirlistacoloniaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $this->relatorioListaPescadorColonia( array('tc_nome','tp_nome'), "tpr_id=2" );
    }

    public function relatorioListaPescador( $order = null, $where = null ) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelPescador = new Application_Model_Pescador();
        $localPescador = $localModelPescador->selectView($where, $order, NULL);

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório de Pescador');
        $modeloRelatorio->setLegenda(30, 'Código');
        $modeloRelatorio->setLegenda(80, 'Pescador');
        $contPescador = 0;
        foreach ($localPescador as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tp_id']);
            $modeloRelatorio->setValue(80, $localData['tp_nome']);
            $modeloRelatorio->setNewLine();
            $contPescador++;
        }
        $modeloRelatorio->setLegValue(30, 'Quantidade total de Pescadores: ', $contPescador);
        $modeloRelatorio->setNewLine();
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_pescador.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

    public function relatorioListaPescadorComunidade( $order = null, $where  = null ) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelPescador = new Application_Model_Pescador();
        $localPescador = $localModelPescador->selectView($where, $order, NULL);

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório de Pescador - Comunidade');
        $modeloRelatorio->setLegenda(30, 'Código');
        $modeloRelatorio->setLegenda(80, 'Comunidade');
        $modeloRelatorio->setLegenda(200, 'Pescador');
        
        $contPescador = 0;
        foreach ($localPescador as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tp_id']);
            $modeloRelatorio->setValue(80, $localData['tcom_nome']);
            $modeloRelatorio->setValue(200, $localData['tp_nome']);
            $modeloRelatorio->setNewLine();
            $contPescador++;
        }
        $modeloRelatorio->setLegValue(30, 'Quantidade total de Pescadores: ', $contPescador);
        $modeloRelatorio->setNewLine();
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_pescador_comunidade.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

    public function relatorioListaPescadorColonia( $order = null, $where = null ) {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelPescador = new Application_Model_Pescador();
        $localPescador = $localModelPescador->selectView($where, $order, NULL);

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório de Pescador - Colônia');
        $modeloRelatorio->setLegenda(30, 'Código');
        $modeloRelatorio->setLegenda(80, 'Colônia');
        $modeloRelatorio->setLegenda(130, 'Pescador');
        
        $contPescador = 0;
        foreach ($localPescador as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tp_id']);
            $modeloRelatorio->setValue(80, $localData['tc_nome']);
            $modeloRelatorio->setValue(130, $localData['tp_nome']);
            $modeloRelatorio->setNewLine();
            $contPescador++;
        }
        $modeloRelatorio->setLegValue(30, 'Quantidade total de Pescadores: ', $contPescador);
        $modeloRelatorio->setNewLine();
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_pescador_colonia.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

    public function relatoriopescadorgroupcomunidadeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelPescador = new Application_Model_Pescador();
        $localPescador = $localModelPescador->select_Pescador_group_comunidade();

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório de Quantidade de Pescadores por Comunidade');
        $modeloRelatorio->setLegenda(30, 'Nº Pescadores');
        $modeloRelatorio->setLegenda(120, 'Comunidade');

        $tmpSum = 0;
        foreach ($localPescador as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 60, $localData['count']);
            $tmpSum = $tmpSum + $localData['count'];
            if (sizeof($localData['tcom_nome']) > 0 ) {
                $modeloRelatorio->setValue(120, $localData['tcom_nome']);
            } else {
                $modeloRelatorio->setValue(120, 'Não declarado');
            }
            $modeloRelatorio->setNewLine();
        }
        $modeloRelatorio->setNewLine();
        $modeloRelatorio->setLegValue(30, 'Total de pescadores cadastrados: ', $tmpSum );
        $modeloRelatorio->setNewLine();
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_qtde_comunidade.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }

    
    
        public function relatoriopescadorgroupcoloniaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelPescador = new Application_Model_Pescador();
        $localPescador = $localModelPescador->select_Pescador_group_colonia();

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório de Quantidade de Pescadores por Colônia');
        $modeloRelatorio->setLegenda(30, 'Nº Pescadores');
        $modeloRelatorio->setLegenda(120, 'Colônia');

        $tmpSum = 0;
        foreach ($localPescador as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 60, $localData['count']);
            $tmpSum = $tmpSum + $localData['count'];
            if (sizeof($localData['tc_nome']) > 0 ) {
                $modeloRelatorio->setValue(120, $localData['tc_nome']);
            } else {
                $modeloRelatorio->setValue(120, 'Não declarado');
            }
            $modeloRelatorio->setNewLine();
        }
        $modeloRelatorio->setNewLine();
        $modeloRelatorio->setLegValue(30, 'Total de pescadores cadastrados: ', $tmpSum );
        $modeloRelatorio->setNewLine();
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_qtde_colonia.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }
    
    public function relatoriopescadorportoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $localModelPescador = new Application_Model_Pescador();
        $localPescador = $localModelPescador->selectPescadorByPortos();

        require_once "../library/ModeloRelatorio.php";
        $modeloRelatorio = new ModeloRelatorio();
        $modeloRelatorio->setTitulo('Relatório de Pescador - Colônia');
        $modeloRelatorio->setLegenda(30, 'Código');
        $modeloRelatorio->setLegenda(80, 'Porto');
        $modeloRelatorio->setLegenda(180, 'Pescador');
        
        $contPescador = 0;
        foreach ($localPescador as $key => $localData) {
            $modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['tp_id']);
            $modeloRelatorio->setValue(80, $localData['pto_nome']);
            $modeloRelatorio->setValue(180, $localData['tp_nome']);
            $modeloRelatorio->setNewLine();
            $contPescador++;
        }
        $modeloRelatorio->setLegValue(30, 'Quantidade total de Pescadores: ', $contPescador);
        $modeloRelatorio->setNewLine();
        $pdf = $modeloRelatorio->getRelatorio();

        ob_end_clean();
        header('Content-Disposition: attachment;filename="rel_lista_pescador_colonia.pdf"');
        header("Content-type: application/x-pdf");
        echo $pdf->render();
    }
    
    public function atualizapescadorespecialistaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $backUrl = $this->_getParam("back_url");
        $dadosPescadorEspecialista = array(
            'idEspecialista'                    => $this->_getParam("tps_id"),
            "selectPortoEspecialista"           => $this->_getParam('pto_id'),
            'tps_dataNasc'                      => $this->_getParam('tps_data_nasc'),              
            'tps_idade'                         => $this->_getParam('tps_idade'),
            'selectEstadoCivil'                 => $this->_getParam('tec_id'),                     
            'tps_numFilhos'                     => $this->_getParam('tps_filhos'),                 
            'tps_tempoResidencia'               => $this->_getParam('tps_tempo_residencia'),       
            'selectOrigem'                      => $this->_getParam('to_id'),                      
            'selectResidencia'                  => $this->_getParam('tre_id'),                     
            'tps_quantPessoas'                  => $this->_getParam('tps_pessoas_na_casa'),        
            'tps_tempoSemPesca'                 => $this->_getParam('tps_tempo_sustento'),         
            'tps_menorRenda'                    => $this->_getParam('tps_renda_menor_ano'),        
            'selectMenorEstacaoAno'             => $this->_getParam('tea_id_menor'),               
            'tps_maiorRenda'                    => $this->_getParam('tps_renda_maior_ano'),        
            'selectMaiorEstacaoAno'             => $this->_getParam('tea_id_maior'),               
            'tps_valorRendaDefeso'              => $this->_getParam('tps_renda_no_defeso'),        
            'tps_tempoPesca'                    => $this->_getParam('tps_tempo_de_pesca'),         
            'selectTutorPesca'                  => $this->_getParam('ttd_id_tutor_pesca'),         
            'selectAntesPesca'                  => $this->_getParam('ttr_id_antes_pesca'),         
            'selectMoraOndePesca'               => $this->_getParam('tps_mora_onde_pesca'),        
            'selectEmbarcado'                   => $this->_getParam('tps_embarcado'),              
            'tps_numPescadorFamilia'            => $this->_getParam('tps_num_familiar_pescador'),  
            'selectFrequenciaPesca'             => $this->_getParam('tfp_id'),                     
            'tps_diasPescando'                  => $this->_getParam('tps_num_dias_pescando'),      
            'tps_horasPescando'                 => $this->_getParam('tps_hora_pescando'),          
            'selectUltimaPesca'                 => $this->_getParam('tup_id'),                                                                      
            'selectFrequenciaConsumo'           => $this->_getParam('tfp_id_consumo'),                        
            'selectSobraPesca'                  => $this->_getParam('tsp_id'),                     
            'selectLocalTratamento'             => $this->_getParam('tlt_id'),                     
            'tps_unidadeBeneficiamento'         => $this->_getParam('tps_unidade_beneficiamento'), 
            'tps_cursoBeneficiamento'           => $this->_getParam('tps_curso_beneficiamento'),   
            'selectAssociacaoPesca'             => $this->_getParam('tasp_id'),                    
            'selectColoniaEspecialista'         => $this->_getParam('tc_id'),                      
            'tps_tempoColonizado'               => $this->_getParam('tps_tempo_em_colonia'),       
            'tps_dificuldadeColonia'            => $this->_getParam('tps_motivo_falta_pagamento'), 
            'tps_beneficiosColonia'             => $this->_getParam('tps_beneficio_colonia'),      
            'selectOrgaoRgp'                    => $this->_getParam('trgp_id'),                                    
            'selectAlternativaRenda'            => $this->_getParam('ttr_id_alternativa_renda'),   
            'selectOutraProfissao'              => $this->_getParam('ttr_id_outra_profissao'),     
            'tps_filhoPescador'                 => $this->_getParam('tps_filho_seguir_profissao'), 
            'tps_dependenciaPesca'              => $this->_getParam('tps_grau_dependencia_pesca'), 
            'selectEntrevistador'               => $this->_getParam('tu_id_entrevistador'),        
            'tps_data'                          => $this->_getParam('tps_data'),
            'tps_obs'                           => $this->_getParam('tps_obs')
        );

        $idPescadorEspecialista  = $this->modelPescadorEspecialista->update($dadosPescadorEspecialista);
        $this->redirect("/pescador/editar/id/" . $backUrl);

        return $idPescadorEspecialista;
    }
    
    public function barAction()
    {
        if($this->getRequest->isXmlHttpRequest()) {
            $this->_helper->layout->disableLayout();
        }
        ob_end_clean();
        // normal logic goes here
    }
    
    public function insertpescadorespecialistaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("tp_id");

        $backUrl = $this->_getParam("back_url");
        
        $respCadastro = $this->_getParam("tp_resp_cad");
        $selectPescador = $this->modelPescadorEspecialista->select('tp_id='. $idPescador);
        
        if(empty($selectPescador)){
        
            $this->modelPescadorEspecialista->insert($idPescador, $respCadastro);
        }
        else{
            $this->redirect("/pescador/editar/id/" . $backUrl);
        }
        $this->redirect("/pescador/editar/id/" . $backUrl);
        return;
    }
// -9 -------------------------------------------------------//
    public function insertestruturaresidencialAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertEstruturaResidencial($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deleteestruturaresidencialAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $idEstrutura = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteEstruturaResidencial($idEstrutura, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -11 -------------------------------------------------------//
     public function insertprogramasocialAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertProgramaSocial($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deleteprogramasocialAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteProgramaSocial($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    
// -13 -------------------------------------------------------//
     public function insertsegurodefesoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertSeguroDefeso($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletesegurodefesoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteSeguroDefeso($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -13.1 -------------------------------------------------------//
    public function insertrendadefesoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertRendaDefeso($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deleterendadefesoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteRendaDefeso($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -16 -------------------------------------------------------//
    public function insertmotivopescaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertMotivoPesca($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletemotivopescaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteMotivoPesca($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -19 -------------------------------------------------------//
    public function inserttransporteAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertTransporte($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletetransporteAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteTransporte($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -20 -------------------------------------------------------//
    public function insertacompanhadoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");
        
        $quantidade = $this->_getParam('quantidade');
        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertAcompanhado($idPescador, $valor, $quantidade);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deleteacompanhadoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteAcompanhado($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -20.1 -------------------------------------------------------//
    public function insertcompanhiaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $quantidade = $this->_getParam("quantidade");
        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertCompanhia($idPescador, $valor, $quantidade);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletecompanhiaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteCompanhia($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -22.1 -------------------------------------------------------//
    public function insertfamiliapescadorAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertFamiliaPescador($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletefamiliapescadorAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteFamiliaPescador($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -24 -------------------------------------------------------//
    public function inserthorariopescaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertHorarioPesca($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletehorariopescaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteHorarioPesca($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -28 -------------------------------------------------------//
    public function insertinsumopescaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $preco = $this->_getParam("preco");
        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertInsumoPesca($idPescador, $valor, $preco);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deleteinsumopescaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteInsumoPesca($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    
// -28.2 -------------------------------------------------------//
    public function insertfornecedorinsumoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertFornecedorInsumos($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletefornecedorinsumoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteFornecedorInsumos($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    
// -28.3 -------------------------------------------------------//
    public function insertrecursosAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertRecurso($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deleterecursosAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteRecurso($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    // -29.2 -------------------------------------------------------//
    public function insertdestinopescadoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertDestinoPescado($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletedestinopescadoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteDestinoPesca($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -29.2 -------------------------------------------------------//
    public function insertcompradorpescadoAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertCompradorPescado($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletecompradorpescadoAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteCompradorPescado($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -36 -------------------------------------------------------//
    public function insertdificuldadeareaAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertDificuldadePesca($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletedificuldadeareaAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteDificuldadePesca($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -37 -------------------------------------------------------//
    public function inserthabilidadeAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertHabilidades($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletehabilidadeAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteHabilidades($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
// -44 -------------------------------------------------------//
    public function insertbarcosAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        $idPescador = $this->_getParam("id");

        $valor = $this->_getParam("valor");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->insertBarco($idPescador, $valor);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function deletebarcosAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        $id = $this->_getParam("id");

        $idPescador = $this->_getParam("tps_id");

        $backUrl = $this->_getParam("back_url");

        $this->modelPescadorEspecialista->deleteBarco($id, $idPescador);

        $this->redirect("/pescador/editar/id/" . $backUrl);

        return;
    }
    public function naopossui($falso){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        if($falso == false){
            return 'Não Possui';
        }
        else{
            return $falso;
        }
    }
    public function relatorioespecialistaAction(){
        set_time_limit(300);
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        
        $this->modelEspecialista = new Application_Model_PescadorEspecialista();
        $this->modelPescadorHasDependentes = new Application_Model_VPescadorHasDependente();
        $this->modelPescadorHasColonias = new Application_Model_VPescadorHasColonia();
        $this->modelPescadorHasTipoEmbarcacao = new Application_Model_VPescadorHasEmbarcacao();
        
        require_once "../library/Classes/PHPExcel.php";

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0);
        $coluna = 0;
        $linha = 1;
        $quant= 44;
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna,   $linha, 'Código');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pescador');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Apelido');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Porto');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Nascimento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Idade');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estado Civil');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Quantidade de Filhos');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo em residência');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Municipio de Origem');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tipo de Residência');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pessoas na casa');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo de sustento com pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Menor Renda');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estação');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Maior Renda');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Estação');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Renda no Defeso');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tutor da pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Profissão antes da pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Mora onde pesca?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pesca com embarcação?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Pescadores na família');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Frequência da pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dias Pescando');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Horas Pescando');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Ultima Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Frequencia Consumo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Sobra da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Local de Tratamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Unidade de Beneficiamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Curso de Beneficiamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Associação de pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Colônia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo em Colônia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motivo falta de Pagamento');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Benefícios da Colônia');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Emissor do RGP');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Alternativa de Renda');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Outra Profissão');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Filhos Seguirem profissão?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Tempo de Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Grau de dependência da pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Escolaridade');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Entrevistador');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Como vai pescar?');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Quantidade');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Companhias');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Quantidade');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Possui em casa');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Horario Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Insumo');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Valor');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Renda no Seguro');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Parentes Pescadores');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Programa Social');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Seguro Defeso');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Transportes');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Destino da Pesca');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dificuldade da Área');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Recurso Utilizado');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Motivo por ser Pescador');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Fornecedor de Insumos');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Comprador Pescado');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Habilidades');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Embarcações');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dependentes');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Colônias');
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, 'Dono das Embarcações?');
        
        $linha = 2;
        $coluna= 0;
        $relatorioEspecialista = $this->modelEspecialista->selectView();
        
        foreach ( $relatorioEspecialista as $key => $especialista ):
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna, $linha,   $especialista['tp_id']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tp_nome']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tp_apelido']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['pto_nome']);
                    $consulta['tps_data_nasc']=date('d/M/Y', $consulta['tps_data_nasc']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_data_nasc']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_idade']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tec_estado']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_filhos']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_tempo_residencia']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tre_residencia']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tmun_municipio']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_pessoas_na_casa']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_tempo_sustento']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_renda_menor_ano']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tea_menor']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_renda_maior_ano']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tea_maior']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_renda_no_defeso']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_tempo_pesca']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tutor']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['antes']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_mora_onde_pesca']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_embarcado']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_num_familiar_pescador']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['frequencia_pesca']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_num_dias_pescando']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_hora_pescando']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tup_pesca']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['consumo']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tsp_sobra']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tlt_local']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_unidade_beneficiamento']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_curso_beneficiamento']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tasp_associacao']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tc_nome']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_tempo_em_colonia']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_motivo_falta_pagamento']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['trgp_emissor']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_beneficio_colonia']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['alternativa']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['outra']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_filho_seguir_profissao']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_tempo_de_pesca']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['tps_grau_dependencia_pesca']);
		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['esc_nivel']);
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(++$coluna, $linha, $especialista['entrevistador']);
                
                $coluna++;
                $acompanhado = $this->modelEspecialista->selectVAcompanhado('tps_id = '.$especialista['tp_id']);
                foreach($acompanhado as $key => $consulta):
                    $acomp.=$consulta['tacp_companhia'].',';
                    $quant.=$consulta['tpstacp_quantidade'].',';
                endforeach;
                    
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($acomp,0,-1)));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($quant,0,-1)));
                    unset($acomp);
                    unset($quant);
                    $companhia = $this->modelEspecialista->selectVCompanhia('tps_id = '.$especialista['tp_id']);
                foreach($companhia as $key => $consulta):
                    $comp.= $consulta['ttd_tipodependente'].',';
                    $quant_comp.=$consulta['tpstcp_quantidade'].',';
                endforeach;
                
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($comp,0,-1)));
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($quant_comp,0,-1)));
                    unset($comp);
                    unset($quant_comp);
                $estrutura = $this->modelEspecialista->selectVEstruturaResidencial('tps_id = '.$especialista['tp_id']);
                
                foreach($estrutura as $key => $consulta):
                    $est.=$consulta['terd_estrutura'].',';
                endforeach;
                    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($est,0,-1)));
                    unset($est);
                $horario = $this->modelEspecialista->selectVHorarioPesca('tps_id = '.$especialista['tp_id']);
                
                foreach($horario as $key => $consulta):
                    $hora.=$consulta['thp_horario'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($hora,0,-1)));
               unset($hora);
                
                $insumos = $this->modelEspecialista->selectVInsumos('tps_id = '.$especialista['tp_id']);
               
                foreach($insumos as $key => $consulta):
                    $insumo.=$consulta['tin_insumo'].',';
                    $valr.=$consulta['tin_valor_insumo'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($insumo,0,-1)));
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($valr,0,-1)));
                unset($insumo);
                unset($valr);
                $noseguro = $this->modelEspecialista->selectVNoSeguro('tps_id = '.$especialista['tp_id']);
                
                foreach($noseguro as $key => $consulta):
                    $noseg.=$consulta['ttr_descricao'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($noseg,0,-1)));
                unset($noseg);
                $parentes = $this->modelEspecialista->selectVParentes('tps_id = '.$especialista['tp_id']);
               
                foreach($parentes as $key => $consulta):
                    $part.=$consulta['ttd_tipodependente'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($part,0,-1)));
                unset($part);
                
                $programaSocial = $this->modelEspecialista->selectVProgramaSocial('tps_id = '.$especialista['tp_id']);
                
                foreach($programaSocial as $key => $consulta):
                    $progsoc.=$consulta['prs_programa'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($progsoc,0,-1)));
                unset($progsoc);
                
                $seguro = $this->modelEspecialista->selectVSeguroDefeso('tps_id = '.$especialista['tp_id']);
                
                foreach($seguro as $key => $consulta):
                    $seg.= $consulta['tsd_seguro'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($seg,0,-1)));
                unset($seg);
                
                $tipoTransporte = $this->modelEspecialista->selectVTipoTransporte('tps_id = '.$especialista['tp_id']);

                foreach($tipoTransporte as $key => $consulta):
                    $tran.=$consulta['ttr_transporte'].',';
                endforeach;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($tran,0,-1)));
                unset($tran);
                
                $destino = $this->modelEspecialista->selectVDestinoPescado('tps_id = '.$especialista['tp_id']);
                
                foreach($destino as $key => $consulta):
                    $dest.=$consulta['dp_destino'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($dest,0,-1)));
                unset($dest);
                
                $dificuldades = $this->modelEspecialista->selectVDificuldadeArea('tps_id = '.$especialista['tp_id']);
                
                foreach($dificuldades as $key => $consulta):
                    $difc.=$consulta['tdif_dificuldade'].',';
                endforeach;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($difc,0,-1)));
                unset($difc);   
                
                $recurso = $this->modelEspecialista->selectVRecurso('tps_id = '.$especialista['tp_id']);

                foreach($recurso as $key => $consulta):
                    $rec.=$consulta['trec_recurso'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($rec,0,-1)));
                unset($rec);
                
                $motivo = $this->modelEspecialista->selectVMotivoPesca('tps_id = '.$especialista['tp_id']);

                foreach($motivo as $key => $consulta):
                    $mot.=$consulta['tmp_motivo'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($mot,0,-1)));
                unset($mot);
                
                $fornecedorinsumos = $this->modelEspecialista->selectVFornecedorInsumos('tps_id = '.$especialista['tp_id']);
                
                foreach($fornecedorinsumos as $key => $consulta):
                    $fornc.=$consulta['tfi_fornecedor'].',';
                endforeach;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($fornc,0,-1)));
                unset($fornc); 
                
                $comprador = $this->modelEspecialista->selectVCompradorPescado('tps_id = '.$especialista['tp_id']);
                
                foreach($comprador as $key => $consulta):
                    $compr.=$consulta['dp_destino'].',';
                endforeach;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($compr,0,-1)));
                unset($compr);
                
                $habilidades = $this->modelEspecialista->selectVHabilidades('tps_id = '.$especialista['tp_id']);

                foreach($habilidades as $key => $consulta):
                    $habi.=$consulta['ttr_descricao'].',';
                endforeach;
                
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($habi,0,-1)));
                unset($habi);
                
                $barcos = $this->modelEspecialista->selectVBarco('tps_id = '.$especialista['tp_id']);
                foreach($barcos as $key => $consulta):
                    $barcs.=$consulta['bar_nome'];
                    if(!empty($consulta['bar_nome'])){
                        $barcs.=',';
                    }
                endforeach;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($barcs,0,-1)));
                unset($barcs);
                
                $dependentes = $this->modelPescadorHasDependentes->selectDependentes('tp_id = '.$especialista['tp_id']);
                foreach($dependentes as $key => $consulta):
                    $deps.=$consulta['ttd_tipodependente'];
                    if(!empty($consulta['ttd_tipodependente'])){
                        $deps.=',';
                    }
                endforeach;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($deps,0,-1)));
                unset($deps);
                
                $colonias = $this->modelPescadorHasColonias->select('tp_id = '.$especialista['tp_id']);
                foreach($colonias as $key => $consulta):
                    $cols.=$consulta['tc_nome'];
                    if(!empty($consulta['tc_nome'])){
                        $cols.=',';
                    }
                endforeach;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, $this->naopossui(substr($cols,0,-1)));
                unset($cols);
                
                $tipobarcos = $this->modelPescadorHasTipoEmbarcacao->select('tp_id = '.$especialista['tp_id']);
                foreach($tipobarcos as $key => $consulta):
                    
                    $tbarcos.=$consulta['tpte_dono'].',';
                    
                endforeach;
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($coluna++, $linha, substr($tbarcos,0,-1));
                unset($tbarcos);
                
                $coluna = 0;
                $linha++;
        endforeach;

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="relatorioEspecialista.xls"');
        header('Cache-Control: max-age=0');

        ob_end_clean();
        $objWriter->save('php://output');
    
    } 
}
