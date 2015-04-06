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
//    public function vazioQuant($array, $porto, $barco){
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
        
        //print_r($arrayQuantCapturaOrdenado);
        
//        $cpueArrastoJaneiro   = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 1   And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoFevereiro = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 2 And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoMarco     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 3     And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoAbril     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 4     And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoMaio      = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 5      And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoJunho     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 6     And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoJulho     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 7     And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoAgosto    = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 8    And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoSetembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 9  And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoOutubro   = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 10  And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoNovembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 11 And Extract(YEAR FROM fd_data) = 2014");
//        $cpueArrastoDezembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 12 And Extract(YEAR FROM fd_data) = 2014");
//        
////        print_r($cpueArrastoJaneiro);
//        
//        foreach($cpueArrastoJaneiro as $cpue):
//            $cpueJaneiro[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoFevereiro as $cpue):
//            $cpueFevereiro[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoMarco as $cpue):
//            $cpueMarco[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoAbril as $cpue):
//            $cpueAbril[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoMaio as $cpue):
//            $cpueMaio[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoJunho as $cpue):
//            $cpueJunho[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoJulho as $cpue):
//            $cpueJulho[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoAgosto as $cpue):
//            $cpueAgosto[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoSetembro as $cpue):
//            $cpueSetembro[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoOutubro as $cpue):
//            $cpueOutubro[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoNovembro as $cpue):
//            $cpueNovembro[] = $cpue['cpue'];
//        endforeach;
//        foreach($cpueArrastoDezembro as $cpue):
//            $cpueDezembro[] = $cpue['cpue'];
//        endforeach;
//        
//        $jsCpueJaneiro = json_encode($cpueJaneiro);
//        $jsCpueFevereiro = json_encode($cpueFevereiro);
//        $jsCpueMarco     = json_encode($cpueMarco);
//        $jsCpueAbril     = json_encode($cpueAbril);
//        $jsCpueMaio      = json_encode($cpueMaio);
//        $jsCpueJunho     = json_encode($cpueJunho);
//        $jsCpueJulho     = json_encode($cpueJulho);
//        $jsCpueAgosto    = json_encode($cpueAgosto);
//        $jsCpueSetembro  = json_encode($cpueSetembro);
//        $jsCpueOutubro   = json_encode($cpueOutubro);
//        $jsCpueNovembro  = json_encode($cpueNovembro);
//        $jsCpueDezembro  = json_encode($cpueDezembro);
//        
//        
//        $this->view->assign("cpueJaneiro",   $jsCpueJaneiro);
//        $this->view->assign("cpueFevereiro", $jsCpueFevereiro);
//        $this->view->assign("cpueMarco",     $jsCpueMarco    );
//        $this->view->assign("cpueAbril", $jsCpueAbril    );
//        $this->view->assign("cpueMaio", $jsCpueMaio     );
//        $this->view->assign("cpueJunho", $jsCpueJunho    );
//        $this->view->assign("cpueJulho", $jsCpueJulho    );
//        $this->view->assign("cpueAgosto", $jsCpueAgosto   );
//        $this->view->assign("cpueSetembro", $jsCpueSetembro );
//        $this->view->assign("cpueOutubro", $jsCpueOutubro  );
//        $this->view->assign("cpueNovembro", $jsCpueNovembro );
//        $this->view->assign("cpueDezembro", $jsCpueDezembro );
//        
//        print_r($jsCpueJaneiro);
//        print_r($jsCpueFevereiro);
//        print_r($jsCpueMarco);
//        print_r($jsCpueAbril);  
//        print_r($jsCpueMaio);  
//        print_r($jsCpueJunho);   
//        print_r($jsCpueJulho);  
//        print_r($jsCpueAgosto);  
//        print_r($jsCpueSetembro); 
//        print_r($jsCpueOutubro);
//        print_r($jsCpueNovembro);
//        print_r($jsCpueDezembro);
        
    }
    public function gerarcpueAction(){
        $cpueArrastoJaneiro   = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 1   And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoFevereiro = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 2 And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoMarco     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 3     And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoAbril     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 4     And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoMaio      = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 5      And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoJunho     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 6     And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoJulho     = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 7     And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoAgosto    = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 8    And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoSetembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 9  And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoOutubro   = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 10  And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoNovembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 11 And Extract(YEAR FROM fd_data) = 2014");
        $cpueArrastoDezembro  = $this->modelArrasto->cpue("pto_nome='".$porto."' and EXTRACT(MONTH FROM fd_data) = 12 And Extract(YEAR FROM fd_data) = 2014");
        
//        print_r($cpueArrastoJaneiro);
        
        foreach($cpueArrastoJaneiro as $cpue):
            $cpueJaneiro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoFevereiro as $cpue):
            $cpueFevereiro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoMarco as $cpue):
            $cpueMarco[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoAbril as $cpue):
            $cpueAbril[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoMaio as $cpue):
            $cpueMaio[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoJunho as $cpue):
            $cpueJunho[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoJulho as $cpue):
            $cpueJulho[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoAgosto as $cpue):
            $cpueAgosto[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoSetembro as $cpue):
            $cpueSetembro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoOutubro as $cpue):
            $cpueOutubro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoNovembro as $cpue):
            $cpueNovembro[] = $cpue['cpue'];
        endforeach;
        foreach($cpueArrastoDezembro as $cpue):
            $cpueDezembro[] = $cpue['cpue'];
        endforeach;
        
        $jsCpueJaneiro = json_encode($cpueJaneiro);
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
        
        
        $this->view->assign("cpueJaneiro",   $jsCpueJaneiro);
        $this->view->assign("cpueFevereiro", $jsCpueFevereiro);
        $this->view->assign("cpueMarco",     $jsCpueMarco    );
        $this->view->assign("cpueAbril", $jsCpueAbril    );
        $this->view->assign("cpueMaio", $jsCpueMaio     );
        $this->view->assign("cpueJunho", $jsCpueJunho    );
        $this->view->assign("cpueJulho", $jsCpueJulho    );
        $this->view->assign("cpueAgosto", $jsCpueAgosto   );
        $this->view->assign("cpueSetembro", $jsCpueSetembro );
        $this->view->assign("cpueOutubro", $jsCpueOutubro  );
        $this->view->assign("cpueNovembro", $jsCpueNovembro );
        $this->view->assign("cpueDezembro", $jsCpueDezembro );
        
        print_r($jsCpueJaneiro);
        print_r($jsCpueFevereiro);
        print_r($jsCpueMarco);
        print_r($jsCpueAbril);  
        print_r($jsCpueMaio);  
        print_r($jsCpueJunho);   
        print_r($jsCpueJulho);  
        print_r($jsCpueAgosto);  
        print_r($jsCpueSetembro); 
        print_r($jsCpueOutubro);
        print_r($jsCpueNovembro);
        print_r($jsCpueDezembro);
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

