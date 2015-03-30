<?php
require_once "../library/fpdf/fpdf.php";
class PortoController extends Zend_Controller_Action
{
    private $modelPorto;
    private $usuario;
    public function init()
    {
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->_redirect('index');
        }

        $this->_helper->layout->setLayout('admin');


        $auth = Zend_Auth::getInstance();
         if ( $auth->hasIdentity() ){
          $identity = $auth->getIdentity();
          $identity2 = get_object_vars($identity);

        }

        $this->modelUsuario = new Application_Model_Usuario();
        $this->usuario = $this->modelUsuario->selectLogin($identity2['tl_id']);
        $this->view->assign("usuario",$this->usuario);


        $this->modelPorto = new Application_Model_Porto();
        $this->modelArrasto = new Application_Model_ArrastoFundo();
        $this->modelCalao= new Application_Model_Calao();
        $this->modelColeta= new Application_Model_ColetaManual();
        $this->modelEmalhe= new Application_Model_Emalhe();
        $this->modelGrosseira= new Application_Model_Grosseira();
        $this->modelJerere= new Application_Model_Jerere();
        $this->modelLinha= new Application_Model_Linha();
        $this->modelLinhaFundo= new Application_Model_LinhaFundo();
        $this->modelManzua= new Application_Model_Manzua();
        $this->modelMergulho= new Application_Model_Mergulho();
        $this->modelRatoeira= new Application_Model_Ratoeira();
        $this->modelSiripoia= new Application_Model_Siripoia();
        $this->modelTarrafa= new Application_Model_Tarrafa();
        $this->modelVaraPesca =  new Application_Model_VaraPesca();
    }

    public function indexAction()
    {
        $dados = $this->modelPorto->select(null, 'pto_prioridade');

        $this->view->assign("dados", $dados);
    }

    public function novoAction()
    {
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $modelMunicipio = new Application_Model_Municipio();

        $municipios = $modelMunicipio->select();

        $this->view->assign("municipios", $municipios);
    }

    public function criarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelPorto->insert($this->_getAllParams());

        $this->_redirect('porto/index');
    }

    public function editarAction()
    {

        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        $modelMunicipio = new Application_Model_Municipio();

        $municipios = $modelMunicipio->select();

        $this->view->assign("municipios", $municipios);

        $porto = $this->modelPorto->find($this->_getParam('id'));

        $this->view->assign("porto", $porto);
    }

    public function atualizarAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        $this->modelPorto->update($this->_getAllParams());

        $this->_redirect('porto/index');
    }

    public function excluirAction()
    {
        if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
        if($this->usuario['tp_id']==15 | $this->usuario['tp_id'] ==17 | $this->usuario['tp_id']==21){
            $this->_redirect('index');
        }
        else{
        $this->modelPorto->delete($this->_getParam('id'));

        $this->_redirect('porto/index');
        }
    }
    public function relatorioindexAction(){
        $dataini = $this->_getParam('dataini');
        $datafim = $this->_getParam('datafim');
        $id = $this->_getParam('porto');
        
        switch($id){
            case 1: $this->_redirect('porto/pontal/dataini/'.$dataini.'/datafim/'.$datafim);
            case 2: $this->_redirect('porto/terminal/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 3: $this->_redirect('porto/prainha/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 4: $this->_redirect('porto/amendoeira/dataini/'.$dataini.'/datafim/'.$datafim);
            case 5: $this->_redirect('porto/barra/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 6: $this->_redirect('porto/saomiguel/dataini/'.$dataini.'/datafim/'.$datafim);
            case 7: $this->_redirect('porto/tulha/dataini/'.$dataini.'/datafim/'.$datafim);
            case 8: $this->_redirect('porto/mamoa/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 9: $this->_redirect('porto/ramo/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 10: $this->_redirect('porto/urucutuca/dataini/'.$dataini.'/datafim/'.$datafim);
            case 11: $this->_redirect('porto/sambaituba/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 12: $this->_redirect('porto/juerana/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 13: $this->_redirect('porto/aritagua/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 14: $this->_redirect('porto/sobradinho/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 15: $this->_redirect('porto/serra/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 16: $this->_redirect('porto/badu/dataini/'.$dataini.'/datafim/'.$datafim); 
            case 17: $this->_redirect('porto/concha/dataini/'.$dataini.'/datafim/'.$datafim);
            case 1: $this->_redirect('porto/forte/dataini/'.$dataini.'/datafim/'.$datafim); 
        }
        
    }
    public function dataFinal($data){
        
        if($data==''){
            $data = date('Y-m-j');
        }

        return $data;
    }
    public function dataInicial($data){
        if($data == ''){
            $data = '2013-11-01';
        }
        return $data;
    }
    public function vazioCount($array, $porto){
        if(empty($array)){
            $array = array( array(
                'pto_nome' => $porto,
                'count' => 0,
                )
            );
        }
        return $array;
    }
    public function vazio($array, $porto){
        if(empty($array)){
            $array = array( array(
                'pto_nome' => $porto,
                'quant' => 0,
                'peso' => 0
                )
            );
        }
        else if($array[0]['quant'] == ""){
            $array[0]['quant'] = 0;
        }
        else if($array[0]['peso'] == ""){
            $array[0]['peso'] = 0;
        }
        return $array;
    }
    
    public function amendoeiraAction(){
        
        $dateStart = $this->_getParam('dataini');
        $dateEnd = $this->_getParam('datafim');
        
        $dataIni = $this->dataInicial($dateStart);
        $date = explode('-',$dataIni);
        $datainicial = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("dataini", $datainicial);
        
        $dataFim = $this->dataFinal($dateEnd);
        $date = explode('-',$dataFim);
        $datafinal = $date[2].'-'.$date[1].'-'.$date[0];
        $this->view->assign("datafim", $datafinal);
        
        $porto = "Amendoeira";
        //Dados Para Select
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaJerere     = $this->modelJerere    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinhaFundo = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
        
        $captArrasto = $this->vazio($capturaArrasto,       $porto);
        $captCalao= $this->vazio($capturaCalao,            $porto);
        $captColeta = $this->vazio($capturaColeta,         $porto);
        $captEmalhe = $this->vazio($capturaEmalhe,         $porto);
        $captGrosseira = $this->vazio($capturaGrosseira,   $porto);
        $captJerere = $this->vazio($capturaJerere,         $porto);
        $captLinha = $this->vazio($capturaLinha,           $porto);
        $captLinhaFundo = $this->vazio($capturaLinhaFundo, $porto);
        $captManzua = $this->vazio($capturaManzua,         $porto);
        $captMergulho = $this->vazio($capturaMergulho,     $porto);
        $captRatoeira = $this->vazio($capturaRatoeira,     $porto);
        $captSiripoia = $this->vazio($capturaSiripoia,     $porto);
        $captTarrafa = $this->vazio($capturaTarrafa,       $porto);
        $captVaraPesca = $this->vazio($capturaVaraPesca,   $porto);
        
        $this->view->assign("capturaArrasto",   $captArrasto);   
        $this->view->assign("capturaCalao",     $captCalao);     
        $this->view->assign("capturaColeta",    $captColeta);    
        $this->view->assign("capturaEmalhe",    $captEmalhe);    
        $this->view->assign("capturaGrosseira", $captGrosseira); 
        $this->view->assign("capturaJerere",    $captJerere);    
        $this->view->assign("capturaLinha",     $captLinha);     
        $this->view->assign("capturaLinhaFundo",$captLinhaFundo);
        $this->view->assign("capturaManzua",    $captManzua);    
        $this->view->assign("capturaMergulho",  $captMergulho);    
        $this->view->assign("capturaRatoeira",  $captRatoeira); 
        $this->view->assign("capturaSiripoia",  $captSiripoia);    
        $this->view->assign("capturaTarrafa",   $captTarrafa);     
        $this->view->assign("capturaVaraPesca", $captVaraPesca);
        
        $arrayArtes = array("Arrasto de fundo",
            "Calão",
            "Coleta Manual",
            "Emalhe", 
            "Groseira", 
            "Jereré", 
            "Linha", 
            "Linha de Fundo",
            "Manzuá",
            "Mergulho",
            "Ratoeira",
            "Siripoia",
            "Tarrafa",
            "Vara de pesca");
        
        $arrayCaptura =  array_merge_recursive($captArrasto, 
                $captCalao, 
                $captColeta, 
                $captEmalhe, 
                $captGrosseira, 
                $captJerere, 
                $captLinha, 
                $captLinhaFundo,
                $captManzua,
                $captMergulho,
                $captRatoeira,
                $captSiripoia,
                $captTarrafa,
                $captVaraPesca);
        
        foreach($arrayCaptura as $key => $captura):
            $arrayQuant[] = $captura['quant'];
            $arrayPeso[] = $captura['peso'];
        endforeach;
        
        $jsQuant = json_encode($arrayQuant);
        $jsPeso = json_encode($arrayPeso);
        $jsArtes = json_encode($arrayArtes);
        
        $this->view->assign("arrayArtes", $jsArtes);
        $this->view->assign("arrayQuant", $jsQuant);
        $this->view->assign("arrayPeso", $jsPeso);
        //print_r($jsQuant);
//        $capturaTotal =$capturaArrasto[0]['quant']+
//                $capturaCalao[0]['quant']+
//                $capturaColeta[0]['quant']+
//                $capturaEmalhe[0]['quant']+
//                $capturaGrosseira[0]['quant']+
//                $capturaJerere[0]['quant']+
//                $capturaLinha[0]['quant']+
//                $capturaLinhaFundo[0]['quant']; 
//                
        //BARCOS
        $barcoArrasto    = $this->modelArrasto   ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoCalao      = $this->modelCalao     ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoColeta     = $this->modelColeta    ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoEmalhe     = $this->modelEmalhe    ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoGrosseira  = $this->modelGrosseira ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoJerere     = $this->modelJerere    ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoLinha      = $this->modelLinha     ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoLinhaFundo = $this->modelLinhaFundo->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoManzua     = $this->modelManzua    ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoMergulho   = $this->modelMergulho  ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoRatoeira   = $this->modelRatoeira  ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoSiripoia   = $this->modelSiripoia  ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $barcoTarrafa    = $this->modelTarrafa   ->selectBarcosByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $barcoVaraPesca  = $this->modelVaraPesca ->selectBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
        $barArrasto =  $this->vazioCount($barcoArrasto   ,  $porto);
        $barCalao =    $this->vazioCount($barcoCalao     , $porto);
        $barColeta =   $this->vazioCount($barcoColeta    , $porto);
        $barEmalhe =   $this->vazioCount($barcoEmalhe    , $porto);
        $barGrosseira= $this->vazioCount($barcoGrosseira , $porto);
        $barJerere =   $this->vazioCount($barcoJerere    , $porto);
        $barLinha =    $this->vazioCount($barcoLinha     , $porto);
        $barLinhaFundo=$this->vazioCount($barcoLinhaFundo, $porto);
        $barManzua=    $this->vazioCount($barcoManzua    , $porto);
        $barMergulho=  $this->vazioCount($barcoMergulho  , $porto);
        $barRatoeira=  $this->vazioCount($barcoRatoeira  , $porto);
        $barSiripoia=  $this->vazioCount($barcoSiripoia  , $porto);
        $barTarrafa=   $this->vazioCount($barcoTarrafa   , $porto);
        $barVaraPesca =$this->vazioCount($barcoVaraPesca ,  $porto);
        
        $this->view->assign("barcosArrasto",   $barArrasto);   
        $this->view->assign("barcosCalao",     $barCalao);     
        $this->view->assign("barcosColeta",    $barColeta);    
        $this->view->assign("barcosEmalhe",    $barEmalhe);    
        $this->view->assign("barcosGrosseira", $barGrosseira); 
        $this->view->assign("barcosJerere",    $barJerere);    
        $this->view->assign("barcosLinha",     $barLinha);     
        $this->view->assign("barcosLinhaFundo",$barLinhaFundo);
        $this->view->assign("barcosManzua",    $barManzua);    
        $this->view->assign("barcosMergulho",  $barMergulho);    
        $this->view->assign("barcosRatoeira",  $barRatoeira); 
        $this->view->assign("barcosSiripoia",  $barSiripoia);    
        $this->view->assign("barcosTarrafa",   $barTarrafa);     
        $this->view->assign("barcosVaraPesca", $barVaraPesca);
        
        $arrayBarcos =  array_merge_recursive(
                $barArrasto, 
                $barCalao, 
                $barColeta, 
                $barEmalhe, 
                $barGrosseira, 
                $barJerere, 
                $barLinha, 
                $barLinhaFundo,
                $barManzua,
                $barMergulho,
                $barRatoeira,
                $barSiripoia,
                $barTarrafa,
                $barVaraPesca);
        
        foreach($arrayBarcos as $key => $barco):
            $arrayCount[] = $barco['count'];
        endforeach;
        
        $jsCount = json_encode($arrayCount);


        $this->view->assign("arrayCount", $jsCount);
        ///BARCOS
       
        //PESCADORES
        $pescadorArrasto    = $this->modelArrasto   ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorCalao      = $this->modelCalao     ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorColeta     = $this->modelColeta    ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorEmalhe     = $this->modelEmalhe    ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorGrosseira  = $this->modelGrosseira ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorJerere     = $this->modelJerere    ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorLinha      = $this->modelLinha     ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorLinhaFundo = $this->modelLinhaFundo->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorManzua     = $this->modelManzua    ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorMergulho   = $this->modelMergulho  ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorRatoeira   = $this->modelRatoeira  ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorSiripoia   = $this->modelSiripoia  ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorTarrafa    = $this->modelTarrafa   ->selectPescadoresByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $pescadorVaraPesca  = $this->modelVaraPesca ->selectPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
        $pescArrasto =  $this->vazioCount($pescadorArrasto   ,  $porto);
        $pescCalao =    $this->vazioCount($pescadorCalao     , $porto);
        $pescColeta =   $this->vazioCount($pescadorColeta    , $porto);
        $pescEmalhe =   $this->vazioCount($pescadorEmalhe    , $porto);
        $pescGrosseira= $this->vazioCount($pescadorGrosseira , $porto);
        $pescJerere =   $this->vazioCount($pescadorJerere    , $porto);
        $pescLinha =    $this->vazioCount($pescadorLinha     , $porto);
        $pescLinhaFundo=$this->vazioCount($pescadorLinhaFundo, $porto);
        $pescManzua=    $this->vazioCount($pescadorManzua    , $porto);
        $pescMergulho=  $this->vazioCount($pescadorMergulho  , $porto);
        $pescRatoeira=  $this->vazioCount($pescadorRatoeira  , $porto);
        $pescSiripoia=  $this->vazioCount($pescadorSiripoia  , $porto);
        $pescTarrafa=   $this->vazioCount($pescadorTarrafa   , $porto);
        $pescVaraPesca =$this->vazioCount($pescadorVaraPesca ,  $porto);
        
        $this->view->assign("pescadoresArrasto",   $pescArrasto);   
        $this->view->assign("pescadoresCalao",     $pescCalao);     
        $this->view->assign("pescadoresColeta",    $pescColeta);    
        $this->view->assign("pescadoresEmalhe",    $pescEmalhe);    
        $this->view->assign("pescadoresGrosseira", $pescGrosseira); 
        $this->view->assign("pescadoresJerere",    $pescJerere);    
        $this->view->assign("pescadoresLinha",     $pescLinha);     
        $this->view->assign("pescadoresLinhaFundo",$pescLinhaFundo);
        $this->view->assign("pescadoresManzua",    $pescManzua);    
        $this->view->assign("pescadoresMergulho",  $pescMergulho);    
        $this->view->assign("pescadoresRatoeira",  $pescRatoeira); 
        $this->view->assign("pescadoresSiripoia",  $pescSiripoia);    
        $this->view->assign("pescadoresTarrafa",   $pescTarrafa);     
        $this->view->assign("pescadoresVaraPesca", $pescVaraPesca);
        
        $arrayPescadores =  array_merge_recursive(
                $pescArrasto, 
                $pescCalao, 
                $pescColeta, 
                $pescEmalhe, 
                $pescGrosseira, 
                $pescJerere, 
                $pescLinha, 
                $pescLinhaFundo,
                $pescManzua,
                $pescMergulho,
                $pescRatoeira,
                $pescSiripoia,
                $pescTarrafa,
                $pescVaraPesca);
        
        foreach($arrayPescadores as $key => $pescador):
            $arrayCountPescador[] = $pescador['count'];
        endforeach;
        
        $jsCountPescador = json_encode($arrayCountPescador);


        $this->view->assign("arrayCountPescador", $jsCountPescador);
        
    }
    public function aritaguaAction(){}
    public function baduAction(){}
    public function conchaAction(){}
    public function forteAction(){}
    public function jueranaAction(){}
    public function mamoaAction(){}
    public function pontalAction(){}
    public function prainhaAction(){}
    public function ramoAction(){}
    public function sambaitubaAction(){}
    public function saomiguelAction(){}
    public function serraAction(){}
    public function sobradinhoAction(){}
    public function terminalAction(){}
    public function tulhaAction(){}
    public function urucutucaAction(){}
            
	public function relatorioAction() {
            if($this->usuario['tp_id']==5){
            $this->_redirect('index');
        }
		$this->_helper->layout->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		$localModelPorto = new Application_Model_Porto();
		$localPorto = $localModelPorto->selectView(NULL, array('tuf_sigla', 'tmun_municipio', 'pto_nome'), NULL);

		require_once "../library/ModeloRelatorio.php";
		$modeloRelatorio = new ModeloRelatorio();
		$modeloRelatorio->setTitulo('Relatório de Portos');
		$modeloRelatorio->setLegenda(30, 'Código');
		$modeloRelatorio->setLegenda(80, 'UF');
		$modeloRelatorio->setLegenda(110, 'Município');
		$modeloRelatorio->setLegenda(220, 'Porto');
		$modeloRelatorio->setLegenda(400, 'Local');

		foreach ($localPorto as $key => $localData) {
			$modeloRelatorio->setValueAlinhadoDireita(30, 40, $localData['pto_id']);
			$modeloRelatorio->setValue(80, $localData['tuf_sigla']);
			$modeloRelatorio->setValue(110, $localData['tmun_municipio']);
			$modeloRelatorio->setValue(220, $localData['pto_nome']);
			$modeloRelatorio->setValue(400, $localData['pto_local']);
			$modeloRelatorio->setNewLine();
		}
		$modeloRelatorio->setNewLine();
		$pdf = $modeloRelatorio->getRelatorio();

		ob_end_clean();
		header('Content-Disposition: attachment;filename="rel_portos.pdf"');
		header("Content-type: application/x-pdf");
		echo $pdf->render();
   }
}

