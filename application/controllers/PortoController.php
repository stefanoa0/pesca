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
            $mes = date('m')-1;
            $ano = date('Y');
            $dia = date('d');
            while(!checkdate($mes, $dia, $ano)){
                $dia--;
            }
            $data = $ano.'-0'.$mes.'-'.$dia;
        }
        else{
            $data = explode('-', $data);
            $mes = $data[1];
            switch($mes){
                case '01': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '02': $data = $data[0].'-'.$data[1].'-'.'28'; break;
                case '03': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '04': $data = $data[0].'-'.$data[1].'-'.'30'; break;
                case '05': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '06': $data = $data[0].'-'.$data[1].'-'.'30'; break;
                case '07': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '08': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '09': $data = $data[0].'-'.$data[1].'-'.'30'; break;
                case '10': $data = $data[0].'-'.$data[1].'-'.'31'; break;
                case '11': $data = $data[0].'-'.$data[1].'-'.'30'; break;
                case '12': $data = $data[0].'-'.$data[1].'-'.'31'; break;
            }
        }
        return $data;
    }
    public function dataInicial($data){
        if($data == ''){
            $data = '2013-11-01';
        }
        else{
            $data = explode('-', $data);
            $data = $data[0].'-'.$data[1].'-01';
        }
        return $data;
    }
    public function vazioCount($array, $porto, $arte){
        if(empty($array)){
            $array = array( array(
                'pto_nome' => $porto,
                'count' => 0,
                )
            );
        }
        $array[0]['arte'] = $arte;
        return $array;
    }
    public function vazio($array, $porto, $arte){
        if(empty($array)){
            $array = array( array(
                'pto_nome' => $porto,
                'quant' => 0,
                'peso' => 0,
                )
            );
        }
        else if($array[0]['quant'] == ""){
            $array[0]['quant'] = 0;
        }
        else if($array[0]['peso'] == ""){
            $array[0]['peso'] = 0;
        }
        
        $array[0]['arte'] = $arte;
        return $array;
    }
//    public function vazioCpue($array){
//        if(empty($array)){
//            $array = array( array(
//                'pto_nome' => $porto,
//                'quant' => 0,
//                )
//            );
//        }
//        return $array;
//    }
    
    function removeDuplicate($in, $key1, $key2) {
        $out = array();

        foreach ($in as $elem) {
            if(array_key_exists($elem[$key1], $out)) {
                $out[$elem[$key1]][$key2] += $elem[$key2];
            } else {
                $out[$elem[$key1]] = array($key1 => $elem[$key1],$key2 => $elem[$key2]);
            }
        }

        return $out;
    }
    function array_sort($array, $on, $order=SORT_ASC){
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

    
    public function gerarrelatorio($porto, $datainicial, $datafinal){
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
        
        $arrayArtesPeso = array(
            "Arrasto de fundo",
            "Calão",
            "Emalhe", 
            "Groseira", 
            "Jereré", 
            "Linha", 
            "Linha de Fundo",
            "Manzuá",
            "Mergulho",
            "Tarrafa",
            "Vara de pesca");
        
        $arrayArtesQuant = array(
            "Coleta Manual",
            "Ratoeira",
            "Siripoia"
        );
        
        $arrayArtes = array(
            "Arrasto de fundo",
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
            "Vara de pesca"
        );
        $arrayCapturaPeso =  array_merge_recursive(
                $captArrasto, 
                $captCalao,
                $captEmalhe, 
                $captGrosseira, 
                $captJerere, 
                $captLinha, 
                $captLinhaFundo,
                $captManzua,
                $captMergulho,
                $captTarrafa,
                $captVaraPesca);
        
        $arrayCapturaQuant = array_merge_recursive(
        $captColeta, 
        $captRatoeira,
        $captSiripoia
                );
        foreach($arrayCapturaPeso as $key => $captura):
            $arrayPeso[] = $captura['peso'];
        endforeach;
        
        foreach($arrayCapturaQuant as $key => $captura):
            $arrayQuant[] = $captura['quant'];
        endforeach;
        
        $jsQuant = json_encode($arrayQuant);
        $jsPeso = json_encode($arrayPeso);
        $jsArtesPeso = json_encode($arrayArtesPeso);
        $jsArtesQuant = json_encode($arrayArtesQuant);
        $jsArtes = json_encode($arrayArtes);
        
        
        $this->view->assign("arrayArtesPeso", $jsArtesPeso);
        $this->view->assign("arrayArtesQuant", $jsArtesQuant);
        $this->view->assign("arrayQuant", $jsQuant);
        $this->view->assign("arrayPeso", $jsPeso);
        $this->view->assign("arrayArtes", $jsArtes);
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
        
        
        
        //Barcos que mais pescam
        $quantBarcosArrasto    = $this->modelArrasto   ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosCalao      = $this->modelCalao     ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosColeta     = $this->modelColeta    ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosEmalhe     = $this->modelEmalhe    ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosGrosseira  = $this->modelGrosseira ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosJerere     = $this->modelJerere    ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosLinha      = $this->modelLinha     ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosLinhaFundo = $this->modelLinhaFundo->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosManzua     = $this->modelManzua    ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosMergulho   = $this->modelMergulho  ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosRatoeira   = $this->modelRatoeira  ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosSiripoia   = $this->modelSiripoia  ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosTarrafa    = $this->modelTarrafa   ->selectQuantBarcosByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosVaraPesca  = $this->modelVaraPesca ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
        
        $arrayQuantBarcos =  array_merge_recursive(
                $quantBarcosArrasto, 
                $quantBarcosCalao, 
                $quantBarcosColeta, 
                $quantBarcosEmalhe, 
                $quantBarcosGrosseira, 
                $quantBarcosJerere, 
                $quantBarcosLinha, 
                $quantBarcosLinhaFundo,
                $quantBarcosManzua,
                $quantBarcosMergulho,
                $quantBarcosRatoeira,
                $quantBarcosSiripoia,
                $quantBarcosTarrafa,
                $quantBarcosVaraPesca);
        //arsort($arrayQuantBarcos);
        $arrayQuantBarcos = $this->removeDuplicate($arrayQuantBarcos, 'bar_nome', 'quant');
        
            /** Creio que até aqui já seja suficiente. Mas para gerar a mesma saída solicitada
            * as linhas abaixo se fazem necessárias */
        $arrayQuantBarcosOrdenado = $this->array_sort($arrayQuantBarcos, 'quant', SORT_DESC);
        //print_r($data);
        
        $j=0;
        foreach($arrayQuantBarcosOrdenado as $key => $quantBarcos):
            if($j==30){
                break;
            }
            $arrayNomesBarcos[] = $quantBarcos['bar_nome'];
            $arrayQuantidades[] = $quantBarcos['quant'];
            $j++;
        endforeach;
        //print_r($arrayNomesBarcos);
        //print_r($arrayQuantidades);
//        
        $jsLabelBarcos = json_encode($arrayNomesBarcos);
        $jsQuantBarcos = json_encode($arrayQuantidades);
//
//      
        $this->view->assign("arrayQuantBarcos", $arrayQuantBarcosOrdenado);
        $this->view->assign("labelBarcos", $jsLabelBarcos);
        $this->view->assign("quantBarcos", $jsQuantBarcos);
        
        //Pescadores que mais pescam
        $quantPescadoresArrasto    = $this->modelArrasto   ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresCalao      = $this->modelCalao     ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresColeta     = $this->modelColeta    ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresEmalhe     = $this->modelEmalhe    ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresGrosseira  = $this->modelGrosseira ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresJerere     = $this->modelJerere    ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresLinha      = $this->modelLinha     ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresLinhaFundo = $this->modelLinhaFundo->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresManzua     = $this->modelManzua    ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresMergulho   = $this->modelMergulho  ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresRatoeira   = $this->modelRatoeira  ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresSiripoia   = $this->modelSiripoia  ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresTarrafa    = $this->modelTarrafa   ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $quantPescadoresVaraPesca  = $this->modelVaraPesca ->selectQuantPescadoresByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
        
        $arrayQuantPescadores =  array_merge_recursive(
                $quantPescadoresArrasto, 
                $quantPescadoresCalao, 
                $quantPescadoresColeta, 
                $quantPescadoresEmalhe, 
                $quantPescadoresGrosseira, 
                $quantPescadoresJerere, 
                $quantPescadoresLinha, 
                $quantPescadoresLinhaFundo,
                $quantPescadoresManzua,
                $quantPescadoresMergulho,
                $quantPescadoresRatoeira,
                $quantPescadoresSiripoia,
                $quantPescadoresTarrafa,
                $quantPescadoresVaraPesca);
        //arsort($arrayQuantPescadores);
        $arrayQuantPescadores = $this->removeDuplicate($arrayQuantPescadores, 'tp_nome', 'count');
        
        //print_r($arrayQuantPescadores);
        $arrayQuantPescadoresOrdenado = $this->array_sort($arrayQuantPescadores, 'count', SORT_DESC);
        //print_r($arrayQuantPescadoresOrdenado);
        $i=0;
        foreach($arrayQuantPescadoresOrdenado as $key => $quantPescadores):
            if($i==30){
                break;
            }
            $arrayNomesPescadores[] = $quantPescadores['tp_nome'];
            $arrayQuantidadesPesc[] = $quantPescadores['count'];
            $i++;   
        endforeach;
        //print_r($arrayNomesPescadores);
        //print_r($arrayQuantidades);
//        
        $jsLabelPescadores = json_encode($arrayNomesPescadores);
        $jsQuantPescadores = json_encode($arrayQuantidadesPesc);
//
        $this->view->assign("arrayQuantPescadores", $arrayQuantPescadoresOrdenado);
        $this->view->assign("labelPescadores", $jsLabelPescadores);
        $this->view->assign("quantPescadores", $jsQuantPescadores);
        
        
        //Espécies mais capturadas
        $quantCapturaArrasto    = $this->modelArrasto   ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaCalao      = $this->modelCalao     ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaColeta     = $this->modelColeta    ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaEmalhe     = $this->modelEmalhe    ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaGrosseira  = $this->modelGrosseira ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaJerere     = $this->modelJerere    ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaLinha      = $this->modelLinha     ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaLinhaFundo = $this->modelLinhaFundo->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaManzua     = $this->modelManzua    ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaMergulho   = $this->modelMergulho  ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaRatoeira   = $this->modelRatoeira  ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaSiripoia   = $this->modelSiripoia  ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaTarrafa    = $this->modelTarrafa   ->selectQuantCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $quantCapturaVaraPesca  = $this->modelVaraPesca ->selectQuantCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
        
        $arrayQuantCaptura =  array_merge_recursive(
                $quantCapturaArrasto, 
                $quantCapturaCalao, 
                $quantCapturaColeta, 
                $quantCapturaEmalhe, 
                $quantCapturaGrosseira, 
                $quantCapturaJerere, 
                $quantCapturaLinha, 
                $quantCapturaLinhaFundo,
                $quantCapturaManzua,
                $quantCapturaMergulho,
                $quantCapturaRatoeira,
                $quantCapturaSiripoia,
                $quantCapturaTarrafa,
                $quantCapturaVaraPesca);
        //arsort($arrayQuantCaptura);
        $arrayQuantCaptura = $this->removeDuplicate($arrayQuantCaptura, 'esp_nome_comum', 'quant');
        
        //print_r($arrayQuantCaptura);
        $arrayQuantCapturaOrdenado = $this->array_sort($arrayQuantCaptura, 'quant', SORT_ASC);
        //print_r($arrayQuantCapturaOrdenado);
        $i=0;
        foreach($arrayQuantCapturaOrdenado as $key => $quantCaptura):
            if($i==30){
                break;
            }
            $arrayNomesCaptura[] = $quantCaptura['esp_nome_comum'];
            $arrayQuantidadesPesc[] = $quantCaptura['quant'];
            $i++;   
        endforeach;
        //print_r($arrayNomesCaptura);
        //print_r($arrayQuantidades);
//        
        $jsLabelCaptura = json_encode($arrayNomesCaptura);
        $jsQuantCaptura = json_encode($arrayQuantidadesPesc);
//
        $this->view->assign("arrayQuantCaptura", $arrayQuantCapturaOrdenado);
        $this->view->assign("labelCaptura", $jsLabelCaptura);
        $this->view->assign("quantCaptura", $jsQuantCaptura);
        

        
    }
    public function gerarquantcaptura($porto, $ano, $arte){
        
        if($arte == 'Arrasto'){
            $quantCaptJaneiro   = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelArrasto->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Calao'){
            $quantCaptJaneiro   = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelCalao->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Coleta'){
            $quantCaptJaneiro   = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelColeta->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Emalhe'){
            $quantCaptJaneiro   = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelEmalhe->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Grosseira'){
            $quantCaptJaneiro   = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelGrosseira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Linha'){
            $quantCaptJaneiro   = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelLinha->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'LinhaFundo'){
            $quantCaptJaneiro   = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Jerere'){
            $quantCaptJaneiro   = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelJerere->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Manzua'){
            $quantCaptJaneiro   = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelManzua->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Mergulho'){
            $quantCaptJaneiro   = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelMergulho->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Ratoeira'){
            $quantCaptJaneiro   = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelRatoeira->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Tarrafa'){
            $quantCaptJaneiro   = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelTarrafa->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Siripoia'){
            $quantCaptJaneiro   = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelSiripoia->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'VaraPesca'){
            $quantCaptJaneiro   = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptFevereiro = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMarco     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAbril     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptMaio      = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJunho     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptJulho     = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptAgosto    = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptSetembro  = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptOutubro   = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptNovembro  = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantCaptDezembro  = $this->modelVaraPesca->selectCapturaByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }

//        print_r($quantArrastoJaneiro);
        
        foreach($quantCaptJaneiro as $quant):
            $pesoJaneiro[] = $quant['peso'];
            $quantJaneiro[] = $quant['peso'];
        endforeach;
        foreach($quantCaptFevereiro as $quant):
            $pesoFevereiro[] = $quant['peso'];
            $quantFevereiro[] = $quant['peso'];
        endforeach;
        foreach($quantCaptMarco as $quant):
            $pesoMarco[] = $quant['peso'];
            $quantMarco[] = $quant['peso'];
        endforeach;
        foreach($quantCaptAbril as $quant):
            $pesoAbril[] = $quant['peso'];
            $quantAbril[] = $quant['peso'];
        endforeach;
        foreach($quantCaptMaio as $quant):
            $pesoMaio[] = $quant['peso'];
            $quantMaio[] = $quant['peso'];
        endforeach;
        foreach($quantCaptJunho as $quant):
            $pesoJunho[] = $quant['peso'];
            $quantJunho[] = $quant['peso'];
        endforeach;
        foreach($quantCaptJulho as $quant):
            $pesoJulho[] = $quant['peso'];
            $quantJulho[] = $quant['peso'];
        endforeach;
        foreach($quantCaptAgosto as $quant):
            $pesoAgosto[] = $quant['peso'];
            $quantAgosto[] = $quant['peso'];
        endforeach;
        foreach($quantCaptSetembro as $quant):
            $pesoSetembro[] = $quant['peso'];
            $quantSetembro[] = $quant['peso'];
        endforeach;
        foreach($quantCaptOutubro as $quant):
            $pesoOutubro[] = $quant['peso'];
            $quantOutubro[] = $quant['peso'];
        endforeach;
        foreach($quantCaptNovembro as $quant):
            $pesoNovembro[] = $quant['peso'];
            $quantNovembro[] = $quant['peso'];
        endforeach;
        foreach($quantCaptDezembro as $quant):
            $pesoDezembro[] = $quant['peso'];
            $quantDezembro[] = $quant['peso'];
        endforeach;
        
        $labels = array('jan/'.$ano, 'fev/'.$ano, 'mar/'.$ano, 'abr/'.$ano, 'mai/'.$ano, 'jun/'.$ano, 'jul/'.$ano, 'ago/'.$ano, 'set/'.$ano, 'out/'.$ano, 'nov/'.$ano, 'dez/'.$ano);
        
        $jsLabels        = json_encode($labels);
        $jsquantCaptJaneiro   = json_encode($quantJaneiro);
        $jsquantCaptFevereiro = json_encode($quantFevereiro);
        $jsquantCaptMarco     = json_encode($quantMarco);
        $jsquantCaptAbril     = json_encode($quantAbril);
        $jsquantCaptMaio      = json_encode($quantMaio);
        $jsquantCaptJunho     = json_encode($quantJunho);
        $jsquantCaptJulho     = json_encode($quantJulho);
        $jsquantCaptAgosto    = json_encode($quantAgosto);
        $jsquantCaptSetembro  = json_encode($quantSetembro);
        $jsquantCaptOutubro   = json_encode($quantOutubro);
        $jsquantCaptNovembro  = json_encode($quantNovembro);
        $jsquantCaptDezembro  = json_encode($quantDezembro);
        
        $jspesoCaptJaneiro   = json_encode($pesoJaneiro);
        $jspesoCaptFevereiro = json_encode($pesoFevereiro);
        $jspesoCaptMarco     = json_encode($pesoMarco);
        $jspesoCaptAbril     = json_encode($pesoAbril);
        $jspesoCaptMaio      = json_encode($pesoMaio);
        $jspesoCaptJunho     = json_encode($pesoJunho);
        $jspesoCaptJulho     = json_encode($pesoJulho);
        $jspesoCaptAgosto    = json_encode($pesoAgosto);
        $jspesoCaptSetembro  = json_encode($pesoSetembro);
        $jspesoCaptOutubro   = json_encode($pesoOutubro);
        $jspesoCaptNovembro  = json_encode($pesoNovembro);
        $jspesoCaptDezembro  = json_encode($pesoDezembro);
        
        $this->view->assign("quantLabels",    $jsLabels);
        $this->view->assign("quantJaneiro",   $jsquantCaptJaneiro); 
        $this->view->assign("quantFevereiro", $jsquantCaptFevereiro);
        $this->view->assign("quantMarco",     $jsquantCaptMarco);
        $this->view->assign("quantAbril",     $jsquantCaptAbril); 
        $this->view->assign("quantMaio",      $jsquantCaptMaio); 
        $this->view->assign("quantJunho",     $jsquantCaptJunho);  
        $this->view->assign("quantJulho",     $jsquantCaptJulho); 
        $this->view->assign("quantAgosto",    $jsquantCaptAgosto); 
        $this->view->assign("quantSetembro",  $jsquantCaptSetembro);
        $this->view->assign("quantOutubro",   $jsquantCaptOutubro);
        $this->view->assign("quantNovembro",  $jsquantCaptNovembro);
        $this->view->assign("quantDezembro",  $jsquantCaptDezembro);
        
        $this->view->assign("pesoJaneiro",   $jspesoCaptJaneiro); 
        $this->view->assign("pesoFevereiro", $jspesoCaptFevereiro);
        $this->view->assign("pesoMarco",     $jspesoCaptMarco);
        $this->view->assign("pesoAbril",     $jspesoCaptAbril); 
        $this->view->assign("pesoMaio",      $jspesoCaptMaio); 
        $this->view->assign("pesoJunho",     $jspesoCaptJunho);  
        $this->view->assign("pesoJulho",     $jspesoCaptJulho); 
        $this->view->assign("pesoAgosto",    $jspesoCaptAgosto); 
        $this->view->assign("pesoSetembro",  $jspesoCaptSetembro);
        $this->view->assign("pesoOutubro",   $jspesoCaptOutubro);
        $this->view->assign("pesoNovembro",  $jspesoCaptNovembro);
        $this->view->assign("pesoDezembro",  $jspesoCaptDezembro);
        
        //print_r($jsquantCaptNovembro);
    }
    public function gerarquantentrevistas($porto, $ano, $arte){
        
        if($arte == 'Arrasto'){
            $quantEntrJaneiro   = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelArrasto->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Calao'){
            $quantEntrJaneiro   = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelCalao->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Coleta'){
            $quantEntrJaneiro   = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelColeta->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Emalhe'){
            $quantEntrJaneiro   = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelEmalhe->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Grosseira'){
            $quantEntrJaneiro   = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelGrosseira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Linha'){
            $quantEntrJaneiro   = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelLinha->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'LinhaFundo'){
            $quantEntrJaneiro   = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelLinhaFundo->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Jerere'){
            $quantEntrJaneiro   = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelJerere->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Manzua'){
            $quantEntrJaneiro   = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelManzua->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Mergulho'){
            $quantEntrJaneiro   = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelMergulho->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Ratoeira'){
            $quantEntrJaneiro   = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelRatoeira->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Tarrafa'){
            $quantEntrJaneiro   = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelTarrafa->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'Siripoia'){
            $quantEntrJaneiro   = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelSiripoia->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        if($arte == 'VaraPesca'){
            $quantEntrJaneiro   = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrFevereiro = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMarco     = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAbril     = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrMaio      = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJunho     = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrJulho     = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrAgosto    = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrSetembro  = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrOutubro   = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrNovembro  = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $quantEntrDezembro  = $this->modelVaraPesca->selectCountEntrevistasByPorto("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }

//        print_r($quantArrastoJaneiro);
        
        foreach($quantEntrJaneiro as $quant):
            $quantJaneiro[] = $quant['count'];
        endforeach;
        foreach($quantEntrFevereiro as $quant):
            $quantFevereiro[] = $quant['count'];
        endforeach;
        foreach($quantEntrMarco as $quant):
            $quantMarco[] = $quant['count'];
        endforeach;
        foreach($quantEntrAbril as $quant):
            $quantAbril[] = $quant['count'];
        endforeach;
        foreach($quantEntrMaio as $quant):
            $quantMaio[] = $quant['count'];
        endforeach;
        foreach($quantEntrJunho as $quant):
            $quantJunho[] = $quant['count'];
        endforeach;
        foreach($quantEntrJulho as $quant):
            $quantJulho[] = $quant['count'];
        endforeach;
        foreach($quantEntrAgosto as $quant):
            $quantAgosto[] = $quant['count'];
        endforeach;
        foreach($quantEntrSetembro as $quant):
            $quantSetembro[] = $quant['count'];
        endforeach;
        foreach($quantEntrOutubro as $quant):
            $quantOutubro[] = $quant['count'];
        endforeach;
        foreach($quantEntrNovembro as $quant):
            $quantNovembro[] = $quant['count'];
        endforeach;
        foreach($quantEntrDezembro as $quant):
            $quantDezembro[] = $quant['count'];
        endforeach;
        
        $labels = array('jan/'.$ano, 'fev/'.$ano, 'mar/'.$ano, 'abr/'.$ano, 'mai/'.$ano, 'jun/'.$ano, 'jul/'.$ano, 'ago/'.$ano, 'set/'.$ano, 'out/'.$ano, 'nov/'.$ano, 'dez/'.$ano);
        
        $jsLabels        = json_encode($labels);
        $jsQuantJaneiro   = json_encode($quantJaneiro);
        $jsQuantFevereiro = json_encode($quantFevereiro);
        $jsQuantMarco     = json_encode($quantMarco);
        $jsQuantAbril     = json_encode($quantAbril);
        $jsQuantMaio      = json_encode($quantMaio);
        $jsQuantJunho     = json_encode($quantJunho);
        $jsQuantJulho     = json_encode($quantJulho);
        $jsQuantAgosto    = json_encode($quantAgosto);
        $jsQuantSetembro  = json_encode($quantSetembro);
        $jsQuantOutubro   = json_encode($quantOutubro);
        $jsQuantNovembro  = json_encode($quantNovembro);
        $jsQuantDezembro  = json_encode($quantDezembro);
        
        $this->view->assign("quantLabels",    $jsLabels);
        $this->view->assign("quantJaneiro",   $jsQuantJaneiro);
        $this->view->assign("quantFevereiro", $jsQuantFevereiro);
        $this->view->assign("quantMarco",     $jsQuantMarco);
        $this->view->assign("quantAbril",     $jsQuantAbril);
        $this->view->assign("quantMaio",      $jsQuantMaio);
        $this->view->assign("quantJunho",     $jsQuantJunho);
        $this->view->assign("quantJulho",     $jsQuantJulho);
        $this->view->assign("quantAgosto",    $jsQuantAgosto);
        $this->view->assign("quantSetembro",  $jsQuantSetembro);
        $this->view->assign("quantOutubro",   $jsQuantOutubro);
        $this->view->assign("quantNovembro",  $jsQuantNovembro);
        $this->view->assign("quantDezembro",  $jsQuantDezembro);
        
        //print_r($jsQuantNovembro);
    }
    public function gerarcpue($porto, $ano, $arte){
        
        if($arte == 'Arrasto'){
            $cpueEntrJaneiro   = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Calao'){
            $cpueEntrJaneiro   = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelCalao->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Coleta'){
            $cpueEntrJaneiro   = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelColeta->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Emalhe'){
            $cpueEntrJaneiro   = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelEmalhe->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Grosseira'){
            $cpueEntrJaneiro   = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelGrosseira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Linha'){
            $cpueEntrJaneiro   = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelLinha->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'LinhaFundo'){
            $cpueEntrJaneiro   = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelLinhaFundo->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Jerere'){
            $cpueEntrJaneiro   = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelJerere->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Manzua'){
            $cpueEntrJaneiro   = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelManzua->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Mergulho'){
            $cpueEntrJaneiro   = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelMergulho->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Ratoeira'){
            $cpueEntrJaneiro   = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelRatoeira->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Tarrafa'){
            $cpueEntrJaneiro   = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelTarrafa->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM tar_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'Siripoia'){
            $cpueEntrJaneiro   = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelSiripoia->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }
        else if($arte == 'VaraPesca'){
            $cpueEntrJaneiro   = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  1  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrFevereiro = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  2  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMarco     = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  3  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAbril     = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  4  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrMaio      = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  5  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJunho     = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  6  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrJulho     = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  7  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrAgosto    = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  8  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrSetembro  = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  9  And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrOutubro   = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  10 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrNovembro  = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  11 And Extract(YEAR FROM fd_data) = ".$ano);
            $cpueEntrDezembro  = $this->modelVaraPesca->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) =  12 And Extract(YEAR FROM fd_data) = ".$ano);
        }

//        print_r($cpueArrastoJaneiro);
        
        foreach($cpueEntrJaneiro as $cpue):
            $cpueJaneiro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrFevereiro as $cpue):
            $cpueFevereiro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrMarco as $cpue):
            $cpueMarco[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrAbril as $cpue):
            $cpueAbril[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrMaio as $cpue):
            $cpueMaio[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrJunho as $cpue):
            $cpueJunho[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrJulho as $cpue):
            $cpueJulho[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrAgosto as $cpue):
            $cpueAgosto[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrSetembro as $cpue):
            $cpueSetembro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrOutubro as $cpue):
            $cpueOutubro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrNovembro as $cpue):
            $cpueNovembro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueEntrDezembro as $cpue):
            $cpueDezembro[] = $cpue['cpue'];
        endforeach;
        
        $labels = array('jan/'.$ano, 'fev/'.$ano, 'mar/'.$ano, 'abr/'.$ano, 'mai/'.$ano, 'jun/'.$ano, 'jul/'.$ano, 'ago/'.$ano, 'set/'.$ano, 'out/'.$ano, 'nov/'.$ano, 'dez/'.$ano);
        
        $jsLabels        = json_encode($labels);
        $jsCpueJaneiro   = json_encode($cpueJaneiro);
        $jsCpueFevereiro = json_encode($cpueFevereiro);
        $jsCpueMarco     = json_encode($cpueMarco);
        $jsCpueAbril     = json_encode($cpueAbril);
        $jsCpueMaio      = json_encode($cpueMaio);
        $jsCpueJunho     = json_encode($cpueJunho);
        $jsCpueJulho     = json_encode($cpueJulho);
        $jsCpueAgosto    = json_encode($cpueAgosto);
        $jsCpueSetembro  = json_encode($cpueSetembro);
        $jsCpueOutubro   = json_encode($cpueOutubro);
        $jsCpueNovembro  = json_encode($cpueNovembro);
        $jsCpueDezembro  = json_encode($cpueDezembro);
        
        $this->view->assign("cpueLabels", $jsLabels);
        $this->view->assign("cpueJaneiro",   $jsCpueJaneiro);
        $this->view->assign("cpueFevereiro", $jsCpueFevereiro);
        $this->view->assign("cpueMarco",     $jsCpueMarco);
        $this->view->assign("cpueAbril",     $jsCpueAbril);
        $this->view->assign("cpueMaio",      $jsCpueMaio);
        $this->view->assign("cpueJunho",     $jsCpueJunho);
        $this->view->assign("cpueJulho",     $jsCpueJulho);
        $this->view->assign("cpueAgosto",    $jsCpueAgosto);
        $this->view->assign("cpueSetembro",  $jsCpueSetembro);
        $this->view->assign("cpueOutubro",   $jsCpueOutubro);
        $this->view->assign("cpueNovembro",  $jsCpueNovembro);
        $this->view->assign("cpueDezembro",  $jsCpueDezembro);
        
        //print_r($jsCpueNovembro);
    }
    public function geraqtdporarte($porto, $ano){
        $quantidadeArrasto    = $this->modelArrasto   ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeCalao      = $this->modelCalao     ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeColeta     = $this->modelColeta    ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeEmalhe     = $this->modelEmalhe    ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeGrosseira  = $this->modelGrosseira ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeJerere     = $this->modelJerere    ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeLinha      = $this->modelLinha     ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeLinhaFundo = $this->modelLinhaFundo->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeManzua     = $this->modelManzua    ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeMergulho   = $this->modelMergulho  ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeRatoeira   = $this->modelRatoeira  ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeSiripoia   = $this->modelSiripoia  ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        $quantidadeTarrafa    = $this->modelTarrafa   ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM tar_data) = ".$ano);
        $quantidadeVaraPesca  = $this->modelVaraPesca ->selectEntrevistasByPorto("pto_nome='".$porto."' and Extract(YEAR FROM fd_data) = ".$ano);
        
        $qtdArrasto =  $this->vazioCount($quantidadeArrasto   , $porto, 'Arrasto de Fundo');
        $qtdCalao =    $this->vazioCount($quantidadeCalao     , $porto, 'Calão');
        $qtdColeta =   $this->vazioCount($quantidadeColeta    , $porto, 'Coleta');
        $qtdEmalhe =   $this->vazioCount($quantidadeEmalhe    , $porto, 'Emalhe');
        $qtdGrosseira= $this->vazioCount($quantidadeGrosseira , $porto, 'Grosseira');
        $qtdJerere =   $this->vazioCount($quantidadeJerere    , $porto, 'Jereré');
        $qtdLinha =    $this->vazioCount($quantidadeLinha     , $porto, 'Pesca de Linha');
        $qtdLinhaFundo=$this->vazioCount($quantidadeLinhaFundo, $porto, 'Linha de Fundo');
        $qtdManzua=    $this->vazioCount($quantidadeManzua    , $porto, 'Manzuá');
        $qtdMergulho=  $this->vazioCount($quantidadeMergulho  , $porto, 'Mergulho');
        $qtdRatoeira=  $this->vazioCount($quantidadeRatoeira  , $porto, 'Ratoeira');
        $qtdSiripoia=  $this->vazioCount($quantidadeSiripoia  , $porto, 'Siripoia');
        $qtdTarrafa=   $this->vazioCount($quantidadeTarrafa   , $porto, 'Tarrafa');
        $qtdVaraPesca =$this->vazioCount($quantidadeVaraPesca , $porto, 'Vara de Pesca');
        /*
        $this->view->assign("qtdArrasto",   $qtdArrasto);   
        $this->view->assign("qtdCalao",     $qtdCalao);     
        $this->view->assign("qtdColeta",    $qtdColeta);    
        $this->view->assign("qtdEmalhe",    $qtdEmalhe);    
        $this->view->assign("qtdGrosseira", $qtdGrosseira); 
        $this->view->assign("qtdJerere",    $qtdJerere);    
        $this->view->assign("qtdLinha",     $qtdLinha);     
        $this->view->assign("qtdLinhaFundo",$qtdLinhaFundo);
        $this->view->assign("qtdManzua",    $qtdManzua);    
        $this->view->assign("qtdMergulho",  $qtdMergulho);    
        $this->view->assign("qtdRatoeira",  $qtdRatoeira); 
        $this->view->assign("qtdSiripoia",  $qtdSiripoia);    
        $this->view->assign("qtdTarrafa",   $qtdTarrafa);     
        $this->view->assign("qtdVaraPesca", $qtdVaraPesca);
        */
        $arrayQuantidades =  array_merge_recursive(
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
        
        $arrayQtds = $this->array_sort($arrayQuantidades,'count', SORT_DESC);
        $i=0;
        foreach($arrayQtds as $qtd):
            if($i++ < 5){
                $arrayTopFive[] = $qtd['count'];
                $labels[] = $qtd['arte'];
            }
        endforeach;
        
        $jsTopFive = json_encode($arrayTopFive);
        $jsLabels = json_encode($labels);

        $this->view->assign("arrayPorArteQtds", $jsTopFive);
        $this->view->assign("arrayPorArteLabels", $jsLabels);
        
        print_r($jsTopFive);
        print_r($jsLabels);
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
        
        //CAPTURA POR ARTE
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        
        ////REPLICAR para todos os portos a baixo os itens:
        //Captura por porto (já feito o select, apenas passar para a view)
        //Entrevistas por Porto (já está no model de cada arte de pesca)
        //Embarcações mais monitoradas
        //Espécies mais capturadas
        //Depois eu vejo os gráficos disso.
        
        $captCalao= $this->vazio($capturaCalao, $porto, 'Calão');
        $captEmalhe= $this->vazio($capturaEmalhe, $porto, 'Emalhe');
        $captGrosseira= $this->vazio($capturaGrosseira, $porto, 'Espinhel/Groseira');
        $captLinha= $this->vazio($capturaLinha, $porto, 'Linha');
        $captManzua= $this->vazio($capturaManzua, $porto, 'Manzuá');
        $captMergulho= $this->vazio($capturaMergulho, $porto, 'Mergulho');
        $captTarrafa= $this->vazio($capturaTarrafa, $porto, 'Tarrafa');
        
        $this->view->assign("capturaCalao",      $captCalao);
        $this->view->assign("capturaEmalhe",     $captEmalhe);
        $this->view->assign("capturaGrosseira",  $captGrosseira);
        $this->view->assign("capturaLinha",      $captLinha);
        $this->view->assign("capturaManzua",     $captManzua);
        $this->view->assign("capturaMergulho",   $captMergulho);
        $this->view->assign("capturaTarrafa",    $captTarrafa);
        

        $arrayCapturaPeso =  array_merge_recursive( 
                $captCalao,
                $captEmalhe, 
                $captGrosseira, 
                $captLinha, 
                $captManzua,
                $captMergulho,
                $captTarrafa);
//        print_r($arrayCapturaPeso);
//        print_r('<br/>');
        $arrayCaptPeso = $this->array_sort($arrayCapturaPeso, 'peso', SORT_DESC);
        //print_r($arrayCaptPeso);
        foreach($arrayCaptPeso as $key => $captura):
            $arrayPeso[] = $captura['peso'];
            $arrayArtes[] = $captura['arte'];
        endforeach;
        
        
        $jsPeso = json_encode($arrayPeso);
        $jsArtes = json_encode($arrayArtes);
        
        $this->view->assign("arrayPeso", $jsPeso);
        $this->view->assign("arrayArtes", $jsArtes);
        
        //print_r($jsPeso);
        //print_r($jsArtes);
        
        //Quantidade de Fichas Por arte
        $entrevistaCalao      = $this->modelCalao     ->selectCountEntrevistasByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $entrevistaEmalhe     = $this->modelEmalhe    ->selectCountEntrevistasByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $entrevistaGrosseira  = $this->modelGrosseira ->selectCountEntrevistasByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $entrevistaLinha      = $this->modelLinha     ->selectCountEntrevistasByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $entrevistaManzua     = $this->modelManzua    ->selectCountEntrevistasByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $entrevistaMergulho   = $this->modelMergulho  ->selectCountEntrevistasByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $entrevistaTarrafa    = $this->modelTarrafa   ->selectCountEntrevistasByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
    
	
	$entrCalao= $this->vazioCount($entrevistaCalao, $porto, 'Calão');
        $entrEmalhe= $this->vazioCount($entrevistaEmalhe, $porto, 'Emalhe');
        $entrGrosseira= $this->vazioCount($entrevistaGrosseira, $porto, 'Espinhel/Groseira');
        $entrLinha= $this->vazioCount($entrevistaLinha, $porto, 'Linha');
        $entrManzua= $this->vazioCount($entrevistaManzua, $porto, 'Manzuá');
        $entrMergulho= $this->vazioCount($entrevistaMergulho, $porto, 'Mergulho');
        $entrTarrafa= $this->vazioCount($entrevistaTarrafa, $porto, 'Tarrafa');
        
        $this->view->assign("entrevistaCalao",      $entrCalao);
        $this->view->assign("entrevistaEmalhe",     $entrEmalhe);
        $this->view->assign("entrevistaGrosseira",  $entrGrosseira);
        $this->view->assign("entrevistaLinha",      $entrLinha);
        $this->view->assign("entrevistaManzua",     $entrManzua);
        $this->view->assign("entrevistaMergulho",   $entrMergulho);
        $this->view->assign("entrevistaTarrafa",    $entrTarrafa);
		
        $arrayEntrevistas =  array_merge_recursive( 
                    $entrCalao,
                    $entrEmalhe, 
                    $entrGrosseira, 
                    $entrLinha, 
                    $entrManzua,
                    $entrMergulho,
                    $entrTarrafa);
				
	$arrayEntrevistasOrdenado = $this->array_sort($arrayEntrevistas, 'count', SORT_DESC);
        
        foreach($arrayEntrevistasOrdenado as $key => $entrevista):
            $arrayEntr[] = $entrevista['count'];
            $arrayArtesEntr[] = $entrevista['arte'];
        endforeach;
        
//        print_r($arrayEntr);
//        print_r($arrayArtesEntr);
        
        $jsEntrevistas = json_encode($arrayEntr);
        $jsArtesEntr = json_encode($arrayArtesEntr);
        
        $this->view->assign("arrayEntrevistas", $jsEntrevistas);
        $this->view->assign("arrayArtesEntr", $jsArtesEntr);
        
        //Barcos que mais pescam
        $quantBarcosCalao      = $this->modelCalao     ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosEmalhe     = $this->modelEmalhe    ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosGrosseira  = $this->modelGrosseira ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosLinha      = $this->modelLinha     ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosManzua     = $this->modelManzua    ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosMergulho   = $this->modelMergulho  ->selectQuantBarcosByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $quantBarcosTarrafa    = $this->modelTarrafa   ->selectQuantBarcosByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        
        
        $arrayQuantBarcos =  array_merge_recursive(
                $quantBarcosCalao, 
                $quantBarcosEmalhe, 
                $quantBarcosGrosseira, 
                $quantBarcosLinha, 
                $quantBarcosManzua,
                $quantBarcosMergulho,
                $quantBarcosTarrafa
                );
        //arsort($arrayQuantBarcos);
        $arrayQuantBarcos = $this->removeDuplicate($arrayQuantBarcos, 'bar_nome', 'quant');
        
            /** Creio que até aqui já seja suficiente. Mas para gerar a mesma saída solicitada
            * as linhas abaixo se fazem necessárias */
        $arrayQuantBarcosOrdenado = $this->array_sort($arrayQuantBarcos, 'quant', SORT_DESC);
        //print_r($data);
        
        $j=0;
        foreach($arrayQuantBarcosOrdenado as $key => $quantBarcos):
            if($j==30){
                break;
            }
            $arrayNomesBarcos[] = $quantBarcos['bar_nome'];
            $arrayQuantidades[] = $quantBarcos['quant'];
            $j++;
        endforeach;
        //print_r($arrayNomesBarcos);
        //print_r($arrayQuantidades);
//        
        $jsLabelBarcos = json_encode($arrayNomesBarcos);
        $jsQuantBarcos = json_encode($arrayQuantidades);
//
//      
        $this->view->assign("arrayQuantBarcos", $arrayQuantBarcosOrdenado);
        $this->view->assign("labelBarcos", $jsLabelBarcos);
        $this->view->assign("quantBarcos", $jsQuantBarcos);
        
        $this->gerarcpue($porto);
    }
    public function aritaguaAction(){
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
        
        $porto = "Aritaguá";
        
        $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaJerere     = $this->modelJerere    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function baduAction(){
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
        
        $porto = "Vila Badú";
        
        $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaJerere     = $this->modelJerere    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function barraAction(){
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
        
        $porto = "Porto da Barra";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function conchaAction(){
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
        
        $porto = "Porto da Concha";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function forteAction(){
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
        
        $porto = "Porto do Forte";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function jueranaAction(){
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
        
        $porto = "Juerana rio";
        
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinhaFundo = $this->modelLinhaFundo->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function mamoaAction(){
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
        
        $porto = "Mamoã";
        
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function pontalAction(){
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
        
        $porto = "Pontal";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function prainhaAction(){
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
        
        $porto = "Prainha";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function ramoAction(){
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
        
        $porto = "Ponta do Ramo";
        
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function sambaitubaAction(){
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
        
        $porto = "Sambaituba";
        
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaJerere     = $this->modelJerere    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function saomiguelAction(){
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
        
        $porto = "São Miguel";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function serraAction(){
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
        
        $porto = "Pé de Serra";
        
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
       $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function sobradinhoAction(){
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
        
        $porto = "Sobradinho";
        
       $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
       $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
       $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
       
    }
    public function terminalAction(){
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
        
        $porto = "Terminal Pesqueiro";
        
        $capturaArrasto    = $this->modelArrasto   ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
        $a = $this->gerarquantcaptura('Terminal Pesqueiro', 2014, 'Arrasto');
        
        print_r($a);
        
        $this->geraqtdporarte($porto, '2014');
    }
    public function tulhaAction(){
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
        
        $porto = "Ponta da Tulha";
        
        $capturaCalao      = $this->modelCalao     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaColeta     = $this->modelColeta    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaGrosseira  = $this->modelGrosseira ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaLinha      = $this->modelLinha     ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaMergulho   = $this->modelMergulho  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaRatoeira   = $this->modelRatoeira  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        
    }
    public function urucutucaAction(){
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
        
        $porto = "Urucutuca";
        
        $capturaEmalhe     = $this->modelEmalhe    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaJerere     = $this->modelJerere    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaManzua     = $this->modelManzua    ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaSiripoia   = $this->modelSiripoia  ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        $capturaTarrafa    = $this->modelTarrafa   ->selectCapturaByPorto("pto_nome='".$porto."' And tar_data between '".$datainicial."' and '".$datafinal."'");
        $capturaVaraPesca  = $this->modelVaraPesca ->selectCapturaByPorto("pto_nome='".$porto."' And fd_data between '".$datainicial."' and '".$datafinal."'");
        
    }
            
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

