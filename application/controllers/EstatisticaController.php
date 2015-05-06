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
    }

    public function indexAction()
    {
        // action body
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
    public function separaArrayPescadores($arrayPescadores){
        
        foreach($arrayPescadores as $consulta):
            $count[] = $consulta['count'];
            $porto[] = $consulta['pto_nome'];
        endforeach;
        
        $this->countPescadores = $count;
        $this->portoPescadores = $porto;
    }
    
    public function pescadorAction()
    {
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
        
        $totalEntrevistas =  $qtdArrasto+ 
                             $qtdCalao+  
                             $qtdColeta+  
                             $qtdEmalhe+  
                             $qtdGrosseira+
                             $qtdJerere+
                             $qtdLinha+   
                             $qtdLinhaFundo+
                             $qtdManzua+
                             $qtdMergulho+
                             $qtdRatoeira+ 
                             $qtdSiripoia+ 
                             $qtdTarrafa+ 
                             $qtdVaraPesca;
        
        $arrayQuantidades =  array(
                $qtdArrasto, 
                $qtdCalao, 
                $qtdColeta, 
                $qtdEmalhe, 
                $qtdGrosseira, 
                $qtdJerere, 
                $qtdLinha, 
                $qtdLinhaFundo,
                $qtdManzua,
                $qtdMergulho,
                $qtdRatoeira,
                $qtdSiripoia,
                $qtdTarrafa,
                $qtdVaraPesca);
        $arrayArtes = array("Arrasto de Fundo", "Calão", "Coleta Manual", "Emalhe", "Espinhel/Groseira", "Jerere", "Linha", "Linha de Fundo", "Manzuá", "Mergulho", "Ratoeira", "Siripoia", "Tarrafa", "Vara de Pesca");
        
        $this->view->assign("totalEntrevistas", $totalEntrevistas);
        $this->view->assign("arrayLabels", json_encode($arrayArtes));
        $this->view->assign("arrayQuantidades", json_encode($arrayQuantidades));
        
    }
    
    public function capturaAction()
    {
        // action body
    }
    
    public function avistamentoAction()
    {
        // action body
    }
}

