<?php

class EstatisticaController extends Zend_Controller_Action
{
    private $countPescadores;
    private $portoPescadores;
    
    public function init()
    {
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
        
        $this->modelPescador =   new Application_Model_Pescador();
        $this->modelArrasto =    new Application_Model_ArrastoFundo();
        $this->modelCalao =      new Application_Model_Calao();
        $this->modelColeta =     new Application_Model_ColetaManual();
        $this->modelEmalhe =     new Application_Model_Emalhe();
        $this->modelGroseira =   new Application_Model_Grosseira();
        $this->modelJerere =     new Application_Model_Jerere();
        $this->modelLinha =      new Application_Model_Linha();
        $this->modelLinhaFundo = new Application_Model_LinhaFundo();
        $this->modelManzua =     new Application_Model_Manzua();
        $this->modelMergulho =   new Application_Model_Mergulho();
        $this->modelRatoeira =   new Application_Model_Ratoeira();
        $this->modelSiripoia =   new Application_Model_Siripoia();
        $this->modelTarrafa =    new Application_Model_Tarrafa();
        $this->modelVaraPesca =  new Application_Model_VaraPesca();
        $this->modelEspecies = new Application_Model_Especie();
    }

    public function indexAction()
    {
        // action body
    }
    public function indexbiometriasAction(){
        
        
        $especies_camarao = $this->modelArrasto->selectEspeciesCamaraoBiometrias();
        $this->view->assign('especiesCamarao',$especies_camarao);
        
        $especiesPeixeArrasto      = $this->modelArrasto->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeCalao        = $this->modelCalao->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum');    
        $especiesPeixeColetaManual = $this->modelColeta->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeEmalhe       = $this->modelEmalhe->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum');  
        $especiesPeixeGrosseira    = $this->modelGroseira->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeJerere       = $this->modelJerere->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeLinha        = $this->modelLinha->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeLinhaFundo   = $this->modelLinhaFundo->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeManzua       = $this->modelManzua->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum');  
        $especiesPeixeMergulho     = $this->modelMergulho->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeRatoeira     = $this->modelRatoeira->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeSiripoia     = $this->modelSiripoia->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeTarrafa      = $this->modelTarrafa->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum'); 
        $especiesPeixeVaraPesca    = $this->modelVaraPesca->selectEspeciesPeixesBiometrias(null, 'esp_nome_comum');
        
        $array_especiesBiometrias = array_merge_recursive($especiesPeixeArrasto,     
                                                        $especiesPeixeCalao,       
                                                        $especiesPeixeColetaManual,
                                                        $especiesPeixeEmalhe,      
                                                        $especiesPeixeGrosseira,   
                                                        $especiesPeixeJerere,      
                                                        $especiesPeixeLinha,       
                                                        $especiesPeixeLinhaFundo,  
                                                        $especiesPeixeManzua,      
                                                        $especiesPeixeMergulho,    
                                                        $especiesPeixeRatoeira,    
                                                        $especiesPeixeSiripoia,    
                                                        $especiesPeixeTarrafa,    
                                                        $especiesPeixeVaraPesca);
        
        
        $especies_unique = array_map('unserialize', array_unique(array_map('serialize', $array_especiesBiometrias)));
        $arrayOrdenadoEspecies = $this->array_sort($especies_unique, 'esp_nome_comum');
        $this->view->assign('especiesPeixes',$arrayOrdenadoEspecies);
        
        
        $arrayCompletoEspecies = array_merge_recursive($especies_camarao,$arrayOrdenadoEspecies);
        $this->view->assign('especiesPeixesCamarao',$arrayCompletoEspecies);
        $especie = $this->_getParam('esp_id');
        if(empty($especie)){
            $especie = 0;
        }
        $biometriasCamaraoArrasto = $this->modelArrasto->selectVBioCamarao("esp_id = '".$especie."'");
        $biometriasPeixeArrasto      = $this->modelArrasto->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeCalao        = $this->modelCalao->selectVBioPeixe("esp_id = '".$especie."'");    
        $biometriasPeixeColetaManual = $this->modelColeta->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeEmalhe       = $this->modelEmalhe->selectVBioPeixe("esp_id = '".$especie."'");  
        $biometriasPeixeGrosseira    = $this->modelGroseira->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeJerere       = $this->modelJerere->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeLinha        = $this->modelLinha->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeLinhaFundo   = $this->modelLinhaFundo->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeManzua       = $this->modelManzua->selectVBioPeixe("esp_id = '".$especie."'");  
        $biometriasPeixeMergulho     = $this->modelMergulho->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeRatoeira     = $this->modelRatoeira->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeSiripoia     = $this->modelSiripoia->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeTarrafa      = $this->modelTarrafa->selectVBioPeixe("esp_id = '".$especie."'"); 
        $biometriasPeixeVaraPesca    = $this->modelVaraPesca->selectVBioPeixe("esp_id = '".$especie."'");
    
        $this->view->assign('arrayBioCamarao', $biometriasCamaraoArrasto);
        $this->view->assign('arrayBioArrasto', $biometriasPeixeArrasto);    
        $this->view->assign('arrayBioCalao', $biometriasPeixeCalao); 
        $this->view->assign('arrayBioColetaManual', $biometriasPeixeColetaManual);
        $this->view->assign('arrayBioEmalhe', $biometriasPeixeEmalhe);
        $this->view->assign('arrayBioGrosseira', $biometriasPeixeGrosseira);   
        $this->view->assign('arrayBioJerere', $biometriasPeixeJerere);
        $this->view->assign('arrayBioLinha', $biometriasPeixeLinha);   
        $this->view->assign('arrayBioLinhaFundo', $biometriasPeixeLinhaFundo);  
        $this->view->assign('arrayBioManzua', $biometriasPeixeManzua);
        $this->view->assign('arrayBioMergulho', $biometriasPeixeMergulho);    
        $this->view->assign('arrayBioRatoeira', $biometriasPeixeRatoeira);  
        $this->view->assign('arrayBioSiripoia', $biometriasPeixeSiripoia);  
        $this->view->assign('arrayBioTarrafa', $biometriasPeixeTarrafa); 
        $this->view->assign('arrayBioVaraPesca', $biometriasPeixeVaraPesca);  
    }
    public function selectespeciesAction(){
        $esp_id = $this->_getParam('esp_id');

        $this->_redirect('estatistica/tableesp/esp_id/'.$esp_id);
    }
    public function tableespAction(){
        
        $this->_helper->layout->disableLayout();
        
        $this->indexbiometriasAction();
        
    }
    public function gerarAction(){
        $especie = $this->_getParam('especie');
        $biometria = $this->_getParam('biometria');
        
        $especieBiometria = $this->modelEspecies->find($biometria);
        switch($especie):
            case 'peixe': $this->redirect('estatistica/biometriapeixe/especie/'.$especieBiometria['esp_nome_comum']);
            case 'camarao': $this->redirect('estatistica/biometriacamarao/especie/'.$especieBiometria['esp_nome_comum']);    
        endswitch;
    }
    
    function array_sort($array, $on, $order = SORT_ASC) {
        $new_array = array();
        $sortable_array = array();

        if (count($array) > 0) {
            foreach ($array as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k2 => $v2) {
                        if ($k2 == $on) {
                            $sortable_array[$k] = $v2;
                        }
                    }
                } else {
                    $sortable_array[$k] = $v;
                }
            }

            switch ($order) {
                case SORT_ASC:
                    asort($sortable_array);
                    break;
                case SORT_DESC:
                    arsort($sortable_array);
                    break;
            }

            foreach ($sortable_array as $k => $v) {
                $new_array[$k] = $array[$k];
            }
        }

        return $new_array;
    }
    function array_sum_values($array, $key, $sum_key) {
        $results = array();
        foreach ($array as $value)
        {
          if( ! isset($results[$value[$key]]) )
          {
             $results[$value[$key]] = 0;
          }

          $results[$value[$key]] += $value[$sum_key];

        }
        return $results;
    }
    
    public function separaArrayPescadores($arrayPescadores){
        
        foreach($arrayPescadores as $consulta):
            $count[] = $consulta['count'];
            $porto[] = $consulta['pto_nome'];
        endforeach;
        
        $this->countPescadores = $count;
        $this->portoPescadores = $porto;
    }
    public function unidadecapturaAction(){
        //Quantidade de Pescadores por porto e por arte de pesca
        //Arrasto de Fundo
        $arrastoPescadoresPorto = $this->modelArrasto->selectPescadoresByPorto();
        //$this->view->assign("arrastoPescadoresPorto", $arrastoPescadoresPorto);
        $this->separaArrayPescadores($arrastoPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosArrasto", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoArrasto", json_encode($this->countPescadores));
        
        //Calao
        $calaoPescadoresPorto = $this->modelCalao->selectPescadoresByPorto();
        //$this->view->assign("arrastoPescadoresPorto", $arrastoPescadoresPorto);
        $this->separaArrayPescadores($calaoPescadoresPorto);
        $this->view->assign("portosCalao", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoCalao", json_encode($this->countPescadores));
        
        //Coleta
        $coletaPescadoresPorto = $this->modelColeta->selectPescadoresByPorto();
        //$this->view->assign("coletaPescadoresPorto", $coletaPescadoresPorto);
        $this->separaArrayPescadores($coletaPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosColeta", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoColeta", json_encode($this->countPescadores));
		
        //Emalhe
        $emalhePescadoresPorto = $this->modelEmalhe->selectPescadoresByPorto();
        //$this->view->assign("emalhePescadoresPorto", $emalhePescadoresPorto);
        $this->separaArrayPescadores($emalhePescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosEmalhe", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoEmalhe", json_encode($this->countPescadores));
		
        //Groseira
        $groseiraPescadoresPorto = $this->modelGroseira->selectPescadoresByPorto();
        //$this->view->assign("groseiraPescadoresPorto", $groseiraPescadoresPorto);
        $this->separaArrayPescadores($groseiraPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosGroseira", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoGroseira", json_encode($this->countPescadores));
		
        //Jerere
        $jererePescadoresPorto = $this->modelJerere->selectPescadoresByPorto();
        //$this->view->assign("jererePescadoresPorto", $jererePescadoresPorto);
        $this->separaArrayPescadores($jererePescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosJerere", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoJerere", json_encode($this->countPescadores));
		
        //Linha
        $linhaPescadoresPorto = $this->modelLinha->selectPescadoresByPorto();
        //$this->view->assign("linhaPescadoresPorto", $linhaPescadoresPorto);
        $this->separaArrayPescadores($linhaPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosLinha", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoLinha", json_encode($this->countPescadores));
		
        //LinhaFundo
        $linhafundoPescadoresPorto = $this->modelLinhaFundo->selectPescadoresByPorto();
        //$this->view->assign("linhafundoPescadoresPorto", $linhafundoPescadoresPorto);
        $this->separaArrayPescadores($linhafundoPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosLinhaFundo", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoLinhaFundo", json_encode($this->countPescadores));
		
        //Manzua
        $manzuaPescadoresPorto = $this->modelManzua->selectPescadoresByPorto();
        //$this->view->assign("manzuaPescadoresPorto", $manzuaPescadoresPorto);
        $this->separaArrayPescadores($manzuaPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosManzua", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoManzua", json_encode($this->countPescadores));
		
        //Mergulho
        $mergulhoPescadoresPorto = $this->modelMergulho->selectPescadoresByPorto();
        //$this->view->assign("mergulhoPescadoresPorto", $mergulhoPescadoresPorto);
        $this->separaArrayPescadores($mergulhoPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosMergulho", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoMergulho", json_encode($this->countPescadores));
		
        //Ratoeira
        $ratoeiraPescadoresPorto = $this->modelRatoeira->selectPescadoresByPorto();
        //$this->view->assign("ratoeiraPescadoresPorto", $ratoeiraPescadoresPorto);
        $this->separaArrayPescadores($ratoeiraPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosRatoeira", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoRatoeira", json_encode($this->countPescadores));
		
        //Siripoia
        $siripoiaPescadoresPorto = $this->modelSiripoia->selectPescadoresByPorto();
        //$this->view->assign("siripoiaPescadoresPorto", $siripoiaPescadoresPorto);
        $this->separaArrayPescadores($siripoiaPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosSiripoia", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoSiripoia", json_encode($this->countPescadores));
		
        //Tarrafa
        $tarrafaPescadoresPorto = $this->modelTarrafa->selectPescadoresByPorto();
        //$this->view->assign("tarrafaPescadoresPorto", $tarrafaPescadoresPorto);
        $this->separaArrayPescadores($tarrafaPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosTarrafa", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoTarrafa", json_encode($this->countPescadores));
		
        //VaraPesca
        $varapescaPescadoresPorto = $this->modelVaraPesca->selectPescadoresByPorto();
        //$this->view->assign("varapescaPescadoresPorto", $varapescaPescadoresPorto);
        $this->separaArrayPescadores($varapescaPescadoresPorto);//O retorno dessa função altera as variaveis globais portoPescadores/countPescadores
        $this->view->assign("portosVaraPesca", json_encode($this->portoPescadores));
        $this->view->assign("pescByPortoVaraPesca", json_encode($this->countPescadores));
        
    }
    public function pescadorAction()
    {

        //Quantidade de Pescadores
        $pescadores = $this->modelPescador->selectView();
        $quantPescador = count($pescadores);
        $this->view->assign("quantPescadores", $quantPescador);
        
        //Quantidade de Pescadores por gênero
        $consultaGenero = $this->modelPescador->selectPescadorBySexo();
        $masc[] = $consultaGenero['masculino'];
        $fem[] = $consultaGenero['feminino'];
        $this->view->assign("Masculino", $masc[0]);
        $this->view->assign("Feminino", $fem[0]);
        
        
        //Comunidade
        $comunidadePescadores = $this->modelPescador->select_Pescador_group_comunidade();
        //print_r($comunidadePescadores);
        foreach($comunidadePescadores as $dados):
            if(empty($dados['tcom_nome'])){
                $dados['tcom_nome'] = 'Não Informado';
            }
            $comunidade[] = $dados['tcom_nome'];
            $count[] = $dados['count'];
        endforeach;
        //$this->view->assign("comunidadePescadores", $comunidadePescadores);
        $this->view->assign("comunidades", json_encode($comunidade));
        $this->view->assign("pescByComunidades", json_encode($count));
        
        //Colonia
        $coloniaPescadores = $this->modelPescador->select_Pescador_group_colonia();
        foreach($coloniaPescadores as $dados):
            if(empty($dados['tc_nome'])){
                $dados['tc_nome'] = 'Não Informado';
            }
            $colonias[] = $dados['tc_nome'];
            $countCol[] = $dados['count'];
        endforeach;
        $this->view->assign("colonias", json_encode($colonias));
        $this->view->assign("pescByColonias", json_encode($countCol));
        
        //Escolaridade
        
        $escolaridadePescadores = $this->modelPescador->select_Pescador_group_escolaridade();
        foreach($escolaridadePescadores as $dados){
            if(empty($dados['esc_nivel'])){
                $dados['esc_nivel'] = 'Não Informado';
            }
            $escolaridade[] = $dados['esc_nivel'];
            $countEsc[] = $dados['count'];
        }

        $this->view->assign("escolaridades", json_encode($escolaridade));
        $this->view->assign("pescByEscolaridade", json_encode($countEsc));
        //$this->view->assign("escolaridadePescadores", $escolaridadePescadores);
    }
    
    public function barcoAction()
    {
        $this->modelEmbarcacaoDetalhada = new Application_Model_EmbarcacaoDetalhada();
        
        $this->modelBarcos = new Application_Model_Barcos();
        //Embarcacoes Por porto
        $totalBarcos = $this->modelBarcos->select();
        $quantBarcos = count($totalBarcos);
        $this->view->assign("quantBarcos", $quantBarcos);
        
        $totalEmbarcacoes = $this->modelEmbarcacaoDetalhada->select();
        $quantEmbarcacoes = count($totalEmbarcacoes);
        $this->view->assign("quantEmbarcacoes", $quantEmbarcacoes);
        
        
        $embarcacoesByPorto = $this->modelEmbarcacaoDetalhada->selectEmbarcacoesByPorto();
        foreach($embarcacoesByPorto as $dados){
            $portos[] = $dados['pto_nome'];
            $countBarcosPorto[] = $dados['count'];
        }
        $this->view->assign("portos", json_encode($portos));
        $this->view->assign("countEmbarcacoes", json_encode($countBarcosPorto));
        
        //Percentual de estado de conservação das embarcações
        $embarcacoesByConservacao = $this->modelEmbarcacaoDetalhada->selectEmbarcacoesByConservacao();
        foreach($embarcacoesByConservacao as $dados):
            if($dados['conservacao'] == 'Bom'){
                $bom = $dados['count'];
            }
            if($dados['conservacao'] == 'Ruim'){
                $ruim = $dados['count'];
            }
            if($dados['conservacao'] == 'Não Declarado'){
                $naoRespondeu = $dados['count'];
            }
        endforeach;
        
        $this->view->assign("bom", $bom);
        $this->view->assign("ruim", $ruim);
        $this->view->assign("naoRespondeu", $naoRespondeu);
        
        
        //Percentual de Embarcações por Artes de Pesca
        $embarcacoesByArte = $this->modelEmbarcacaoDetalhada->selectEmbarcacoesByArtePesca();
        $this->view->assign("embarcacoesByArte", $embarcacoesByArte);
        
        $embarcacoesByEstado = $this->modelEmbarcacaoDetalhada->selectEmbarcacoesByEstado();
        foreach($embarcacoesByEstado as $dados):
            if($dados['estado'] == 'Nova'){
                $nova = $dados['count'];
            }
            if($dados['estado'] == 'Usada'){
                $usada = $dados['count'];
            }
            if($dados['estado'] == 'Não Declarado'){
                $naoRespondeuEstado = $dados['count'];
            }
        endforeach;
        //print_r($embarcacoesByEstado);
        $this->view->assign("nova", $nova);
        $this->view->assign("usada", $usada);
        $this->view->assign("naoRespondeuEstado", $naoRespondeuEstado);
       
        $embarcacoesByAnoConstrucao = $this->modelEmbarcacaoDetalhada->selectEmbarcacoesByAnoConstr();
        $embarcacoesByAnoConstrucaoOrdenado = $this->array_sort($embarcacoesByAnoConstrucao, 'ted_ano_construcao');
        foreach($embarcacoesByAnoConstrucaoOrdenado as $dados):
            $ano[] = $dados['ted_ano_construcao'];
            $countEmbByAno[] = $dados['count'];
        endforeach;
        
        $this->view->assign("ano",  json_encode($ano));
        $this->view->assign("embarcacoesByAnoConstrucao", json_encode($countEmbByAno));
        
        //print_r($embarcacoesByAnoConstrucao);
    }
    
    public function entrevistaAction()
    {
        $quantidadeArrasto    = $this->modelArrasto   ->select();
        $quantidadeCalao      = $this->modelCalao     ->select();
        $quantidadeColeta     = $this->modelColeta    ->select();
        $quantidadeEmalhe     = $this->modelEmalhe    ->select();
        $quantidadeGrosseira  = $this->modelGroseira  ->select();
        $quantidadeJerere     = $this->modelJerere    ->select();
        $quantidadeLinha      = $this->modelLinha     ->select();
        $quantidadeLinhaFundo = $this->modelLinhaFundo->select();
        $quantidadeManzua     = $this->modelManzua    ->select();
        $quantidadeMergulho   = $this->modelMergulho  ->select();
        $quantidadeRatoeira   = $this->modelRatoeira  ->select();
        $quantidadeSiripoia   = $this->modelSiripoia  ->select();
        $quantidadeTarrafa    = $this->modelTarrafa   ->select();
        $quantidadeVaraPesca  = $this->modelVaraPesca ->select();
        
        $qtdArrasto =  count($quantidadeArrasto);
        $qtdCalao =    count($quantidadeCalao);
        $qtdColeta =   count($quantidadeColeta);
        $qtdEmalhe =   count($quantidadeEmalhe);
        $qtdGrosseira= count($quantidadeGrosseira);
        $qtdJerere =   count($quantidadeJerere);
        $qtdLinha =    count($quantidadeLinha);
        $qtdLinhaFundo=count($quantidadeLinhaFundo);
        $qtdManzua=    count($quantidadeManzua);
        $qtdMergulho=  count($quantidadeMergulho);
        $qtdRatoeira=  count($quantidadeRatoeira);
        $qtdSiripoia=  count($quantidadeSiripoia);
        $qtdTarrafa=   count($quantidadeTarrafa);
        $qtdVaraPesca =count($quantidadeVaraPesca);
        
        $totalEntrevistas =  $qtdArrasto+ $qtdCalao+  $qtdColeta+  $qtdEmalhe+  $qtdGrosseira+$qtdJerere+$qtdLinha+   $qtdLinhaFundo+$qtdManzua+$qtdMergulho+$qtdRatoeira+ $qtdSiripoia+ $qtdTarrafa+ $qtdVaraPesca;
        
        $arrayQuantidades =  array($qtdArrasto, $qtdCalao, $qtdColeta, $qtdEmalhe, $qtdGrosseira, $qtdJerere, $qtdLinha, $qtdLinhaFundo,$qtdManzua,$qtdMergulho,$qtdRatoeira,$qtdSiripoia,$qtdTarrafa,$qtdVaraPesca);
        $arrayArtes = array("Arrasto de Fundo", "Calão", "Coleta Manual", "Emalhe", "Espinhel/Groseira", "Jerere", "Linha", "Linha de Fundo", "Manzuá", "Mergulho", "Ratoeira", "Siripoia", "Tarrafa", "Vara de Pesca");
        
        $this->view->assign("totalEntrevistas", $totalEntrevistas);
        $this->view->assign("arrayLabels", json_encode($arrayArtes));
        $this->view->assign("arrayQuantidades", json_encode($arrayQuantidades));
        
        $pesqueirosArrasto    = $this->modelArrasto   ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosCalao      = $this->modelCalao     ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosColeta     = $this->modelColeta    ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosEmalhe     = $this->modelEmalhe    ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosGrosseira  = $this->modelGroseira  ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosJerere     = $this->modelJerere    ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosLinha      = $this->modelLinha     ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosLinhaFundo = $this->modelLinhaFundo->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosManzua     = $this->modelManzua    ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosMergulho   = $this->modelMergulho  ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosRatoeira   = $this->modelRatoeira  ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosSiripoia   = $this->modelSiripoia  ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosTarrafa    = $this->modelTarrafa   ->selectPesqueirosVisitados(null,'count Desc','25');
        $pesqueirosVaraPesca  = $this->modelVaraPesca ->selectPesqueirosVisitados(null,'count Desc','25');
        
        foreach($pesqueirosArrasto as $dados):
            $pesqArrasto[] = $dados['paf_pesqueiro'];
            $quantArrasto[] = $dados['count'];    
        endforeach;
        foreach($pesqueirosCalao as $dados):
            $pesqCalao[] = $dados['paf_pesqueiro'];
            $quantCalao[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosColeta as $dados):
            $pesqColeta[] = $dados['paf_pesqueiro'];
            $quantColeta[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosEmalhe  as $dados):
            $pesqEmalhe[] = $dados['paf_pesqueiro'];
            $quantEmalhe[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosGrosseira as $dados):
            $pesqGrosseira[] = $dados['paf_pesqueiro'];
            $quantGrosseira[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosJerere as $dados):
            $pesqJerere[] = $dados['paf_pesqueiro'];
            $quantJerere[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosLinha as $dados):
            $pesqLinha[] = $dados['paf_pesqueiro'];
            $quantLinha[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosLinhaFundo as $dados):
            $pesqLinhaFundo[] = $dados['paf_pesqueiro'];
            $quantLinhaFundo[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosManzua as $dados):
            $pesqManzua[] = $dados['paf_pesqueiro'];
            $quantManzua[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosMergulho as $dados):
            $pesqMergulho[] = $dados['paf_pesqueiro'];
            $quantMergulho[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosRatoeira as $dados):
            $pesqRatoeira[] = $dados['paf_pesqueiro'];
            $quantRatoeira[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosSiripoia as $dados):
            $pesqSiripoia[] = $dados['paf_pesqueiro'];
            $quantSiripoia[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosTarrafa as $dados):
            $pesqTarrafa[] = $dados['paf_pesqueiro'];
            $quantTarrafa[] = $dados['count'];  
        endforeach;
        foreach($pesqueirosVaraPesca as $dados):
            $pesqVaraPesca[] = $dados['paf_pesqueiro'];
            $quantVaraPesca[] = $dados['count'];  
        endforeach;
        
        $this->view->assign("pesqArrasto", json_encode($pesqArrasto));
        $this->view->assign("quantArrasto", json_encode($quantArrasto));
        
        $this->view->assign("pesqCalao", json_encode($pesqCalao));
        $this->view->assign("quantCalao", json_encode($quantCalao));
        
        $this->view->assign("pesqColeta", json_encode($pesqColeta));
        $this->view->assign("quantColeta", json_encode($quantColeta));
        
        $this->view->assign("pesqEmalhe", json_encode($pesqEmalhe));
        $this->view->assign("quantEmalhe", json_encode($quantEmalhe));
        
        $this->view->assign("pesqGrosseira", json_encode($pesqGrosseira));
        $this->view->assign("quantGrosseira", json_encode($quantGrosseira));
        
        $this->view->assign("pesqJerere", json_encode($pesqJerere));
        $this->view->assign("quantJerere", json_encode($quantJerere));
        
        $this->view->assign("pesqLinha", json_encode($pesqLinha));
        $this->view->assign("quantLinha", json_encode($quantLinha));
        
        $this->view->assign("pesqLinhaFundo", json_encode($pesqLinhaFundo));
        $this->view->assign("quantLinhaFundo", json_encode($quantLinhaFundo));
        
        $this->view->assign("pesqManzua", json_encode($pesqManzua));
        $this->view->assign("quantManzua", json_encode($quantManzua));
        
        $this->view->assign("pesqMergulho", json_encode($pesqMergulho));
        $this->view->assign("quantMergulho", json_encode($quantMergulho));
        
        $this->view->assign("pesqRatoeira", json_encode($pesqRatoeira));
        $this->view->assign("quantRatoeira", json_encode($quantRatoeira));
        
        $this->view->assign("pesqSiripoia", json_encode($pesqSiripoia));
        $this->view->assign("quantSiripoia", json_encode($quantSiripoia));
        
        $this->view->assign("pesqTarrafa", json_encode($pesqTarrafa));
        $this->view->assign("quantTarrafa", json_encode($quantTarrafa));
        
        $this->view->assign("pesqVaraPesca", json_encode($pesqVaraPesca));
        $this->view->assign("quantVaraPesca", json_encode($quantVaraPesca));
           
    }
    
    public function capturaAction()
    {
        
    }
    
    public function avistamentoAction()
    {
        $avistamentosArrasto      = $this->modelArrasto->selectArrastoHasAvistamento();
        $avistamentosCalao        = $this->modelCalao->selectCalaoHasAvistamento();    
        $avistamentosColetaManual = $this->modelColeta->selectColetaManualHasAvistamento(); 
        $avistamentosEmalhe       = $this->modelEmalhe->selectEmalheHasAvistamento();  
        $avistamentosGrosseira    = $this->modelGroseira->selectGrosseiraHasAvistamento(); 
        $avistamentosJerere       = $this->modelJerere->selectJerereHasAvistamento(); 
        $avistamentosLinha        = $this->modelLinha->selectLinhaHasAvistamento(); 
        $avistamentosLinhaFundo   = $this->modelLinhaFundo->selectLinhaFundoHasAvistamento(); 
        $avistamentosManzua       = $this->modelManzua->selectManzuaHasAvistamento();  
        $avistamentosMergulho     = $this->modelMergulho->selectMergulhoHasAvistamento(); 
        $avistamentosRatoeira     = $this->modelRatoeira->selectRatoeiraHasAvistamento(); 
        $avistamentosSiripoia     = $this->modelSiripoia->selectSiripoiaHasAvistamento(); 
        $avistamentosTarrafa      = $this->modelTarrafa->selectTarrafaHasAvistamento(); 
        $avistamentosVaraPesca    = $this->modelVaraPesca->selectVaraPescaHasAvistamento();
        
        $type_count = 0;
        foreach($avistamentosArrasto as $dados) {
            $type_count[] = count(array_keys($avistamentosArrasto,'avs_descricao'));
        }
       
        
        
        print_r($type_count);
        
        
    }
    public function dadosBiometriaCamarao($tipo,$especie){
        $biometriasCamaraoArrasto      = $this->modelArrasto->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoCalao        = $this->modelCalao->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null);    
        $biometriasCamaraoColetaManual = $this->modelColeta->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoEmalhe       = $this->modelEmalhe->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null);  
        $biometriasCamaraoGrosseira    = $this->modelGroseira->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoJerere       = $this->modelJerere->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoLinha        = $this->modelLinha->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoLinhaFundo   = $this->modelLinhaFundo->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoManzua       = $this->modelManzua->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null);  
        $biometriasCamaraoMergulho     = $this->modelMergulho->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoRatoeira     = $this->modelRatoeira->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoSiripoia     = $this->modelSiripoia->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoTarrafa      = $this->modelTarrafa->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasCamaraoVaraPesca    = $this->modelVaraPesca->selectVBioCamarao("esp_nome_comum = '".$especie."'", $order = null, $limit = null);
    
        
        $arrayBiometrias = array_merge_recursive($biometriasCamaraoArrasto,
                                                $biometriasCamaraoCalao,    
                                                $biometriasCamaraoColetaManual,
                                                $biometriasCamaraoEmalhe,
                                                $biometriasCamaraoGrosseira,
                                                $biometriasCamaraoJerere,
                                                $biometriasCamaraoLinha,
                                                $biometriasCamaraoLinhaFundo,
                                                $biometriasCamaraoManzua, 
                                                $biometriasCamaraoMergulho, 
                                                $biometriasCamaraoRatoeira, 
                                                $biometriasCamaraoSiripoia,
                                                $biometriasCamaraoTarrafa,
                                                $biometriasCamaraoVaraPesca);
        $i=0;
        $soma=0;
        $max = 0;
        $min = PHP_INT_MAX;
        
        foreach($arrayBiometrias as $key=> $dados):
            $soma += $dados[$tipo];
            $i++;
            if($dados[$tipo]>=$max){
                $max = $dados[$tipo];
            }
            if($dados[$tipo]<=$min){
                $min = $dados[$tipo];
            }
        endforeach;
        
        $this->view->assign("totalRegistrado", count($arrayBiometrias));
        $this->view->assign("media".$tipo, $soma/$i);
        $this->view->assign("max".$tipo, $max);
        $this->view->assign("min".$tipo, $min);
    
    }
    
    public function biometriacamaraoAction()
    {
        $tipo_comprimento = 'tbc_comprimento_cabeca';
        $tipo_peso = 'tbc_peso';
        
        $especie = $this->_getParam('especie');
        $biometriasArrastoComprimento = $this->modelArrasto->selectHistogramaBiometriaCamarao($tipo_comprimento,"esp_nome_comum = '".$especie."'",$tipo_comprimento,null);
        
        $biometriasArrastoPeso = $this->modelArrasto->selectDadosBiometriaCamarao("esp_nome_comum = '".$especie."'");        
    
        foreach($biometriasArrastoComprimento as $dados):
            if($dados['tbc_comprimento_cabeca'] == '0'){
                $dados['tbc_comprimento_cabeca'] = '<1';
            }
            $quantidadeComprimento[] = $dados['quantidade'];
            $comprimento[] = $dados['tbc_comprimento_cabeca'].'mm';
        endforeach;
        //print_r($biometriasArrastoPeso);
//        foreach($biometriasArrastoPeso as $dados):
//            if($dados['tbc_peso'] == '0'){
//                $dados['tbc_peso'] = '<1';
//            }
//            $Dados[] = $dados['quantidade'];
//        endforeach;
        
        $this->view->assign("DadosCamarao", json_encode($biometriasArrastoPeso));
        
        $this->dadosBiometriaCamarao($tipo_comprimento,$especie);
        $this->dadosBiometriaCamarao($tipo_peso, $especie);
        $this->view->assign('especie', $especie);
        $this->view->assign("jsDadosComprimento", json_encode($quantidadeComprimento));
//        $this->view->assign("jsDadosPeso", json_encode($quantidadePeso));
        
        $this->view->assign("jsLabelsComprimento", json_encode($comprimento));
//        $this->view->assign("jsLabelsPeso", json_encode($peso));
    }
    
    public function dadosBiometriaPeixe($tipo,$especie){
        
        $biometriasPeixeArrasto      = $this->modelArrasto->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeCalao        = $this->modelCalao->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null);    
        $biometriasPeixeColetaManual = $this->modelColeta->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeEmalhe       = $this->modelEmalhe->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null);  
        $biometriasPeixeGrosseira    = $this->modelGroseira->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeJerere       = $this->modelJerere->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeLinha        = $this->modelLinha->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeLinhaFundo   = $this->modelLinhaFundo->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeManzua       = $this->modelManzua->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null);  
        $biometriasPeixeMergulho     = $this->modelMergulho->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeRatoeira     = $this->modelRatoeira->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeSiripoia     = $this->modelSiripoia->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeTarrafa      = $this->modelTarrafa->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null); 
        $biometriasPeixeVaraPesca    = $this->modelVaraPesca->selectVBioPeixe("esp_nome_comum = '".$especie."'", $order = null, $limit = null);
    
        
        $arrayBiometrias = array_merge_recursive($biometriasPeixeArrasto,
                                                $biometriasPeixeCalao,    
                                                $biometriasPeixeColetaManual,
                                                $biometriasPeixeEmalhe,
                                                $biometriasPeixeGrosseira,
                                                $biometriasPeixeJerere,
                                                $biometriasPeixeLinha,
                                                $biometriasPeixeLinhaFundo,
                                                $biometriasPeixeManzua, 
                                                $biometriasPeixeMergulho, 
                                                $biometriasPeixeRatoeira, 
                                                $biometriasPeixeSiripoia,
                                                $biometriasPeixeTarrafa,
                                                $biometriasPeixeVaraPesca);
        $i=0;
        $soma=0;
        $max = 0;
        $min = 999999;
        foreach($arrayBiometrias as $key=> $dados):
            $soma += $dados[$tipo];
            $i++;
            if($dados[$tipo]>=$max){
                $max = $dados[$tipo];
            }
            if($dados[$tipo]<=$min){
                $min = $dados[$tipo];
            }
        endforeach;
        
        $this->view->assign("totalRegistrado", count($arrayBiometrias));
        $this->view->assign("media".$tipo, $soma/$i);
        $this->view->assign("max".$tipo, $max);
        $this->view->assign("min".$tipo, $min);
    }
    public function biometriapeixebytipo($tipo,$especie){
        
        $biometriasPeixeArrasto      = $this->modelArrasto->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeCalao        = $this->modelCalao->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null);    
        $biometriasPeixeColetaManual = $this->modelColeta->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeEmalhe       = $this->modelEmalhe->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null);  
        $biometriasPeixeGrosseira    = $this->modelGroseira->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeJerere       = $this->modelJerere->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeLinha        = $this->modelLinha->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeLinhaFundo   = $this->modelLinhaFundo->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeManzua       = $this->modelManzua->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null);  
        $biometriasPeixeMergulho     = $this->modelMergulho->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeRatoeira     = $this->modelRatoeira->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeSiripoia     = $this->modelSiripoia->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeTarrafa      = $this->modelTarrafa->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null); 
        $biometriasPeixeVaraPesca    = $this->modelVaraPesca->selectHistogramaBiometriaPeixe($tipo,"esp_nome_comum = '".$especie."'",$tipo,null);
        
        $arrayBiometrias = array_merge_recursive($biometriasPeixeArrasto,     
                                                $biometriasPeixeCalao,
                                                $biometriasPeixeColetaManual,
                                                $biometriasPeixeEmalhe,   
                                                $biometriasPeixeGrosseira,
                                                $biometriasPeixeJerere,
                                                $biometriasPeixeLinha,  
                                                $biometriasPeixeLinhaFundo,
                                                $biometriasPeixeManzua,
                                                $biometriasPeixeMergulho,
                                                $biometriasPeixeRatoeira,
                                                $biometriasPeixeSiripoia,
                                                $biometriasPeixeTarrafa, 
                                                $biometriasPeixeVaraPesca);
        
       $arrayBiometriasOrdenado = $this->array_sort($arrayBiometrias, $tipo);
       $arrayBiometriasSum = $this->array_sum_values($arrayBiometriasOrdenado, $tipo, 'quantidade');
       
       return $arrayBiometriasSum;
    }
    public function biometriapeixebypeso($especie){
    
        $biometriasPeixeArrasto      = $this->modelArrasto->   selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeCalao        = $this->modelCalao->     selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'");    
        $biometriasPeixeColetaManual = $this->modelColeta->    selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeEmalhe       = $this->modelEmalhe->    selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'");  
        $biometriasPeixeGrosseira    = $this->modelGroseira->  selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeJerere       = $this->modelJerere->    selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeLinha        = $this->modelLinha->     selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeLinhaFundo   = $this->modelLinhaFundo->selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeManzua       = $this->modelManzua->    selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'");  
        $biometriasPeixeMergulho     = $this->modelMergulho->  selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeRatoeira     = $this->modelRatoeira->  selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeSiripoia     = $this->modelSiripoia->  selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeTarrafa      = $this->modelTarrafa->   selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'"); 
        $biometriasPeixeVaraPesca    = $this->modelVaraPesca-> selectDadosBiometriaPeixe("esp_nome_comum = '".$especie."'");
        
        $arrayBiometrias = array_merge_recursive($biometriasPeixeArrasto,     
                                                $biometriasPeixeCalao,
                                                $biometriasPeixeColetaManual,
                                                $biometriasPeixeEmalhe,   
                                                $biometriasPeixeGrosseira,
                                                $biometriasPeixeJerere,
                                                $biometriasPeixeLinha,  
                                                $biometriasPeixeLinhaFundo,
                                                $biometriasPeixeManzua,
                                                $biometriasPeixeMergulho,
                                                $biometriasPeixeRatoeira,
                                                $biometriasPeixeSiripoia,
                                                $biometriasPeixeTarrafa, 
                                                $biometriasPeixeVaraPesca);
        
       //$arrayBiometrias = $this->array_sort($arrayBiometrias, $tipo);
       //$arrayBiometriasSum = $this->array_sum_values($arrayBiometriasOrdenado, $tipo, 'quantidade');
       
       return $arrayBiometrias;
    }
    
    public function biometriapeixeAction()
    {   
        $tipo_comprimento = 'tbp_comprimento';
        $tipo_peso = 'tbp_peso';
        $especie = $this->_getParam('especie');
       
        $arrayComprimento = $this->biometriapeixebytipo($tipo_comprimento,$especie);
        $arrayPeso = $this->biometriapeixebypeso($especie);
        
        
        foreach($arrayComprimento as $key => $dados):
            if($key == '0'){
                $key = '<1';
            }
            $comprimento[] = $key.'cm';
        endforeach;
        
        
        
        
        $this->dadosBiometriaPeixe($tipo_comprimento,$especie);
        $this->dadosBiometriaPeixe($tipo_peso,$especie);
        
        $this->view->assign("especie", $especie);
        $this->view->assign('jsDadosComprimento', json_encode($arrayComprimento));
        $this->view->assign('jsLabelsComprimento', json_encode($comprimento));
        $this->view->assign('DadosPeixes', json_encode($arrayPeso));
        //$this->view->assign('jsLabelsPeso', json_encode($peso));
        //$this->view->assign('jsDadosPeso', json_encode($arrayPeso));

    }
    
    

}

